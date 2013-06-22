<?php
class InformacionController extends Controller{
	
	public function actionIndex(){
		
		// Modelo de formulario
		$model=new InformacionForm;
		
		$ldap = Yii::app()->getSession()->get('ldap');
		
		print_r($ldap);
		
		echo $model->apellido=$ldap[0]['sn'][0];

		$model->nombre=$ldap[0]['cn'][0];
		$model->titulo=$ldap[0]['title'][0];
		$model->apellido=$ldap[0]['sn'][0];
		$model->teléfono=$ldap[0]['telephonenumber'][0];
		
		
		if(isset($_POST['InformacionForm']))
		{
			$model->attributes=$_POST['InformacionForm'];
			if($model->validate())
			{
				$nombre='=?UTF-8?B?'.base64_encode($model->nombre).'?=';
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