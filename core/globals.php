<?php
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);

/**
 * This is the shortcut to Yii::app()
 * @return CWebApplication
 */
function app()
{
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->widgets
 * @return CHttpRequest
 */
function request()
{
	return Yii::app()->request;
}
 
/**
 * This is the shortcut to Yii::app()->clientScript
 * @return CClientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 * @return CWebUser
 */
function user($module = null) 
{
	if (empty($module))
    	return Yii::app()->getUser();
    else 
    	return Yii::app()->getModule($module)->getComponent('user');
}

/**
 * 
 * return theme path url
 * This is shortcut to Yii::app()->theme->baseUrl .'/'. $path
 */
function tUrl($path)
{
	$u = Yii::app()->theme->baseUrl .'/'. $path;
	return $u;
}

/**
 * This is the shortcut to Yii::app()->createUrl()
  */
function url($route,$params=array(), $absoluteUrl = false)
{
	if($absoluteUrl)
	{
		$u = Yii::app()->createAbsoluteUrl($route,$params);
	}
	else
	{
		$u = Yii::app()->createUrl($route,$params);
	}
	
	return $u ;
}

/**
 * This is the shortcut to Yii::app()->getController()->createAbsoluteUrl()
 */
function aUrl($route,$params=array(),$schema='',$ampersand='&')
{
    return Yii::app()->getController()->createAbsoluteUrl($route,$params,$schema,$ampersand);
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name) 
{
    return Yii::app()->params[$name];
}