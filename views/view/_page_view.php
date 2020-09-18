<?php
use humhub\libs\Html;

/* @var $this \humhub\components\View */
/* @var $blog \humhub\modules\custom_pages\models\CustomContentContainer */
?>

<div style="display:none;" data-widget-fade-in="slow" data-ui-widget="blog.BlogContent" data-ui-init="1">
    <?= $this->render('_page_view_head', ['blog' => $blog]) ?>
    <div class="blog-content <?= Html::encode($blog->cssClass) ?>">
        <?= $blog->render() ?>
    </div>
</div>