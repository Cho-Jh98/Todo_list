<?php

function connectDB(){
	$dbConnection = mysqli_connect("sql313.epizy.com", "epiz_32410431", "NKBBqmhUBfx2", "epiz_32410431_temp");
	if (mysqli_connect_errno()){
		die(mysqli_connect_error());
	}
	return $dbConnection;
}
?>
