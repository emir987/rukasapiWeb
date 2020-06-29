<?php

$servername = 'localhost';
$user = 'root';
$password = '';
$base = 'api';

$connect = new mysqli($servername, $user, $password, $base) or die('connection problem');