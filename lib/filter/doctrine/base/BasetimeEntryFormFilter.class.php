<?php

/**
 * timeEntry filter form base class.
 *
 * @package    basecamp2cnp
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasetimeEntryFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'cnp_id'      => new sfWidgetFormFilterInput(),
      'basecamp_id' => new sfWidgetFormFilterInput(),
      'date'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'description' => new sfWidgetFormFilterInput(),
      'hours'       => new sfWidgetFormFilterInput(),
      'person_id'   => new sfWidgetFormFilterInput(),
      'project_id'  => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'cnp_id'      => new sfValidatorPass(array('required' => false)),
      'basecamp_id' => new sfValidatorPass(array('required' => false)),
      'date'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'description' => new sfValidatorPass(array('required' => false)),
      'hours'       => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'person_id'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'project_id'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('time_entry_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'timeEntry';
  }

  public function getFields()
  {
    return array(
      'id'          => 'Number',
      'cnp_id'      => 'Text',
      'basecamp_id' => 'Text',
      'date'        => 'Date',
      'description' => 'Text',
      'hours'       => 'Number',
      'person_id'   => 'Number',
      'project_id'  => 'Number',
    );
  }
}
