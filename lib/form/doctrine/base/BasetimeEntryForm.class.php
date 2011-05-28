<?php

/**
 * timeEntry form base class.
 *
 * @method timeEntry getObject() Returns the current form's model object
 *
 * @package    basecamp2cnp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasetimeEntryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'cnp_id'      => new sfWidgetFormInputText(),
      'basecamp_id' => new sfWidgetFormInputText(),
      'date'        => new sfWidgetFormDate(),
      'description' => new sfWidgetFormInputText(),
      'hours'       => new sfWidgetFormInputText(),
      'person_id'   => new sfWidgetFormInputText(),
      'project_id'  => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'cnp_id'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'basecamp_id' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date'        => new sfValidatorDate(array('required' => false)),
      'description' => new sfValidatorPass(array('required' => false)),
      'hours'       => new sfValidatorInteger(array('required' => false)),
      'person_id'   => new sfValidatorInteger(array('required' => false)),
      'project_id'  => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('time_entry[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'timeEntry';
  }

}
