<?php

class TableView extends Object implements IView
{
    public function Render()
    { 
        require_once 'include/header.php';

        echo '
        <div class="table-view">
            <form method="GET" action="/router.php">
                <input name="r" type="hidden" value="admin/index">
                <label>Select table</label>
                <select name="table">
                    ';
        
        foreach ($this->tables as $key => $value) {
            if ($value == $this->table)
            {
                echo '<option value="'.strtolower($value).'" selected>'.Ucfirst($value).'</option>';
            }
            else
            {
                echo '<option value="'.strtolower($value).'">'.Ucfirst($value).'</option>';
            }
        }
        // select to choose page to view
        echo '
                </select>';

        // order by
        echo '<label>Order by</label><select name="order_by">';
        
        foreach ($this->column_headers as $key => $value) {
            if ($value == $this->order_by)
            {
                echo '<option value="'.strtolower($value).'" selected>'.strtolower($value).'</option>';
            }
            else
            {
                echo '<option value="'.strtolower($value).'">'.strtolower($value).'</option>';
            }
        }
        echo '</select>';
        // order by direction
        echo '<label>Direction</label><select name="order_direction">';
        
        foreach (array('asc', 'desc') as $value) {
            if (strtolower($value) == strtolower($this->order_direction))
            {
                echo '<option value="'.strtolower($value).'" selected>'.ucfirst($value).'</option>';
            }
            else
            {
                echo '<option value="'.strtolower($value).'">'.ucfirst($value).'</option>';
            }
        }
        echo '</select>';
        // displaying numeric updown to choose page
        echo '
            <label>Table page</label>
            <input type="number" size="2" name="page" min="1" max="'.$this->page_max.'" value="'.$this->page.'">';
        
        echo '
                <button type="submit">View</button>
            </form>
        </div>
        ';       

        // displaying table
        echo '<table><tr>';
        // displaying header
        echo '<th>Edit</th>';
        echo '<th>Delete</th>'; 
        foreach ($this->column_headers as $index => $header) {
            echo '<th>'.strtolower($header).'</th>';    
        }
        echo '</tr>';
        // displaying rows
        foreach ($this->rows as $row_index => $row) {
            echo '<tr>';
            // displaying edit button
            echo '
            <td>
            <form method="'.$_SERVER['REQUEST_METHOD'].'" action="/router.php">
                <input type="hidden" name="r" value="admin/edit">
                <input type="hidden" name="table" value="'.$this->table.'">
                <input type="hidden" name="page" value="'.$this->page.'">
                <input type="hidden" name="id" value="'.$row['id'].'">
                <button type="submit">Edit</button>
            </form>
            </td>
            <td>
            <form method="'.$_SERVER['REQUEST_METHOD'].'" action="/router.php">
                <input type="hidden" name="r" value="admin/delete">
                <input type="hidden" name="table" value="'.$this->table.'">
                <input type="hidden" name="page" value="'.$this->page.'">
                <input type="hidden" name="id" value="'.$row['id'].'">
                <button type="submit">Delete</button>
            </form>
            </td>';
            //
            foreach ($this->column_headers as $header)
            {
                echo '<td>';
                if ($this->table == 'image' && $header == 'data')
                {
                    echo '<img src="/php/imageGetter.php?item_id='.$row['fk_item_id'].'" alt="There should be an image">';
                }
                else
                {
                    if (strlen($row[$header]) >= 50)
                    {
                        $cutted = mb_substr($row[$header], 0, 50);
                        echo '<span>'.$cutted.'...</span>';
                    }
                    else
                    {
                        echo '<span>'.$row[$header].'</span>';
                    }
                }
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</table>';

        require_once 'include/footer.php';
    }
}
