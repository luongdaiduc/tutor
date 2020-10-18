<?php

class VideosController extends Controller
{
	public function actionIndex()
	{
		if(!empty(app()->user->id))
		{
			//check whether tutor is enhance/premium or not
			$account = $this->getAccount();
			
			if($account->isFeature($account->id) == 1)
			{
				$dataProvider = Video::model()->searchVideo(app()->user->id);
				
				$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Videos';
				$this->change_title = true;
				
				$this->layout = 'account';
				$this->render('index', array(
						'dataProvider'=>$dataProvider,
				));
			}
			else 
			{
				$this->redirect(url('/tutor/index'));
			}
		}
		else
		{
			$this->redirect(url('/site/login'));
		}
	}
	
	public function actionEdit()
	{
		if(!empty(app()->user->id))
		{
			//check whether tutor is enhance/premium or not
			$account = $this->getAccount();
				
			if($account->isFeature($account->id) == 1)
			{
				$id = CPropertyValue::ensureInteger(app()->request->getParam('id', 0));
				$title = '';
				//defined whether create or update a photo
				if($id == 0)
				{
					$title = 'Add Video';
					$model = new Video();
				}
				else
				{
					$title = 'Edit Video';
					$model = Video::model()->findByPk($id);
				}
				
				$video = app()->request->getPost('Video', false);
				
				if($video)
				{
					$model->attributes = $video;
					$model->ref_account_id = app()->user->id;
								
					if($model->save())
					{
						$this->redirect(url('/videos/index'));
					}
				}
				
				$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: ' . $title;
				$this->change_title = true;
				
				$this->layout = 'account';
				$this->render('edit', array(
						'model'=>$model,
						));
			}
			else 
			{
				$this->redirect(url('/tutor/index'));
			}
		}
		else
		{
			$this->redirect(url('/site/login'));
		}
	}
	
	/**
	 * delete
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
		
		$ids = explode(',', $ids);
		
		foreach ($ids as $id)
		{
			$video = Video::model()->findByPk($id);
		
			if($action == 'delete')
			{
				$video->delete();
			}
			
		}
		
		echo json_encode(array('success'=>true));
	}
}