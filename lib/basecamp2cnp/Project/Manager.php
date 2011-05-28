<?php
namespace basecamp2cnp\Project;

class Manager
{
  protected $_api = null;
  protected $_task = null;
  protected $_projects = null;
  
  public function __construct($basecampApi)
  {
    $this->_api = $basecampApi;
  }
  
  public function setTask($task)
  {
    $this->_task = $task;
  }
  
  public function updateProjects($projectTable)
  {
    $projects = $this->getAllProjects();
    
    $this->logProgress(sprintf('Found %s projects, looking for updates..', count($projects)));
    
    foreach ($projects as $project)
    {
      $projectTable->addOrUpdateProject($project, $this->_task);
    }
  }
  
  public function getAllProjects()
  {
    if (!$this->_projects)
    {
      $this->_projects = $this->_api->getProjectsInstance()->startAll();
    }
    
    return $this->_projects;
  }
  
  private function logProgress($msg)
  {
    if ($this->_task)
    {
      $this->_task->logSection('Project\Manager', $msg);
    }
  }
}