<?php

class TableModel extends Object
{
    public function GetTableContent()
    {
        global $db;
        // select all table names
        $tables = $db->Select('SHOW tables FROM public;');
        if ($tables == null)
        {
            throw new Exception('Cannot get tables list.');
        }
        // check asked exists
        $is_table_exists = false;
        foreach ($tables as $key => $table)
        {
            if ($this->table == $table['Tables_in_public'])
            {
                $is_table_exists = true;
                break;
            }    
        }
        if (!$is_table_exists)
        {
            throw new Exception('Asked table "'.$this->table.'" not exists.');
        }
        $this->tables = array();
        foreach ($tables as $key => $table)
        {
            array_push($this->data['tables'], $table['Tables_in_public']);
        }
        // select column headers
        $sql = 'SHOW COLUMNS FROM public.'.$this->table.';';
        $column_headers = $db->Select($sql);
        if ($column_headers == null)
        {
            throw new Exception('Cannot get column headers.');
        }
        $this->column_headers = array();
        foreach ($column_headers as $key => $value)
        {
            array_push($this->data['column_headers'], $value['Field']);
        }
        // count rows in table
        $sql = 'SELECT COUNT(*) AS COUNT FROM public.'.$this->table.';';
        $this->rows_count = $db->Select($sql);
        if ($this->rows_count == null)
        {
            return $this->data;
        }
        try
        {
            $this->rows_count = intval($this->rows_count[0]['COUNT']);
        }
        catch (Exception $e)
        {
            throw new Exception('Cannot count rows.');
        }
        if ($this->rows_count == 0)
        {
            $this->rows = [];
            $this->page_max = 1;
            return $this->data;
        }
        // check page offset
        if ($this->rows_count + (PAGE_SIZE - $this->rows_count % PAGE_SIZE) < $this->page * PAGE_SIZE)
        {
            $this->page = 1;
        }
        $this->page_offset = $this->page * PAGE_SIZE - PAGE_SIZE;
        $this->page_max = ceil(doubleval($this->rows_count) / PAGE_SIZE);
        // select asked page
        $sql = 'SELECT * FROM public.'.$this->table.' LIMIT '.PAGE_SIZE.' OFFSET '.$this->page_offset.';';
        $this->rows = $db->Select($sql);
        if ($this->rows == null) {
            throw new Exception('Cannot select rows.');
        }
        // returning result
        return $this->data;
    }
}