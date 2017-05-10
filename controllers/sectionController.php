<?php

function InsertNewItem() 
{
    $db = new Database();

    $title = 'Yamaha SVC110 электровиолончель';
    $description = 'виолончель ученическая, размер 3/4, верхняя дека - ель, низ и бока - клен, в комплекте - сумка, смычок, канифоль';
    $section = 'cellos';
    $imgFilename = 'image.jpg';
    $properties = [ 
        'Размер' => '4/4',
        'Цена' => '33550 Грн.'
        ];

    $sql = "INSERT INTO public.item (fk_section_id, title, description)
  SELECT
    section.id,
    '".$db->RealEscapeString($title)."',
    '".$db->RealEscapeString($description)."'
  FROM public.section
  WHERE LOWER(section.name) = LOWER('".$db->RealEscapeString($section)."');";
        if ($db->Insert($sql) == TRUE) {
            echo 'Success.';
        }
        else {
            echo 'Item insert failed.';
            die();
        } 

    $imgData = file_get_contents($imgFilename);
        $sql = "INSERT INTO public.image (fk_item_id, path, data)
  SELECT
    item.id,
    '".$db->RealEscapeString($imgFilename)."',
    '".$db->RealEscapeString($imgData)."'
  FROM public.item
  WHERE item.title = '".$db->RealEscapeString($title)."';";
        if ($db->Insert($sql) == TRUE) {
            echo 'Success.';
        }
        else {
            echo 'Image insert failed.';
            die();
        } 

    foreach ($properties as $property => $value) {
        $sql = "INSERT INTO public.property (fk_item_id, property, value)
  SELECT
    item.id,
    '".$db->RealEscapeString($property)."',
    '".$db->RealEscapeString($value)."'
  FROM public.item
  WHERE item.title = '".$db->RealEscapeString($title)."';";
         if ($db->Insert($sql) == TRUE) {
            echo 'Success.';
        }
        else {
            echo 'Property "'.$property.'" insert failed.<br>';
            die();
        } 
    }
    die();
}

class SectionController extends Object implements IController
{
    public function actionIndex()
    {
        if (!isset($this->section) || $this->section == "" || $this->section == null) {
            throw new Exception("Section name is not passed.");
            return;
        }

        $this->model = (new SectionModel())->GetSectionItems($this->section);

        if (!isset($this->model['items']))
        {
            (new NoItemsView($this->section));
            return;
        }
        
        // Rendering page.
        $view = new SectionView();
        $view->data = $this->data;
        $view->Render();
    }
}
