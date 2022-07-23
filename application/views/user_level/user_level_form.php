<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA USER_LEVEL</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Nama User Level <?php echo form_error('nama_user_level') ?></td><td><input type="text" class="form-control" name="nama_user_level" id="nama_user_level" placeholder="Nama User Level" value="<?php echo $nama_user_level; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_level" value="<?php echo $id_level; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('user_level') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>