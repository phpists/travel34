<?php

class ToolsCommand extends CConsoleCommand
{
    /**
     * Очистка ресурсов
     * yiic tools clearassets
     */
    public function actionClearassets()
    {
        $assets_path = Yii::getPathOfAlias('webroot.assets');
        if ($assets_path) {
            if ($handle = opendir($assets_path)) {
                while (($file = readdir($handle)) !== false) {
                    if (strpos($file, '.') === 0) {
                        continue;
                    }
                    $path = $assets_path . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($path)) {
                        CFileHelper::removeDirectory($path);
                    } else {
                        unlink($path);
                    }
                }
                closedir($handle);
            }
        }
    }

    /**
     * Очистка кеша
     * yiic tools flushcache
     */
    public function actionFlushcache()
    {
        Yii::app()->cache->flush();
    }

    /**
     * yiic tools assignstyles
     */
    public function actionAssignstyles()
    {
        Yii::app()->db->createCommand()->truncateTable('tr_style_assign');

        $styles = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Style::model()->tableName())
            ->query();
        foreach ($styles as $style) {
            Yii::app()->db->createCommand()->insert('tr_style_assign', [
                'style_id' => $style['id'],
                'page_key' => $style['page_key'],
                'item_id' => $style['item_id'],
            ]);
            echo ".";
        }
        echo "\nDone\n";
    }

    /**
     * yiic tools testmail --to="vasia@mail.ru"
     */
    public function actionTestmail($to)
    {
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            echo sprintf('"%s" is wrong email.', $to) . "\n";
            return;
        }

        $from = Yii::app()->params['senderEmail'];

        echo "Sending email\nFrom: $from\nTo: $to\n\n";

        $mailer = new YiiMailer();
        $mailer->setView('test');
        $mailer->setFrom($from);
        $mailer->setTo($to);
        $mailer->setSubject(sprintf('[%s] Тестовое письмо', Yii::app()->name));
        $mailer->setData([
            'date' => date('r'),
        ]);
        if ($mailer->send()) {
            echo "OK!\n";
        } else {
            echo "Sending error.\n";
        }
    }
}
