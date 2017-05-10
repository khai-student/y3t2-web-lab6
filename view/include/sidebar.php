<?php

global $db;

$sections = $db->Select("SELECT name FROM public.section;");
echo '
<div class="sidebar">
    <a href="index.php" id="logo"><img src="/images/logo.png" alt="logo"></a>
    <ul>';

if (count($sections) > 0)
{
    foreach ($sections as $section)
    {
        echo '<li>
            <a href="/router.php?r=section/index&section='.strtolower($section['name']).'">'.$section['name'].'</a>
        </li>';
    }
}

echo '
    </ul>
</div>
';
