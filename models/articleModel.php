<?php
class ArticleModel extends Object
{
    public function GetAllArticles()
    {
        global $db;

        $articles = $db->Select("SELECT id, title, brief FROM public.articles;");

        if ($articles == null || count($articles) == 0)
        {
            $articles = [];
        } 

        return ['articles' => $articles];
    }

    public function GetArticleInfo()
    {
        global $db;

        if (!isset($this->article_id))
        {
            throw new Exception("Article ID is not passed.");
        }
        $sql = sprintf("SELECT id, title, brief, content, date FROM public.articles WHERE id = %s;", $this->article_id);
        $article = $db->Select($sql);
        if ($article == null)
        {
            throw new Exception("Cannot get article.");
        }
        return ['article' => $article[0]];
    }
}
?>