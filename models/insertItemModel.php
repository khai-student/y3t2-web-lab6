<?php

class InsertItemModel extends Object
{
    function getData()
    {
        global $db;
        
        if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0)
        {
            $this->msg = 'Image upload failed.';
            return $this->data;
        }  
        if (!isset($this->title) || !isset($this->description))
        {
            $this->msg = 'Not all data entered.';
            return $this->data;
        }
        $sql = sprintf("INSERT INTO public.item (fk_section_id, title, description)
                        SELECT id, '%s', '%s' FROM public.section WHERE LOWER(section.name) = '%s';",
                        $db->RealEscapeString($this->title),
                        $db->RealEscapeString($this->description),
                        $db->RealEscapeString(strtolower($this->section))
                        );
        if ($db->Insert($sql) != TRUE)
        {
            $this->msg = 'Item insert failed.';
            return $this->data;
        } 
        $imageMimeTypes = array(
            'image/png',
            'image/gif',
            'image/jpeg');
        if (!in_array(mime_content_type($_FILES['image']['tmp_name']), $imageMimeTypes))
        {
            $this->msg = 'File is not an image.';
            return $this->data;
        }
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $sql = sprintf("INSERT INTO public.image (fk_item_id, data) 
                        SELECT id, '%s' FROM public.item WHERE title = '%s';",
                        $db->RealEscapeString($imageData),
                        $db->RealEscapeString($this->title)
                        );
        if ($db->Insert($sql) != TRUE)
        {
            $this->msg = 'Image insert failed.';
            return $this->data;
        } 
        $this->msg = 'Item added.';

        return $this->data;
    }
}