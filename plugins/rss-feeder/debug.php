<?php
function debugEcho($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
}

function debugReturn($var)
{
    ob_start();
    var_dump($var);
    $return = ob_get_contents();
    ob_end_clean();
    return $return;
}

function debugEmail($var, $email, $subject = '')
{
    ob_start();
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    $message = ob_get_contents();
    ob_end_clean();
    mail($email, (! empty($subject) ? $subject : 'DEBUG:'.date("Y-m-d-H-i-s")), $message);
}
