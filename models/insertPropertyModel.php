<?php

class InsertPropertyModel extends Object
{
    function getData()
    {
        global $db;
         
        if (!isset($this->name) || !isset($this->value) || !isset($this->item_id))
        {
            $this->msg = 'Not all data entered.';
            return $this->data;
        }
        $sql = sprintf("INSERT INTO public.property (fk_item_id, property, value)
                        SELECT id, '%s', '%s' FROM public.item WHERE id = %s;",
                        $db->RealEscapeString($this->name),
                        $db->RealEscapeString($this->value),
                        $db->RealEscapeString(strtolower($this->item_id))
                        );
        if ($db->Insert($sql) != TRUE)
        {
            $this->msg = 'Property insert failed.';
            return $this->data;
        } 
        $this->msg = 'Property added.';

        return $this->data;
    }
}