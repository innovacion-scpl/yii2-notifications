<?php

use yii\db\Schema;
use yii\db\Migration;

class m250711_143048_tipo_notificacion_canal extends Migration
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
            '{{%tipo_notificacion_canal}}',
            [
                'id_tipo_notificacion'=> $this->integer(11)->notNull(),
                'id_canal'=> $this->integer(11)->notNull(),
                'es_seleccionable'=> $this->tinyInteger(1)->notNull()->defaultValue(0),
            ],$tableOptions
        );
        $this->createIndex('tipo_notificacion_canal_canal_notificacion_FK','{{%tipo_notificacion_canal}}',['id_canal'],false);
        $this->addPrimaryKey('pk_on_tipo_notificacion_canal','{{%tipo_notificacion_canal}}',['id_tipo_notificacion','id_canal']);

    }

    public function safeDown()
    {
    $this->dropPrimaryKey('pk_on_tipo_notificacion_canal','{{%tipo_notificacion_canal}}');
        $this->dropIndex('tipo_notificacion_canal_canal_notificacion_FK', '{{%tipo_notificacion_canal}}');
        $this->dropTable('{{%tipo_notificacion_canal}}');
    }
}
