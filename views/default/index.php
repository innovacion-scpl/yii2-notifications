<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use backend\assets\AppAsset;
use webzop\notifications\DefaultAsset;

AppAsset::register($this);
DefaultAsset::register($this);
$this->title = "Notificaciones";
?>

<div class="notif-header">
    <div class="notif-header-title">
        <span class="fas fa-bullhorn"></span>
        <a href="<?= Url::to(['/notifications/canal-user/index']) ?>">Mis notificaciones</a>
    </div>
    <a class="btn btn-outline-secondary btn-sm" href="<?= Url::toRoute(['/notifications/default/read-all']) ?>">
        <span class="fas fa-check-double me-1"></span> Marcar todo como leído
    </a>
</div>

<?php if ($notifications) { ?>

<div class="notif-list">
    <?php foreach ($notifications as $notif):
        $isRead = $notif['read'];
        $url = $isRead ? '' : Url::toRoute(['/notifications/default/read', 'id' => $notif['id']]);
    ?>
    <div class="notif-item <?= $isRead ? 'notif-read' : 'notif-unread' ?>">
        <span class="notif-dot"></span>

        <a href="<?= $url ?>" class="notif-message <?= $isRead ? 'read' : '' ?>" data-id="<?= $notif['id'] ?>" data-key="<?= $notif['key'] ?>">
            <?= Html::decode($notif['message']) ?>
        </a>

        <div class="notif-meta">
            <small class="timeago"><?= $notif['timeago']; ?></small>
            <span class="mark-read" data-toggle="tooltip" title="<?= $isRead ? 'Leído' : 'Marcar como leído' ?>">
                <a href="<?= $url ?>" data-id="<?= $notif['id'] ?>" data-key="<?= $notif['key'] ?>">
                    <span class="fas fa-check"></span>
                </a>
            </span>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?= LinkPager::widget([
    'pagination' => $pagination,
    'firstPageLabel' => 'Primera',
    'lastPageLabel' => 'Última',
    'prevPageLabel' => '&laquo;',
    'nextPageLabel' => '&raquo;',
    'options' => ['class' => 'pagination justify-content-center mt-4'],
    'linkContainerOptions' => ['class' => 'page-item'],
    'linkOptions' => ['class' => 'page-link'],
    'disabledListItemSubTagOptions' => ['tag' => 'a', 'class' => 'page-link'],
]); ?>

<?php } else { ?>
<p class="empty-row text-muted"><i>No hay notificaciones para mostrar.</i></p>
<?php } ?>

