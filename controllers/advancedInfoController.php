<?php

class AdvancedInfoController extends Object implements IController
{
    public function actionIndex()
    {
        if (!isset($this->item_id))
        {
            throw new Exception("Item ID is not passed.");
            return;
        }

        $data = (new AdvancedInfoModel())->GetAdvancedInfo($this->item_id);
        if (count($data) == 0)
        {
            (new NoAdvancedInfoView()).Render();
            return;
        }
        // if data is correct
        $this->section = $data['section'];
        $this->item = $data['item'];
        $this->properties = $data['properties'];

        $view = new AdvancedInfoView();
        $view->data = $this->data;
        $view->Render();
    }
}
?>