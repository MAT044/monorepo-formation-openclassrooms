<?php
spl_autoload_register(function ($class_name) {
    $prefix = "TomTroc\\";
    $folder = "/src/";
    $classpath = str_replace($prefix, $folder, $class_name);
    $classpath = str_replace("\\", "/", $classpath);
    require __DIR__ . $classpath . '.php';
});