<?php

namespace humhub\modules\blog;

use humhub\modules\blog\integration\BlogService;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\modules\space\models\Space;
use humhub\modules\content\components\ContentContainerModule;

class Module extends ContentContainerModule
{
    const ICON = 'fa-rss';

    /**
     * @inheritdoc
     */
    public function getContentContainerTypes()
    {
        return [
            Space::class,
        ];
    }

    /**
    * @inheritdoc
    */
    public function disable()
    {
        (new BlogService())->deleteAll();
        parent::disable();
    }

    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        (new BlogService())->deleteByContainer($container);
        parent::disableContentContainer($container);
    }
}
