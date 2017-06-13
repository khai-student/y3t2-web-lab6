<?php

class AllArticleView extends Object implements IView
{
    function Render()
    { 
        require_once 'include/header.php';

        echo '
        <h3>
            <span>Articles</span>
        </h3>
        <div class="all-articles">
            ';

        // displaying items
        echo '<ul>';
        foreach ($this->articles as $index => $article) {
            echo '
            <li>
                <span class="title">'.htmlentities($article['title']).'</span>
                <span class="brief">'.htmlentities($article['brief']).'</span><br>
                <a href="/router.php?r=article/info&article_id='.$article['id'].'">Read article</a>
            </li>
            ';
        }
        echo '</ul></div>';

        require_once 'include/footer.php';
    }
}
