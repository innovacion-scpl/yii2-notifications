<?php

use yii\db\Schema;
use yii\db\Migration;

class m250711_143046_canal_notificacion extends Migration
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
            '{{%canal_notificacion}}',
            [
                'id'=> $this->primaryKey(11),
                'nombre'=> $this->string(100)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%canal_notificacion}}');
    }
}
