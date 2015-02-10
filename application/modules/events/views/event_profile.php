<div>
	<div class="wrapper wrapper-content">
		<div class="row animated fadeInRight">
            <div class="row">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Event Profile</h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-responsive" src="<?php echo $eve_details[0]['cover']; ?>">
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong><?php echo $eve_details[0]["event_name"]; ?></strong></h4>
                                <p><i class="fa fa-map-marker"></i><?php echo $eve_details[0]["place"]; ?></p>
                                <p>
                                    <?php echo $eve_details[0]["Description"];?>
                                </p>
                                <h5>
                                    FROM: <?php echo $months.' , '.$eve_details[0]["start_year"];?>
                                </h5>
                                <div class="user-button">
                                    <div class="col-md-6">
                                        <button class = "btn btn-success btn-sm btn-block" type="button"><a href="<?php echo base_url(); ?>events/add_images/<?php echo $eve_details[0]['event_id']; ?>" style="color:white;">Add Images</a></button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href = "#" class="btn btn-warning btn-sm btn-block" id = "profile-edit"><i class="fa fa-pencil"></i> Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8" id = "pictures_section">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5><?php echo ucwords(strtolower($eve_details[0]['event_name'])); ?>'s Photos</h5>
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

            <div class="row">
                <div class="col-lg-12 animated fadeInRight">
                    <div class="row">
                 
                        <div class="col-lg-12">
                            <div class="ibox float-e-margins">
                                <div class="ibox-title">
                                    <h5>Basic Table <small>Images</small></h5>
                                    <div class="ibox-tools">
                                        <a class="collapse-link">
                                            <i class="fa fa-chevron-up"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="ibox-content">

                                    <?php
                                        echo $event_images;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
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
        Dropzone.options.myAwesomeDropzone = {
                autoProcessQueue: false,
                uploadMultiple: true,
                parallelUploads: 100,
                maxFiles: 100,

                // Dropzone settings
                init: function() {
                    var myDropzone = this;

                    this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                    });
                    this.on("sendingmultiple", function() {
                        console.log('Uploading Files. Please wait...');
                    });
                    this.on("successmultiple", function(files, response) {
                        location.reload();
                    });
                    this.on("errormultiple", function(files, response) {
                        alert(response);
                    });
                }

            }
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
                $('#a_button').text('Update Event Profile');
            });
            $('#myModal4').modal('show');
        });
    });

    function get_model_images()
    {
        $.get('<?php echo base_url(); ?>events/ajax_event_images/' + '<?php echo $eve_details[0]["event_id"]; ?>', function(data){
            obj = jQuery.parseJSON(data);
            $('#model-carousel').append(obj.pictures_section);
            $('#all-pictures').append(obj.all_pictures);
            $('.upload_caller').attr('id', 'upload_request');
        });
    }
</script>