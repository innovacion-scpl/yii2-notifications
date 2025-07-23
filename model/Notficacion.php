<?php

namespace webzop\notifications\model;

use Yii;
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
    public function sendNotifications($id_user, $contenido, $id_tipo_notificacion){

        $canalNotificacionUser = CanalUser::buscarPorNotificacion($id_user, $id_tipo_notificacion);
        foreach ($canalNotificacionUser as $index => $canalUser) {
            switch ($canalUser->id_canal) {
                case CanalNotificacion::ID_CANAL_EMAIL:
                    $channel = Yii::$app->getModule('notifications')->getChannel('email');
                    // $canalNotificacion = CanalNotificacion::buscar($canalUser->id_canal);
                    $this->toEmail($channel, $id_user, 'mperalta@scplcr.com', $contenido, $id_tipo_notificacion);

                    break;
                case CanalNotificacion::ID_CANAL_SISTEMA:
                    
                    break;
                
                default:
                    
                    break;
            }
        }
        
    }

    private function toEmail($channel, $id_user, $email_user, $contenido, $id_tipo_notificacion){
        $tipo_notificacion = TipoNotificacion::buscar($id_tipo_notificacion);
        $template = $tipo_notificacion->view; // es la vista del email.
        $message = $channel->mailer->compose($template, [
            'mensaje' => $contenido,
        ]);

        Yii::configure($message, $channel->message);

        $message->setTo($email_user);
        $message->setSubject($tipo_notificacion->subject);
        Yii::error(VarDumper::dumpAsString($message));
        $send = $message->send($channel->mailer);
        Yii::error(VarDumper::dumpAsString($send));
    }

    public static function traducirMensaje($contet, $params){
        return Yii::t($contet, $params);
    }
    
}