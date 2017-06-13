<?php

class AddArticleView extends Object implements IView
{
    public function Render()
    { 
        require_once 'include/headerAdminPanel.php';
     ?>   
        <div class="edit-view">
            <form method="POST" action="/router.php" enctype="multipart/form-data">
                <input name="r" type="hidden" value="admin/insert">
                <input name="new" type="hidden" value="article">
                <div class="form-group">
                    <label for="title">Article title</label>
                    <input class="form-control" name="title" id="title" type="text" placeholder="Input title" required>
                    <label for="brief">Article brief</label>
                    <input class="form-control" name="brief" id="brief" type="text" placeholder="Input brief" required>
                    <label for="content">Article content</label>
                    <textarea class="form-control" name="content" id="content" placeholder="Write main content here..." required></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Add Article</button>
                    <?php
                    if (isset($this->msg))
                    {
                        echo '<span class="label label-default info-msg">'.$this->msg.'</span>';
                    }
                    ?>
                </div>
            </form>
        </div>
<?php
        require_once 'include/footer.php';
    }
}
