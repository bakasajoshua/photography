<style type="text/css">
	.carousel_image
	{
		height: 418px !important;
		width: 699px !important;
	}

	.no_data
	{
		padding: 30%;
		background-color: #f3f3f3;
	}
</style>
<div class="wrapper wrapper-content">
	<div class = "row animated fadeInRight">
		<div class="col-md-4" id = "details_section">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $model_details['first_name']; ?>'s Profile</h5>
				</div>
				<div>
					<div class="ibox-content no-padding border-left-right">
						<img alt="image" class="img-responsive" src="<?php echo $model_details['profile']?>">
					</div>
					<div class="ibox-content profile-content">
						<h4><strong><?php echo ucwords(strtolower($model_details['first_name'])) . ' ' . ucwords(strtolower($model_details['last_name'])); ?></strong></h4>
						<p><i class="fa fa-map-marker"></i> <?php echo $model_details['address'];?></p>
						<h5>
							About <?php echo ucwords(strtolower($model_details['first_name'])); ?>
						</h5>
						<p>
							<?php echo ucwords(strtolower($model_details['first_name'])); ?> is a <?php echo ucwords(strtolower($model_details['occupation'])); ?> at <?php echo ucwords(strtolower($model_details['company'])); ?> and was born in <?php echo date('dS F, Y', strtotime($model_details['dob']))?>
						</p>
						<div class="row m-t-lg">
							<div class="col-md-4">
								<span class="bar">5,0,9,6,5,9,7,3,5,2</span>
								<h5><strong><?php echo $model_details['imagecounts'];?></strong> Images</h5>
							</div>
							<div class="col-md-4">
								<span class="line">5,3,9,6,5,9,7,3,5,2</span>
								<h5><strong>28</strong> Following</h5>
							</div>
							<div class="col-md-4">
								<span class="bar">5,3,2,-1,-3,-2,2,3,5,2</span>
								<h5><strong>240</strong> Followers</h5>
							</div>
						</div>
						<div class="user-button">
							<div class="row">
								<div class="col-md-6">
									<button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Send Message</button>
								</div>
								<div class="col-md-6">
									<a href = "#" class="btn btn-warning btn-sm btn-block" id = "profile-edit"><i class="fa fa-pencil"></i> Edit Profile</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-8" id = "pictures_section">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo ucwords(strtolower($model_details['first_name'])); ?>'s Photos</h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
					<div id = "model-carousel"></div>
				</div>
			</div>
		</div>
	</div>

	<div class = "row">
		<div class="col-md-12 animated" id = "all_pictures">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>All of <?php echo ucwords(strtolower($model_details['first_name'])); ?>'s Photos</h5>&nbsp;&nbsp;<a id = "upload_request"  class = "upload_caller">Upload More?</a>
				</div>
				<div class="ibox-content">
					<div id = "all-pictures"></div>
				</div>
			</div>
		</div>

		<div class="col-md-12 animated" id = "uploader">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Upload Pictures to <?php echo ucwords(strtolower($model_details['first_name'])); ?>'s Profile</h5>&nbsp;&nbsp;<a id = "upload_reject" class = "">Go back to photos</a>
				</div>
				<div class="ibox-content">
				<form id="my-awesome-dropzone" class="dropzone" action="<?php echo base_url(); ?>models/upload_model_photo" enctype="multipart/form-data">
					<div class="dropzone-previews"></div>
					<input type = "hidden" value = "<?php echo $model_details['model_id']; ?>" name = "modelid" />
					<input type = "hidden" value = "<?php echo $model_details['first_name']; ?>" name = "model_first_name" />
					<input type = "hidden" value = "<?php echo $model_details['last_name']; ?>" name = "model_last_name" />
					<button type="submit" class="btn btn-success pull-right"><i class = "fa fa-upload"></i>&nbsp;Upload Photos!</button>
				</form>
				</div>
			</div>
		</div> 
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#uploader').hide();
		details_height = $('#details_section').height();
		$('#pictures_section').height(details_height);
		get_model_images();
		
		$('.upload_caller').click(function(){
			$('#all_pictures').hide();
			$('#uploader').show();
		});

		$('#upload_reject').click(function(){
			$('#all_pictures').show();
			$('#uploader').hide();
		});

		$('#profile-edit').click(function(){
			$.get('<?php echo base_url(); ?>models/ajax_edit_model_details/<?php echo $model_details["model_id"];?>', function(data){
				obj = jQuery.parseJSON(data);
				$('.modal-title').text(obj.heading);
				$('#modal_form').html(jQuery.parseHTML(obj.theform));
				$('#modal_form').attr('action', obj.form_action);
				$('#a_button').text('Update Model Profile');
			});
			$('#myModal4').modal('show');
		});
	});

	function get_model_images()
	{
		// $.get('<?php echo base_url(); ?>models/ajax_model_images/' + '<?php echo $model_details["model_id"]; ?>', function(data){
		// 	obj = jQuery.parseJSON(data);
		// 	$('#model-carousel').append(obj.pictures_section);
		// 	$('#all-pictures').append(obj.all_pictures);
		// 	$('.upload_caller').attr('id', 'upload_request');
		// });
	}
</script>