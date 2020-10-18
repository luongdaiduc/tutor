<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	//selected fields in search
	public $selected = array();

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/home';
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
	
	public $settings = array();
	public $subjects = array();
	public $states = array();
	public $levels = array();
	public $deliveries = array();
	
	public $change_title = false;
	
	public function init()
	{
		parent::init();
		
		$this->settings = Setting::getSettingCache();
		$this->subjects = Subject::getSubjectCache();
		$this->states = State::getstateCache();
		$this->levels = SubjectLevel::getLevelCache();
		$this->deliveries = Delivery::getDeliveryCache();
	}
	
	protected function beforeAction($action)
	{
		//check world wide web 
		$r = app()->request;
		$url = $r->getUrl();
		if(strcmp($r->getHostInfo(), 'http://' . app()->params['domain_name']) == 0)
		{
			$this->redirect(app()->params['siteUrl']. $url);
		}
			
		//account id in register 
		$ref_account_id = app()->user->getState('account_id');
		$is_complete = app()->user->getState('complete_register');

		if($this->id != 'register' && !empty($ref_account_id) && $is_complete == true)
		{
			//clear session
			app()->user->setState('account_id', null);
			app()->user->setState('complete_register', null);
		}
		
		if ($this->id != 'register' && !empty($ref_account_id) && empty($is_complete))
		{
			Account::model()->deleteByPk($ref_account_id);
			Profile::model()->deleteAll('ref_account_id = ?', array($ref_account_id));
			Advertise::model()->deleteAll('ref_account_id = ?', array($ref_account_id));
			TutorDelivery::model()->deleteAll('ref_account_id = ?', array($ref_account_id));
			TutorSubject::model()->deleteAll('ref_account_id = ?', array($ref_account_id));
			
			//clear session
			app()->user->setState('account_id', null);
		}
		
		//check existed user, used in tutor account management
		$this->checkAccount();
		
		return true;
	}
	
	/**
	 * use in layout, hide/active advertise
	 */
	public function getAccount()
	{
		$account = Account::model()->findByPk(app()->user->id);
	
		return $account;
	}
	
	/**
	 * check if user is deleted/disabled
	 */
	public function checkAccount()
	{
		if(!empty(app()->user->id))
		{
			$id = app()->user->id;
			
			$account = Account::model()->find('id = ? AND t.status = ?', array($id, Account::ACTIVE));
			
			if(empty($account) && $this->action->id != 'logout')
			{
				$this->redirect(url('/site/logout'));
			}
			
		}
	}
}