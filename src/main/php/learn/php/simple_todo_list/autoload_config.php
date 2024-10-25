<?php

define( "__DIR_ROOT",               realpath(".") );
define( "__DIR_PUBLIC_RESOURCE",    realpath(__DIR_ROOT . "/public/resource") );
define( "__DIR_PRIVATE_RESOURCE",   realpath(__DIR_ROOT . "/src/main/resource") );

define( "__DIR_PRIVATE_TEST_RESOUCE", realpath(__DIR_ROOT . "/src/test/resource") );

define( "__DIR_VIEW", realpath(__DIR_ROOT . "/src/main/php/learn/php/simple_todo_list/view") );

define( "__DIR_CONTROLLER", realpath(__DIR_ROOT . "/src/main/php/learn/php/simple_todo_list/controller") );

require_once __DIR_ROOT . "/vendor/autoload.php";