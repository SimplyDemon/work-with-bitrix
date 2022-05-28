<?php

require_once 'vendor/autoload.php';

require_once 'Inc/Generators/Email.php';


$emails = new sd\Generators\Email();
var_dump($emails->get());
