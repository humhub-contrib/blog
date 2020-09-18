<?php
use humhub\modules\blog\widgets\LatestBlogsStreamViewer;
use humhub\widgets\PanelMenu;

/* @var $this \humhub\components\View */
/* @var $container \humhub\modules\content\components\ContentContainerActiveRecord*/
?>

<div id="latest-blog-snippet" class="panel panel-default panel-activities">
    <?= PanelMenu::widget(['id' => 'panel-activities']); ?>
    <div class="panel-heading">
        <?= Yii::t('BlogModule.base', '<strong>Latest</strong> blog posts') ?>
    </div>
    <div class="panel-body">
        <?= LatestBlogsStreamViewer::widget(['contentContainer' => $container])?>
    </div>
</div>
