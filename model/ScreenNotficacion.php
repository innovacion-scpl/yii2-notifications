<?php
namespace webzop\notifications\model;

use Yii;
use webzop\notifications\Notification;


class ScreenNotficacion extends Notification
{

    public $user;
    public $contenido;

    
    public function getTitle()
    {
        return $this->contenido;
        
    }

    
}