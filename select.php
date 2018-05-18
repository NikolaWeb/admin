<?php
include 'connection.php';
$request=$_REQUEST;
$col =array(
    0   =>  'id_info',
    1   =>  'name',
	2   =>  'short_desc',
	3   =>  'tags',
	6   =>  'url_path'
);  //create column like table in database

$sql ="SELECT * FROM info";
$query=mysqli_query($conn,$sql);

$totalData=mysqli_num_rows($query);

$totalFilter=$totalData;

//Search
$sql ="SELECT * FROM info WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND (name Like '".$request['search']['value']."%' ";
    $sql.=" OR url_path Like '".$request['search']['value']."%' ";
	$sql.=" OR tags Like '%".$request['search']['value']."%' )";
}
$query=mysqli_query($conn,$sql);
$totalData=mysqli_num_rows($query);

//Order
$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";

$query=mysqli_query($conn,$sql);

$data=array();

while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[]=$row[0]; //id
    $subdata[]=$row[1]; //name
    $subdata[]=$row[2]; //short desc
    $subdata[]=$row[3]; //tags
    $subdata[]=$row[6]; //path
	
	
    $subdata[]="<button class='getEdit' data-id='".$row[0]."'><i class='icon icon-edit'></i></button>
				<button class='deleteItem' data-id='".$row[0]."'><i class='icon icon-delete'></i></button>";

    $data[]=$subdata;
}

$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);

?>
