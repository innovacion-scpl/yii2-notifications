<?php

use yii\db\Migration;

class m250711_113808_tipo_notificacion extends Migration
{
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('{{%tipo_notificacion}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string(100)->notNull(),
            'content' => $this->string(300)->notNull(),
        ]);
    }

    public function down()
    {
        echo "m250711_113808_tipo_notificacion cannot be reverted.\n";

        return false;
    }
    
}
