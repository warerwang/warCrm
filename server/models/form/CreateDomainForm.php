<?php

namespace app\models\form;

use app\models\Domain;
use app\models\User;
use Yii;

/**
 * ContactForm is the model behind the contact form.
 */
class CreateDomainForm extends Domain
{
    const CREATE_STEP1 = 'create1';
    const CREATE_STEP2 = 'create2';
    public $adminEmail;
    public $adminPassword;
    public $adminPasswordRepeat;
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        return array_merge($labels, [
            'adminEmail' => '管理员邮箱',
            'adminPassword' => '管理员密码',
            'adminPasswordRepeat' => '重复密码',
        ]);
    }
    public function rules()
    {
        return [
            [['domain'], 'required'],
            [['domain'], 'unique'],
            ['domain', 'match', 'pattern' => '/[0-9a-zA-z\-]{5,30}/'],
            [['name', 'adminEmail', 'adminPassword'], 'required' , 'on' => self::CREATE_STEP2],
            [['adminEmail'], 'email' , 'on' => self::CREATE_STEP2],
            ['adminPasswordRepeat', 'compare', 'compareAttribute' => 'adminPassword', 'on' => self::CREATE_STEP2],
        ];
    }

    public function createDomain()
    {
        if(!$this->save()) return false;
        User::createUser($this->id, $this->adminEmail, $this->adminPassword);
        return true;
    }
}
