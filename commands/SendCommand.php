<?php

class SendCommand extends CConsoleCommand
{
    /**
     * cd /var/www/user1187023/data/www/trevel34.loc/travel/protected && /usr/bin/php yiic ...
     * php yiic send proposals --form_type=roulette --to=marina.kovaleva@priorbank.by --subject="Заявки на карту «Бумеранг» с 34travel"
     * @param string $form_type
     * @param string $to
     * @param string $subject
     */
    public function actionProposals($form_type, $to, $subject)
    {
        $to = preg_split('/\s*,\s*/', trim($to), -1, PREG_SPLIT_NO_EMPTY);
        $from = Yii::app()->params['senderEmail'];

        echo "Sending emails\nFrom: $from\nTo: " . implode(', ', $to) . "\nSubject: $subject\n\n";

        /** @var Proposal[] $models */
        $models = Proposal::model()->findAllByAttributes(['processed' => 0, 'form_type' => $form_type]);
        if (($total = count($models)) == 0) {
            echo "No new proposals found.\n";
            return;
        }

        $mailer = new YiiMailer();
        $mailer->setView('proposals');
        $mailer->setFrom($from);
        $mailer->setTo($to);
        $mailer->setSubject($subject);
        $mailer->setData([
            'models' => $models,
        ]);
        if ($mailer->send()) {
            Proposal::model()->updateAll(['processed' => 1, 'processed = :processed AND form_type = :form_type', [':processed' => 0, ':form_type' => $form_type]]);
            echo "$total proposal(s) was sent.\n";
        } else {
            echo "Sending error.\n";
        }
    }

    /**
     * php yiic send test --to=dev@iquadart.by --subject="Test email from 34travel"
     * @param string $to
     * @param string $subject
     */
    public function actionTest($to, $subject)
    {
        $to = preg_split('/\s*,\s*/', trim($to), -1, PREG_SPLIT_NO_EMPTY);
        $from = Yii::app()->params['senderEmail'];

        echo "Sending test email\nFrom: $from\nTo: " . implode(', ', $to) . "\nSubject: $subject\n\n";

        $mailer = new YiiMailer();
        $mailer->setBody("$subject - " . date('r'));
        $mailer->setFrom($from);
        $mailer->setTo($to);
        $mailer->setSubject($subject);
        if ($mailer->send()) {
            echo "OK\n";
        } else {
            echo "ERROR!\n";
        }
    }
}
