<?php

class AddPropertyView extends Object implements IView
{
    public function Render()
    { 
        require_once 'include/headerAdminPanel.php';
        
        echo '<div class="edit-view">
            <form method="POST" action="/router.php" enctype="multipart/form-data">
                <input name="r" type="hidden" value="admin/insert">
                <input name="new" type="hidden" value="property">
                <div class="form-group">
                    <label name="item_id">Item ID</label>
                    <select class="form-control" name="item_id" id="item_id">';
                
        foreach ($this->items as $item) {
            echo '<option value="'.$item['id'].'" selected>'.$item['id'].' ('.substr($item['title'], 0, 30).'...)</option>';
        }

        echo '  </select>
                <label for="name">Property name</label>
                <input class="form-control" name="name" id="name" type="text" placeholder="Input name" required>
                <label for="value">Property value</label>
                <input class="form-control" name="value" id="value" type="text" placeholder="Input value" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Add Property</button>';

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
