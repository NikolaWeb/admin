<?php

include 'connection.php';

if(isset($_GET['id'])) {
    $id=intval($_GET['id']);

    $sql="SELECT * FROM info i
		INNER JOIN results r 
		ON i.id_info = r.info_id
		WHERE id_info=$id";
    $run_sql=mysqli_query($conn,$sql);
    $numOfQueries = intval(mysqli_num_rows($run_sql))+1;

    $i = 0;
    while($row=mysqli_fetch_array($run_sql)) {

        //singular data from info table
        $idInfo = $row['id_info'];
        $infoName = $row['name'];
        $shortDesc = $row['short_desc'];
        $tags = $row['tags'];
        $headerPixel = $row['tracking_header'];
        $footerPixel = $row['tracking_footer'];
        $urlPath = $row['url_path'] . time();

        /*
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
        */

        if($row['meta_title']){
            $titles[$i] = $row['meta_title'];
        }
        else{
            $titles[$i] = "";
        }
        if($row['url_mask']){
            $displayLinks[$i] = $row['url_mask'];
        }
        else{
            $displayLinks[$i] = "";
        }


        $i++;
    }

    $infoQuery = "INSERT INTO info (id_info, name, short_desc, tags, tracking_header, tracking_footer, url_path)
			VALUES(NULL, '$infoName', '$shortDesc', '$tags', '$headerPixel', '$footerPixel', '$urlPath')";

    if (mysqli_query($conn, $infoQuery)) {
        $idInfo = mysqli_insert_id($conn);
    } else {
        echo mysqli_error($conn);
    }


    $result = "";
    for($i=1;$i<$numOfQueries;$i++){

/*
        $query[$i] = "INSERT INTO results (id_result, meta_title, url_mask, masked_url, description, ad, ratings, stars, votes, thumbnail, info_id)
			VALUES(NULL, '$titles[$i]', 
			'$displayLinks[$i]', 
			'$actualLinks[$i]', 
			'$descriptions[$i]', '$isAds[$i]', '$enableRatings[$i]', '$stars[$i]', '$numberVotes[$i]', '', $idInfo)";
     */
        $query[$i] = "INSERT INTO results (id_result, meta_title, url_mask, masked_url, description, ad, ratings, stars, votes, thumbnail, info_id)
			VALUES(NULL, '$titles[$i]', 
			'$displayLinks[$i]', 
			'', '', '', '', NULL, NULL, '', $idInfo";
        var_dump($query[$i]);
        mysqli_query($conn, $query[$i]);


    }
}