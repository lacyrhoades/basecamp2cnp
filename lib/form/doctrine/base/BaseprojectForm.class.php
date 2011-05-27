<?php

/**
 * project form base class.
 *
 * @method project getObject() Returns the current form's model object
 *
 * @package    basecamp2cnp
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseprojectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputText(),
      'name'        => new sfWidgetFormInputText(),
      'cnp_id'      => new sfWidgetFormInputText(),
      'basecamp_id' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorInteger(array('required' => false)),
      'name'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'cnp_id'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'basecamp_id' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('project[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'project';
  }

}
