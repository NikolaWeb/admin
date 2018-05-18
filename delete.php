<?php
include 'connection.php';

if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $sql="SELECT * FROM info
		WHERE id_info=$id";
    $run_sql = mysqli_query($conn,$sql);


    $row = mysqli_fetch_array($run_sql);

    $urlPath = "../" .$row['url_path'];


    //deletes all files and folders associated with this entry
    function delete_files($urlPath) {
        if(is_dir($urlPath)){
            $files = glob( $urlPath . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

            foreach( $files as $file )
            {
                delete_files( $file );
            }
            if(is_dir($urlPath)){
                rmdir( $urlPath );
            }

        } elseif(is_file($urlPath)) {
            unlink( $urlPath );
        }
    }

    delete_files($urlPath);

    $sqldelete="DELETE FROM info WHERE id_info='$id'";
    $result_delete = mysqli_query($conn,$sqldelete);
    if($result_delete){
        echo'<script>window.location.href="index.php"</script>';
    }
    else{
        echo'<script>alert("Delete Failed")</script>';
    }
}

include 'close.php';
?>
