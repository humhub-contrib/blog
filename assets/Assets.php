<?php

namespace  humhub\modules\blog\assets;

use humhub\modules\activity\assets\ActivityAsset;
use humhub\modules\stream\assets\StreamAsset;
use yii\web\AssetBundle;

/**
* AssetsBundles are used to include assets as javascript or css files
*/
class Assets extends AssetBundle
{
    /**
     * @var string defines the path of your module assets
     */
    public $sourcePath = '@blog/resources';

    /**
     * @var array defines where the js files are included into the page, note your custom js files should be included after the core files (which are included in head)
     */
    public $jsOptions = ['position' => \yii\web\View::POS_END];

    /**
    * @var array change forceCopy to true when testing your js in order to rebuild this assets on every request (otherwise they will be cached)
    */
    public $publishOptions = [
        'forceCopy' => false
    ];

    public $js = [
        'js/humhub.blog.js'
    ];

    public $css = [
        'css/humhub.blog.css'
    ];

    /**
     * @var array This is a workaround for HumHub 1.3.10
     */
    public $depends = [
        ActivityAsset::class,
        StreamAsset::class
    ];

}
