<?php

namespace webzop\notifications\channels;

use Yii;
use webzop\notifications\Channel;
use webzop\notifications\model\Notifications;
use webzop\notifications\Notification;
use yii\helpers\VarDumper;

class ScreenChannel extends Channel
{
    public function send(Notification $notification)
    {
        $db = Yii::$app->getDb();
        $className = get_class($notification);
        $currTime = time();
        
        $modelNotification = new Notifications();
        $modelNotification->class = strtolower(substr($className, strrpos($className, '\\')+1, -12));
        $modelNotification->key = $notification->key;
        $modelNotification->message = $notification->getTitle();
        $modelNotification->route = serialize($notification->getRoute());
        $modelNotification->user_id = $notification->userId;
        $modelNotification->created_at = $currTime;
        $res = $modelNotification->save();
        // $res = $db->createCommand()->insert('{{%notifications}}', [
        //     'class' => strtolower(substr($className, strrpos($className, '\\')+1, -12)),
        //     'key' => $notification->key,
        //     'message' => (string)$notification->getTitle(),
        //     'route' => serialize($notification->getRoute()),
        //     'user_id' => $notification->userId,
        //     'created_at' => $currTime,
        // ])->execute();
        Yii::error(VarDumper::dumpAsString($modelNotification));

        Yii::error(VarDumper::dumpAsString($res));

    }

}
