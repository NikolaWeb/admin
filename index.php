<!doctype html>
<html>
	<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="robots" content="noindex">
	<meta name="googlebot" content="noindex">
	<meta name="theme-color" content="#03A9F4">
	<title>lSearch Page Creator</title>
	<link rel="stylesheet" type="text/css" href="admin-panel.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
	</head>
	<body class="app">
		<header class="app__header">
			<h1>lSearch Page Creator</h1>
		</header>
		<main class="app__main">
			<form class="section section--queryResults" action="" method="POST" id="queryCreator" enctype="multipart/form-data">
				<section class="section section--numOfQueries">
					<label class="label--ratings">
						<span>&#8470; of queries:</span>
						<select id="chooseNumOfQueries" class="single__input single__input--select" name="numOfQueries">
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13" selected>13</option>

						</select>
					</label>
				</section>
			<?php for($i=1;$i<14;$i++) : ?>

				<section class="section section--queryResult">
					<h4 class="section__heading">Query Result <?php echo $i; ?>:</h4>
					<div class="input__group input__group--two">
						<input class="single__input" type="text" name="Title<?php echo $i; ?>" placeholder="Enter meta title here *">
						<input class="single__input" type="text" name="displayLink<?php echo $i; ?>" placeholder="Enter URL mask here *">
					</div>

					<input class="single__input" type="text" name="actualLink<?php echo $i; ?>" placeholder="Enter masked URL here *">

					<textarea class="single__input single__input--textarea" name="description<?php echo $i; ?>" placeholder="Enter description here *"></textarea>

					<label class="label--checkbox">
						<span>Is this an Ad?</span>
						<input class="single__checkbox single__checkbox--ad" type="checkbox" name="ad<?php echo $i; ?>" value="yes" >

						<label class="label--checkbox label--checkbox--ratings">
							<span>Enable ratings</span>
							<input class="single__checkbox single__checkbox--ratings" type="checkbox" name="rating<?php echo $i; ?>" value="yes">

							<div class="input__group input__group--center input__group--ratings">
								<label class="label--ratings">
									<span>Stars:</span>
									<select class="single__input single__input--select" name="stars<?php echo $i; ?>">
									  <option value="1">1</option>
									  <option value="2">2</option>
									  <option value="3">3</option>
									  <option value="4">4</option>
									  <option value="5" selected>5</option>
									</select>
								</label>
								<label class="label--ratings">
									<span>&#8470; of Votes:</span>
									<input class="single__input single__input--number" type="number" value="50" name="numberVotes<?php echo $i; ?>">
								</label>
							</div>
						</label>
					</label>

					<label class="label--imageUpload">
						<span>Enable thumbnail:</span>
						<input class="single__checkbox single__checkbox--file" type="checkbox" name="image<?php echo $i; ?>" value="yes">
						<div class="input--file">
							<span>Upload an image:</span>
							<input name="imageUpload<?php echo $i; ?>" type="file">
						</div>
					</label>

				</section>

			<?php endfor; ?>
			<div class="input__group input__group--submit">
				<input class="single__input single__input--text" type="text" name="infoName" placeholder="Name" />
				<textarea class="single__input single__input--textarea" type="text" name="shortDesc" placeholder="Enter short description"></textarea>
				<input class="single__input single__input--text" type="text" name="infoTags" placeholder="Tags" />
				<textarea class="single__input single__input--textarea" type="text" name="trackingPixelHeader" placeholder="Enter tracking pixel for header"></textarea>
				<textarea class="single__input single__input--textarea" type="text" name="trackingPixelFooter" placeholder="Enter tracking pixel for footer"></textarea>
				<div class="input__group--submit__group">
					<input class="single__input single__input--text" type="text" name="urlPath" placeholder="URL path" />
					<input class="single__input single__input--submit" type="submit" value="Submit Query">
				</div>
			</div>
			</form>
			<div class="app_content">
				<?php
					include "connection.php";
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

				<?php
					include "close.php";
				?>
			</div>
		</main>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js"></script>
		<script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
		<script type="text/javascript">
		  WebFont.load({
		    google: {
		      families: ['Roboto']
		    }
		  });

			$(document).ready(function() {







				var selectNumOfQueries = $('#chooseNumOfQueries');
				$(selectNumOfQueries).change(function() {
					var numOfQueriesSelected = parseInt(selectNumOfQueries.val());
					var querySelectSections = $('.section--queryResult');
					var querySectionLength = querySelectSections.length;
					var delta = querySectionLength - numOfQueriesSelected;
					$(querySelectSections).css({
						'display' : 'flex'
					});
					$('.section--queryResult:nth-of-type(n +' + (numOfQueriesSelected + 2) + ')').css({
						'display' : 'none'
					});
				});

              $("#queryCreator").validate({
                  rules:{
                      'urlPath' : {
                          required: true
                      }
                  },
                  submitHandler: function(form) {
                      var url = "/admin/stage2.php";
                      var form = $('#queryCreator')[0];
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
							  //empty form fields
							  $('#queryCreator')[0].reset();
							  
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

                              //display message
                              $("#app_status").text("Item added!").css('display','block').fadeOut(2000).removeClass().addClass('item-added');
                          },
						error: function(textStatus){
							console.log(textStatus);
						}
                      });

                  }
              });

			 
				var dataTable=$('#app_table').DataTable({
					"processing": true,
					"serverSide":true,
					"ajax":{
						url:"select.php",
						type:"post"
					}
				});
				
				
				$(".all").change(function(){  //"select all" change
					$(".single_chb").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
				});

				//".checkbox" change
				$('.single_chb').change(function(){
					//uncheck "select all", if one of the listed checkbox item is unchecked
					if(false == $(this).prop("checked")){ //if this item is unchecked
						$(".all").prop('checked', false); //change "select all" checked status to false
					}
					//check "select all" if all checkbox items are checked
					if ($('.single_chb:checked').length == $('.single_chb').length ){
						$(".all").prop('checked', true);
					}
				});				
				
				
			});
			
			//fetch edit data
			$(document).on('click','.getEdit',function(e){
				e.preventDefault();
				var per_id=$(this).data('id');
				//alert(per_id);
				$('.app__main').html('');
				$.ajax({
					url:'edit.php',
					type:'POST',
					data:'id='+per_id,
					dataType:'html'
				}).done(function(data){
					$('.app__main').html('');
					$('.app__main').html(data);
				}).fail(function(){
					$('.app__main').html('<p>Error</p>');
				});
			});
			
			//delete an item
			$(document).on('click','.deleteItem',function(e){
				e.preventDefault();
				if (confirm("Selected item will be deleted. Are you sure?")){
					var per_id=$(this).data('id');

					$.ajax({
						url:'delete.php?delete='+per_id,
						type:'POST',					
						dataType:'html',
						success: function(data){
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
							
							//display message
							$("#app_status").text("Item deleted!").css('display','block').fadeOut(2000).removeClass().addClass('item-deleted');
						},
						error: function(textStatus){
							console.log(textStatus);
						}
					});
				}	
			});

          //delete an item
          $(document).on('click','.cloneItem',function(e){
              e.preventDefault();
              if (confirm("Selected item will be cloned. Are you sure?")){
                  var per_id=$(this).data('id');

                  $.ajax({
                      url:'clone.php?id='+per_id,
                      type:'POST',
                      dataType:'html',
                      success: function(data){
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

                          //display message
                          $("#app_status").text("Item Cloned!").css('display','block').fadeOut(2000).removeClass().addClass('item-added');
                      },
                      error: function(textStatus){
                          console.log(textStatus);
                      }
                  });
              }
          });
			

		</script>
	</body>
</html>