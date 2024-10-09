<?php

namespace humhub\modules\blog\widgets;

use humhub\components\Widget;
use humhub\modules\custom_pages\models\ContainerPage;

class LatestBlogsStreamEntry extends Widget
{
    /**
     * @var ContainerPage
     */
    public $blog;

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('latestBlogsStreamEntry', ['blog' => $this->blog]);
    }

}
