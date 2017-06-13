<?php

class SectionController extends Object implements IController
{
    public function actionIndex()
    {
        if (!isset($this->section) || $this->section == "" || $this->section == null) {
            $this->section = 'strings';
        }

        $this->model = (new SectionModel())->GetSectionItems($this->section);

        if (!isset($this->model['items']))
        {
            (new NoItemsView($this->section));
            return;
        }
        
        // Rendering page.
        $view = new SectionView();
        $view->data = $this->data;
        $view->Render();
    }

    public function actionInfo()
    {
        $model = new ItemInfoModel();
        $model->data = $this->data;
        $this->data = $model->GetItemInfo();

        $view = new ItemInfoView();
        $view->data = $this->data;
        $view->Render();
    }
}
