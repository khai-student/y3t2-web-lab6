<?php
spl_autoload_register(function ($class_name) {
    include '../classes/' . $class_name . '.php';
});

function ShowBodyPage($item_id, $back)
{
    $utilities = new Utilities();

    if ($item_id == -1)
    {
        die();
    }

    $db = new Database();

    $item = $db->Select("SELECT
            item.title AS 'title',
            item.description AS 'description'
            FROM public.item
            WHERE
            item.id = ".$db->RealEscapeString($item_id).";");
    $properties = $db->Select("SELECT
            property.property AS 'property',
            property.value AS 'value'
            FROM public.property
            WHERE
            property.fk_item_id = ".$db->RealEscapeString($item_id).";");

    if ($properties == null || count($properties) == 0) {
        header("Location: ../body-page.php?msg=No%20properties.");
        die();
    }

    echo '
        <div class="services">
            <h2>'.$item[0]['title'].'</h2>
            <ul class="navigation">
                <li>
                    <a href="../body-page.php?r=controllers/sectionController.php&data='.$back.'">Back</a>
                </li>
            </ul>
            <ul>
                <h3>
                    <span>Advanced information</span>
                </h3>
                <li>
                    <div class="img">
                        <img src="/php/imageGetter.php?item_id='.$item_id.'" alt="There must be an image.">
                    </div>
                    <div class="info">
                        <p>'.$item[0]['description'].'</p>
                    ';

    foreach ($properties as $index => $property) {
        echo '<p>'.ucfirst($property['property']).': '.$property['value'].'</p>';
    }

    echo '
                    </div>
                </li>
            </ul>
        </div>
        ';
}
