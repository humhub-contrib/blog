<?php

use humhub\modules\blog\widgets\Sidebar;
use humhub\modules\blog\widgets\LatestBlogsSnippet;
use humhub\modules\space\models\Space;
use humhub\modules\content\widgets\WallEntryAddons;


/* @var $this \humhub\components\View */
/* @var $container \humhub\modules\content\components\ContentContainerActiveRecord */
/* @var $isCustomPagesEnabled bool */
/* @var $blog \humhub\modules\custom_pages\models\ContainerPage */
/* @var $nextBlog \humhub\modules\custom_pages\models\ContainerPage */
/* @var $prevBlog \humhub\modules\custom_pages\models\ContainerPage */
/* @var $sidebar bool */

\humhub\modules\blog\assets\Assets::register($this);

$isSpaceAdmin = $container->isAdmin();

?>

<div id="blog-root">
    <div class="panel panel-default">

        <div class="panel-body">
            <?php if (!$isCustomPagesEnabled && $isSpaceAdmin) : ?>
                <?= $this->render('_activate_custom_pages', ['space' => $container]) ?>
            <?php elseif ($blog) : ?>
                <?= $this->render('_page_view', ['blog' => $blog]) ?>
            <?php else: ?>
                <?= $this->render('_page_empty', ['canCreate' => $isSpaceAdmin, 'container' => $container]) ?>
            <?php endif; ?>

            <?php if ($blog && ($prevBlog || $nextBlog)) : ?>
                <?= $this->render('_blog_navigation', ['container' => $container, 'prevBlog' => $prevBlog, 'nextBlog' => $nextBlog]) ?>
            <?php endif; ?>
        </div>
    </div>


    <?php if ($blog) : ?>
        <div id="blog-content-addon" class="panel panel-default">

            <div class="panel-body">
                <?= WallEntryAddons::widget(['object' => $blog]); ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<?php if ($sidebar && $container instanceof Space) : ?>
    <?php $this->beginBlock('sidebar'); ?>
    <?= Sidebar::widget(['space' => $container, 'widgets' => [
        [LatestBlogsSnippet::class, ['container' => $container], ['sortOrder' => 10]],
    ]]); ?>
    <?php $this->endBlock(); ?>
<?php endif; ?>

