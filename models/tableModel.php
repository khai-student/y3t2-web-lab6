<?php

class TableModel extends Object
{
    public function GetTableContent()
    {
        global $db;
        // getting table content
        if (!isset($this->table)) {
            $this->table = 'item';
        }
        // checking types
        if (!isset($this->page)) {
            $this->page = 1;
        }
        // order by
        if (!isset($this->order_by)) {
            $this->order_by = 'id';
        }
        // direction
        if (!isset($this->order_direction) || !in_array(strtolower($this->order_direction), array('asc', 'desc')))
        {
            $this->order_direction = 'asc';
        }
        // direction
        try
        {
            $this->page = intval($this->page);
            if ($this->page <= 0) throw Exception();
        }
        catch (Exception $e)
        {
            $utilites->error('Cannot convert page parameter to int.', $e->getMessage());
        }
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
        if (!in_array($this->order_by, $this->column_headers))
        {
            $this->order_by = $this->column_headers[0];
        }

        $sql = sprintf('SELECT * FROM public.%s ORDER BY %s %s LIMIT %u OFFSET %u',
            $this->table,
            $this->order_by,
            strtoupper($this->order_direction),
            PAGE_SIZE,
            $this->page_offset);
        $this->rows = $db->Select($sql);
        if ($this->rows == null) {
            throw new Exception('Cannot select rows.');
        }
        // returning result
        return $this->data;
    }
}