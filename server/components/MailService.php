<?php
/**
 * Created by PhpStorm.
 * User: yadongw
 * Date: 15-8-20
 * Time: 上午10:56
 */

namespace app\components;

use yii;
use yii\swiftmailer\mailer;

class MailService extends mailer {

	public $apiKey;
	public $apiUrl = 'https://api.mailgun.net/v3/sandbox89f39c7786af43498a62e961bad52fcc.mailgun.org/messages';
	public $from;

	/**
	 * @param yii\swiftmailer\Message $message
	 * @return bool|void
	 * @throws yii\base\Exception
	 */
	protected function sendMessage ($message)
	{
		$address = $message->getTo();
		if (is_array($address)) {
			$address = implode(', ', array_keys($address));
		}
		/** @var \Swift_Message $swiftMessage */
		$swiftMessage = $message->getSwiftMessage();
		$htmlContentType ='text/html';
		foreach($swiftMessage->getChildren() as $child){
			if($child->getContentType() == $htmlContentType){
				$body = $child->getBody();
			}
		}
		if(!isset($body)){
			throw new yii\base\Exception('body is not set.');
		}
		try{
			$sendMailCammand = "curl -s --user 'api:".$this->apiKey."' \\
 ".$this->apiUrl." \\
 -F from='". key($message->getFrom())."' \\
 -F to='".$address."' \\
 -F subject='". $message->getSubject() ."' \\
 --form-string html='". $body ."' \\
 ";
			exec($sendMailCammand);
		}catch (\Exception $e){
			Yii::error("send mail fail. Cammand: " . $sendMailCammand);
		}
	}

    public function sendMail ($to, $subject, $view, $params = [])
    {
        return $this->compose($view, $params)
            ->setTo($to)
            ->setFrom($this->from)
            ->setSubject($subject)
            ->send();
    }
}