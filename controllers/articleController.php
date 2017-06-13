<?php

class ArticleController extends Object implements IController
{
    public function actionIndex()
    {
        $model = new ArticleModel();
        $model->data = $this->data;
        $this->data = $model->GetAllArticles();

        $view = new AllArticleView();
        $view->data = $this->data;
        $view->Render();
    }

    public function actionInfo()
    {
        $model = new ArticleModel();
        $model->data = $this->data;
        $this->data = $model->GetArticleInfo();

        $view = new ArticleInfoView();
        $view->data = $this->data;
        $view->Render();
    }
}
