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
        if (!isset($this->new))
        {
            $utilites->error('400 Client error.');
        }
        //
        $model = NULL;
        $view = NULL;
        switch ($this->new)
        {
            case 'item':
            {
                $model = new AddItemModel();
                $this->data = array_merge($this->data, $model->getData());
                $view = new AddItemView();
                break;
            }
            case 'property':
            {
                $model = new AddPropertyModel();
                $this->data = array_merge($this->data, $model->getData());
                $view = new AddPropertyView();
                break;
            }
            case 'article':
            {
                $view = new AddArticleView();
                break;
            }
            case 'contacts':
            {
                $model = new ChangeContactsModel();
                $this->data = array_merge($this->data, $model->selectContacts());
                $view = new ChangeContactsView();
                break;
            }
            default:
            {
                $utilites->error('400 Client Error.');
                break;
            }
        }
        $view->data = $this->data;
        $view->Render();
    }

    public function actionInsert()
    {
        global $utilites;
        if (!isset($this->new))
        {
            $utilites->error('400 Client error.');
        }
        $model = NULL;
        $view = NULL;
        switch ($this->new)
        {
            case 'item':
            {
                $this->data = array_merge($this->data, (new AddItemModel())->getData());
                // inserting item
                $model = new InsertItemModel();
                $model->data = $this->data;
                $this->data = array_merge($this->data, $model->getData());
                $view = new AddItemView();
                break;
            }
            case 'property':
            {
                $this->data = array_merge($this->data, (new AddPropertyModel())->getData());
                // inserting item
                $model = new InsertPropertyModel();
                $model->data = $this->data;
                $this->data = array_merge($this->data, $model->getData());
                $view = new AddPropertyView();
                break;
            }
            case 'article':
            {
                $model = new InsertArticleModel();
                $model->data = $this->data;
                $this->data = array_merge($this->data, $model->getData());
                $view = new AddArticleView();
                break;
            }
            case 'contacts':
            {
                $model = new ChangeContactsModel();
                $model->data = $this->data;
                $this->data = array_merge($this->data, $model->alterContacts());
                $view = new ChangeContactsView();
                break;
            }
            default:
            {
                $utilites->error('400 Client Error.');
                break;
            }
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