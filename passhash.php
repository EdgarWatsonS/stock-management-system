<?php
$pass = 12345;
$pass = password_hash($pass, PASSWORD_BCRYPT);

echo $pass;
?>