<?php

class SendProposalsForm extends CFormModel
{
    public $email;
    public $subject;
    public $form_type;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email, subject, form_type', 'required'],
            ['email, subject', 'length', 'max' => 100],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'form_type' => 'Тип формы',
            'email' => 'Email',
            'subject' => 'Тема',
        ];
    }

    /**
     * @param Proposal[] $models
     * @return bool
     */
    public function sendEmail($models)
    {
        $to = preg_split('/\s*,\s*/', trim($this->email), -1, PREG_SPLIT_NO_EMPTY);

        $mailer = new YiiMailer();
        $mailer->setView('proposals');
        $mailer->setFrom(Yii::app()->params['senderEmail']);
        $mailer->setTo($to);
        $mailer->setSubject($this->subject);
        $mailer->setData([
            'models' => $models,
        ]);
        return $mailer->send();
    }
}
