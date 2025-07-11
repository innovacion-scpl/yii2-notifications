<?php

use yii\db\Schema;
use yii\db\Migration;

class m250711_143047_tipo_notificacion extends Migration
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
            '{{%tipo_notificacion}}',
            [
                'id'=> $this->primaryKey(11),
                'subject'=> $this->string(100)->notNull(),
                'content'=> $this->string(300)->notNull(),
            ],$tableOptions
        );

    }

    public function safeDown()
    {
        $this->dropTable('{{%tipo_notificacion}}');
    }
}
