<?php

class AdminController extends Object implements IController
{
    // displaying tables there
    public function actionIndex()
    {
        global $utilites;
        
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
        global $utilites;

        // 
        $model = new EditModel();
        $model->data = $this->data;
        try
        {
            if (isset($this->save)) // $this->save means that data was already edited
            {
                $model->SaveChanges();
            }
            else
            {
                $model->GetRecord();
            }
        }
        catch (Exception $e)
        {
            $utilites->error($e->getMessage());
        }

        if (isset($this->save))
        {
            $view = new InfoMsgView();
        }
        else
        {
            $view = new EditView();
        }

        $view->data = $this->data;
        $view->Render();
    }

    public function actionDelete()
    {
        global $utilites;

        // 
        $model = new DeleteModel();
        $model->data = $this->data;
        try
        {
            $this->data = $model->Delete();
        }
        catch (Exception $e)
        {
            $utilites->error($e->getMessage());
        }

        $view = new InfoMsgView();
        $view->data = $this->data;
        $view->Render();
    }
}