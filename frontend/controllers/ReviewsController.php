<?php
class ReviewsController extends Controller
{
	public function filters()
	{
		return array(
				'accessControl',
		);
	}
	
	public function accessRules()
	{
		return array(
				array('deny',
						'actions'=>array('index'),
						'users'=>array('?'),
				),
		);
	}
	
	public function actionIndex()
	{
		$id = app()->user->id;
		
		$dataProvider = Review::model()->searchReview($id);
		
		//check whether user is admin or not
		$is_admin = false;
		
		$h = app()->user->getState('hash_admin');
		
		if(!empty($h))
		{
			$time = time();
				
			$hash = Hash::model()->find('hash= ? AND expire > ?', array($h, $time));
			
			if(!empty($hash))
			{
				$is_admin = true;
			}
			else
			{
				$is_admin = false;
				
				Hash::model()->deleteAll('hash = ?', array($h));
			}
		}
		
		$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Review';
		$this->change_title = true;
		
		$this->layout = 'account';
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				'message'=>app()->user->getFlash('message'),
				'is_admin'=>$is_admin,
				));
	}
	
	public function actionView()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		
		$review = Review::model()->findByPk($id);
		
		if(!empty($review))
		{
			$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: View Review';
			$this->change_title = true;
			
			$this->layout = 'account';
			$this->render('view', array(
					'review'=>$review,
					));
		}
		else
		{
			$this->redirect(url('/site/error'));
		}
	}
	
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
		
		if($action == 'request')
		{
			$url = url('/reviews/remove', array('ids'=>$ids));
			
			echo json_encode(array('success'=>true, 'redirect'=>true, 'url'=>$url));
		}
		elseif ($action == 'delete')
		{
			$ids = explode(',', $ids);
			foreach ($ids as $id)
			{
				$review = Review::model()->findByPk($id);
			
				$review->delete();
			}
			
			echo json_encode(array('success'=>true));
		}
	}
	
	/**
	 * request remove review
	 */
	public function actionRemove()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		if(!empty($ids))
		{
			$dataProvider = Review::model()->searchRequestRemove($ids);
			
			$model = new ContactForm();
			
			$account = Account::model()->findByPk(app()->user->id);
			
			$model->name = $account->first_name . ' ' . $account->last_name;
			$model->email = $account->email;
			
			$contact = app()->request->getPost('ContactForm', false);
			
			if($contact)
			{
				$model->attributes = $contact;
					
				if($model->validate())
				{	
					//content for message
					$url = app()->params['adminUrl'] . url('/user/loginAsUser', array('id'=>app()->user->id));
					$content = '<a href="' . $url . '" target="_blank" >' . $url . '</a><br/>';
					$content .= 'Review(s): ' . '<br/>';
					$ids = explode(',', $ids);
					//update review status
					foreach ($ids as $id)
					{
						$review = Review::model()->findByPk($id);
							
						if(!empty($review))
						{
							$content .= $review->content . '<br/>';
							
							$review->status = Review::REQUEST_REMOVAL;
							$review->save();
						}
					}
					
					//send message to admin
					$message = new Message();
					
					$message->sender_name = $model->name;
					$message->sender_email = $model->email;
					$message->title = 'Request removal review';
					$message->content = $content . 'Reason: <br/>' . $model->message;
					$message->created = date('Y-m-d H:i:s');
					
					$message->save();
						
					app()->user->setFlash('message', Common::translate('alert message', 'Your message has been sent to admin successfully'));
					
					$this->redirect(url('/reviews/index'));
				}
				
			}
			
			$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Request Removal Review';
			$this->change_title = true;
			
			$this->layout = 'account';
			$this->render('remove', array(
					'dataProvider'=>$dataProvider,
					'model'=>$model,
			));
		}
		else 
		{
			$this->redirect(url('/site/error'));
		}
	}
}