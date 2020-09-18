<?php
use humhub\libs\Html;
use humhub\widgets\Button;
use humhub\modules\blog\helpers\Url;

/* @var $this \humhub\components\View */
?>

<?= Html::beginTag('div', $options) ?>
    <ul id="latestBlogStreamContents" data-stream-content class="media-list"></ul>

    <?php if(Yii::$app->user->isAdmin()) : ?>
        <div class="panel-footer">
            <?= Button::primary(Yii::t('BlogModule.base', 'Create blog post'))->link(Url::toCreateBlog($contentContainer))->sm()?>
        </div>
    <?php endif; ?>
<?= Html::endTag('div') ?>