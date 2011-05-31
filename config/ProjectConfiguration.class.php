<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

class ProjectConfiguration extends sfProjectConfiguration
{
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    
    $this->registerBasecampApi();
    $this->registerZend();
    $this->registerBasecamp();
    
    require_once dirname(__FILE__).'/custom.php';
  }
  
  private function registerBasecampApi()
  {
    require_once sfConfig::get('sf_lib_dir').'/vendor/Sirprize/Basecamp.php';
    require_once sfConfig::get('sf_lib_dir').'/vendor/Sirprize/Basecamp/Id.php';
  }
  
  private function registerZend()
  {
    $lib = sfConfig::get('sf_lib_dir').'/vendor';

    $path = array(
      $lib,
      get_include_path()
    );

    set_include_path(implode(PATH_SEPARATOR, $path));

    require_once sfConfig::get('sf_lib_dir').'/vendor/Zend/Loader/Autoloader.php';
  }
  
  private function registerBasecamp()
  {
    require_once sfConfig::get('sf_lib_dir').'/basecamp/Project/Manager.php';
    require_once sfConfig::get('sf_lib_dir').'/basecamp/Person/Manager.php';
    require_once sfConfig::get('sf_lib_dir').'/basecamp/TimeEntry/Manager.php';
  }
}
