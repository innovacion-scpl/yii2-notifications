<?php

namespace webzop\notifications\model;

use Yii;

/**
 * This is the model class for table "tipo_notificacion".
 *
 * @property int $id
 * @property string $subject
 * @property string $content
 * @property string|null $view
 *
 * @property CanalUser[] $canalUsers
 * @property ModeloAtributoNotificacion[] $modeloAtributoNotificacions
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
            [['subject', 'view'], 'string', 'max' => 100],
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
            'view' => 'View'
        ];
    }

    /**
     * Gets query for [[CanalUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCanalUsers()
    {
        return $this->hasMany(CanalUser::class, ['id_tipo_notificacion' => 'id']);
    }

    /**
     * Gets query for [[TipoNotificacionCanals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacionCanals()
    {
        return $this->hasMany(TipoNotificacionCanal::class, ['id_tipo_notificacion' => 'id']);
    }

    /**
     * Gets query for [[Canals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCanals()
    {
        return $this->hasMany(CanalNotificacion::class, ['id' => 'id_canal'])->viaTable('tipo_notificacion_canal', ['id_tipo_notificacion' => 'id']);
    }

    public static function searchAll(){
        $notificaciones = TipoNotificacion::find()->all();
        return $notificaciones;
    }

    public static function buscar($id){
        $notificacion = TipoNotificacion::findOne(['id' => $id]);
        return $notificacion;

    }
}