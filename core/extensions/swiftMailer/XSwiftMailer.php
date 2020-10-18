<?php 
/**
 * Swift Mailer extension for Yii
 */
Yii::import('application.extensions.swiftMailer.SwiftMailer');
class XSwiftMailer extends SwiftMailer {

	static $logger;
	public static $templateNameAndLanguage;
	
    public function getMailer() 
    {
        // Get mailer
        $SM = Yii::app()->mailer;
        
        // Get config
        $mailHost = Yii::app()->params['smtp_host'];
        $mailPort = Yii::app()->params['smtp_port']; // Optional
        
        // New transport
        $Transport = $SM->smtpTransport($mailHost, $mailPort);
        $Transport->setUsername(Yii::app()->params['smtp_user']);
        $Transport->setPassword(Yii::app()->params['smtp_password']);
        
        $mailer = $SM->mailer($Transport);
			
        return $mailer;
    }
        
    /**
     * @desc parse template with params
     * @param type $template template mail in /mailtemplate
     * @param type $params array($key=>$val,...)
     * @return type 
     */
    public static function getContentByTemplate($template, $params) {
        $file = Yii::getPathOfAlias('webroot').DIRECTORY_SEPARATOR."mailtemplate".DIRECTORY_SEPARATOR.$template . ".html";      
        $template = file_get_contents($file);
        $template = mb_convert_encoding($template, 'UTF-8',mb_detect_encoding($template, 'UTF-8, ISO-8859-1', true));
        
        foreach($params as $key=>$val){
            $template = str_replace("{".$key."}", $val, $template);
        }
        
        return $template;
    }
    
    /**
     * @desc get data from mail template with parse parameters
     * @param type $template
     * @param type $params
     * @param type $field = body / subject / senderemail / sendername / receivername / receiveremail
     * @param type $loggedUser
     * @param type $responsible
     * @param type $applier
     * @param type $customer current customer of logged in employee
     * @return type 
     */
    public static function getDataFromTemplate($template, $params, $field="body", $loggedUser=null, $responsible=null, $applier=null, $customer=null){
        $ret = "";
        switch ($field) {
            case "body":
                $ret = mb_convert_encoding($template->body, 'UTF-8',mb_detect_encoding($template->body, 'UTF-8, ISO-8859-1', true));
                break;
            case "subject":
                $ret = mb_convert_encoding($template->subject, 'UTF-8',mb_detect_encoding($template->subject, 'UTF-8, ISO-8859-1', true));
                break;
            case "sendername":
                $ret = mb_convert_encoding($template->sendername, 'UTF-8',mb_detect_encoding($template->sendername, 'UTF-8, ISO-8859-1', true));                
                break;
            case "senderemail":
                $ret = mb_convert_encoding($template->senderemail, 'UTF-8',mb_detect_encoding($template->senderemail, 'UTF-8, ISO-8859-1', true));
                break;
            case "receivername":
                $ret = mb_convert_encoding($template->receivername, 'UTF-8',mb_detect_encoding($template->receivername, 'UTF-8, ISO-8859-1', true));
                break;
            case "receiveremail":
                $ret = mb_convert_encoding($template->receiveremail, 'UTF-8',mb_detect_encoding($template->receiveremail, 'UTF-8, ISO-8859-1', true));
                break;
            default:
                break;
        }
        
        foreach($params as $key=>$val){
            $ret = str_replace("{".$key."}", $val, $ret);
        }
        //replace for current logged in user 
        if(!is_null($loggedUser)){
            $ret = self::replaceCommonVars($ret, $loggedUser, "currentuser");
        }
        //replace for the users that are responsible for the current logged in user 
        if(!is_null($responsible)){
            $ret = self::replaceCommonVars($ret, $responsible, "responsibleuser");
        }
        //replace for the users that are applier for the absence
        if(!is_null($applier)){
            $ret = self::replaceCommonVars($ret, $applier, "applier");
        }
        
        //replace for the customer
        if(!is_null($customer)){
            $ret = self::replaceCustomerVars($ret, $customer);
        }
        
        return $ret;
    }
}