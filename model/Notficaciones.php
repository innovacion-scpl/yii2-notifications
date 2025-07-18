<?php

namespace webzop\notifications\model;

use webzop\notifications\channels\EmailChannel;
use Yii;
use yii\helpers\VarDumper;

class Notficaciones extends \yii\db\ActiveRecord
{
    /** 
     * Permite envíar la misma notificación, por distintos canales a un
     * grupo de usuarios.
     * 
     * @param array $id_users
     * @param int $id_tipo_notificacion
     * 
    */
    public function sendNotifications($id_users, $id_tipo_notificacion){

        foreach ($id_users as $index => $id_user) {
            Yii::error(VarDumper::dumpAsString($id_user));
            $canalNotificacionUser = CanalUser::buscarPorNotificacion($id_user, $id_tipo_notificacion);
            foreach ($canalNotificacionUser as $index => $canalUser) {
                switch ($canalUser->id_canal) {
                    case CanalNotificacion::ID_CANAL_EMAIL:
                        $channel = Yii::$app->getModule('notifications')->getChannel('email');
                        $this->toEmail($channel, $id_user, 'mperalta@scplcr.com', $id_tipo_notificacion);
                        break;
                    case CanalNotificacion::ID_CANAL_SISTEMA:
                        
                        break;
                    
                    default:
                        
                        break;
                }
            }
        }

    }

    private function toEmail($channel, $id_user, $email_user, $id_tipo_notificacion){
        $tipo_notificacion = TipoNotificacion::buscar($id_tipo_notificacion);
        $subject = "";
        $template = ""; // es la vista del email.
        $message = $channel->mailer->compose($template, [
            'user' => $id_user,
            // 'notification' => $notification,
        ]);

        Yii::configure($message, $channel->message);

        $message->setTo($email_user);
        $message->setSubject($$tipo_notificacion->subject);
        $send = $message->send($channel->mailer); 
    }
    
}