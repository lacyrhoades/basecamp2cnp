<?php

/**
 * person form base class.
 *
 * @method person getObject() Returns the current form's model object
 *
 * @package    basecamp2cnp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasepersonForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                      => new sfWidgetFormInputHidden(),
      'name'                    => new sfWidgetFormInputText(),
      'cnp_id'                  => new sfWidgetFormInputText(),
      'basecamp_id'             => new sfWidgetFormInputText(),
      'client_id'               => new sfWidgetFormInputText(),
      'im_handle'               => new sfWidgetFormInputText(),
      'im_service'              => new sfWidgetFormInputText(),
      'phone_number_fax'        => new sfWidgetFormInputText(),
      'phone_number_home'       => new sfWidgetFormInputText(),
      'phone_number_mobile'     => new sfWidgetFormInputText(),
      'phone_number_office'     => new sfWidgetFormInputText(),
      'phone_number_office_ext' => new sfWidgetFormInputText(),
      'title'                   => new sfWidgetFormInputText(),
      'created_at'              => new sfWidgetFormDate(),
      'updated_at'              => new sfWidgetFormDate(),
      'uuid'                    => new sfWidgetFormInputText(),
      'first_name'              => new sfWidgetFormInputText(),
      'last_name'               => new sfWidgetFormInputText(),
      'company_id'              => new sfWidgetFormInputText(),
      'email_address'           => new sfWidgetFormInputText(),
      'avatar_url'              => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                      => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cnp_id'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'basecamp_id'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'client_id'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'im_handle'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'im_service'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone_number_fax'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone_number_home'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone_number_mobile'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone_number_office'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'phone_number_office_ext' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'title'                   => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'              => new sfValidatorDate(array('required' => false)),
      'updated_at'              => new sfValidatorDate(array('required' => false)),
      'uuid'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'first_name'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_name'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'company_id'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email_address'           => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'avatar_url'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('person[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'person';
  }

}
