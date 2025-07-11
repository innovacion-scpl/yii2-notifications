<?php

use yii\db\Migration;

class m250711_113826_tipo_notificacion_canal extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%tipo_notificacion_canal}}', [
            'id_tipo_notificacion' => $this->primaryKey(),
            'id_canal' => $this->integer(11)->notNull(),
        ]);

        // add foreign key for table `canal`
        $this->addForeignKey(
            'tipo_notificacion_canal_notificacion_FK',
            'tipo_notificacion_canal',
            'id_canal',
            'canal_notificacion',
            'id'
        );
        // add foreign key for table `user`
        $this->addForeignKey(
            'tipo_notificacion_canal_tipo_notificacion_FK',
            'tipo_notificacion_canal',
            'id_tipo_notificacion',
            'tipo_notificacion',
            'id'
        );
    }

    public function down()
    {
        echo "m250711_113826_tipo_notificacion_canal cannot be reverted.\n";

        return false;
    }

}
