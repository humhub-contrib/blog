<?php


namespace humhub\modules\blog\widgets;


use humhub\modules\content\components\ContentActiveRecord;
use humhub\widgets\JsWidget;

class LatestBlogsSnippet extends JsWidget
{
    /**
     * @var ContentActiveRecord
     */
    public $container;

    public function run()
    {

        return $this->render('latestBlogSnippet', ['container' => $this->container]);
    }

}