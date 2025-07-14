<?php

namespace webzop\notifications\model;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use webzop\notifications\model\TipoNotificacionCanal;

/**
 * TipoNotificacionCanalSearch represents the model behind the search form of `backend\models\TipoNotificacionCanal`.
 */
class TipoNotificacionCanalSearch extends TipoNotificacionCanal
{
    public $check_notify;
    public $check_es_seleccionable;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo_notificacion', 'id_canal', 'es_seleccinable'], 'integer'],
            [['id_tipo_notificacion', 'id_canal', 'es_seleccinable'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = TipoNotificacionCanal::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
