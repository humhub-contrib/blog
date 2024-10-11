<?php
/**
 * Created by PhpStorm.
 * User: kingb
 * Date: 25.02.2019
 * Time: 11:52
 */

namespace humhub\modules\blog\controllers;

use humhub\modules\blog\actions\LatestBlogStream;
use humhub\modules\blog\assets\Assets;
use humhub\modules\blog\helpers\Url;
use humhub\modules\blog\integration\BlogService;
use humhub\modules\content\components\ContentContainerController;
use yii\web\HttpException;

/**
 * Class ViewController
 * @package humhub\modules\blog\controllers
 */
class ViewController extends ContentContainerController
{
    /**
     * @var BlogService
     */
    public $blogService;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        Assets::register($this->getView());
        $this->blogService = new BlogService();
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'stream' => [
                'class' => LatestBlogStream::class,
                'contentContainer' => $this->contentContainer,
            ],
        ];
    }

    /**
     * @var $id string
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionIndex($id = null)
    {
        $blog = $id ? $this->blogService->getBlogById($id, $this->contentContainer)
                    : $this->blogService->getLatestBlogs($this->contentContainer);

        $prevBlog = ($blog && $id) ? $this->blogService->getPrevBlog($blog->id, $this->contentContainer) : null;
        $nextBlog = $blog ? $this->blogService->getNextBlog($blog->id, $this->contentContainer) : null;

        return $this->render('index', [
            'blog' => $blog,
            'container' => $this->getSpace(),
            'sidebar' => true,
            'nextBlog' => $nextBlog,
            'prevBlog' => $prevBlog,
            'isCustomPagesEnabled' => $this->blogService->isCustomPagesInstalled($this->contentContainer),
            'blogCount' => $this->blogService->getBlogCount($this->contentContainer),
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws HttpException
     * @throws \yii\base\Exception
     */
    public function actionLoad($id)
    {
        $blog = $this->blogService->getBlogById($id, $this->contentContainer);

        if (!$blog) {
            throw new HttpException(404);
        }

        $prevBlog = $blog ? $this->blogService->getPrevBlog($blog->id, $this->contentContainer) : null;
        $nextBlog = $blog ? $this->blogService->getNextBlog($blog->id, $this->contentContainer) : null;


        $output = $this->renderAjax('index', [
            'blog' => $blog,
            'nextBlog' => $nextBlog,
            'prevBlog' => $prevBlog,
            'container' => $this->getSpace(),
            'sidebar' => false,
            'isCustomPagesEnabled' => $this->blogService->isCustomPagesInstalled($this->contentContainer),
        ]);

        return $this->asJson([
            'output' => $output,
            'url' => $blog->getUrl(),
        ]);
    }

}
