<?php

use yii\db\Migration;

class m250711_113844_canal_user extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%canal_user}}', [
            'id_canal' => $this->primaryKey(),
            'id_user' => $this->int(10)->notNull(),
        ]);

        // add foreign key for table `canal`
        $this->addForeignKey(
            'canal_user_canal_notificacion_FK',
            'canal_user',
            'id_canal',
            'canal_notificacion',
            'id'
        );
        
    }

    public function down()
    {
        echo "m250711_113844_canal_user cannot be reverted.\n";

        return false;
    }
}
