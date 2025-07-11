<?php

namespace webzop\notifications\model;

use Yii;

/**
 * This is the model class for table "canal_user".
 *
 * @property int $id_canal
 * @property int $id_user
 *
 * @property CanalNotificacion $canal
 * @property User $user
 */
class CanalUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'canal_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_canal', 'id_user'], 'required'],
            [['id_canal', 'id_user'], 'integer'],
            [['id_canal', 'id_user'], 'unique', 'targetAttribute' => ['id_canal', 'id_user']],
            [['id_canal'], 'exist', 'skipOnError' => true, 'targetClass' => CanalNotificacion::className(), 'targetAttribute' => ['id_canal' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_canal' => 'Id Canal',
            'id_user' => 'Id User',
        ];
    }

    /**
     * Gets query for [[Canal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCanal()
    {
        return $this->hasOne(CanalNotificacion::className(), ['id' => 'id_canal']);
    }
}