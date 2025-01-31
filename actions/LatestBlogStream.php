<?php

namespace humhub\modules\blog\actions;

use humhub\modules\blog\widgets\LatestBlogsStreamEntry;
use humhub\modules\content\components\ContentActiveRecord;
use Yii;
use yii\web\Response;
use humhub\modules\blog\integration\BlogService;
use humhub\modules\space\models\Space;
use humhub\modules\stream\actions\ContentContainerStream;
use humhub\modules\stream\models\StreamQuery;

class LatestBlogStream extends ContentContainerStream
{
    /**
     * @inheritdoc
     */
    public $streamQueryClass = StreamQuery::class;

    public function init()
    {
        if ($this->isEnabled()) {
            $this->includes = ['humhub\modules\custom_pages\models\ContainerPage'];
        }

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!$this->isEnabled()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [];
        }

        return parent::run();
    }

    protected function setActionSettings()
    {
        parent::setActionSettings();
        $this->streamQuery->channel = null;
    }

    public static function renderEntry(ContentActiveRecord $record, $options =  [], $partial = true)
    {
        return LatestBlogsStreamEntry::widget(['blog' => $record]);
    }

    /**
     * @inheritdoc
     */
    public function setupFilters()
    {
        if ($this->isEnabled()) {
            $this->activeQuery->innerJoin('custom_pages_container_page', 'content.object_id=custom_pages_container_page.id');
            $this->activeQuery->andWhere(['custom_pages_container_page.target' => BlogService::DEFAULT_TARGET_ID]);

            if ($this->contentContainer instanceof Space && !$this->contentContainer->isAdmin()) {
                $this->activeQuery->andWhere(['custom_pages_container_page.admin_only' => 0]);
            }
        }
    }

    public function isEnabled()
    {
        return (new BlogService())->isCustomPagesInstalled($this->contentContainer);
    }
}
