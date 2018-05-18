<?php

include "connection.php";

#Multiple fields
$titles[] = "";
$displayLinks[] = "";
$actualLinks[] = "";
$isAds[] = "";
$enableRatings[] = "";
$stars[] = "";
//$percentages[] = "";
$numberVotes[] = "";
$descriptions[] = "";
$thumbnails[] = "";

#Single fields
$numOfQueries = "";
$infoName = "";
$shortDesc = "";
$tags = "";
$headerPixel = "";
$footerPixel = "";
$urlPath = "";

if(isset($_POST['infoName'])){
	$infoName = $_POST['infoName'];
}

if(isset($_POST['shortDesc'])){
	$shortDesc = $_POST['shortDesc'];
}

if(isset($_POST['infoTags'])){
	$tags = $_POST['infoTags'];
}

if(isset($_POST['trackingPixelHeader'])){
	$headerPixel = $_POST['trackingPixelHeader'];
}

if(isset($_POST['trackingPixelFooter'])){
	$footerPixel = $_POST['trackingPixelFooter'];
}

if(isset($_POST['numOfQueries'])){
	$numOfQueries = intval($_POST['numOfQueries']) +1;
}

if(isset($_POST['urlPath'])){
	$urlPath = $_POST['urlPath'];
}


if(substr($urlPath, -1) == '/') {
    $urlPath = substr($urlPath, 0, -1);
}

if (!file_exists("../" . $urlPath)) {
    mkdir("../" . $urlPath, 0755, true);
}
$myfile = fopen("../" . $urlPath."/index.php", "w") or die("Unable to open file!");

$infoQuery = "INSERT INTO info (id_info, name, short_desc, tags, tracking_header, tracking_footer, url_path)
			VALUES(NULL, '$infoName', '$shortDesc', '$tags', '$headerPixel', '$footerPixel', '$urlPath')";



if (mysqli_query($conn, $infoQuery)) {
    $idInfo = mysqli_insert_id($conn);
} else {
    echo mysqli_error($conn);
}		
			
for($i=1;$i<$numOfQueries;$i++){
	$titles[$i] = "";
	$displayLinks[$i] = "";
	$actualLinks[$i] = "";
	
	if(isset($_POST['ad'. $i])){
		$isAds[$i] = true;
	}
	else{
		$isAds[$i] = false;
	}
	
	if(isset($_POST['rating'. $i])){
		$enableRatings[$i] = true;
		$stars[$i] = $_POST['stars' . $i];
		$numberVotes[$i] = $_POST['numberVotes' . $i];
	}
	else{
		$enableRatings[$i] = false;
		$stars[$i] = 0;
		$numberVotes[$i] = 0;
	}
	
	
	$descriptions[$i] = "";
	$thumbnails[$i] = "";
	
	
	$titles[$i] = $_POST['Title' . $i];
	$displayLinks[$i] = $_POST['displayLink' . $i];
	$actualLinks[$i] = $_POST['actualLink' . $i];
	
	//$percentages[$i] = "";
	//$percentages[$i] = $_POST['percentage' . $i];
	
	$descriptions[$i] = $_POST['description' . $i];
	
}



$result = "";
for($i=1;$i<$numOfQueries;$i++){
	$ad = '';
	if($isAds[$i] != 0) $ad ='<div class="ad">Ad</div>';
	$rating = '';
	if($enableRatings[$i] != 0) $rating = '<div class="rating"><span style="margin-top: -1px;">'.$stars[$i].'.0 </span><img src="/assets/images/rate-'.$stars[$i].'.png" style="margin-right: 4px;"><span style="color: #777; margin-top: -1px;">'.$numberVotes[$i].' votes - rating for '.$displayLinks[$i].'</span></div>';

	$fullPath = "../" . $urlPath ."/images/";
	if (!is_dir($fullPath)) {
		mkdir($fullPath, 0755, true);
	}
	
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
		} 
		else {
			if (move_uploaded_file($_FILES["imageUpload" . $i]["tmp_name"], $target_file)) {
		 //       echo "The file ". basename( $_FILES["imageUpload" . $i]["name"]). " has been uploaded.";
				
				$query[$i] = "INSERT INTO results (id_result, meta_title, url_mask, masked_url, description, ad, ratings, stars, votes, thumbnail, info_id)
					VALUES(NULL, '$titles[$i]', '$displayLinks[$i]', '$actualLinks[$i]', '$descriptions[$i]', '$isAds[$i]', '$enableRatings[$i]', $stars[$i], $numberVotes[$i], '$target_file', $idInfo)";
			
				mysqli_query($conn, $query[$i]);		
		 
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

			} 
			else {
			   echo "Sorry, there was an error uploading your file.";
			}
		}
	}
	$query[$i] = "INSERT INTO results (id_result, meta_title, url_mask, masked_url, description, ad, ratings, stars, votes, thumbnail, info_id)
			VALUES(NULL, '$titles[$i]', '$displayLinks[$i]', '$actualLinks[$i]', '$descriptions[$i]', '$isAds[$i]', '$enableRatings[$i]', $stars[$i], $numberVotes[$i], '', $idInfo)";
	
	mysqli_query($conn, $query[$i]);		

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

include "close.php";
?>
