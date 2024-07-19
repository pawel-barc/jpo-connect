<?php

require_once(__DIR__ . '/classes/Register.php');
require_once(__DIR__ . '/classes/Login.php');

$data = json_decode(file_get_contents('php://input'));

$className = $data->className;
$methodName = $data->methodName;
$payload = isset($data->payload) ? $data->payload : null;

if(class_exists($className)){
    $object = new $className;
    if(method_exists($object, $methodName)){
        if($payload){
            $object->{$methodName}($payload);
        }
        else{
            $object->{$methodName}();
        }
    }
    else{
        echo 'Method not exist';
    }
}
else{
    echo 'Class not exists!';
}