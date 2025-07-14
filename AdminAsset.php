<?php

namespace webzop\notifications;

use yii\web\AssetBundle;

/**
 * Class AdminAsset
 *
 * @package webzop\notifications
 */
class AdminAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = __DIR__.'/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/admin.js',
    ];

    /**
     * @inheritdoc
     */
    public $css = [
        // 'css/notifications.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];

}
