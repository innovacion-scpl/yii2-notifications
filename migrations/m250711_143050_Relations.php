<?php

use yii\db\Schema;
use yii\db\Migration;

class m250711_143050_Relations extends Migration
{

    public function init()
    {
       $this->db = 'db';
       parent::init();
    }

    public function safeUp()
    {
        $this->addForeignKey('fk_tipo_notificacion_canal_id_canal',
            '{{%tipo_notificacion_canal}}','id_canal',
            '{{%canal_notificacion}}','id'
        );
        $this->addForeignKey('fk_tipo_notificacion_canal_id_tipo_notificacion',
            '{{%tipo_notificacion_canal}}','id_tipo_notificacion',
            '{{%tipo_notificacion}}','id'
        );
        $this->addForeignKey('fk_canal_user_id_canal',
        '{{%canal_user}}','id_canal',
        '{{%canal_notificacion}}','id'
        );
        $this->addForeignKey('fk_canal_user_id_tipo_notificacion',
            '{{%canal_user}}','id_tipo_notificacion',
            '{{%tipo_notificacion}}','id'
        );
        $this->addForeignKey('fk_canal_user_id_user',
            '{{%canal_user}}','id_user',
            '{{%user}}','id'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_tipo_notificacion_canal_id_canal', '{{%tipo_notificacion_canal}}');
        $this->dropForeignKey('fk_tipo_notificacion_canal_id_tipo_notificacion', '{{%tipo_notificacion_canal}}');
    }
}
