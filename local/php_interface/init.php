<?
spl_autoload_register(function ($class_name) {
    include $_SERVER['DOCUMENT_ROOT'] . '/local/php_interface/include/' . $class_name . '.php';
});
include_once($_SERVER['DOCUMENT_ROOT'].'/redirect.php');
