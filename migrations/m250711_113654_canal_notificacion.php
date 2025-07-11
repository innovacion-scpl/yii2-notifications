<?php

use yii\db\Migration;

class m250711_113654_canal_notificacion extends Migration
{ 
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
         // notifications
         $this->createTable('{{%canal_notificacion}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string(100)->notNull(),
        ]);
    }

    public function down()
    {
        echo "m250711_113654_canal_notificacion cannot be reverted.\n";

        return false;
    }
    
}
