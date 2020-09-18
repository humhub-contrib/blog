<?php
use humhub\widgets\Button;
use humhub\modules\blog\helpers\Url;

/* @var $this \humhub\components\View */
/* @var $canCreate bool */
/* @var $container \humhub\modules\content\components\ContentContainerActiveRecord */
?>


    <div class="text-center blog-welcome" >
        <h1><?= Yii::t('BlogModule.base', '<strong>Blog</strong> Module') ?><strong></h1>

        <?php if($canCreate) : ?>
            <h2>
                <?= Yii::t('BlogModule.base', 'No blogs created yet. So it\'s on you.') ?>
                <br>
                <?= Yii::t('BlogModule.base', 'Create the first blog now.'); ?>
            </h2>
            <br>
            <p>
                <?= Button::primary(Yii::t('BlogModule.base', 'Let\'s go!'))->link(Url::toCreateBlog($container))?>
            </p>
        <?php else: ?>
            <?= Yii::t('BlogModule.base', 'No blogs created yet.') ?>
        <?php endif; ?>
    </div>
