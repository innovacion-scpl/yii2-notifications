<?php

use yii\db\Schema;
use yii\db\Migration;

class m250711_143049_canal_user extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

        $this->createTable(
            '{{%canal_user}}',
            [
                'id_canal'=> $this->integer(11)->notNull(),
                'id_user'=> $this->integer(10)->unsigned()->notNull(),
                'id_tipo_notificacion'=> $this->integer(11)->notNull(),
            ],$tableOptions
        );
        $this->createIndex('canal_user_canal_notificacion_FK','{{%canal_user}}',['id_canal'],false);
        $this->createIndex('canal_user_tipo_notificacion_FK','{{%canal_user}}',['id_tipo_notificacion'],false);
        $this->addPrimaryKey('pk_on_canal_user','{{%canal_user}}',['id_canal','id_user']);

    }

    public function safeDown()
    {
    $this->dropPrimaryKey('pk_on_canal_user','{{%canal_user}}');
        $this->dropIndex('canal_user_canal_notificacion_FK', '{{%canal_user}}');
        $this->dropIndex('canal_user_tipo_notificacion_FK', '{{%canal_user}}');
        $this->dropTable('{{%canal_user}}');
    }
}
