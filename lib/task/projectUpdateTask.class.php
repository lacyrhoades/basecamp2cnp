<?php

class projectUpdateTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'cron';
    $this->name             = 'project-update';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [ioProjectUpdate|INFO] task does things.
Call it with:

  [php symfony ioProjectUpdate|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $config = $this->getBasecampConfigArray();
    
    $basecampApi = new \Sirprize\Basecamp($config);
    
    
    $projectManager = new \basecamp2cnp\Project\Manager($basecampApi);
    
    $projectManager->setTask($this);
    
    $projectTable = Doctrine::getTable('project');
    
    $projectManager->updateProjects($projectTable);
    
    
    $peopleManager = new \basecamp2cnp\People\Manager($basecampApi);
    
    $peopleManager->setTask($this);
    
    $peopleTable = Doctrine::getTable('person');
    
    $peopleManager->updatePeople($peopleTable);
    
    
    $projectsTable = Doctrine::getTable('project');
    
    $projects = $projectManager->getAllProjectsFromDatabase($projectsTable);
    
    foreach ($projects as $project)
    {
      $this->logSection('execute', sprintf('Updating time for Project: %s', $project->getName()));
      
      $timeManager = new \basecamp2cnp\TimeEntry\Manager($basecampApi, $project->getBasecampId());
      
      $timeManager->setTask($this);
      
      $timeEntryTable = Doctrine::getTable('timeEntry');
      
      $timeManager->updateTimeEntries($timeEntryTable);
    }
  }
  
  private function getBasecampConfigArray()
  {
    return array(
      'baseUri' => sfConfig::get('basecamp_baseUri', null),
      'username' => sfConfig::get('basecamp_username', null),
      'password' => sfConfig::get('basecamp_password', null)
    );
  }
}
