<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use backend\assets\AppAsset;

AppAsset::register($this);
$this->title = "Notificaciones";
?>


<h1>
    <span class="fas fa-bullhorn"></span>
    <a href="<?= Url::to(['/notifications/canal-user/index']) ?>" style="text-decoration:none; color:black;">Mis notificaciones</a>
</h1>

<div class="buttons pb-4">
    <!-- <a class="btn btn-danger" href="<?= Url::toRoute(['/notifications/default/delete-all']) ?>"><?= Yii::t('modules/notifications', 'Delete all'); ?></a> -->
    <a class="btn btn-primary" href="<?= Url::toRoute(['/notifications/default/read-all']) ?>">Marcar todo como leído</a>
</div>

<?php if($notifications) { ?>
    <div class="card">
        <?php foreach($notifications as $notif):
                if ($notif['read']) { ?>
                    <!-- Notificaciones leídas -->
                    <div class="card-body notification-item-view read">
                        <a href="" class="read" data-id="<?= $notif['id']?>" data-key="<?= $notif['key']?>" style="text-decoration:none; color:black;">
                            <?= Html::encode($notif['message'])?>
                        </a>
                        <small class="timeago"><?= $notif['timeago']; ?></small>
                        <span class="mark-read" data-toggle="tooltip" title="Leído"></span>
                    </div>                    
                <?php }else{ ?>
                    <!-- Notificaciones que no fueron leídas -->
                        <div class="card-body notification-item-view">
                            <a href="<?= Url::toRoute(['/notifications/default/read', 'id' => $notif['id']]) ?>" data-id="<?= $notif['id']?>" data-key="<?= $notif['key']?>" style="text-decoration:none; color:black;">
                                <?= Html::encode($notif['message'])?>
                            </a>
                            <small class="timeago"><?= $notif['timeago']; ?></small>
                            <span class="mark-read" data-toggle="tooltip" title="Marcar como leído"></span>
                        </div>     
                <?php    
                    }
                ?>
        <?php endforeach; ?>
    </div>
    <?= LinkPager::widget([
            'pagination' => $pagination,
            // Optional: Customize labels and CSS classes for Bootstrap 5 styling
            'firstPageLabel' => 'Primera',
            'lastPageLabel' => 'Última',
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
            'options' => ['class' => 'pagination justify-content-center'], // Bootstrap 5 pagination classes
            'linkContainerOptions' => ['class' => 'page-item'],
            'linkOptions' => ['class' => 'page-link'],
            'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'], // For disabled links
        ]);
    ?>
    <?php
        }else{ ?>
                <p class="empty-row"><i>No hay notificaciones para mostrar.</i></p>
    <?php    
        }
    ?>

<?= LinkPager::widget(['pagination' => $pagination]); ?>