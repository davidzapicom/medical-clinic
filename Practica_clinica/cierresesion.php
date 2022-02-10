<?php
session_start();

if (isset ($_POST["bt3"])|| isset($_POST["bt4"])||isset($_POST["cierre"])){

	session_destroy();

	header('Location: login.php');
}

?>