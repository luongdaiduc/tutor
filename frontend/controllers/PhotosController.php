<?php
Yii::import('core.extensions.image.Image');

class PhotosController extends Controller
{
	public function actionIndex()
	{
		if(!empty(app()->user->id))
		{
			//check whether tutor is enhance/premium or not
			$account = $this->getAccount();
				
			if($account->isFeature($account->id) == 1)
			{
				$dataProvider = Gallery::model()->searchPhoto();
				
				$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Gallery';
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
					$title = 'Add Photo';
					$model = new Gallery();
					$model->setScenario('create');
				}
				else
				{
					$title = 'Edit Photo';
					$model = Gallery::model()->findByPk($id);
					$model->setScenario('update');
				}
				
				$gallery = app()->request->getPost('Gallery', false);
				
				if($gallery)
				{
					$model->attributes = $gallery;
					$model->ref_account_id = app()->user->id;
					$photo = Common::saveFile($model, 'streamPhoto');
					
					if($photo != null)
					{
						$model->photo = $photo;				
					
						//thumbnail image used for display in search, featured tutor
						$image = new Image(Common::getUserImageFolder(app()->user->id) . '/' . $photo);
						$image->resize(260, 180, Image::NONE)->quality(100);
						$image->save(Common::getUserImageFolder(app()->user->id) . '/' . 'thumb-' . $photo);	
						
					}
					
					if($model->save())
					{
						if($model->is_favourite) {
							Gallery::model()->updateAll(array('is_favourite'=>0), ' id <> '. $model->id);
						}
						
						$this->redirect(url('/photos/crop', array('id'=>$model->id)));
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
	 * crop image after upload
	 */
	public function actionCrop()
	{
		$id = CPropertyValue::ensureInteger(request()->getParam('id'));
		
		$model = Gallery::model()->findByPk($id);
		
		if(!empty($model))
		{
			if(!empty($_POST))
			{
				$photo = $model->photo;
				
				$p = explode('.', $photo);
				$filename = $p[0]; //the filename
				$filetype = strtolower($p[1]); //the filetype; important to lowercase so it doesn't choke on .JPG instead of .jpg, for example
					
				$xCoord1 = $_POST['x1']; 
				$yCoord1 = $_POST['y1']; 
				$xCoord2 = $_POST['x2'];
				$yCoord2 = $_POST['y2'];
			
				$width = abs($xCoord2 - $xCoord1); // width of the cropped area
				$heigh = abs($yCoord2 - $yCoord1); // height of the cropped area

				$path = Common::getUserImageFolder($model->ref_account_id) . '/';
				
				//convert post to PHP resource
				if ($filetype == 'jpeg' || $filetype == 'jpg') {
					$img = imagecreatefromjpeg($path.$photo);
				} else if ($filetype == 'gif') {
					$img = imagecreatefromgif($path.$photo);
				}  else if ($filetype == 'png') {
					$img = imagecreatefrompng($path.$photo);
				}
					
				//create a new PHP image object to hold the cropped image, and crop the image
				$newImage = imagecreatetruecolor($width, $heigh);
				imagecopyresampled($newImage, $img, 0, 0, $xCoord1, $yCoord1, $width, $heigh, $width, $heigh);
				//convert the PHP image object to a .png file
				imagepng($newImage, $path.'thumb-'.$photo, 0);
				//cleanup
				imagedestroy($img);
				imagedestroy($newImage);
				
				//thumbnail image used for display in search, featured tutor
				$image = new Image($path.'thumb-'.$photo);
				$image->resize(260, 180, Image::NONE)->quality(100);
				$image->save($path.'thumb-'.$photo);
				
				$this->redirect(url('/photos/index'));
			}
			
			$this->pageTitle = $this->settings['site_title'] . ' :: My Account :: Crop Photo';
			$this->change_title = true;
			
			$this->layout = 'account';
			$this->render('crop', array(
					'model'=>$model,
			));
				
		}
		else 
		{
			$this->redirect(url('/site/error'));
		}
	}
		
	/**
	 * delete or make favourite
	 */
	public function actionManageMultiRecord()
	{
		$ids = CPropertyValue::ensureString(request()->getParam('ids'));
		$action = CPropertyValue::ensureString(request()->getParam('action'));
		
		$ids = explode(',', $ids);
		
		foreach ($ids as $id)
		{
			$gallery = Gallery::model()->findByPk($id);
		
			if($action == 'delete')
			{
				$gallery->delete();
			}
			elseif($action == 'favourite')
			{
				$gallery->is_favourite = Gallery::IS_FAVOURITE;
				if($gallery->save())
				{
					Gallery::model()->updateAll(array('is_favourite'=>0), ' id <> '. $gallery->id);
				}
			}
			
		}
		
		echo json_encode(array('success'=>true));
	}
}