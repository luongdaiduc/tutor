<?php
class MessageController extends Controller
{
	public function actionIndex()
	{
		$dataProvider = Message::model()->search();
		
		$this->render('index', array(
				'dataProvider'=>$dataProvider,
				'alert'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * delete, mark multiple record
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
	
		$ids = explode(',', $ids);
	
		foreach ($ids as $id)
		{
			$message = Message::model()->findByPk($id);
	
			if($action == 'delete')
			{
				$message->delete();
			}
			elseif($action == 'mark_read')
			{
				$message->is_read = Message::READ;
				$message->save();
			}
			else
			{
				$message->is_read = Message::UNREAD;
				$message->save();
			}
		}
	
		echo json_encode(array('success'=>true));
	}
	
	/**
	 * view message detail
	 */
	public function actionDetail()
	{
		$id = CPropertyValue::ensureInteger(app()->request->getParam('id'));
		
		$model = Message::model()->findByPk($id);
		
		$model->is_read = Message::READ;
		$model->save();
		
		//first message id
		$first = $model->firstMessage();
		//last message id
		$last = $model->lastMessage();
		//previous message id
		$prev = $model->prevMessage();
		//next message id
		$next = $model->nextMessage();
		
		if(app()->request->isAjaxRequest)
		{
			//hide prev or next button
			$hide_prev = $id == $first;
			$hide_next = $id == $last;
			
			$delete_id = $model->id;
			$reply_message = '<a href="' .url('/message/reply', array('id'=>$model->id)) .'" class="m-btn input-medium"><i class="icon-share-alt"></i>Reply</a>';
			$html = $this->renderPartial('_detail', array('message'=>$model), true);
			
			echo json_encode(array('success'=>true, 'html'=>$html, 'prev_id'=>$prev, 'next_id'=>$next, 'hide_prev'=>$hide_prev, 'hide_next'=>$hide_next, 'delete_id'=>$delete_id, 'reply_message'=>$reply_message));
		}
		else
		{
			$this->render('detail', array(
					'message'=>$model,
					'first'=>$first,
					'last'=>$last,
					'prev'=>$prev,
					'next'=>$next,
			));
		}
	}
	
	/**
	 * reply message
	 */
	public function actionReply()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		
		$message = Message::model()->findByPk($id);
		
		if(!empty($message))
		{
			$model = new ReplyForm();
			
			$model->subject = 'Reply: ' . $message->title;
			
			$reply = request()->getPost('ReplyForm', false);
			
			if($reply)
			{
				$model->attributes = $reply;
				
				if($model->validate())
				{
					//send email
					$email = $message->sender_email;
					$name = $message->sender_name;
					
					//save queue mail
					$queue = new Queue();
					
					$queue->sender_name = $this->settings['no_reply_name'];
					$queue->sender_email = $this->settings['no_reply_address'];
					$queue->recipient_name = $name;
					$queue->recipient_email = $email;
					$queue->title = $model->subject;
					$queue->message = $model->content;
					$queue->status = Queue::SUCCESS;
						
					$queue->save();
					
					//sender's information
					$from = array('name'=>$queue->sender_name, 'email'=>$queue->sender_email);
						
					//recipient's information
					$to = array('name'=>$queue->recipient_name, 'email'=>$queue->recipient_email);
						
					$subject = $queue->title;
					$message = $queue->message;
						
					MailHelper::sendMail($from, $to, $subject, $message);
					
					app()->user->setFlash('message', 'Send a reply mail to ' . $name . ' successfully.');
					
					$this->redirect(url('/message/index'));
				}
				
			}
			
			$this->render('reply', array(
					'message'=>$message,
					'model'=>$model,
					));
		}
		else
		{
			$this->redirect(url('/message/index'));
		}
	}
	
	public function actionSend()
	{
		$settings = $this->settings;
		
		$from_choices = array(
								$settings['reply_address'] => $settings['reply_name'] . ' <' . $settings['reply_address'] . '>',
								$settings['no_reply_address'] => $settings['no_reply_name'] . ' <' . $settings['no_reply_address'] . '>',
							);
		
		$tutors = Account::model()->findAll('role = ?', array(Account::TUTOR));
		
		$model = new ReplyForm();
		
		$reply = request()->getPost('ReplyForm', false);
		
		if($reply)
		{
			$model->attributes = $reply;
			
			if($model->validate())
			{
				//admin email
				$from_choice = request()->getPost('from_choices', false);
				
				//save queue mail
				$queue = new Queue();
				
				$queue->sender_name = $from_choice;
				$queue->sender_email = $from_choice;
				
				$recipient_name = '';
				$recipient_email = array();
				
				//select tutors to send message
				$select_user_choice = request()->getPost('selectUsers', false);
				
				$select_tutors = '';
				if($select_user_choice == 'all')
				{
					$select_tutors = Account::model()->findAll('role = ?', array(Account::TUTOR));
					
					$recipient_name = 'All Tutors';
				}
				elseif ($select_user_choice == 'active')
				{
					$select_tutors = Account::model()->findAll('role = ? AND t.status = ?', array(Account::TUTOR, Account::ACTIVE));
					
					$recipient_name = 'Active Tutors';
				}
				else 
				{
					$tutor_ids = request()->getPost('tutor_ids', false);
					
					if($tutor_ids)
					{
						$select_tutors = Account::model()->findAll('id IN(' . $tutor_ids . ')');
					}
					
					$recipient_name = 'Selected Tutors';
				}
				
				if(!empty($select_tutors))
				{
					$to = '';
					$from = $from_choice;
					$bcc = array();
					$subject = $model->subject;
					$message = $model->content;
					
					foreach ($select_tutors as $idx => $select_tutor)
					{
						$recipient_email[] = $select_tutor->email;
						 
						if($idx == 1)
						{
							$to = $select_tutor->email;
						}
						else 
						{
							$bcc[] = $select_tutor->email;
						}
					}
					
					// To send HTML mail, the Content-type header must be set
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					
					// Additional headers
					$headers .= 'To: ' . $to . "\r\n";
					$headers .= 'From: ' . $from . "\r\n";
					$headers .= 'Bcc: ' . implode(', ', $bcc) . "\r\n";

					// Mail it
					mail($to, $subject, $message, $headers);
					
					$queue->recipient_name = $recipient_name;
					$queue->recipient_email = implode(',', $recipient_email);
					$queue->title = $subject;
					$queue->message = $message;
					$queue->status = Queue::SUCCESS;
						
					if($queue->save())
					{
						app()->user->setFlash('message', 'Send mail successfully.');
					}
				}
			}
		}	
		
		$this->render('send', array(
				'from_choices'=>$from_choices,
				'tutors'=>$tutors,
				'model'=>$model,
				'alert'=>app()->user->getFlash('message'),
				));
	}
	
	/**
	 * delete message 
	 */
	public function actionDelete()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		
		$message = Message::model()->findByPk($id);
		
		if(!empty($message))
		{
			$message->delete();
		}
	}
}