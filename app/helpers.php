<?php

/**
 * This function renders a view partial and extracts
 * any optional data to be used as a variable name
 * in the partial.
 *
 * @param $view
 * @param array $data
 * @throws Exception
 */
function render($view, array $data = [])
{
    extract($data);
    
    $file = str_replace('\\', '/', ROOT . '/dummyAdmin/app/views/partials/' . $view . '.php');
    
    if (is_readable($file)) {
        require_once $file;
    } else {
        throw new Exception("The partial '$view' does not exist or is not readable");
    }
}