<?php
class BLockController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Block::model()->search();
	
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				'message'=>app()->user->getFlash('message'),
		));
	}
	
	/**
	 * edit or create new subject
	 */
	public function actionEdit()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id', 0));
	
		$pages = Page::model()->findAll();
		
		if($id == 0)
		{
			$model = new Block();
		}
		else
		{
			$model = Block::model()->findByPk($id);
			
			foreach ($model->pages as $page)
			{
				$model->target[] = $page->id;
			}
		}
	
		// collect user input data
		$block = app()->request->getPost('Block', false);
	
		if($block)
		{
			$model->attributes = $block;
			
			$model->save();
			
			//save block and page relation
			if(isset($block['target']))
			{
				PageBlock::model()->deleteAll('ref_block_id = ?', array($model->id));
				
				foreach ($block['target'] as $target)
				{
					$page_block = new PageBlock();
					$page_block->ref_page_id = $target;
					$page_block->ref_block_id = $model->id;
					
					$page_block->save();
				}
			}
			
			app()->user->setFlash('message', $id == 0 ? 'Add new block successfully' : 'Edit block successfully');
			$this->redirect(url('/block'));
		}
	
		$this->render('edit', array(
				'model'=>$model,
				'pages'=>CHtml::listData($pages, 'id', 'title'),
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
			$block = Block::model()->findByPk($id);
	
			if($action == 'delete')
			{
				PageBlock::model()->deleteAll('ref_block_id = ?', array($id));
				
				$block->delete();
			}
			elseif($action == 'draft')
			{
				$block->status = Block::DRAFT;
				$block->save(false);
			}
			else
			{
				$block->status = Block::PUBLISHED;
				$block->save(false);
			}
		}
	
		echo json_encode(array('success'=>true));
	}
}