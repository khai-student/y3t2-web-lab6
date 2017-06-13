<?php

class ChangeContactsView extends Object implements IView
{
    public function Render()
    { 
        require_once 'include/headerAdminPanel.php';
     ?>   
        <div class="edit-view">
            <form method="POST" action="/router.php" enctype="multipart/form-data">
                <input name="r" type="hidden" value="admin/insert">
                <input name="new" type="hidden" value="contacts">
                <div class="form-group">
                    <label for="email">E-Mail address</label>
                    <input class="form-control" name="email" id="email" type="email" value="<?php echo $this->email ?>" required>
                    <label for="phone">Phone number</label>
                    <input class="form-control" name="phone" id="phone" type="tel" value="<?php echo $this->phone ?>" required>
                    <label for="skype">Skype login</label>
                    <input class="form-control" name="skype" id="skype" type="text" value="<?php echo $this->skype ?>" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-default" type="submit">Change contacts</button>
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
