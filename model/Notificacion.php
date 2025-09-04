<?php

namespace webzop\notifications\model;

use Yii;
use webzop\notifications\Notification;
use yii\helpers\VarDumper;


class Notificacion extends \yii\db\ActiveRecord
{
     /** 
     * Permite envíar la misma notificación, por distintos canales a un
     * grupo de usuarios.
     * 
     * @param array $id_users
     * @param int $id_tipo_notificacion
     * 
    */
    public function sendNotifications($user, $contenido, $id_tipo_notificacion){
        $canalNotificacionUser = CanalUser::buscarPorNotificacion($user->id, $id_tipo_notificacion);
        foreach ($canalNotificacionUser as $index => $canalUser) {
            switch ($canalUser->id_canal) {
                case CanalNotificacion::ID_CANAL_EMAIL:
                    $channel = Yii::$app->getModule('notifications')->getChannel('email');
                    $this->toEmail($channel, $user->correo, $contenido, $id_tipo_notificacion);
                    break;
                case CanalNotificacion::ID_CANAL_SISTEMA:
                    $channel = Yii::$app->getModule('notifications')->getChannel('screen');
                    $this->toScreen($channel, $user, $contenido, $id_tipo_notificacion);
                    break;
                
                default:
                    
                    break;
            }
        }
        
    }

    private function toEmail($channel, $email_user, $contenido, $id_tipo_notificacion){
        $tipo_notificacion = TipoNotificacion::buscar($id_tipo_notificacion);
        $template = $tipo_notificacion->view; // es la vista del email.
        $message = $channel->mailer->compose($template, [
            'mensaje' => $contenido,
        ]);

        Yii::configure($message, $channel->message);

        $message->setTo($email_user);
        $message->setSubject($tipo_notificacion->subject);
        $send = $message->send($channel->mailer);
        return $send;
    }

    public static function traducirMensaje($contet, $params){
        return Yii::t('app', $contet, $params);
    }

    private function toScreen($channel, $user, $contenido, $id_tipo_notificacion){
        if (!Notificacion::notificacionEnviada($user->id, $id_tipo_notificacion)) {
            $sendNot = ScreenNotficacion::create($id_tipo_notificacion, ['user' => $user, 'contenido' => $contenido, 'userId' => $user->id]);
            $sendNot->send($channel);            
        }
    }

    /** $key se refiere al id de tipo notificación */
    private static function notificacionEnviada($user_id, $key){
        $notificacion = Notifications::findOne(['user_id' => $user_id, 'key' => $key]);
        return isset($notificacion->id);
    }
}