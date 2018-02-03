<?php
require "lib/rb.php";
    R::setup('mysql:host=localhost;dbname=vok',
        'timur', '1234');
session_start();
?>