<?php

namespace humhub\modules\blog;

use humhub\modules\blog\integration\BlogService;
use humhub\modules\custom_pages\models\PageType;
use humhub\modules\custom_pages\models\Target;
use Yii;
use humhub\modules\blog\helpers\Url;

class Events
{
    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onAdminMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'Blog',
            'url' => Url::to(['/blog/admin']),
            'group' => 'manage',
            'icon' => '<i class="fa fa-adjust"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'blog' && Yii::$app->controller->id == 'admin'),
            'sortOrder' => 99999,
        ]);
    }

    /**
     * Defines what to do if admin menu is initialized.
     *
     * @param $event
     */
    public static function onSpaceMenuInit($event)
    {
        $space = $event->sender->space;

        if ($space !== null && $space->isModuleEnabled('blog')) {
            $event->sender->addItem([
                'label' => Yii::t('BlogModule.base', 'Blog'),
                'group' => 'modules',
                'url' => Url::toIndex($space),
                'icon' => '<i class="fa ' . Module::ICON . '"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'blog'),
            ]);
        }
    }

    /**
     * @param $event \humhub\modules\custom_pages\interfaces\CustomPagesTargetEvent
     */
    public static function onFetchPageTargets($event)
    {
        $blogService = new BlogService();
        $blogService->registerTargets($event);
    }

}
