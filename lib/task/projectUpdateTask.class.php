<?php

/**
 * task for pulling "projects" from the Basecamp API to the local database
 */
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
The [project-update|INFO] task pulls project objects from the API and puts
them in the local databse.
Call it with:

  [php symfony cron:project-update|INFO]
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
    
    
    // grab a "project" manager service
    $projectManager = new \basecamp\Project\Manager($basecampApi);
    
    // set the task so we get feedback over stdout
    $projectManager->setTask($this);
    
    // get the project database table
    $projectTable = Doctrine::getTable('project');
    
    // call the update method, get to work
    $projectManager->updateProjects($projectTable);
  }
  
}
