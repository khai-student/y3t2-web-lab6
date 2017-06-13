<?php
class DeleteModel extends Object
{
    public function Delete()
    {
        global $db;

        if (!isset($this->table))
        {
             $this->table = 'item';
        }
        if (!isset($this->page))
        {
            $this->page = 1;
        }
        // making back page parameter
        $this->back = ['r' => 'admin/index', 'table' => $this->table, 'page' => $this->page];
        // trying to delete item
        if (!isset($this->id))
        {
            $this->msg = 'Cannot delete record without ID.';
            return $this->data;
        }
        $sql = sprintf('DELETE FROM public.%s WHERE id = %u;', $this->table, $this->id);
        try
        {
            if ($db->Exec($sql) === false)
            {
                $this->msg = 'Cannot delete cortege with id '.$this->id;
            }
            else
            {
                $this->msg = 'Cortege with id '.$this->id.' is deleted from table "'.$this->table.'"';
            }
        }
        catch (Exception $e)
        {
            throw new Exception($e->getMessage());
        }

        return $this->data;
    }
}