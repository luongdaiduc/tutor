<?php
class PageController extends Controller
{
	public function actionIndex()
	{
		$slug = CPropertyValue::ensureString(request()->getParam('slug'));
		
		//select page from database
		$model = Page::model()->find('slug = ? and status = ?', array($slug, Page::PUBLISHED));
		
		if(!empty($model))
		{
			$this->pageTitle = $this->settings['site_title'] . ' :: ' . $model->title;
			$this->change_title = true;
		}
		
		Common::insertMeta();
		
		$this->render('index', array(
				'model'=>$model,
				));
	}
}