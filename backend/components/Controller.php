<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	
	public $siteUrl = null;
	
	public $settings = array();
	public $states = array();
	public $categories = array();
	
	public function init()
	{
		parent::init();
		
		$this->siteUrl = Yii::app()->params['siteUrl'];
		$this->settings = Setting::getSettingCache();
		$this->states = State::getstateCache();
		$this->categories = I18nSourceMessage::getCategoryCache();
	}
	
	/**
	 * force user to login before use admin page
	 * (non-PHPdoc)
	 * @see CController::beforeAction()
	 */
	public function beforeAction($action)
	{
		if(parent::beforeAction($action))
		{
			if($action->id == 'login' || $this->checkUserAccess())
				return true;
			else {
				app()->user->logout();
				$this->redirect(url('/site/login'));
			}
		}
		else
			return false;
	}
	
	
	/**
	 * Check authorization access admin
	 */
	public function checkUserAccess()
	{
		if (app()->user->isGuest)
			return false;
		else 
		{	
			return true;
		}
	}
}