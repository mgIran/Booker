<?php
class Mailer {

    /**
     * Send mail
     */
    public static function mail($to, $subject, $message, $from)
    {
        $mail_theme=Yii::app()->params['mailTheme'];
        $message=str_replace('{MessageBody}', $message, $mail_theme);
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail=new JPhpMailer;
        $mail->SetFrom($from, Yii::app()->name);
        $mail->Subject=$subject;
        $mail->MsgHTML($message);
        $mail->AddAddress($to);
        return $mail->Send();
    }
}