<?php

global $db;
global $session;
echo '
<div class="sidebar">
    <a href="index.php" id="logo"><img src="/images/logo.png" alt="logo"></a>
    <ul>
';
if ($session->isAuthorized()) 
{
echo '
    <li>
        <a href="/router.php?r=auth/signOut">Sign Out</a>
    </li>
';
}
else
{
echo '
    <li>
        <a href="/router.php?r=auth/signIn">Sign In</a>
    </li>
';
}

echo '
    <li>
        <a href="/router.php?r=news/index">News</a>
    </li>
';

$sections = $db->Select('SELECT section.name FROM public.section;');
if (count($sections) > 0)
{
    foreach ($sections as $section)
    {
        echo '
            <li>
                <a href="/router.php?r=section/index&section='.strtolower($section['name']).'">'.$section['name'].'</a>
            </li>
        ';
    }
}

if ($session->isAdmin())
{
    echo '
    <li>
        <a href="#"></a>
    </li>
    <li>
        <a href="/router.php?r=section/edit">Edit sections</a>
    </li>
    <li>
        <a href="/router.php?r=news/edit">Edit news</a>
    </li>
    ';
}

echo '
    </ul>
</div>
';
