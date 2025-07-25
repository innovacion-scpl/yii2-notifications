<?php

namespace webzop\notifications\model;

use Yii;
use Exception;
use common\models\User;
use yii\helpers\VarDumper;

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

    const CANAL_EMAIL = 1;
    const CANAL_SISTEMA = 2;

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
            [['id_canal', 'id_user', 'id_tipo_notificacion'], 'required'],
            [['id_canal', 'id_user', 'id_tipo_notificacion'], 'integer'],
            [['id_canal', 'id_user', 'id_tipo_notificacion'], 'unique', 'targetAttribute' => ['id_canal', 'id_user', 'id_tipo_notificacion']],
            [['id_canal'], 'exist', 'skipOnError' => true, 'targetClass' => CanalNotificacion::class, 'targetAttribute' => ['id_canal' => 'id']],
            [['id_tipo_notificacion'], 'exist', 'skipOnError' => true, 'targetClass' => TipoNotificacion::class, 'targetAttribute' => ['id_tipo_notificacion' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
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
            'id_tipo_notificacion' => 'Id Tipo Notificacion',
        ];
    }

    /**
     * Gets query for [[Canal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCanal()
    {
        return $this->hasOne(CanalNotificacion::class, ['id' => 'id_canal']);
    }

    /**
     * Gets query for [[Canal]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTipoNotificacion()
    {
        return $this->hasOne(TipoNotificacion::class, ['id' => 'id_tipo_notificacion']);
    }

     /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public static function  buscar($id_canal, $id_tipo_notificacion){
        $asociacion = CanalUser::find()
                                ->where(['id_canal' => $id_canal])
                                ->andWhere(['id_tipo_notificacion' => $id_tipo_notificacion])
                                ->one();
        return $asociacion;
    }
    
    public static function buscarPorUsuario($id_canal, $id_tipo_notificacion, $id_user){
        $asociacion = CanalUser::find()
                                ->where(['id_canal' => $id_canal])
                                ->andWhere(['id_tipo_notificacion' => $id_tipo_notificacion])
                                ->andWhere(['id_user' => $id_user])
                                ->one();
        return $asociacion;
    }

    public static function eliminar($id_canal, $id_tipo_notificacion, $id_user){
        $asociacion = CanalUser::buscarPorUsuario($id_canal, $id_tipo_notificacion, $id_user);
        return $asociacion->delete() == 1;
    }

    public static function eliminarNotificacionCanal($id_canal, $id_tipo_notificacion){
        $del = CanalUser::deleteAll(['id_canal' => $id_canal, 'id_tipo_notificacion' => $id_tipo_notificacion]);
        // return ($del == false) ? false : true;
    }

    public static function buscarPorNotificacion($id_user, $id_tipo_notificacion){
        $asociaciones = CanalUser::find()
                                ->where(['id_tipo_notificacion' => $id_tipo_notificacion])
                                ->andWhere(['id_user' => $id_user])
                                ->all();
        return $asociaciones;
    }

    public function guardar($id_user, $id_canal, $id_tipo_notificacion){
        $transaccion = Yii::$app->db->beginTransaction();
        try {
            /** Verificar si ya no esta creada la asociación */
            if (!isset(CanalUser::buscarPorUsuario($id_canal, $id_tipo_notificacion, $id_user)->id_canal)) {
                $canalUser = new CanalUser();
                $canalUser->id_user = $id_user;
                $canalUser->id_canal = $id_canal;
                $canalUser->id_tipo_notificacion = $id_tipo_notificacion;
                if($canalUser->save()) {
                    $transaccion->commit();
                    return true;
                }
                $transaccion->rollBack();
                return false;
            }
            return true;
        } catch (Exception $e) {
            $transaccion->rollBack();
            return false;
        }
    }
}