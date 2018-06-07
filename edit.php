<?php

include 'connection.php';

if(isset($_REQUEST['id'])){
    $id=intval($_REQUEST['id']);
	
    $sql="SELECT * FROM info i
		INNER JOIN results r 
		ON i.id_info = r.info_id
		WHERE id_info=$id";
    $run_sql=mysqli_query($conn,$sql);
	$numOfQueries = intval(mysqli_num_rows($run_sql))+1;
	
    while($row=mysqli_fetch_array($run_sql)){
		//singular data from info table
        $idInfo = $row['id_info'];
        $infoName = $row['name'];
		$shortDesc = $row['short_desc'];
		$tags = $row['tags'];
		$headerPixel = $row['tracking_header'];
		$footerPixel = $row['tracking_footer'];
		$urlPath = $row['url_path'];
		
		//arrays from results table
		$idResults[] = $row['id_result'];
		array_unshift($idResults,"");
		unset($idResults[0]);
		$titles[] = $row['meta_title'];
		array_unshift($titles,"");
		unset($titles[0]);
		$displayLinks[] = $row['url_mask'];
		array_unshift($displayLinks,"");
		unset($displayLinks[0]);
		$actualLinks[] = $row['masked_url'];
		array_unshift($actualLinks,"");
		unset($actualLinks[0]);
		$descriptions[] = $row['description'];
		array_unshift($descriptions,"");
		unset($descriptions[0]);
		$isAds[] = $row['ad'];
		array_unshift($isAds,"");
		unset($isAds[0]);
		$enableRatings[] = $row['ratings'];
		array_unshift($enableRatings,"");
		unset($enableRatings[0]);
		$stars[] = $row['stars'];
		array_unshift($stars,"");
		unset($stars[0]);
		$numberVotes[] = $row['votes'];
		array_unshift($numberVotes,"");
		unset($numberVotes[0]);
		$thumbnails[] = $row['thumbnail'];
		array_unshift($thumbnails,"");
		unset($thumbnails[0]);
    }
    if(substr($urlPath, -1) == '/') {
        $urlPath = substr($urlPath, 0, -1);
    }

    if (!file_exists("../" . $urlPath)) {
        mkdir("../" . $urlPath, 0755, true);
    }
	$myfile = fopen("../" . $urlPath."/index.php", "w") or die("Unable to open file!");



?>
   			<form class="section section--queryResults" action="" method="POST" id="queryEditor" enctype="multipart/form-data">
			<input type="hidden" data-id="<?php echo $id; ?>" id="idInfo" />
				<section class="section section--numOfQueries">
					<label class="label--ratings">
						<span>&#8470; of queries:</span>
						<select disabled id="chooseNumOfQueries" class="single__input single__input--select" name="numOfQueries">
							<?php
								for($i=5;$i<14;$i++):
							?>
								<option value="<?php echo $i; ?>" <?php echo ($i == $numOfQueries-1) ? "selected" : ""  ?>><?php echo $i; ?></option>
							<?php
								endfor;
							?>
						</select>
					</label>
				</section>
			<?php for($i=1;$i<$numOfQueries;$i++) : ?>

				<section class="section section--queryResult">
					<h4 class="section__heading">Query Result <?php echo $i; ?></h4>
					<div class="input__group input__group--two">
						<input class="single__input" type="text" name="Title<?php echo $i; ?>" placeholder="Enter meta title here *" value="<?php echo $titles[$i]; ?>">
						<input class="single__input" type="text" name="displayLink<?php echo $i; ?>" placeholder="Enter URL mask here *" value="<?php echo $displayLinks[$i]; ?>">
					</div>

					<input class="single__input" type="text" name="actualLink<?php echo $i; ?>" placeholder="Enter masked URL here *" value="<?php echo $actualLinks[$i]; ?>">

					<textarea class="single__input single__input--textarea" name="description<?php echo $i; ?>" placeholder="Enter description here *"><?php echo $descriptions[$i]; ?></textarea>

					<label class="label--checkbox">
						<span>Is this an Ad?</span>
						<input class="single__checkbox single__checkbox--ad" type="checkbox" name="ad<?php echo $i; ?>" value="yes" <?php echo ($isAds[$i] == 1) ? "checked" : ""; ?> />

						<label class="label--checkbox label--checkbox--ratings">
							<span>Enable ratings</span>
							<input class="single__checkbox single__checkbox--ratings" type="checkbox" name="rating<?php echo $i; ?>" value="yes" <?php echo ($enableRatings[$i] == 1) ? "checked" : ""; ?> />

							<div class="input__group input__group--center input__group--ratings">
								<label class="label--ratings">
									<span>Stars:</span>
									<select class="single__input single__input--select" name="stars<?php echo $i; ?>">
										<?php
											for($j=1;$j<=5;$j++):
										?>
											<option value="<?php echo $j; ?>" <?php echo ($j == $stars[$i]) ? "selected" : "50"; ?>><?php echo $j; ?></option>
										<?php
											endfor;
										?>
									</select>
								</label>
								<label class="label--ratings">
									<span>&#8470; of Votes:</span>
									<input class="single__input single__input--number" type="number" value="<?php echo ($numberVotes[$i] != 0) ? $numberVotes[$i] : "50"; ?>" name="numberVotes<?php echo $i; ?>">
								</label>
							</div>
						</label>
					</label>

					<label class="label--imageUpload">
						<span>Enable thumbnail:</span>
						<input class="single__checkbox single__checkbox--file" type="checkbox" name="image<?php echo $i; ?>" value="yes" <?php echo ($thumbnails[$i] != '') ? "checked" : ""; ?>>
						<div class="input--file">
							<?php echo ($thumbnails[$i] != '') ? '<img src="../"' . $urlPath . '"images/"' . $thumbnails[$i] . ' />' : ""; ?>
							<span>Upload an image:</span>
							<input name="imageUpload<?php echo $i; ?>" type="file">
						</div>
					</label>

				</section>

			<?php endfor; ?>
			<div class="input__group input__group--submit">
				<input class="single__input single__input--text" type="text" name="infoName" placeholder="Name" value="<?php echo $infoName; ?>"/>
				<textarea class="single__input single__input--textarea" type="text" name="shortDesc" placeholder="Enter short description"><?php echo $shortDesc; ?></textarea>
				<input class="single__input single__input--text" type="text" name="infoTags" placeholder="Tags" value="<?php echo $tags; ?>"/>
				<textarea class="single__input single__input--textarea" type="text" name="trackingPixelHeader" placeholder="Enter tracking pixel for header"><?php echo $headerPixel; ?></textarea>
				<textarea class="single__input single__input--textarea" type="text" name="trackingPixelFooter" placeholder="Enter tracking pixel for footer"><?php echo $footerPixel; ?></textarea>
				<div class="input__group--submit__group">
					<input class="single__input single__input--text" type="text" name="urlPath" placeholder="URL path" value="<?php echo $urlPath; ?>" disabled/>
					<input class="single__input single__input--submit" type="submit" value="Save">
				</div>
			</div>
			</form>
            <div class="app_content">
                <?php

                $query = "SELECT * from info";
                $res = mysqli_query($conn, $query);

                ?>
                <form method="POST" action="">
                    <table id="app_table" class="display">
                        <thead>
                        <!--
                        <tr>
                            <td>
                                <select class="form-control form-control-sm">
                                    <option value = "0" >Choose...</option>
                                    <option value = "remove" >Delete selected</option>
                                </select>
                            </td>
                            <td>
                                <input name="delItems" type="submit" value="Confirm" class="single__input single__input--submit" />
                            </td>
                        </tr>
                        -->
                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Short Description</th>
                            <th>Tags</th>
                            <th>Path</th>
                            <th>Action</th>
                            <!--<th><input type="checkbox" class="all" name="all" value="all"></th>-->
                        </tr>
                        </thead>

                    </table>
                </form>
                <div id="app_status" class="item-changed">

                </div>
            </div>
<?php
if(isset($_REQUEST['infoName'])){
	$infoName = $_REQUEST['infoName'];
}
if(isset($_REQUEST['shortDesc'])){
	$shortDesc = trim($_REQUEST['shortDesc']);
}
if(isset($_REQUEST['infoTags'])){
	$tags = $_REQUEST['infoTags'];
}
if(isset($_REQUEST['trackingPixelHeader'])){
	$headerPixel = $_REQUEST['trackingPixelHeader'];
}
if(isset($_REQUEST['trackingPixelFooter'])){
	$footerPixel = $_REQUEST['trackingPixelFooter'];
}
if(isset($_REQUEST['urlPath'])){
	$urlPath = $_REQUEST['urlPath'];
}
/*
$infoQuery = "UPDATE info
				SET name = '$infoName', short_desc ='$shortDesc'
				WHERE id_info = $id";
		*/
	$infoQuery = "UPDATE info 
				SET name = '$infoName', short_desc ='$shortDesc', tags = '$tags', tracking_header = '$headerPixel', tracking_footer = '$footerPixel', url_path= '$urlPath'
				WHERE id_info = $id";
				//echo $infoQuery;

	mysqli_query($conn, $infoQuery);

for($i=1;$i<$numOfQueries;$i++){
	if(isset($_POST['idResults'])){
		$idResults[$i] = $_POST['idResults'];
	}
	if(isset($_POST['Title'. $i])){
		$titles[$i] = $_POST['Title'. $i];
	}
	if(isset($_POST['displayLink'. $i])){
		$displayLinks[$i] = $_POST['displayLink'. $i];
	}
	if(isset($_POST['actualLink'. $i])){
		$actualLinks[$i] = $_POST['actualLink'. $i];
	}
	if(isset($_POST['description'. $i])){
		$descriptions[$i] = $_POST['description'. $i];
	}
	if(isset($_POST['ad'. $i])){
		$isAds[$i] = $_POST['ad'. $i];
	}
	if(isset($_POST['rating'. $i])){
		$enableRatings[$i] = $_POST['rating'. $i];
	}
	if(isset($_POST['stars'. $i])){
		$stars[$i] = $_POST['stars'. $i];
	}
	if(isset($_POST['numberVotes'. $i])){
		$numberVotes[$i] = $_POST['numberVotes'. $i];
	}
	if(isset($_POST['imageUpload'. $i])){
		$thumbnails[$i] = $_POST['imageUpload'. $i];
	}
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
	if(isset($_FILES["imageUpload" . $i])){
		$target_file = $target_dir . basename($_FILES["imageUpload" . $i]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	}
	$uploadOk = 1;

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

				$query[$i] = "UPDATE results 
							SET meta_title = '$titles[$i]', url_mask = '$displayLinks[$i]', masked_url = '$actualLinks[$i]', description = '$descriptions[$i]', ad = '$isAds[$i]', ratings = '$enableRatings[$i]', stars = $stars[$i], votes = $numberVotes[$i], thumbnail = '$target_file'
							WHERE info_id = $idInfo";
			/*
			$query[$i] = "UPDATE results
				SET meta_title = '$titles[$i]'
				WHERE id_result = $idResults[$i]";
			*/
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


	$query[$i] = "UPDATE results 
				SET meta_title = '$titles[$i]', url_mask = '$displayLinks[$i]', masked_url = '$actualLinks[$i]', description = '$descriptions[$i]', ad = '$isAds[$i]', ratings = '$enableRatings[$i]', stars = $stars[$i], votes = $numberVotes[$i], thumbnail = ''
				WHERE id_result = $idResults[$i]";
	/*
	$query[$i] = "UPDATE results
				SET meta_title = '$titles[$i]'
				WHERE id_result = $idResults[$i]";
	echo $query[$i];
	*/
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
}//end if

include "close.php";
?>
<script>
$(document).ready(function() {

    var dataTable=$('#app_table').DataTable({
        "processing": true,
        "serverSide":true,
        "ajax":{
            url:"select.php",
            type:"post"
        }
    });

	$("#queryEditor").submit(function(e) {
		var per_id = $('#idInfo').data('id');
		var url = "/admin/edit.php?id="+per_id;
		var form = $('#queryEditor')[0];
		var formData = new FormData(form);
		$.ajax({
			type: "POST",
			url: url,
			 processData: false,
			 contentType: false,
			 data : formData,
			 cache: false,
			success: function(data)
			{
				console.log(data);
				location.href = "index.php";
				/*
				if ($.fn.DataTable.isDataTable("#app_table")) {
					$('#app_table').DataTable().clear().destroy();
				}
				//redraw table after deletion
				var dataTable=$('#app_table').DataTable({
					"processing": true,
					"serverSide":true,
					"ajax":{
						url:"select.php",
						type:"post"
					}
				});
			*/
				//display message
				$("#app_status").text("Item added!").css('display','block').fadeOut(2000).removeClass().addClass('item-added');
			}
		});
		e.preventDefault();
	});
	
});
		
</script>