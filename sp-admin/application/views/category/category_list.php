<?php $this->load->view('includes/header'); ?>
<!-- BEGIN CONTAINER -->
<div class="page-container">
	<!-- BEGIN SIDEBAR -->
	<?php $this->load->view('includes/menu'); ?>
	<!-- END SIDEBAR -->
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEADER-->
			<?php $this->load->view('includes/breadcrumb',$breadcrumbs); ?>
                <div class="page-toolbar">
					<a href="<?php echo site_url('category/category_add') ?>" class="btn blue">إضافة قسم جديد</a>
                </div>
            </div>
			<!-- END PAGE HEADER-->
			<div class="row">
				<div class="col-md-12">
					<?php
                    $all = $this->messages->get();
                    if ($all != null) {
                        foreach ($all as $type => $messages)
                            foreach ($messages as $message)
                                switch ($type) {
                                    case "error":
                                        echo '<div class="alert alert-danger innerLR"><button type="button" class="close" data-dismiss="alert">×</button><strong>خطأ</strong><br>' . $message . '</div>';
                                        break;
                                    case "success":
                                        echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button><strong>نجاح</strong><br>' . $message . '</div>';
                                        break;
                                    case "alert":
                                        echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button><strong>تحذير</strong><br>' . $message . '</div>';
                                        break;
                                }
                    }
                    ?>
                    <?php if (validation_errors() != null) { ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>خطأ</strong><?php echo validation_errors(); ?> </div>
                    <?php } ?>
                
                
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-users"></i><?php echo $pageTitle ?>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover">
								<thead>
								<tr>
                                    <th>#</th>
									<th>القسم</th>
									<th>الإعدادات</th>
								</tr>
								</thead>
								<tbody>
									<?php
                                    if($rows != false)
                                    foreach($rows as $row){
                                    ?>
                                    <tr>
                                        <td><?php echo $row->cat_uid; ?></td>
                                        <td><?php echo $row->cat_name ?></td>
                                        <td>
                                        	<a href="<?php echo site_url('category/category_edit/'.$row->cat_uid) ?>" class="btn btn-xs yellow"><i class="fa fa-pencil"></i> تعديل</a>
                                            <a href="<?php echo site_url('category/category_del/'.$row->cat_uid) ?>" class="btn btn-xs red"><i class="fa fa-trash-o"></i> حذف</a>
                                            
										
                                        </td>
                                    </tr>
                                    <?php } ?>
								</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
            </div>
            
			<div class="clearfix">
			</div>
			
			
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<?php $this->load->view('includes/footer'); ?>