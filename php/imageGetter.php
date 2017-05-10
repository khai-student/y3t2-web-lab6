<?php
spl_autoload_register(function ($class_name) {
    include '../classes/' . $class_name . '.php';
});

$utilities = new Utilities();

$item_id = $utilities->GetParam('item_id', -1);
if ($item_id == -1)
{
    die();
}

$db = new Database();

$image = $db->Select(
    sprintf(
        "SELECT image.data AS 'image' FROM public.image, public.item WHERE image.fk_item_id = %s;",
        $db->RealEscapeString($item_id)
    )
);

if ($image == null || count($image) == 0) {
    die();
}

header("Content-Type: image/jpeg");
echo $image[0]['image'];