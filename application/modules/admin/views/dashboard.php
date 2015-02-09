<style type="text/css">
    a {
        color: white;
        text-decoration: none;
    }

    .widget a:hover, .bi a:hover
    {
        color: white;
    } 

    .button-image
    {
        height: 120px;
        background-color: #111;
        background-size: cover;
        text-align: center;
    }

    .button-image:hover .floater
    {
        opacity: 0.8;
    }

    .button-image .floater
    {
        background-color: rgba(0,0,0,0.75);
    }
    .button-image h2
    {
        width: 100%;
        height: 120px;
        display: table-cell;
        vertical-align: middle;
        text-align: middle;
        text-align: center;
    }
</style>
<script type="text/javascript" src = "<?php echo base_url(); ?>assets/admin/js/analytics.js"></script>
<script type="text/javascript" src = "<?php echo base_url(); ?>assets/admin/js/main.js"></script>  
<div>
	<!-- <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Dashboard</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="<?php //echo base_url('admin') ?>">Home</a>
                        </li>
                        <li class="active">
                            <a>Dashboard</a>
                        </li>
                        
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
 -->
    <div class="row  border-bottom white-bg dashboard-header">

                    <div class="col-sm-3">
                        <h2>Welcome <?php echo ucwords(strtolower($user_details['admin_f_name']));?></h2>
                        <small>You have 42 messages and 6 notifications.</small>
                        <ul class="list-group clear-list m-t">
                            <li class="list-group-item fist-item">
                                <span class="pull-right">
                                    09:00 pm
                                </span>
                                <span class="label label-success">1</span> Please contact me
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    10:16 am
                                </span>
                                <span class="label label-info">2</span> Sign a contract
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    08:22 pm
                                </span>
                                <span class="label label-primary">3</span> Open new shop
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    11:06 pm
                                </span>
                                <span class="label label-default">4</span> Call back to Sylvia
                            </li>
                            <li class="list-group-item">
                                <span class="pull-right">
                                    12:00 am
                                </span>
                                <span class="label label-primary">5</span> Write a letter to Sandra
                            </li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <div class="flot-chart dashboard-chart">
                            <canvas class="flot-chart-content" id="flot-dashboard-chart"></canvas>
                            <center><a class ="label label-info" id = "line-expand"><i class = "fa fa-expand"></i> Expand</a></center>
                        </div>
                       <!--  <div class="row text-left">
                            <div class="col-xs-4">
                                <div class=" m-l-md">
                                <span class="h4 font-bold m-t block">$ 406,100</span>
                                <small class="text-muted m-b block">Sales marketing report</small>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <span class="h4 font-bold m-t block">$ 150,401</span>
                                <small class="text-muted m-b block">Annual sales revenue</small>
                            </div>
                            <div class="col-xs-4">
                                <span class="h4 font-bold m-t block">$ 16,822</span>
                                <small class="text-muted m-b block">Half-year revenue margin</small>
                            </div>

                        </div> -->
                    </div>
                    <div class="col-sm-3">
                        <div class="statistic-box">
                        <h4>
                           <center>Uploads Categorised</center>
                        </h4>
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <canvas id="doughnutChart"></canvas>
                            </div>
                        </div>
                        <div class="m-t">
                            <center><a class ="label label-info" id = "doughnut-expand"><i class = "fa fa-expand"></i> Expand</a></center>
                        </div>

                        </div>
                    </div>

        </div>
	<div class="wrapper wrapper-content">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-3 bi">
                    <a href = "<?php echo base_url(); ?>admin/pick">
                        <div class = "button-image animated" style = "background-image: url('<?php echo base_url(); ?>assets/images/pickoftheday.jpg')">
                            <div class = "floater"><center><h2>Picture of the day</h2></center></div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 bi">
                     <a href = "<?php echo base_url(); ?>admin/edithome">
                        <div class = "button-image animated" style = "background-image: url('<?php echo base_url(); ?>assets/images/frontpage.jpg')">
                            <div class = "floater"><center><h2>Home page Images</h2></center></div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 bi">
                     <a href = "<?php echo base_url(); ?>events/">
                        <div class = "button-image animated" style = "background-image: url('<?php echo base_url(); ?>assets/images/events.jpeg')">
                            <div class = "floater"><center><h2>Events</h2></center></div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 bi">
                     <a href = "<?php echo base_url(); ?>categories/">
                        <div class = "button-image animated" style = "background-image: url('<?php echo base_url(); ?>assets/images/fun.jpg')">
                            <div class = "floater"><center><h2>Fun Stuff</h2></center></div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="hr-line-dashed"></div>
            
            <div class="row">
                <!-- <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Daily ACtivities</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                                </a>
                                
                            </div>
                        </div>
                       <div class="ibox-content text-center h-200">
                            <span id=""></span>
                        </div>
                    </div>
                </div> -->
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Quick Upload: Categories</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                                </a>
                                
                            </div>
                        </div>
                        <div class="ibox-content">
                            <form method = "POST" class="form-horizontal" name = "image_uploader" enctype="multipart/form-data" action = "<?php echo base_url(); ?>upload/quickupload" id = "quickuploadform">
                                <div class = "form-group">
                                    <select name = "upload_to" data-placeholder="Choose what to upload to..." class="form-control chosen-select">
                                        <?php echo $categories; ?>
                                    </select>
                                </div>
                                <div class = "form-group">
                                    <input class="form-control" type="text" name="upload_name" placeholder="Name of Image" required/>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class = "form-group">
                                    <textarea class="form-control" name='upload_description' placeholder="Enter Description..." rows = "4" required></textarea>
                                </div>
                                 <div class = "form-group">
                                    <input type = "file" name = "upload_image" required/>
                                </div>

                                <div class="form-group">
                                    <button name = "upload_button" class="btn btn-success " type="submit" id = "upload_button"><i class="fa fa-upload"></i>&nbsp;&nbsp;<span class="bold">Upload</span></button>
                                </div>
                               
                                <div class = "message_box"><span class = "<?php if($error){ echo 'error';}else echo 'success' ?>"><p><?php echo $message; ?></p></span></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Quick Email</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                                </a>
                                
                            </div>
                        </div>
                        <div class="ibox-content">
                            <?php echo form_open(base_url('admin/email_send'));?>
                            
                                <div class="form-group">
                                    <div class=""><input type="text" class="form-control" name="email_address" id="email_address" placeholder="Email Address"></div>
                                </div>
                                
                                <div class="form-group">
                                    <div class=""><input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"></div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="">
                                        <textarea class="form-control" name="message" id="message" placeholder="Type Message Here..." rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <button class="btn btn-primary " type="submit"><i class="fa fa-send"></i>&nbsp;Send Mail</button>
                            </form>
                        </div>
                    </div>
                </div> 


            </div>
            <div class = "row">
                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">Total</span>
                            <h5>Uploads per Category</h5>
                        </div>
                        <div class="ibox-content">
                            <canvas id = "categories_uploads"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-warning pull-right">Total</span>
                            <h5>Uploads Per Event</h5>
                        </div>
                        <div class="ibox-content">
                            <canvas id = "events_uploads"></canvas>
                        </div>
                    </div>
                </div>

               <!--  <div class="col-lg-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">Monthly</span>
                            <h5>Income</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="flot-chart">
                                <div class="flot-chart-pie-content" id="flot-pie"></div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
