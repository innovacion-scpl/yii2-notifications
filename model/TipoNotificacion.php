<?php

namespace webzop\notifications\model;

use Yii;

/**
 * This is the model class for table "tipo_notificacion".
 *
 * @property int $id
 * @property string $subject
 * @property string $content
 *
 * @property TipoNotificacionCanal[] $tipoNotificacionCanals
 * @property CanalNotificacion[] $canals
 */
class TipoNotificacion extends \yii\db\ActiveRecord
{
    public $check_notify;
    public $check_es_seleccionable;
    public $check_notify_email;
    public $check_notify_system;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_notificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'content'], 'required'],
            [['subject'], 'string', 'max' => 100],
            [['content'], 'string', 'max' => 300],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subject' => 'Subject',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[TipoNotificacionCanals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacionCanals()
    {
        return $this->hasMany(TipoNotificacionCanal::className(), ['id_tipo_notificacion' => 'id']);
    }

    /**
     * Gets query for [[Canals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCanals()
    {
        return $this->hasMany(CanalNotificacion::className(), ['id' => 'id_canal'])->viaTable('tipo_notificacion_canal', ['id_tipo_notificacion' => 'id']);
    }

    public static function searchAll(){
        $notificaciones = TipoNotificacion::find()->all();
        return $notificaciones;
    }
}