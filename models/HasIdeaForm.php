<?php

class HasIdeaForm extends CFormModel
{
    public $name;
    public $method;
    public $message;
    public $subject; // fake field (must be hidden by css)

    public function rules()
    {
        return [
            ['name, method, message', 'required'],
            ['name, method', 'length', 'max' => 100],
            ['subject', 'checkSpam'],
        ];
    }

    /**
     * @param string $attribute
     *
     * @throws CHttpException
     */
    public function checkSpam($attribute)
    {
        if (!$this->hasErrors()) {
            if (!empty($this->$attribute)) {
                throw new CHttpException(500, 'Wrong Request');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Как вас зовут?',
            'method' => 'Как с вами связаться?',
            'message' => 'О чем хотите сказать?',
            'subject' => 'Тема',
        ];
    }

    /**
     * Отправка письма
     * @return bool
     * @throws CException
     * @throws Exception
     * @throws phpmailerException
     */
    public function sendEmail()
    {
        $mailer = new YiiMailer();
        $mailer->setView('hasIdea');
        $mailer->setFrom(Yii::app()->params['senderEmail']);
        $mailer->setTo(Yii::app()->params['adminEmail']);
        $mailer->setSubject('Хочу предложить свою помощь/идею редакции');
        $mailer->setData([
            'model' => $this,
        ]);
        return $mailer->send();
    }
}
