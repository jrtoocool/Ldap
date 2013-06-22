<?php

/**
 * InformacionForm class.
 * InformacionForm is the data structure for keeping
 * info form data. It is used by the 'index' action of 'InformationController'.
 */
class InformacionForm extends CFormModel
{
	public $nombre;
	public $apellido;
	public $email;
	public $teléfono;
	public $subject;
	public $titulo;
	
	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('email, subject', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			
			array('teléfono', 'numerical'),
			// verifyCode needs to be entered correctly
			//array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	
	public function attributeLabels()
		{
			return array(
				'verifyCode'=>'Verification Code',
			);
		}
	
}