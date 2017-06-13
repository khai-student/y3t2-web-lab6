<?php
class SectionModel
{
    public function GetSectionItems($section_name)
    {
        global $db;

        $items = $db->Select(
        "SELECT
            item.id AS 'id',
            item.title AS 'title',
            item.description AS 'description'
            FROM public.item
            WHERE
            item.fk_section_id = (SELECT section.id FROM public.section WHERE
            LOWER(section.name) = LOWER('".$db->RealEscapeString($section_name)."'));"
        );

        if ($items == null || count($items) == 0)
        {
            return [];
        } 

        return ['items' => $items];
    }
}
?>