<?php

namespace humhub\modules\blog\actions;

use Yii;
use yii\db\Expression;
use yii\web\Response;
use Exception;
use humhub\modules\blog\integration\BlogService;
use humhub\modules\blog\widgets\LatestBlogsStreamEntry;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\content\models\Content;
use humhub\modules\space\models\Space;
use humhub\modules\stream\actions\ContentContainerStream;
use humhub\modules\stream\models\StreamQuery;


class LatestBlogStream extends ContentContainerStream
{
    public function init()
    {
        if($this->isEnabled()) {
            $this->includes = ['humhub\modules\custom_pages\models\ContainerPage'];
        }

        parent::init();
    }

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if(!$this->isEnabled()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [];
        }

        return parent::run();
    }

    /**
     * @inheritdoc
     */
    public $streamQueryClass = StreamQuery::class;

    protected function setActionSettings()
    {
        parent::setActionSettings();
        $this->streamQuery->channel = null;
    }

    /**
     * @inheritdoc
     */
    public function setupFilters()
    {
        if($this->isEnabled()) {
            $this->activeQuery->innerJoin('custom_pages_container_page', 'content.object_id=custom_pages_container_page.id');
            $this->activeQuery->andWhere(['custom_pages_container_page.target' => BlogService::DEFAULT_TARGET_ID]);

            if($this->contentContainer instanceof Space && !$this->contentContainer->isAdmin()) {
                $this->activeQuery->andWhere(['custom_pages_container_page.admin_only' => 0]);
            }
        }
    }

    /**
     * Workaround for HumHub v1.3.10 since in this version self::renderEntry was used instead of static::renderEntry.
     *
     * @param Content $content
     * @return array
     * @throws \Exception
     */
    public static function getContentResultEntry(Content $content)
    {
        $result = [];

        // Get Underlying Object (e.g. Post, Poll, ...)
        $underlyingObject = $content->getPolymorphicRelation();
        if ($underlyingObject === null) {
            throw new Exception('Could not get contents underlying object! - contentid: ' . $content->id);
        }

        // Fix for newly created content
        if ($content->created_at instanceof Expression) {
            $content->created_at = date('Y-m-d G:i:s');
            $content->updated_at = $content->created_at;
        }

        $underlyingObject->populateRelation('content', $content);

        $result['output'] = static::renderEntry($underlyingObject, false);
        $result['pinned'] = (boolean) $content->pinned;
        $result['archived'] = (boolean) $content->archived;
        $result['guid'] = $content->guid;
        $result['id'] = $content->id;

        return $result;
    }

    public static function renderEntry(ContentActiveRecord $record, $options =  [], $partial = true)
    {
        return LatestBlogsStreamEntry::widget(['blog' => $record]);
    }

    public function isEnabled()
    {
        return (new BlogService())->isCustomPagesInstalled($this->contentContainer);
    }
}