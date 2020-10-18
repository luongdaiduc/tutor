<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$admins = Account::model()->findAll('role = ?', array(Account::ADMIN));
		$this->render('index', array(
				'admins'=>$admins,
				));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	//save error into database
	    	$model = new Error();
	    	$model->level = $error['type'];
	    	$model->title = $error['message'];
	    	$model->source = $error['file'] . ' on line ' . $error['line'];
	    	$model->content = $error['trace'];
	    	$model->created = date('Y-m-d H:i:s');
	    	
	    	$model->save();
	    	
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else 
	    	{
	    		$this->render('error', $error);
	    	}
	        	
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		$loginForm = app()->request->getPost('LoginForm', false);
		if($loginForm)
		{
			$model->attributes = $loginForm;
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect('/');
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionChangePassword()
	{
		$id = app()->user->id;
		
		if(!empty($id))
		{
			$model = new ResetForm();
			
			$change_password = request()->getPost('ResetForm', false);
			
			if($change_password)
			{
				$model->attributes = $change_password;
				
				if($model->validate())
				{
					$account = Account::model()->findByPk($id);
					
					$account->password = md5($model->newPassword);
					$account->save();
					
					app()->user->setFlash('message', 'Change password successfully.');
					$this->refresh();
				}
			}
			
			$this->render('change_password', array(
					'model'=>$model,
					'message'=>app()->user->getFlash('message'),
					));
		}
	}
	
	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}