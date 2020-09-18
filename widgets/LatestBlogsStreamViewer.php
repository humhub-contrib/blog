<?php


namespace humhub\modules\blog\widgets;


use humhub\modules\stream\widgets\StreamViewer;


class LatestBlogsStreamViewer extends StreamViewer
{
    /**
     * @inheritdoc
     */
    public $jsWidget = 'blog.LatestBlogsStream';

    /**
     * @var string stream view
     * @since 1.3
     */
    public $view = 'latestBlogsStream';

    public $streamAction = '/blog/view/stream';

    public $streamFilterNavigation = null;

    /**
     * @inheritdoc
     */
    public $id = 'latestBlogStream';
}