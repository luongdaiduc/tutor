<?php
class TranslationController extends Controller
{
	/**
	 * translate page
	 */
	public function actionTranslate()
	{
		$category = CPropertyValue::ensureString(request()->getParam('category'));
		
		$texts = I18nSourceMessage::model()->findAll('t.category = ?', array($category));
		
		$translates = request()->getPost('Translate',false);
	
		if($translates)
		{
			foreach($translates as $idx => $translate)
			{
				$translate_message = I18nMessage::model()->find('id = ? AND language = ?', array($idx, $this->settings['language']));
				if(!empty($translate_message))
				{
					$translate_message->translation = $translate;
					$translate_message->save();
				}
				else
				{
					$translate_message = new I18nMessage();
					$translate_message->id = $idx;
					$translate_message->language = $this->settings['language'];
					$translate_message->translation = $translate;
					$translate_message->save();
				}
				
			}
			
			//clear cache
			app()->cache->delete('translate_message');
			app()->user->setFlash('message', 'Save translate text successfully.');
		}
		
		$this->render('translate', array(
				'texts'=>$texts,
				'message'=>app()->user->getFlash('message'),
				));
	}
}