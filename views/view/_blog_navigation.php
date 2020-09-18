<?php
use humhub\widgets\Link;
use humhub\modules\blog\helpers\Url;
use humhub\libs\Html;
use humhub\widgets\TimeAgo;

/* @var $this \humhub\components\View */
/* @var $container \humhub\modules\content\components\ContentContainerActiveRecord */
/* @var $nextBlog \humhub\modules\custom_pages\models\ContainerPage */
/* @var $prevBlog \humhub\modules\custom_pages\models\ContainerPage */

?>

<div class="blog-navigation container">
    <div class="row">
        <div class="col-xs-6 blog-nav-link text-right">
            <?php if($prevBlog) : ?>
                <a href="#" data-action-click="blog.load" data-action-url="<?= Url::toLoadBlog($prevBlog, $container) ?>">
                    <span class="main-nav-link"><i class="fa fa-arrow-left"></i><?= Yii::t('BlogModule.base', 'Last post') ?></span>
                    <p><?= Html::encode($prevBlog->title) ?></p>
                    <?= TimeAgo::widget(['timestamp' => $prevBlog->content->created_at]); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="col-xs-6 blog-nav-link">
            <?php if($nextBlog) : ?>
                <a href="#" data-action-click="blog.load" data-action-url="<?= Url::toLoadBlog($nextBlog, $container) ?>">
                    <span class="main-nav-link"><?= Yii::t('BlogModule.base', 'Next post') ?> <i class="fa fa-arrow-right"></i></span>
                    <p><?= Html::encode($nextBlog->title) ?></p>
                    <?= TimeAgo::widget(['timestamp' => $nextBlog->content->created_at]); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>