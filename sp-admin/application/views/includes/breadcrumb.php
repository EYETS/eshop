    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo site_url('main') ?>">الرئيسية</a>
            </li>
            <?php foreach($breadcrumbs as $key => $value){ ?>
            <li>
                <i class="fa fa-angle-left"></i>
                <a href="<?php echo $value ?>"><?php echo $key ?></a>
            </li>
			<?php } ?>
        </ul>
