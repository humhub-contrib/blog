<?php
use humhub\widgets\Button;

/* @var $this \humhub\components\View */
/* @var $space \humhub\modules\space\models\Space */
?>

<div class="alert alert-info blog-install-info">
    <i class="fa fa-info-circle"></i>
    <?= Yii::t('BlogModule.base',
        'Please activate the Custom Pages module on this space, in order to use the blog features.'); ?>
    <div class="clearfix" style="margin-top:10px" >
        <?= Button::primary(Yii::t('BlogModule.base', 'Modules'))->icon('fa-rocket')
            ->link($space->createUrl('/space/manage/module'))->sm() ?>
    </div>
</div>
