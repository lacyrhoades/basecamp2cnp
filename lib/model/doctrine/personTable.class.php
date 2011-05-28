<?php

/**
 * personTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class personTable extends Doctrine_Table
{
  protected $_task;
  
  public function addOrUpdatePerson($person, sfTask $task = null)
  {
    $this->_task = $task;
    
    if ($this->personExistsExactly($person))
    {
      return;
    }
    
    if ($existingPerson = $this->personExists($person))
    {
      $this->updatePerson($existingPerson, $person);
      return;
    }
    
    $this->addPerson($person);
  }
  
  private function personExistsExactly($person)
  {
    $q = $this->createQuery('p')->where('p.basecamp_id = ?', $person->getId())
      ->andWhere('p.first_name = ?', $person->getFirstName())
      ->andWhere('p.last_name = ?', $person->getLastName());
      
    if ($q->count() > 0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }
  
  private function personExists($person)
  {
    $q = $this->createQuery('p')->where('p.basecamp_id = ?', $person->getId());
    
    if ($q->count() > 0)
    {
      return $q->fetchOne();
    }
    else
    {
      return false;
    }
  }
  
  private function addPerson($basecampPerson)
  {
    $person = new person();

    $this->_updateDatabaseRecordFromApiRecord($person, $basecampPerson);

    $person->save();
    
    $this->logProgress(sprintf('New person added! "%s"', $person->name));
  }
  
  private function updatePerson($existingPerson, $basecampPerson)
  {
    $this->_updateDatabaseRecordFromApiRecord($existingPerson, $basecampPerson);
    
    $existingPerson->save();
    
    $this->logProgress(sprintf('Updated existing person: "%s"', $existingPerson->name));
  }
  
  private function _updateDatabaseRecordFromApiRecord($dbRecord, $apiRecord)
  {
    $dbRecord->basecamp_id = $apiRecord->getId();
    $dbRecord->client_id = $apiRecord->getClientId();
    $dbRecord->im_handle = $apiRecord->getImHandle();
    $dbRecord->im_service = $apiRecord->getImService();
    $dbRecord->phone_number_fax = $apiRecord->getPhoneNumberFax();
    $dbRecord->phone_number_home = $apiRecord->getPhoneNumberHome();
    $dbRecord->phone_number_mobile = $apiRecord->getPhoneNumberMobile();
    $dbRecord->phone_number_office = $apiRecord->getPhoneNumberOffice();
    $dbRecord->phone_number_office_ext = $apiRecord->getPhoneNumberOfficeExt();
    $dbRecord->title = $apiRecord->getTitle();
    $dbRecord->created_at = $apiRecord->getCreatedAt();
    $dbRecord->updated_at = $apiRecord->getUpdatedAt();
    $dbRecord->uuid = $apiRecord->getUuid();
    $dbRecord->first_name = $apiRecord->getFirstName();
    $dbRecord->last_name = $apiRecord->getLastName();
    $dbRecord->company_id = $apiRecord->getCompanyId();
    $dbRecord->email_address = $apiRecord->getEmailAddress();
    $dbRecord->avatar_url = $apiRecord->getAvatarUrl();
  }
  
  private function logProgress($msg)
  {
    if ($this->_task)
    {
      $this->_task->logSection('personTable', $msg);
    }
  }
}