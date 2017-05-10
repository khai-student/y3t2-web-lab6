<?php

class AdvancedInfoView extends Object implements IView
{
    function Render()
    { 
        require_once 'include/header.php';

        echo '
            <div class="services">
                <h2>'.$this->item['title'].'</h2>
                <ul class="navigation">
                    <li>
                        <a href="router.php?r=section/index&section='.$this->section.'">Back</a>
                    </li>
                </ul>
                <ul>
                    <h3>
                        <span>Advanced information</span>
                    </h3>
                    <li>
                        <div class="img">
                            <img src="/php/imageGetter.php?item_id='.$this->item['id'].'" alt="There must be an image.">
                        </div>
                        <div class="info">
                            <p>'.$this->item['description'].'</p>
                        ';

        foreach ($this->properties as $index => $property) {
            echo '<p>'.ucfirst($property['name']).': '.$property['value'].'</p>';
        }

        echo '          </div>
                    </li>
                </ul>
            </div>
            ';

        require_once 'include/footer.php';
    }
}



?>