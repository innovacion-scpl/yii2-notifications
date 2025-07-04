<?php

namespace webzop\notifications\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\db\Query;
use webzop\notifications\NotificationsAsset;


class Notifications extends \yii\base\Widget
{

    public $options = ['class' => 'nav-item dropdown nav-notifications'];

    /**
     * @var string the HTML options for the item count tag. Key 'tag' might be used here for the tag name specification.
     * For example:
     *
     * ```php
     * [
     *     'tag' => 'span',
     *     'class' => 'badge badge-warning',
     * ]
     * ```
     */
    public $countOptions = [];

    /**
     * @var array additional options to be passed to the notification library.
     * Please refer to the plugin project page for available options.
     */
    public $clientOptions = [];
    /**
     * @var integer the XHR timeout in milliseconds
     */
    public $xhrTimeout = 2000;
    /**
     * @var integer The delay between pulls in milliseconds
     */
    public $pollInterval = 60000;

    public function init()
    {
        parent::init();

        if(!isset($this->options['id'])){
            $this->options['id'] = $this->getId();
        }
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo $this->renderNavbarItem();

        $this->registerAssets();
    }

    /**
     * @inheritdoc
     */
    protected function renderNavbarItem()
    {
        $html  = Html::beginTag('div', $this->options);
            /** ICONO DE CAMPANA */
            $html .= Html::beginTag('a', ['href' => '#', 'class' => 'nav-link dropdown-toggle', 'data-bs-toggle' => 'dropdown', 'role' => 'button',  'aria-expanded' =>"false"]);
                $html .= Html::tag('span', '', ['class' => 'fas fa-bell']);
                /** CONTADOR DE NOTIFICACIONES */
                $count = self::getCountUnread();
                $countOptions = array_merge([
                    'tag' => 'span',
                    'data-count' => $count,
                ], $this->countOptions);
                Html::addCssClass($countOptions, 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger');
                if(!$count){
                    $countOptions['style'] = 'display: none;';
                }
                $countTag = ArrayHelper::remove($countOptions, 'tag', 'span');
                $html .= Html::tag($countTag, $count, $countOptions);
                /******************************/
            $html .= Html::endTag('a');
            /** FINALIZA EL BOTON PARA DESPLEGAR LAS NOTIFICACIONES */

            /** EMPIEZAN LAS NOTIFICACIONES */
            $html .= Html::begintag('ul', ['class' => 'dropdown-menu']);
                // $header = Html::a('Marcar todo como leído', '#', ['class' => 'read-all pull-right text-decoration-none']);
                $header = Html::tag('p','Notificaciones', ['class' => 'encabezado-text']);
                $html .= Html::tag('div', $header, ['class' => 'nav-header']);
                $html .= Html::begintag('div', ['id' => 'notifications-list']);
                    $html .= Html::begintag('div', ['class' => 'dropdown-item']);
                        $html .= Html::tag('div', '<span class="ajax-loader"></span>', ['class' => 'loading-row']);
                        $html .= Html::tag('div', Html::tag('span', Yii::t('modules/notifications', 'No tiene notificaciones'), ['style' => 'display: none;']), ['class' => 'empty-row']);
                    $html .= Html::endTag('div');
                $html .= Html::endTag('div');

                $footer = Html::a(Yii::t('modules/notifications', 'Ver todo'), ['/notifications/default/index']);
                $html .= Html::tag('div', $footer, ['class' => 'nav-footer']);
            $html .= Html::endTag('ul');
        $html .= Html::endTag('div');

        return $html;
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $this->clientOptions = array_merge([
            'id' => $this->options['id'],
            'url' => Url::to(['/notifications/default/list']),
            'countUrl' => Url::to(['/notifications/default/count']),
            'readUrl' => Url::to(['/notifications/default/read']),
            'readAllUrl' => Url::to(['/notifications/default/read-all']),
            'xhrTimeout' => Html::encode($this->xhrTimeout),
            'pollInterval' => Html::encode($this->pollInterval),
        ], $this->clientOptions);

        $js = 'Notifications(' . Json::encode($this->clientOptions) . ');';
        $view = $this->getView();

        NotificationsAsset::register($view);

        $view->registerJs($js);
    }

    public static function getCountUnseen(){
        $userId = Yii::$app->getUser()->getId();
        $count = (new Query())
            ->from('{{%notifications}}')
            ->andWhere(['or', 'user_id = 0', 'user_id = :user_id'], [':user_id' => $userId])
            ->andWhere(['seen' => false])
            ->count();
        return $count;
    }

    public static function getCountUnread(){
        $userId = Yii::$app->getUser()->getId();
        $count = (new Query())
            ->from('{{%notifications}}')
            ->andWhere(['or', 'user_id = 0', 'user_id = :user_id'], [':user_id' => $userId])
            ->andWhere(['read' => false])
            ->count();
        return $count;
    }
}
