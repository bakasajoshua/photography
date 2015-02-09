<style type="text/css">
    a.label
    {
        color: #fff;
    }

    .folder-list a:hover
    {
        background-color: #f3f3f3;
    }
    .no_data
    {
        padding: 20%;
        color: #ed5565;
        background-color: #fff;
    }
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="file-manager">
                        <h5>Show:</h5>
                        <a href="#" class="file-control active label label-info">All</a>
                        <a href="#" class="file-control label label-primary">Active</a>
                        <a href="#" class="file-control label label-danger">Deactivated</a>
                        <div class="hr-line-dashed"></div>
                        <button class="btn btn-primary btn-block" id = "add-category">Add a Category</button>
                        <div class="hr-line-dashed"></div>
                        <h5>Upload Statistics</h5>
                        <ul class="folder-list" style="padding: 0">
                            <?php echo $category_listing; ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $category_grid;?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        get_category_form();
        $('#add-category').click(function(){
            $('#myModal4').modal('show');
        });

        $('.activation').click(function(){
            $(this).html('<i class = "fa fa-spin fa-spinner"></i> Working...');
           category_id = $(this).attr('data-id');
           todo = $(this).attr('data-to');

           $.get('<?php echo base_url(); ?>categories/update_category/'+todo+'/'+category_id, function(data){
            obj = jQuery.parseJSON(data);
            if (obj.type === 'Success')
            {
                $('.modal-title').text('Success');
                update_link(todo, category_id);
            }
            else
            {
                $('.modal-title').text('Error');
            }
            $('#message-body').html(jQuery.parseHTML('<p>'+obj.message+'</p>'));
            $('#messageModal').modal('show');
           });
        });

        $('.category_link').click(function(){
            category_id = $(this).attr('data-id');
            cleartextboxes();

            $.get('<?php base_url(); ?>categories/get_category_by_id/'+category_id, function(info){
                obj = jQuery.parseJSON(info);
                if(obj.type === 'Error')
                {
                    $('.modal-title').text('Error');
                    $('#message-body').html(jQuery.parseHTML('<center><p>'+obj.message+'</p></center>'));
                    $('#messageModal').modal('show');
                }
                else
                {
                    data = obj.data;
                    $('.modal-title').text('Updating: ' + data.category_name);
                    $('input[name="category_name"]').val(data.category_name);
                    $('textarea[name="description"]').val(data.description);
                    $('#a_button').text('Update Category');
                    $('#modal_form').attr('action', '<?php echo base_url(); ?>categories/update_category/update/'+category_id);
                    $('#myModal4').modal('show');
                }
            });
        });
    });

    function get_category_form()
    {
        $.get('<?php echo base_url();?>categories/get_add_categories_form', function(info){
            $('.modal-title').text('Add a new Category');
            $('#modal_form').html(jQuery.parseHTML(info));
            $('#modal_form').attr('action', '<?php echo base_url(); ?>categories/addcategory');
            $('#a_button').text('Add a New Category');
        });
    }

    function update_link(todo, category_id)
    {
        link = $('a.label[data-id='+category_id+']')
        if(todo === 'activate')
        {
            link.removeClass('label-danger');
            link.addClass('label-primary');
            link.attr('data-to', 'deactivate');
            link.text('Active');
        }
        else
        {
            link.removeClass('label-primary');
            link.addClass('label-danger');
            link.attr('data-to', 'activate');
            link.text('Deactivated');
        }
    }

    function cleartextboxes()
    {
        $('input, textarea').val('');
    }
</script>