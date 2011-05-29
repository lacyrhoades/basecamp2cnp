<?php

/**
 * task for updating the person table from the Basecamp API
 */
class personUpdateTask extends sfBaseTask
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
    $this->name             = 'person-update';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [person-update|INFO] task calls basecamp and asks for all the "person"
employed by our company. It then updates the local database to relflect what
it finds.

Call it with:

  [php symfony cron:person-update|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // setup the basecamp connection
    $config = sfConfig::get('basecamp_config', array());
    $basecampApi = new \Sirprize\Basecamp($config);


    // grab the person managing service
    $personManager = new \basecamp2cnp\Person\Manager($basecampApi);

    // set the task so we can have logging feedback to stdout
    $personManager->setTask($this);

    // grab the person table so we can add things to the database
    $personTable = Doctrine::getTable('person');

    // call the update person method, passing the person table.
    $personManager->updatePeople($personTable);
  }
}
