<?php

namespace webzop\notifications\model;

use Yii;

/**
 * This is the model class for table "canal_notificacion".
 *
 * @property int $id
 * @property string $nombre
 *
 * @property CanalUser[] $canalUsers
 * @property User[] $users
 * @property TipoNotificacionCanal[] $tipoNotificacionCanals
 * @property TipoNotificacion[] $tipoNotificacions
 */
class CanalNotificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'canal_notificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[CanalUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCanalUsers()
    {
        return $this->hasMany(CanalUser::className(), ['id_canal' => 'id']);
    }

    /**
     * Gets query for [[TipoNotificacionCanals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacionCanals()
    {
        return $this->hasMany(TipoNotificacionCanal::className(), ['id_canal' => 'id']);
    }

    /**
     * Gets query for [[TipoNotificacions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacions()
    {
        return $this->hasMany(TipoNotificacion::className(), ['id' => 'id_tipo_notificacion'])->viaTable('tipo_notificacion_canal', ['id_canal' => 'id']);
    }
}