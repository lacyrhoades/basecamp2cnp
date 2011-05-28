<?php

/**
 * Basecamp API Wrapper for PHP 5.3+ 
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt
 *
 * @category   Sirprize
 * @package    Basecamp
 * @copyright  Copyright (c) 2010, Christian Hoegl, Switzerland (http://sirprize.me)
 * @license    MIT License
 */


namespace Sirprize\Basecamp\Milestone;


/**
 * Represent and modify a milestone
 *
 * @category  Sirprize
 * @package   Basecamp
 */
class Entity
{
	
	
	const _ID = 'id';
	const _TITLE = 'title';
	const _DEADLINE = 'deadline';
	const _COMMENTS_COUNT = 'comments-count';
	const _COMPLETED = 'completed';
	const _CREATED_ON = 'created-on';
	const _CREATOR_ID = 'creator-id';
	const _PROJECT_ID = 'project-id';
	const _RESPONSIBLE_PARTY_ID = 'responsible-party-id';
	const _RESPONSIBLE_PARTY_TYPE = 'responsible-party-type';
	const _WANTS_NOTIFICATION = 'wants-notification';
	
	
	protected $_basecamp = null;
	protected $_httpClient = null;
	protected $_data = array();
	protected $_loaded = false;
	protected $_response = null;
	protected $_observers = array();
	
	
	
	public function setBasecamp(\Sirprize\Basecamp $basecamp)
	{
		$this->_basecamp = $basecamp;
		return $this;
	}
	
	
	public function setHttpClient(\Zend_Http_Client $httpClient)
	{
		$this->_httpClient = $httpClient;
		return $this;
	}
	
	
	/**
	 * Get response object
	 *
	 * @return \Sirprize\Basecamp\Response|null
	 */
	public function getResponse()
	{
		return $this->_response;
	}
	
	
	/**
	 * Attach observer object
	 *
	 * @return \Sirprize\Basecamp\Milestone
	 */
	public function attachObserver(\Sirprize\Basecamp\Milestone\Entity\Observer\Abstrakt $observer)
	{
		$exists = false;
		
		foreach(array_keys($this->_observers) as $key)
		{
			if($observer === $this->_observers[$key])
			{
				$exists = true;
				break;
			}
		}
		
		if(!$exists)
		{
			$this->_observers[] = $observer;
		}
		
		return $this;
	}
	
	
	/**
	 * Detach observer object
	 *
	 * @return \Sirprize\Basecamp\Milestone
	 */
	public function detachObserver(\Sirprize\Basecamp\Milestone\Entity\Observer\Abstrakt $observer)
	{
		foreach(array_keys($this->_observers) as $key)
		{
			if($observer === $this->_observers[$key])
			{
				unset($this->_observers[$key]);
				break;
			}
		}
		
		return $this;
	}
	
	
	public function setTitle($title)
	{
		$this->_data[self::_TITLE] = $title;
		return $this;
	}
	
	
	public function setDeadline(\Sirprize\Basecamp\Date $deadline)
	{
		$this->_data[self::_DEADLINE] = $deadline;
		return $this;
	}
	
	
	public function setProjectId(\Sirprize\Basecamp\Id $projectId)
	{
		$this->_data[self::_PROJECT_ID] = $projectId;
		return $this;
	}
	
	
	public function setResponsiblePartyId(\Sirprize\Basecamp\Id $responsiblePartyId)
	{
		$this->_data[self::_RESPONSIBLE_PARTY_ID] = $responsiblePartyId;
		return $this;
	}
	
	
	public function setWantsNotification($wantsNotification)
	{
		$this->_data[self::_WANTS_NOTIFICATION] = $wantsNotification;
		return $this;
	}
	
	
	public function getId()
	{
		return $this->_getVal(self::_ID);
	}
	
	
	public function getTitle()
	{
		return $this->_getVal(self::_TITLE);
	}
	
	
	/**
	 * @return \Sirprize\Basecamp\Date
	 */
	public function getDeadline()
	{
		return $this->_getVal(self::_DEADLINE);
	}
	
	
	public function getCommentsCount()
	{
		return $this->_getVal(self::_COMMENTS_COUNT);
	}
	
	
	public function getIsCompleted()
	{
		return $this->_getVal(self::_COMPLETED);
	}
	
	
	public function getCreatedOn()
	{
		return $this->_getVal(self::_CREATED_ON);
	}
	
	
	/**
	 * @return \Sirprize\Basecamp\Id
	 */
	public function getCreatorId()
	{
		return $this->_getVal(self::_CREATOR_ID);
	}
	
	
	/**
	 * @return \Sirprize\Basecamp\Id
	 */
	public function getProjectId()
	{
		return $this->_getVal(self::_PROJECT_ID);
	}
	
	
	/**
	 * @return \Sirprize\Basecamp\Id
	 */
	public function getResponsiblePartyId()
	{
		return $this->_getVal(self::_RESPONSIBLE_PARTY_ID);
	}
	
	
	public function getResponsiblePartyType()
	{
		return $this->_getVal(self::_RESPONSIBLE_PARTY_TYPE);
	}
	
	
	public function getWantsNotification()
	{
		return $this->_getVal(self::_WANTS_NOTIFICATION);
	}
	
	
	
	
	/**
	 * Load data returned from an api request
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return \Sirprize\Basecamp\Milestone
	 */
	public function load(\SimpleXMLElement $xml, $force = false)
	{
		if($this->_loaded && !$force)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('entity has already been loaded');
		}
		
		#print_r($xml); exit;
		$this->_loaded = true;
		$array = (array) $xml;
		
		require_once 'Sirprize/Basecamp/Date.php';
		$deadline = new \Sirprize\Basecamp\Date($array[self::_DEADLINE]);
		
		require_once 'Sirprize/Basecamp/Id.php';
		$id = new \Sirprize\Basecamp\Id($array[self::_ID]);
		$projectId = new \Sirprize\Basecamp\Id($array[self::_PROJECT_ID]);
		$creatorId = new \Sirprize\Basecamp\Id($array[self::_CREATOR_ID]);
		$responsiblePartyId = new \Sirprize\Basecamp\Id($array[self::_RESPONSIBLE_PARTY_ID]);
		
		$completed = ($array[self::_COMPLETED] == 'true');
		$wantsNotification = ($array[self::_WANTS_NOTIFICATION] == 'true');
		
		$this->_data = array(
			self::_ID => $id,
			self::_TITLE => $array[self::_TITLE],
			self::_DEADLINE => $deadline,
			self::_COMMENTS_COUNT => $array[self::_COMMENTS_COUNT],
			self::_COMPLETED => $completed,
			self::_CREATED_ON => $array[self::_CREATED_ON],
			self::_CREATOR_ID => $creatorId,
			self::_PROJECT_ID => $projectId,
			self::_RESPONSIBLE_PARTY_ID => $responsiblePartyId,
			self::_RESPONSIBLE_PARTY_TYPE => $array[self::_RESPONSIBLE_PARTY_TYPE],
			self::_WANTS_NOTIFICATION => $wantsNotification
		);
		
		return $this;
	}
	
	
	
	/**
	 * Create XML to create a new milestone
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return string
	 */
	public function getXml()
	{
		if($this->getTitle() === null)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call setTitle() before '.__METHOD__);
		}
		
		if($this->getDeadline() === null)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call setDeadline() before '.__METHOD__);
		}
		
		if($this->getResponsiblePartyId() === null)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call setResponsiblePartyId() before  '.__METHOD__);
		}
		
  		$xml  = '<milestone>';
		$xml .= '<title>'.htmlspecialchars($this->getTitle(), ENT_NOQUOTES).'</title>';
		$xml .= '<deadline type="date">'.$this->getDeadline().'</deadline>';
		$xml .= '<responsible-party>'.$this->getResponsiblePartyId().'</responsible-party>';
		$xml .= '<notify>'.(($this->getWantsNotification()) ? 'true' : 'false').'</notify>';
		$xml .= '</milestone>';
		return $xml;
	}
	
	
	
	/**
	 * Persist this milestone in storage
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return boolean
	 */
	public function create()
	{
		if($this->getProjectId() === null)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('set project-id before  '.__METHOD__);
		}
		
		$projectId = $this->getProjectId();
		
		$xml  = '<request>';
		$xml .= $this->getXml();
		$xml .= '</request>';
		
		try {
			$response = $this->_getHttpClient()
				->setUri($this->_getBasecamp()->getBaseUri()."/projects/$projectId/milestones/create")
				->setAuth($this->_getBasecamp()->getUsername(), $this->_getBasecamp()->getPassword())
				->setHeaders('Content-type', 'application/xml')
				->setHeaders('Accept', 'application/xml')
				->setRawData($xml)
				->request('POST')
			;
		}
		catch(\Exception $exception)
		{
			try {
				// connection error - try again
				$response = $this->_getHttpClient()->request('POST');
			}
			catch(\Exception $exception)
			{
				$this->onCreateError();
			
				require_once 'Sirprize/Basecamp/Exception.php';
				throw new \Sirprize\Basecamp\Exception($exception->getMessage());
			}
		}
		
		require_once 'Sirprize/Basecamp/Response.php';
		$this->_response = new \Sirprize\Basecamp\Response($response);
		
		if($this->_response->isError())
		{
			// service error
			$this->onCreateError();
			return false;
		}
		
		$this->onCreateLoad($this->_response->getData()->milestone);
		return true;
	}
	
	
	
	/**
	 * Load data from a \Sirprize\Basecamp\Milestone\Collection::create() opteration
	 *
	 * @return void
	 */
	public function onCreateLoad(\SimpleXMLElement $xml)
	{
		$this->load($xml);
		$this->_onCreateSuccess();
	}
	
	
	
	/**
	 * Get notified of an error in a \Sirprize\Basecamp\Milestone\Collection::create() opteration
	 *
	 * @return void
	 */
	public function onCreateError()
	{
		$this->_onCreateError();
	}
	
	
	
	/**
	 * Update this milestone in storage
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return boolean
	 */
	public function update($moveUpcomingMilestones = false, $moveUpcomingMilestonesOffWeekends = false)
	{
		if(!$this->_loaded)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call load() before '.__METHOD__);
		}
		
		$xml  = '<request>';
		$xml .= $this->getXml();
		$xml .= '<move-upcoming-milestones>'.(($moveUpcomingMilestones) ? 'true' : 'false').'</move-upcoming-milestones>';
		$xml .= '<move-upcoming-milestones-off-weekends>'.(($moveUpcomingMilestonesOffWeekends) ? 'true' : 'false').'</move-upcoming-milestones-off-weekends>';
		$xml .= '</request>';
		
		try {
			$response = $this->_getHttpClient()
				->setUri($this->_getBasecamp()->getBaseUri()."/milestones/update/".$this->getId())
				->setAuth($this->_getBasecamp()->getUsername(), $this->_getBasecamp()->getPassword())
				->setHeaders('Content-type', 'application/xml')
				->setHeaders('Accept', 'application/xml')
				->setRawData($xml)
				->request('POST')
			;
		}
		catch(\Exception $exception)
		{
			try {
				// connection error - try again
				$response = $this->_getHttpClient()->request('POST');
			}
			catch(\Exception $exception)
			{
				$this->_onUpdateError();
			
				require_once 'Sirprize/Basecamp/Exception.php';
				throw new \Sirprize\Basecamp\Exception($exception->getMessage());
			}
		}
		
		require_once 'Sirprize/Basecamp/Response.php';
		$this->_response = new \Sirprize\Basecamp\Response($response);
		
		if($this->_response->isError())
		{
			// service error
			$this->_onUpdateError();
			return false;
		}
		
		$this->load($this->_response->getData(), true);
		$this->_onUpdateSuccess();
		return true;
	}
	
	
	
	/**
	 * Delete this milestone from storage
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return boolean
	 */
	public function delete()
	{
		$id = $this->getId();
		
		try {
			$response = $this->_getHttpClient()
				->setUri($this->_getBasecamp()->getBaseUri()."/milestones/delete/$id")
				->setAuth($this->_getBasecamp()->getUsername(), $this->_getBasecamp()->getPassword())
				->setHeaders('Content-type', 'application/xml')
				->setHeaders('Accept', 'application/xml')
				->request('DELETE')
			;
		}
		catch(\Exception $exception)
		{
			try {
				// connection error - try again
				$response = $this->_getHttpClient()->request('DELETE');
			}
			catch(\Exception $exception)
			{
				$this->_onDeleteError();
			
				require_once 'Sirprize/Basecamp/Exception.php';
				throw new \Sirprize\Basecamp\Exception($exception->getMessage());
			}
		}
		
		require_once 'Sirprize/Basecamp/Response.php';
		$this->_response = new \Sirprize\Basecamp\Response($response);
		
		if($this->_response->isError())
		{
			// service error
			$this->_onDeleteError();
			return false;
		}
		
		$this->_onDeleteSuccess();
		$this->_data = array();
		$this->_loaded = false;
		return true;
	}
	
	
	
	/**
	 * Complete this milestone
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return boolean
	 */
	public function complete()
	{
		if(!$this->_loaded)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call load() before '.__METHOD__);
		}
		
		try {
			$response = $this->_getHttpClient()
				->setUri($this->_getBasecamp()->getBaseUri()."/milestones/complete/".$this->getId())
				->setAuth($this->_getBasecamp()->getUsername(), $this->_getBasecamp()->getPassword())
				->setHeaders('Content-type', 'application/xml')
				->setHeaders('Accept', 'application/xml')
				->request('GET')
			;
		}
		catch(\Exception $exception)
		{
			try {
				// connection error - try again
				$response = $this->_getHttpClient()->request('GET');
			}
			catch(\Exception $exception)
			{
				$this->_onCompleteError();
			
				require_once 'Sirprize/Basecamp/Exception.php';
				throw new \Sirprize\Basecamp\Exception($exception->getMessage());
			}
		}
		
		require_once 'Sirprize/Basecamp/Response.php';
		$this->_response = new \Sirprize\Basecamp\Response($response);
		
		if($this->_response->isError())
		{
			// service error
			$this->_onCompleteError();
			return false;
		}
		
		$this->load($this->_response->getData(), true);
		$this->_onCompleteSuccess();
		return true;
	}
	
	
	
	/**
	 * Uncomplete this milestone
	 *
	 * @throws \Sirprize\Basecamp\Exception
	 * @return boolean
	 */
	public function uncomplete()
	{
		if(!$this->_loaded)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call load() before '.__METHOD__);
		}
		
		try {
			$response = $this->_getHttpClient()
				->setUri($this->_getBasecamp()->getBaseUri()."/milestones/uncomplete/".$this->getId())
				->setAuth($this->_getBasecamp()->getUsername(), $this->_getBasecamp()->getPassword())
				->setHeaders('Content-type', 'application/xml')
				->setHeaders('Accept', 'application/xml')
				->request('GET')
			;
		}
		catch(\Exception $exception)
		{
			try {
				// connection error - try again
				$response = $this->_getHttpClient()->request('GET');
			}
			catch(\Exception $exception)
			{
				$this->_onCompleteError();
			
				require_once 'Sirprize/Basecamp/Exception.php';
				throw new \Sirprize\Basecamp\Exception($exception->getMessage());
			}
		}
		
		require_once 'Sirprize/Basecamp/Response.php';
		$this->_response = new \Sirprize\Basecamp\Response($response);
		
		if($this->_response->isError())
		{
			// service error
			$this->_onUncompleteError();
			return false;
		}
		
		$this->load($this->_response->getData(), true);
		$this->_onUncompleteSuccess();
		return true;
	}
	
	
	
	protected function _getBasecamp()
	{
		if($this->_basecamp === null)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call setBasecamp() before '.__METHOD__);
		}
		
		return $this->_basecamp;
	}
	
	
	protected function _getHttpClient()
	{
		if($this->_httpClient === null)
		{
			require_once 'Sirprize/Basecamp/Exception.php';
			throw new \Sirprize\Basecamp\Exception('call setHttpClient() before '.__METHOD__);
		}
		
		return $this->_httpClient;
	}
	
	
	protected function _getVal($name)
	{
		return (isset($this->_data[$name])) ? $this->_data[$name] : null;
	}
	
	
	protected function _onCompleteSuccess()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onCompleteSuccess($this);
		}
	}
	
	
	protected function _onUncompleteSuccess()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onUncompleteSuccess($this);
		}
	}
	
	
	protected function _onCreateSuccess()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onCreateSuccess($this);
		}
	}
	
	
	protected function _onUpdateSuccess()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onUpdateSuccess($this);
		}
	}
	
	
	protected function _onDeleteSuccess()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onDeleteSuccess($this);
		}
	}
	
	
	protected function _onCompleteError()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onCompleteError($this);
		}
	}
	
	
	protected function _onUncompleteError()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onUncmpleteError($this);
		}
	}
	
	
	protected function _onCreateError()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onCreateError($this);
		}
	}
	
	
	protected function _onUpdateError()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onUpdateError($this);
		}
	}
	
	
	protected function _onDeleteError()
	{
		foreach($this->_observers as $observer)
		{
			$observer->onDeleteError($this);
		}
	}
	
	
	
	
	
	
	
	
	
	
	protected $_todoLists = null;
	
	
	public function getTodoLists()
	{
		if($this->_todoLists === null)
		{
			$this->_todoLists = $this->_getBasecamp()->getTodoListsInstance();
		}
		
		return $this->_todoLists;
	}
	
	
	
	public function findTodoListByName($name)
	{
		foreach($this->getTodoLists() as $todoList)
		{
			if($name == $todoList->getName())
			{
				return $todoList;
			}
		}
		
		return null;
	}
	
}