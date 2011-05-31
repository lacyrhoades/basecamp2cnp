<?php
class PersonTest extends PHPUnit_Framework_TestCase
{
  public function setUp()
  {
    require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

    $configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', false);
    sfContext::createInstance($configuration);
  }
  
  public function testConstructor()
  {
    $personInstance = $this->getMock('\Sirprize\Basecamp\Person\Collection', array('startAll'), array(), '', false, false, false);

    $person = $this->getMock('\Sirprize\Basecamp', array(), array(), '', false, false, false);

    $manager = new \basecamp\Person\Manager($person);
  }

  public function testSetTask()
  {
    $task = $this->getMock('sfTask', array(), array(), '', false, false, false);

    $person = $this->getMock('\Sirprize\Basecamp', array(), array(), '', false, false, false);

    $manager = new \basecamp\Person\Manager($person);
    
    $manager->setTask($task);
  }
  
  public function testUpdatePeople()
  {
    $personTable = $this->getMock('personTable', array(), array(), '', false, false, false);
    
    $personInstance = $this->getMock('\Sirprize\Basecamp\Person\Collection', array('startAll'), array(), '', false, false, false);
    $personInstance->expects($this->once())->method('startAll')->will($this->returnValue(array()));

    $person = $this->getMock('\Sirprize\Basecamp', array(), array(), '', false, false, false);
    $person->expects($this->once())->method('getPersonsInstance')->will($this->returnValue($personInstance));

    $manager = new \basecamp\Person\Manager($person);
    
    $manager->updatePeople($personTable);
  }

  public function testGetAllPeopleFromApi()
  {
    $personInstance = $this->getMock('\Sirprize\Basecamp\Person\Collection', array('startAll'), array(), '', false, false, false);
    $personInstance->expects($this->once())->method('startAll')->will($this->returnValue(array()));

    $person = $this->getMock('\Sirprize\Basecamp', array(), array(), '', false, false, false);
    $person->expects($this->once())->method('getPersonsInstance')->will($this->returnValue($personInstance));

    $manager = new \basecamp\Person\Manager($person);
    
    $manager->getAllPeopleFromApi();
  }
}
