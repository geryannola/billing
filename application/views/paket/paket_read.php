
    <body>
        <h2 style="margin-top:0px">Paket Read</h2>
        <table class="table">
	    <tr><td>Nama Paket</td><td><?php echo $nama_paket; ?></td></tr>
	    <tr><td>Harga Paket</td><td><?php echo $harga_paket; ?></td></tr>
	    <tr><td>Limit Paket</td><td><?php echo $limit_paket; ?></td></tr>
	    <?php if ($is_aktive==1) { ?>
	    	<tr><td>Is Aktive</td><td><?php echo 'Aktive'?></td></tr>
	   	<?php  }else { ?>
	   		<tr><td>Is Aktive</td><td><?php echo 'Non Aktive'?></td></tr>
	   	<?php } ?>
	    <tr><td>Create Date</td><td><?php echo $create_date; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('paket') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>