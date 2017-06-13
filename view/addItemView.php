<?php

class AddItemView extends Object implements IView
{
    public function Render()
    { 
        require_once 'include/headerAdminPanel.php';
        
        echo '<div class="edit-view">
            <form method="POST" action="/router.php" enctype="multipart/form-data">
                <input name="r" type="hidden" value="admin/insert">
                <input name="new" type="hidden" value="item">
                <div class="form-group">
                    <label for="section">Section</label>
                    <select class="form-control" name="section" id="section">';
                
        foreach ($this->sections as $section) {
            echo '<option value="'.$section.'" selected>'.$section.'</option>';
        }

        echo '      </select>
                    <label for="title">Item title</label>
                    <input class="form-control" name="title" id="title" type="text" placeholder="Input title" required>
                    <label for="description">Description text</label>
                    <textarea class="form-control" name="description" id="description" placeholder="Write description there..." required></textarea>
                </div>
                <div class="form-group">
                    <label class="btn btn-default btn-file">
                        Browse and image... <input name="image" type="file" style="display: none;" required>
                    </label>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Add New Item</button>';
                if (isset($this->msg))
                {
                    echo '<span class="label label-default info-msg">'.$this->msg.'</span>';
                }
                echo '
                </div>
            </form>
        </div>';

        require_once 'include/footer.php';
    }
}
