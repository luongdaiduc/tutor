<?php
class PageController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Page::model()->searchCreated();
		
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * edit or create new subject
	 */
	public function actionEdit($id = 0)
	{
		$id = CPropertyValue::ensureInteger($id);
		$model = Page::model()->findByPk($id);
		
		if(!$model)
		{
			$model = new Page();
		}

		// collect user input data
		$page = app()->request->getPost('Page', false);		
		if($page)
		{
			$model->attributes = $page;
			
			if($model->save())
			{
				app()->user->setFlash('message', ($id == 0) ? 'Add new page successfully' : 'Edit page successfully');
				$this->redirect(url('/page'));
			}
		}
		
		$this->render('edit', array(
				'model'=>$model,
				));
	}
	
	/**
	 * delete, draft, publish multiple record
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
		
		$ids = explode(',', $ids);
		
		foreach ($ids as $id)
		{
			$page = Page::model()->findByPk($id);
	
			if($action == 'delete')
			{
				PageBlock::model()->deleteAll('ref_page_id = ?', array($id));
				
				Page::model()->deleteByPk($id);
			}
			else
			{
				$page->status = ($action == 'draft') ? Page::DRAFT : Page::PUBLISHED;
				$page->save();
			}
		}
		
		echo json_encode(array('success'=>true));
	}
	
	public function actionShowPage()
	{
		$slug = CPropertyValue::ensureString(request()->getParam('slug'));
	
		//select page from database
		$model = Page::model()->find('slug = ? and status = ?', array($slug, Page::PUBLISHED));
	
		$this->render('page', array(
				'model'=>$model,
		));
	}
}
