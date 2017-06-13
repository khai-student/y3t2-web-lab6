<?php

class InfoMsgView extends Object implements IView
{
    function Render()
    {
        require_once 'include/header.php';

        if (!isset($this->back))
        {
            $this->back = ['r' => 'section/index', 'section' => 'strings'];
        }

        echo '
            <div class="info-msg-view">
            <form method="'.$_SERVER['REQUEST_METHOD'].'" action="/router.php" >
            <span class="info-msg">'.$this->msg.'</span>';
        
        foreach ($this->back as $key => $value) {
            echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
        }

        echo '
                <button class="btn btn-default" type="submit" default>Back</button>
            </form>
            </div>
        ';

        require_once 'include/footer.php';
    }
}