<?php

use humhub\modules\user\widgets\Image;
use humhub\libs\Html;
use humhub\widgets\TimeAgo;
use humhub\modules\content\widgets\PermaLink;
use humhub\widgets\Link;
use humhub\modules\custom_pages\helpers\Url;

/* @var $this \humhub\components\View */
/* @var $blog \humhub\modules\custom_pages\models\CustomContentContainer */
?>

<div class="blog-header media">
    <div class="media-left">
        <?= Image::widget(['user' => $blog->content->createdBy, 'width' => '32']) ?>
    </div>
    <div class="media-body">
        <h4 class="media-heading"><?= Html::encode($blog->content->createdBy->displayName) ?></h4>
        <strong>
            <?= TimeAgo::widget(['timestamp' => $blog->content->created_at]); ?>
            <?= $blog->admin_only ? ' <i class="fa fa-lock"></i>' : '' ?>
        </strong>
    </div>

    <ul class="nav nav-pills preferences pull-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"
               aria-label="<?= Yii::t('base', 'Toggle panel menu'); ?>"
               aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu pull-right">
                <li>
                    <?= PermaLink::widget(['content' => $blog->content]) ?>
                </li>
                <?php if($blog->content->canEdit()) : ?>
                    <li>
                        <?= Link::to(Yii::t('base', 'Edit'), Url::toEditPage($blog->id, $blog->content->container))->icon('fa-pencil') ?>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
    </ul>
</div>



