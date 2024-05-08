<?php 
require 'vendor/autoload.php';

/**
 * Outputs view
 *
 * @param string $file view file name
 * @param array  $data data if given
 * 
 * @return string 
 */
function view(string $file, array $data=[]) : string
{
    $blade = new \Jenssegers\Blade\Blade('App\Views', 'cache');
    return $blade->make($file, $data)->render();
}

/**
 * Returns Auth class
 *
 * @return static
 */
function auth():\App\Auth
{
    return new \App\Auth;
}

/**
 * Return json 
 *
 * @param mixed $data data 
 * 
 * @return void
 */
function json(mixed $data) 
{
    header('Content-Type: application/json');
    echo json_encode($data);
    exit; 
}

/**
 * Redirects to address
 *
 * @param string $address address
 * 
 * @return void
 */
function redirect(string $address):void 
{
    header("location: ?".$address);
}
//init db 
\App\Db::init();

$address=(isset($_GET['page'])?($_GET['page']):'home');
echo \App\GetController::init($address);