<?php
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function view($template, array $data = [])
{
    extract($data);

    require $template;
}