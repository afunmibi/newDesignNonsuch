<?php 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachement; Filename = MyData.xls");
require("generate.php");

?>