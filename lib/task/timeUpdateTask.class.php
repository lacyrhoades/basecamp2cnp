<?php

class timeUpdateTask extends sfBaseTask
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
    $this->name             = 'time-update';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [time-update|INFO] task pulls "time entries" from the Basecamp API and
puts them in the local database.
Call it with:

  [php symfony cron:time-update|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // setup the Basecamp connection
    $config = sfConfig::get('basecamp_config', array());
    $basecampApi = new \Sirprize\Basecamp($config);
    
    // grab the local table for projects
    $projectsTable = Doctrine::getTable('project');
    
    // get the project data provider service
    $projectManager = new \basecamp\Project\Manager($basecampApi);
    
    // grab all the projects from the table
    $projects = $projectManager->getAllProjectsFromDatabase($projectsTable);
    
    // get the time entry table, so we can write changes to it
    $timeEntryTable = Doctrine::getTable('timeEntry');
    
    // go over each project
    foreach ($projects as $project)
    {
      // report that we're updating entries for a certain project
      $this->logSection('execute', sprintf('Updating time for Project: %s', $project->getName()));
      
      // create an id object for this basecamp entry
      $id = new \Sirprize\Basecamp\Id($project->getBasecampId());
      
      // create a manager object for this project, by id
      $timeManager = new \basecamp\TimeEntry\Manager($basecampApi, $id);
      
      // set the task so we get feedback over stdout
      $timeManager->setTask($this);
      
      // call the update method to do the updates
      $timeManager->updateTimeEntries($timeEntryTable);
    }
  }
}
