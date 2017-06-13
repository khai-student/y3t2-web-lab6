<?php

class AddItemModel extends Object
{
    function getData()
    {
        global $db;
        $sections = $db->Select('SELECT section.name FROM public.section;');
        if (count($sections) > 0)
        {
            $this->sections = [];
            foreach ($sections as $section)
            {
                array_push($this->data['sections'], $section['name']);
            }
        }

        return $this->data;
    }
}