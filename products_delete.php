<?php
include ('common_functions.php');
$id = $_GET['id'];
$query  =   mysqli_query($conn, "DELETE FROM tblproduct WHERE pkproductid = $id");
header("Location: products.php");
die();
