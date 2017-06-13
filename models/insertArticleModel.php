<?php

class InsertArticleModel extends Object
{
    function getData()
    {
        global $db;
        
        if (!isset($this->title) || !isset($this->brief) || !isset($this->content))
        {
            $this->msg = 'Not all data entered.';
            return $this->data;
        }
        $sql = sprintf("INSERT INTO public.articles (date, title, brief, content)
                        SELECT CURRENT_TIMESTAMP, '%s', '%s', '%s';",
                        $db->RealEscapeString($this->title),
                        $db->RealEscapeString($this->brief),
                        $db->RealEscapeString($this->content)
                        );
        if ($db->Insert($sql) != TRUE)
        {
            $this->msg = 'Article insert failed.';
            return $this->data;
        } 
        $this->msg = 'Article added.';

        return $this->data;
    }
}