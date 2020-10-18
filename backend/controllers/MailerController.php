<?php
class MailerController extends Controller
{
public function actionTemplate()
	{
		$dataProvider = Template::model()->search();
	
		$this->render('template', array(
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
	
		if($id == 0)
		{
			$model = new Template();
		}
		else
		{
			$model = Template::model()->findByPk($id);
		}
	
		// collect user input data
		$template = app()->request->getPost('Template', false);
	
		if($template)
		{
			$model->attributes = $template;
			if($model->save())
			{
				app()->user->setFlash('message', $id == 0 ? 'Add new template successfully' : 'Edit template successfully');
				$this->redirect(url('/mailer/template'));
			}
				
		}
	
		$this->render('edit', array(
				'model'=>$model,
		));
	}
	
	/**
	 * delete, draft, publish multiple record
	 */
// 	public function actionManageMultiRecord()
// 	{
// 		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
// 		$action = CPropertyValue::ensureString(request()->getParam('action'));
	
// 		$ids = explode(',', $ids);
	
// 		foreach ($ids as $id)
// 		{
// 			$block = Block::model()->findByPk($id);
	
// 			if($action == 'delete')
// 			{
// // 				Page::model()->deleteByPk($id);
// 			}
// 			elseif($action == 'draft')
// 			{
// 				$block->status = Block::DRAFT;
// 				$block->save();
// 			}
// 			else
// 			{
// 				$block->status = Block::PUBLISHED;
// 				$block->save();
// 			}
// 		}
	
// 		echo json_encode(array('success'=>true));
// 	}
	
	/**
	 * list queue mail
	 */
	public function actionQueue()
	{
		$dataProvider = Queue::model()->searchQueue();
		
		$this->render('queue', array(
				'dataProvider'=>$dataProvider,
				'message'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * view mail detail
	 */
	public function actionViewQueue()
	{
		$id = CPropertyValue::ensureInteger(app()->request->getParam('id'));
		
		$model = Queue::model()->findByPk($id);
		
		//first queue id
		$first = $model->firstQueue();
		//last queue id
		$last = $model->lastQueue();
		//previous queue id
		$prev = $model->prevQueue();
		//next queue id
		$next = $model->nextQueue();
		
		if(app()->request->isAjaxRequest)
		{
			//hide prev or next button
			$hide_prev = $id == $first;
			$hide_next = $id == $last;
			
			//queue status to define whether show or hide send mail button
			$queue_status = $model->status;
				
			$html = $this->renderPartial('_view', array('model'=>$model), true);
				
			echo json_encode(array('success'=>true, 'html'=>$html, 'prev_id'=>$prev, 'next_id'=>$next, 'hide_prev'=>$hide_prev, 'hide_next'=>$hide_next, 'queue_status'=>$queue_status, 'queue_id'=>$id));
		}
		else
		{
			$this->render('view', array(
					'model'=>$model,
					'first'=>$first,
					'last'=>$last,
					'prev'=>$prev,
					'next'=>$next,
			));
		}
	}
	
	public function actionSendQueueMail()
	{
		$queue_id = CPropertyValue::ensureInteger(app()->request->getParam('queue_id'));
		
		$queue = Queue::model()->findByPk($queue_id);
		
		//sender's information
		$from = array('name'=>$queue->sender_name, 'email'=>$queue->sender_email);
		
		//recipient's information
		$to = array('name'=>$queue->recipient_name, 'email'=>$queue->recipient_email);
		
		$subject = $queue->title;
		$message = $queue->message;
		
// 		MailHelper::sendMail($from, $to, $subject, $message);
		
		//update mail's status
		$queue->status = Queue::SUCCESS;
		
		$queue->save();
		
		app()->user->setFlash('message', 'Mail has been sent.');
		
		echo json_encode(array('success'=>true));
	}
	
}