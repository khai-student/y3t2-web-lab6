<?php
class AdvancedInfoModel
{
    public function GetAdvancedInfo($item_id)
    {
        global $db;
        
        $section = $db->Select(
            "SELECT
            section.name AS 'name'
            FROM public.section, public.item
            WHERE item.id = ".$db->RealEscapeString($item_id)." AND item.fk_section_id = section.id;"
        );

        $item = $db->Select(
            "SELECT
            item.id AS 'id',
            item.title AS 'title',
            item.description AS 'description'
            FROM public.item
            WHERE
            item.id = ".$db->RealEscapeString($item_id).";"
        );
        $properties = $db->Select(
            "SELECT
            property.property AS 'name',
            property.value AS 'value'
            FROM public.property
            WHERE
            property.fk_item_id = ".$db->RealEscapeString($item_id).";"
        );

        if ($properties == null || count($properties) == 0) {
            return [];
        }

        return ['section' => $section[0]['name'], 'item' => $item[0], 'properties' => $properties];
    }
}