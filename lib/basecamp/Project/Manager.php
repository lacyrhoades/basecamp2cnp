<?php
namespace basecamp\Project;

class Manager
{
  protected $_api = null;
  protected $_task = null;
  protected $_projects = null;
  
  public function __construct(\Sirprize\Basecamp $basecampApi)
  {
    $this->_api = $basecampApi;
  }
  
  public function setTask(\sfTask $task)
  {
    $this->_task = $task;
  }
  
  public function updateProjects(\projectTable $projectTable)
  {
    $projects = $this->getAllProjectsFromApi();
    
    $this->logProgress(sprintf('Found %s projects, looking for updates..', count($projects)));
    
    foreach ($projects as $project)
    {
      $projectTable->addOrUpdateProject($project, $this->_task);
    }
  }
  
  public function getAllProjectsFromApi()
  {
    if (!$this->_projects)
    {
      $this->_projects = $this->_api->getProjectsInstance()->startAll();
    }
    
    return $this->_projects;
  }
  
  public function getAllProjectsFromDatabase($table)
  {
    $q = $table->createQuery('p');
    
    return $q->execute();
  }
  
  private function logProgress($msg)
  {
    if ($this->_task)
    {
      $this->_task->logSection('Project\Manager', $msg);
    }
  }
}