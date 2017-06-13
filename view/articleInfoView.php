<?php

class ArticleInfoView extends Object implements IView
{
    function Render()
    { 
        require_once 'include/header.php';

        echo '
            <div class="article-info">
                <div>
                    <span class="title">'.htmlentities($this->article['title']).'</span>
                    <a class="navigation" href="router.php?r=article/index">Back</a>
                </div>
                <span class="brief">'.htmlentities($this->article['brief']).'</span>
                <span class="content">'.htmlentities($this->article['content']).'</span>
                <span class="date">'.$this->article['date'].'</span>
            </div>
            ';

        require_once 'include/footer.php';
    }
}
