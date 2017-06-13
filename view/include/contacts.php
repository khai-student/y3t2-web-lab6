<?php

global $db;
$contacts = $db->Select("SELECT * FROM public.contacts;");
if ($contacts != NULL)
{
    foreach ($contacts as $index => $contact) {
        echo '<span class="name">'.$contact['contact'].': </span><span class="value">'.$contact['value'].'</span><br>';
    }
}