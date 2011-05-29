<?php
namespace basecamp2cnp\TimeEntry;

class Manager
{
  protected $_api = null;
  protected $_task = null;
  protected $_timeEntries = null;
  
  public function __construct(\Sirprize\Basecamp $basecampApi, $basecampProjectId)
  {
    $this->_api = $basecampApi;
    $this->_project_id = $basecampProjectId;
  }
  
  public function setTask(\sfTask $task)
  {
    $this->_task = $task;
  }
  
  public function updateTimeEntries(\timeEntryTable $timeEntryTable)
  {
    $timeEntries = $this->getAllTimeEntriesFromApi();
    
    $this->logProgress(sprintf('Found %s time entries, looking for updates..', count($timeEntries)));
    
    foreach ($timeEntries as $timeEntry)
    {
      $timeEntryTable->addOrUpdateEntry($timeEntry, $this->_task);
    }
  }
  
  public function getAllTimeEntriesFromApi()
  {
    if (!$this->_timeEntries)
    {
      $this->_timeEntries = $this->_api->getTimeEntriesInstance()->startByProjectId($this->_project_id);
    }
    
    return $this->_timeEntries;
  }
  
  private function logProgress($msg)
  {
    if ($this->_task)
    {
      $this->_task->logSection('TimeEntry\Manager', $msg);
    }
  }
}