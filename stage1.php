<?php


$titles = array();
$displayLinks = array();
$actualLinks = array();
$isAds = array();
$enableRatings = array();
$starss = array();
$percentages = array();
$numberVotess = array();
$descriptions = array();
$headerPixel = $_POST['trackingPixelHeader'];
$footerPixel = $_POST['trackingPixelFooter'];
$numOfQueries = intval($_POST['numOfQueries']) +1;

$urlPath = $_POST['urlPath'];
if(substr($urlPath, -1) == '/') {
    $urlPath = substr($urlPath, 0, -1);
}

if (!file_exists("../" . $urlPath)) {
    mkdir("../" . $urlPath, 0755, true);
}
$myfile = fopen("../" . $urlPath."/index.php", "w") or die("Unable to open file!");



for($i=1;$i<$numOfQueries;$i++){




	$titles[$i] = $_POST['Title' . $i];
	$displayLinks[$i] = $_POST['displayLink' . $i];
	$actualLinks[$i] = $_POST['actualLink' . $i];
	$isAds[$i] = $_POST['ad' . $i];
	$enableRatings[$i] = $_POST['rating' . $i];
	$starss[$i] = $_POST['stars' . $i];
	$percentages[$i] = $_POST['percentage' . $i];
	$numberVotess[$i] = $_POST['numberVotes' . $i];
	$descriptions[$i] = $_POST['description' . $i];
}


$result = "";
for($i=1;$i<$numOfQueries;$i++){
	$ad = '';
	if(isset($isAds[$i])) $ad ='<div class="ad">Ad</div>';
	$rating = '';
	if(isset($enableRatings[$i])) $rating = '<div class="rating"><span style="margin-top: -1px;">'.$starss[$i].'.0 </span><img src="/assets/images/rate-'.$starss[$i].'.png" style="margin-right: 4px;"><span style="color: #777; margin-top: -1px;">'.$numberVotess[$i].' votes - rating for '.$displayLinks[$i].'</span></div>';

mkdir("../" . $urlPath ."/images/", 0755, true);
$target_dir ="../" . $urlPath ."/images/";
$imageFileType = 0;
$target_file = $target_dir . basename($_FILES["imageUpload" . $i]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//echo '<br>' . $target_file . '<br>';
// Check if image file is a actual image or fake image
if($imageFileType) {

if ($uploadOk == 0) {
//    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["imageUpload" . $i]["tmp_name"], $target_file)) {
 //       echo "The file ". basename( $_FILES["imageUpload" . $i]["name"]). " has been uploaded.";

		$result .='<div style="margin-bottom: 22px;float:left;content:” “;display: table;clear: both;">
					<h3 class="result-heading"><a href="'.$actualLinks[$i].'">'.$titles[$i].'</a></h3>
					<a href="'.$actualLinks[$i].'" style="height:65px;width:116px">
					<div class="video-thumb">
					<img src="'.$target_file.'" width="116" height="65">
					<span class="play">&#9654;</span>
					</div>
					</a><div class="video-desc">
					'. $ad .'<a href="'.$actualLinks[$i].'" class="site-link">'.$displayLinks[$i].'</a><img src="/assets/images/down-arrow-g.png" style="padding-left: 5px; padding-bottom: 2px;">
					'. $rating .'
					<div class="result-des">'.$descriptions[$i].'</div>
					</div>
				</div>';
				continue;

    } else {
       echo "Sorry, there was an error uploading your file.";
    }

}
}


		$result .='<div style="margin-bottom: 22px;float:left;content:” “;display: table;clear: both;">
					<h3 class="result-heading"><a href="'.$actualLinks[$i].'">'.$titles[$i].'</a></h3>
					'. $ad .'<a href="'.$actualLinks[$i].'" class="site-link">'.$displayLinks[$i].'</a><img src="/assets/images/down-arrow-g.png" style="padding-left: 5px; padding-bottom: 2px;">
					'. $rating .'
					<div class="result-des">'.$descriptions[$i].'</div>
				</div>';
}



$header = file_get_contents('header.php');
$header2 = file_get_contents('header2.php');
$footer = file_get_contents('footer.php');
$footer2 = file_get_contents('footer2.php');


fwrite($myfile,$header);
fwrite($myfile,$headerPixel);
fwrite($myfile,$header2);

fwrite($myfile, $result);
fwrite($myfile, $footer);
fwrite($myfile, $footerPixel);
fwrite($myfile, $footer2);

fclose($myfile);
echo 'Page Created!';
?>
