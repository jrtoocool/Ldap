<?php
class InformacionController extends Controller{
	
	public function actionIndex(){
		
		
		$ldapconn = ldap_connect("localhost")
		    or die("Could not connect to LDAP server.");
		
		// Modelo de formulario
		$model=new InformacionForm;
		
		$model->name=Yii::app()->getSession()->get('uid');
		
		if(isset($_POST['InformacionForm']))
		{
			$model->attributes=$_POST['InformacionForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('index',array('model'=>$model));
	}
	
	
	
}