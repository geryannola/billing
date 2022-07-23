<div class="content-wrapper">
    
    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA KAS_MASJID</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">
            
<table class='table table-bordered>'        

	    <tr><td width='200'>Tgl Km <?php echo form_error('tgl_km') ?></td><td><input type="date" class="form-control" name="tgl_km" id="tgl_km" placeholder="Tgl Km" value="<?php echo $tgl_km; ?>" /></td></tr>
	    <tr><td width='200'>Uraian Km <?php echo form_error('uraian_km') ?></td><td><input type="text" class="form-control" name="uraian_km" id="uraian_km" placeholder="Uraian Km" value="<?php echo $uraian_km; ?>" /></td></tr>
	    <tr><td width='200'>Masuk <?php echo form_error('masuk') ?></td><td><input type="text" class="form-control" name="masuk" id="masuk" placeholder="Masuk" value="<?php echo $masuk; ?>" /></td></tr>
	    <tr><td width='200'>Keluar <?php echo form_error('keluar') ?></td><td><input type="text" class="form-control" name="keluar" id="keluar" placeholder="Keluar" value="<?php echo $keluar; ?>" /></td></tr>
	    <tr><td width='200'>Jenis <?php echo form_error('jenis') ?></td><td><input type="text" class="form-control" name="jenis" id="jenis" placeholder="Jenis" value="<?php echo $jenis; ?>" /></td></tr>
	    <tr><td></td><td><input type="hidden" name="id_km" value="<?php echo $id_km; ?>" /> 
	    <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button> 
	    <a href="<?php echo site_url('rekap_kas_masjid') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a></td></tr>
	</table></form>        </div>
</div>
</div>