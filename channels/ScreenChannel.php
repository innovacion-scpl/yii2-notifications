<?php

namespace webzop\notifications\channels;

use Yii;
use webzop\notifications\Channel;
use webzop\notifications\model\Notifications;
use webzop\notifications\Notification;

class ScreenChannel extends Channel
{
    public function send(Notification $notification)
    {
        $db = Yii::$app->getDb();
        $className = get_class($notification);
        $currTime = time();
        
        $modelNotification = new Notifications();
        $modelNotification->class = 'screen';
        $modelNotification->key = $notification->key;
        $modelNotification->message = $notification->getTitle();
        $modelNotification->route = serialize($notification->getRoute());
        $modelNotification->user_id = $notification->userId;
        $modelNotification->created_at = $currTime;
        $res = $modelNotification->save();
    }

}
