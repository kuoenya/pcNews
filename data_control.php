
<?php

	include_once "class_data.php";

	define('DB_HOST', '127.0.0.1');
	define('DB_USER', 'root');
	define('DB_PASS', '');
	define('DB_NAME', 'pc_crawler');

	$page = $_GET['page'];

	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
	$query = "SELECT * FROM `0709_news` ORDER BY `id`";
	mysqli_set_charset($link,"utf8"); //亂碼 hero
	$result = mysqli_query($link,$query);
	$data_nums = mysqli_num_rows($result);
	$per = 25;
	$pages = ceil($data_nums/$per);
	if ( !isset($_GET["page"]) ) {
		$page = 1;
	} else {
		$page = intval($_GET["page"]);
	}
	$start = ($page-1)*$per; //SQL LIMIT first parameter
	$query2 = "SELECT * FROM `0709_news` LIMIT ".$start.",".$per."";
	$result = mysqli_query($link,$query2) or die("Error");

	$data = new data();
	$data->pages = $pages;
	$data->data = array();
	while( $row = mysqli_fetch_assoc($result) ) {

		$data->data[] = $row; 
	} 

		echo json_encode($data,true);


?>










