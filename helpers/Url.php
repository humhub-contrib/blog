<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2019 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\blog\helpers;

use humhub\modules\blog\integration\BlogService;
use humhub\modules\content\components\ContentContainerActiveRecord;
use yii\helpers\Url as BaseUrl;

class Url extends BaseUrl
{
    public const ROUTE_INDEX = '/blog/view';
    public const ROUTE_LOAD = '/blog/view/load';

    public static function toIndex(ContentContainerActiveRecord $container)
    {
        return $container->createUrl(self::ROUTE_INDEX);
    }

    public static function toLoadBlog($blog, ContentContainerActiveRecord $container)
    {
        return $container->createUrl(self::ROUTE_LOAD, ['id' => $blog->id]);
    }

    public static function toCreateBlog(ContentContainerActiveRecord $container)
    {
        return BlogService::getCreateUrl($container);
    }
}
