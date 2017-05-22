<?php

class SectionView extends Object implements IView
{
    function Render()
    { 
        require_once 'include/header.php';

        echo '
        <div class="portfolio">
            <h3>
                <span>'.ucfirst($this->section).'</span>
            </h3>
            ';

        
        // displaying items
        echo '<ul>';
        foreach ($this->model['items'] as $index => $item) {
            echo '
            <li>
                <a href="/router.php?r=advancedInfo/index&item_id='.$item['id'].'">
                    <img src="/php/imageGetter.php?item_id='.$item['id'].'" alt="There should be an image">
                </a> 
                <span>'.$item['title'].'</span>
                <a href="/router.php?r=advancedInfo/index&item_id='.$item['id'].'">Read Details</a>
            </li>
            ';
        }
        echo '</ul></div>';

        require_once 'include/footer.php';
    }
}
