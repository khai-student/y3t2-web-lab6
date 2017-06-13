<?php

class AddPropertyModel extends Object
{
    function getData()
    {
        global $db;
        $sections = $db->Select('SELECT id, title FROM public.item ORDER BY id ASC;');
        if (count($sections) > 0)
        {
            $this->items = [];
            foreach ($sections as $section)
            {
                array_push($this->data['items'], $section);
            }
        }

        return $this->data;
    }
}