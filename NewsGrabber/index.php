<?php
include_once('simple_html_dom.php');


function scraping_generic($url, $search) {
$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "mydb";
// Create connection
$conn =mysqli_connect($hostname, $username, $password, $dbname);
mysqli_select_db($conn,$dbname);
mysqli_query($conn,'SET CHARACTER SET utf8' );
mysqli_query($conn,"SET SESSION collation_connection='utf8_general_ci'");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully"."<br>";
	// Didn't find it yet.
	$return = false;

	echo "reading the url: " . $url . "<br/>";
    // create HTML DOM
    $html = file_get_html($url);
	echo "url has been read.<br/>";
	echo "\n\n";
	
	$links=array();
	foreach($html->find('a') as $a){
		$return - true;
		
		$links=$a->href;
		$links1=$a->plaintext;
		$arr[]=$links1;
		if(strpos($links,"https://")!==false||strpos($links,"http://")!==false){
			$grab[]= " <a href=$links >$links1</a>";
		
			
		}
		else{
			$grab[]= " <a href=$url/$links >$links1</a>";
		}
	

	}
	$result=preg_grep("/$search/",$grab); 
	$result1=preg_grep("/$search/",$arr); 
	//print_r($result);

	foreach($result as $value){
  // echo $sql="INSERT INTO grabber(link,keyword) VALUES ('$value','$search')";
  
 // $value = mysqli_real_escape_string($conn, $_REQUEST['value']);

  
	//$conn->query($sql);
	//$conn->mysqli_query($conn,$sql);	
		echo "<br>".$value."<br>";
		
	}
	


foreach ($result1 as $val)
{
	$search = mysqli_real_escape_string($conn, $_REQUEST['search']);
$sql="INSERT INTO grabber(link,keyword) VALUES ('$val','$search')";
mysqli_query($conn, $sql);

}



//}
	
//$serializedData = serialize($result1);

// save serialized data in a text file
//file_put_contents('Result.txt', $serializedData. PHP_EOL, FILE_APPEND | LOCK_EX);


	

    
    // clean up memory
    $html->clear();
    unset($html);

    return $return;
}


// ------------------------------------------
error_log ("post:" . print_r($_POST, true));
$url = "";
if (isset($_POST['url']))
{
	$url = $_POST['url'];
}
$search = "";
if (isset($_POST['search']))
{
	$search = $_POST['search'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title>News Grabber</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">

</head>
<body>
<form method="post">
<h1 style="text-align:center;"><strong>NEWS GRABBER</strong><br/></h1>
<center>
<img class="mySlides" src="news.jpg" height="300" width="500">
<img class="mySlides" src="news1.jpg" height="300" width="500">
<img class="mySlides" src="news2.jpg" height="300" width="500">
<img class="mySlides" src="news3.jpg" height="300" width="500">

</center>
<script>
var slideIndex = 0;
carousel();

function carousel() {
  var i;
  var x = document.getElementsByClassName("mySlides");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1}
  x[slideIndex-1].style.display = "block";
  setTimeout(carousel, 5000); // Change image every 2 seconds
}

</script>

	<p style="text-align:center;"><strong>URL:</strong> <input name="url" type="text" value="<?=$url;?>"/><br/></p>
	<p style="text-align:center;"><strong>Search:</strong> <input name="search" type="text" value="<?=$search;?>"/><br/></p>
	<p style="text-align:center;"><input name="submit" type="submit" value="Submit"/></p>
</form>
</body>
</html>
<?php
// -----------------------------------------------------------------------------
// test it!
if (isset ($_POST['submit']))
{
	$response = scraping_generic($_POST['url'], $_POST['search']);
	/*if (!$response)
	{
		echo "News Article " . $_POST['search'] . "<br />";
	}*/
}
?>