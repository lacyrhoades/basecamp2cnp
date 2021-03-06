<?php
namespace basecamp\Person;

class Manager
{
  protected $_api = null;
  protected $_task = null;
  protected $_people = null;
  
  public function __construct(\Sirprize\Basecamp $basecampApi)
  {
    $this->_api = $basecampApi;
  }
  
  public function setTask(\sfTask $task)
  {
    $this->_task = $task;
  }
  
  public function updatePeople(\personTable $personTable)
  {
    $people = $this->getAllPeopleFromApi();
    
    $this->logProgress(sprintf('Found %s people, looking for updates..', count($people)));
    
    foreach ($people as $person)
    {
      $personTable->addOrUpdatePerson($person, $this->_task);
    }
  }
  
  public function getAllPeopleFromApi()
  {
    if (!$this->_people)
    {
      $this->_people = $this->_api->getPersonsInstance()->startAll();
    }
    
    return $this->_people;
  }
  
  private function logProgress($msg)
  {
    if ($this->_task)
    {
      $this->_task->logSection('Person\Manager', $msg);
    }
  }
}