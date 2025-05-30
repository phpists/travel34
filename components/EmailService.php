<?php


class EmailService
{
    public static function sendConfirmationEmail($url, $email, $userId)
    {
        $encryptedUserId = EmailService::encrypt($userId);
        $confirmationLink = Yii::app()->createAbsoluteUrl($url, [
            'token' => $encryptedUserId,
            'email' => $email,
        ]);

        $template = EmailTemplate::getEmailTemplate(EmailTemplate::FORGOT_PASSWORD_CONFIRM_EMAIL);
        $templateDescription = str_replace('@link', $confirmationLink, $template->description);

        $status = EmailService::sendEmail($email, $template->subject, $templateDescription);

        if (!$status) {
            Yii::app()->user->setFlash('email', 'Не удалось отправить письмо восстановление пароля. Попробуйте еще раз.');
        }
    }

    public static function sendSuccessEmail($email)
    {
        $template = EmailTemplate::getEmailTemplate(EmailTemplate::FORGOT_PASSWORD_SUCCESS_EMAIL);

        EmailService::sendEmail($email, $template->subject, $template->description);
    }

    public static function encrypt($data)
    {
        $encryptionKey = Yii::app()->params['encryptionKey'];
        return base64_encode(openssl_encrypt($data, 'aes-256-cbc', $encryptionKey, 0, substr($encryptionKey, 0, 16)));
    }

    public static function decrypt($data)
    {
        $encryptionKey = Yii::app()->params['encryptionKey'];
        return openssl_decrypt(base64_decode($data), 'aes-256-cbc', $encryptionKey, 0, substr($encryptionKey, 0, 16));
    }

    public static function sendEmail($email, $subject, $body)
    {
        $logFile = Yii::getPathOfAlias('application.runtime') . '/email_log.txt';
        $mail = new YiiMailer();
        $mail->setFrom('34t@farbatest.com', '34travel');
        $mail->setTo($email);
        $mail->setSubject($subject);
        $mail->setBody($body);
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'smtp.beget.com';
        $mail->Port = 465;
        $mail->Username = '34t@farbatest.com';
        $mail->Password = 'rZkOvSS1nyx*';

        $logData = [
            'date' => date('Y-m-d H:i:s'),
            'to' => $email,
            'subject' => $subject,
            'body' => $body,
            'mailer' => $mail->Mailer,
            'smtp_status' => $mail->Mailer === 'smtp' ? 'Yes' : 'No',
            'Crypt' => $mail->Mailer === 'smtp' ? 'SMTP' : 'TLS',
            'status' => '',
            'error' => ''
        ];

        if ($mail->send()) {
            $logData['status'] = 'Success';
            $status = true;
        } else {
            $logData['status'] = 'Failed';
            $logData['error'] = $mail->getError();
            $status = false;
        }

        file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);

        return $status;
    }

    /**
     * Valid email
     * @param $email
     * @return bool
     */
    public static function validateGmailEmail($email)
    {
        $domain = substr(strrchr($email, "@"), 1);
        if (stripos($domain, 'gmail') !== false && strtolower($domain) !== 'gmail.com') {
            return true;
        }

        return false;
    }
}