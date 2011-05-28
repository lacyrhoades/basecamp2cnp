<?php

/**
 * person filter form base class.
 *
 * @package    basecamp2cnp
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasepersonFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                    => new sfWidgetFormFilterInput(),
      'cnp_id'                  => new sfWidgetFormFilterInput(),
      'basecamp_id'             => new sfWidgetFormFilterInput(),
      'client_id'               => new sfWidgetFormFilterInput(),
      'im_handle'               => new sfWidgetFormFilterInput(),
      'im_service'              => new sfWidgetFormFilterInput(),
      'phone_number_fax'        => new sfWidgetFormFilterInput(),
      'phone_number_home'       => new sfWidgetFormFilterInput(),
      'phone_number_mobile'     => new sfWidgetFormFilterInput(),
      'phone_number_office'     => new sfWidgetFormFilterInput(),
      'phone_number_office_ext' => new sfWidgetFormFilterInput(),
      'title'                   => new sfWidgetFormFilterInput(),
      'created_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'updated_at'              => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'uuid'                    => new sfWidgetFormFilterInput(),
      'first_name'              => new sfWidgetFormFilterInput(),
      'last_name'               => new sfWidgetFormFilterInput(),
      'company_id'              => new sfWidgetFormFilterInput(),
      'email_address'           => new sfWidgetFormFilterInput(),
      'avatar_url'              => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'name'                    => new sfValidatorPass(array('required' => false)),
      'cnp_id'                  => new sfValidatorPass(array('required' => false)),
      'basecamp_id'             => new sfValidatorPass(array('required' => false)),
      'client_id'               => new sfValidatorPass(array('required' => false)),
      'im_handle'               => new sfValidatorPass(array('required' => false)),
      'im_service'              => new sfValidatorPass(array('required' => false)),
      'phone_number_fax'        => new sfValidatorPass(array('required' => false)),
      'phone_number_home'       => new sfValidatorPass(array('required' => false)),
      'phone_number_mobile'     => new sfValidatorPass(array('required' => false)),
      'phone_number_office'     => new sfValidatorPass(array('required' => false)),
      'phone_number_office_ext' => new sfValidatorPass(array('required' => false)),
      'title'                   => new sfValidatorPass(array('required' => false)),
      'created_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'updated_at'              => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'uuid'                    => new sfValidatorPass(array('required' => false)),
      'first_name'              => new sfValidatorPass(array('required' => false)),
      'last_name'               => new sfValidatorPass(array('required' => false)),
      'company_id'              => new sfValidatorPass(array('required' => false)),
      'email_address'           => new sfValidatorPass(array('required' => false)),
      'avatar_url'              => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('person_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'person';
  }

  public function getFields()
  {
    return array(
      'id'                      => 'Number',
      'name'                    => 'Text',
      'cnp_id'                  => 'Text',
      'basecamp_id'             => 'Text',
      'client_id'               => 'Text',
      'im_handle'               => 'Text',
      'im_service'              => 'Text',
      'phone_number_fax'        => 'Text',
      'phone_number_home'       => 'Text',
      'phone_number_mobile'     => 'Text',
      'phone_number_office'     => 'Text',
      'phone_number_office_ext' => 'Text',
      'title'                   => 'Text',
      'created_at'              => 'Date',
      'updated_at'              => 'Date',
      'uuid'                    => 'Text',
      'first_name'              => 'Text',
      'last_name'               => 'Text',
      'company_id'              => 'Text',
      'email_address'           => 'Text',
      'avatar_url'              => 'Text',
    );
  }
}
