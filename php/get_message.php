<?php
header('Content-Type: application/xml; charset=UTF-8');

$name = isset($_GET['name']) ? $_GET['name'] : '';
$email = isset($_GET['userEmail']) ? $_GET['userEmail'] : '';

echo "<?xml version='1.0' encoding='UTF-8'?>";
echo '<message>';
echo '<name>' . $name . '</name>';
echo '<email>' . $email . '</email>';
echo '</message>';
