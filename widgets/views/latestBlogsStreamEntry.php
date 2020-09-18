<?php

use humhub\modules\user\widgets\Image;
use humhub\libs\Html;
use humhub\widgets\TimeAgo;
use humhub\modules\blog\assets\Assets;
use humhub\modules\blog\helpers\Url;

/* @var $this \humhub\components\View */
/* @var $blog \humhub\modules\custom_pages\models\ContainerPage */

Assets::register($this);
?>

<li data-stream-entry data-action-component="blog.LatestBlogsStreamEntry" data-action-click="loadEntry"
    data-action-url="<?= Url::toLoadBlog($blog, $blog->content->container) ?>"
    data-content-key="<?= $blog->content->id ?>">
    <div class="media">
        <div class="media-left">
            <?= Image::widget(['user' => $blog->content->createdBy, 'width' => '32']) ?>
        </div>
        <div class="media-body">
            <h4 class="media-heading"><strong><?= Html::encode($blog->title) ?></strong><?= $blog->admin_only ? ' <i class="fa fa-lock pull-right"></i>' : '' ?></h4>
            <?= TimeAgo::widget(['timestamp' => $blog->content->created_at]); ?>
        </div>
    </div>
</li>
