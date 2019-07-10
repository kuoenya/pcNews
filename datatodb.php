<?php

	include_once("include/phpQuery-onefile.php");
	include_once('simple_html_dom.php');

	function get_one_news($link){

		$conn = mysqli_connect('127.0.0.1', 'root','','pc_crawler');
		$opts = array(
		  'http'=>array(
		    'header'=>"User-Agent:Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53\r\n"
		  )
		);
		$context = stream_context_create($opts);
		$html = file_get_html("https://www.ithome.com.tw/news/".$link, false, $context);
		$html_fb = file_get_html("https://www.facebook.com/plugins/like.php?action=like&app_id=161989317205664&channel=https%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D44%23cb%3Df21d5aa2ae10654%26domain%3Dwww.ithome.com.tw%26origin%3Dhttps%253A%252F%252Fwww.ithome.com.tw%252Ff279ae60f5d6fec%26relation%3Dparent.parent&container_width=0&href=https%3A%2F%2Fwww.ithome.com.tw%2Fnews%2F".$link."&layout=button_count&locale=zh_TW&sdk=joey&share=true&show_faces=false", false, $context);
		$title = $html->find('title',0)->plaintext;
		$content = $html->find('div[class="field-item even"]',1)->plaintext; //this shows no tag just the text!! 
		$date = $html->find('span[class="created"]',0)->plaintext;
		$praise =$html_fb->find('span[class="_5n6h _2pih"]',0)->plaintext;
		echo "praise_ ";  print_r( $praise);
		$img = $html->find('img',1);
		$author = $html->find('span[class="author"]',0)->plaintext;
		$sql_title = "INSERT INTO `0709_news` (title,content,thedate,praise,img,author) VALUES 
		('".$title."','".mysqli_real_escape_string($conn,$content)."','".$date."','".$praise."','".$img."','".$author."')";	
		echo $sql_title.'<br>';
		mysqli_set_charset($conn,"utf8"); 
		$result = mysqli_query($conn,$sql_title);

		if ($result) {
			echo "ok conn!!";
		} else {
			echo "no conn.";
		}
		mysqli_close($conn);
	}

	for ($i=131361; $i < 131367; $i++) {

		get_one_news($i);

	}

?>

