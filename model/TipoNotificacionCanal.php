<?php

namespace webzop\notifications\model;

use Yii;

/**
 * This is the model class for table "tipo_notificacion_canal".
 *
 * @property int $id_tipo_notificacion
 * @property int $id_canal
 *
 * @property CanalNotificacion $canal
 * @property TipoNotificacion $tipoNotificacion
 */
class TipoNotificacionCanal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_notificacion_canal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_notificacion', 'id_canal'], 'required'],
            [['id_tipo_notificacion', 'id_canal'], 'integer'],
            [['id_tipo_notificacion', 'id_canal'], 'unique', 'targetAttribute' => ['id_tipo_notificacion', 'id_canal']],
            [['id_canal'], 'exist', 'skipOnError' => true, 'targetClass' => CanalNotificacion::className(), 'targetAttribute' => ['id_canal' => 'id']],
            [['id_tipo_notificacion'], 'exist', 'skipOnError' => true, 'targetClass' => TipoNotificacion::className(), 'targetAttribute' => ['id_tipo_notificacion' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_notificacion' => 'Id Tipo Notificacion',
            'id_canal' => 'Id Canal',
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

    /**
     * Gets query for [[TipoNotificacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacion()
    {
        return $this->hasOne(TipoNotificacion::className(), ['id' => 'id_tipo_notificacion']);
    }
}