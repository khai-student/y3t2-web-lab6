<?php

class AdminController extends Object implements IController
{
    // displaying tables there
    public function actionIndex()
    {
        global $utilites;
        // getting table content
        if (!isset($this->table)) {
            $this->table = 'item';
        }
        // checking types
        if (!isset($this->page)) {
            $this->page = 1;
        }
        try
        {
            $this->page = intval($this->page);
            if ($this->page <= 0) throw Exception();
        }
        catch (Exception $e)
        {
            $utilites->error('Cannot convert page parameter to int.', $e->getMessage());
        }
        // getting data
        $model = new TableModel();
        $model->data = $this->data;
        try
        {
            $this->data = $model->GetTableContent();
        }
        catch (Exception $e)
        {
            $utilites->error($e->getMessage());
        }

        // showing asked page
        $view = new TableView();
        $view->data = $this->data;
        $view->Render();
    }

    public function actionEdit()
    {
        
    }
}