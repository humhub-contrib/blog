<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\blog\Events;

return [
    'id' => 'blog',
    'class' => 'humhub\modules\blog\Module',
    'namespace' => 'humhub\modules\blog',
    'events' => [
        ['class' => Menu::class, 'event' => Menu::EVENT_INIT, 'callback' => [Events::class, 'onSpaceMenuInit']],
        ['class' => 'humhub\modules\custom_pages\interfaces\CustomPagesService', 'event' => 'fetchTargets', 'callback' => [Events::class, 'onFetchPageTargets']],
    ],
];
