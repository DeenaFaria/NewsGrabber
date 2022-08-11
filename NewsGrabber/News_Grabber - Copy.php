<?php
include_once('simple_html_dom.php');

function scraping_generic($url, $search) {
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
	

	foreach($result as $value){
		echo "<br>".$value."<br>";
	}
	

$hostname = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn =new mysqli($hostname, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

foreach ($result as $links1=>$value)
{
// connect to mysql database
$sql="INSERT INTO grabber('NewsTitle') VALUES ('$links1')";


mysqli_query($conn,$sql);

}
foreach ($result as $result){
$sql="INSERT INTO grabber('Link') VALUES ('$result')";
mysqli_query($conn,$sql);
}
foreach ($result as $search){
$sql="INSERT INTO grabber('Keyword') VALUES ('$search')";
mysqli_query($conn,$sql);
}
	
$serializedData = serialize($result1);

// save serialized data in a text file
file_put_contents('Result.txt', $serializedData. PHP_EOL, FILE_APPEND | LOCK_EX);


	

    
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