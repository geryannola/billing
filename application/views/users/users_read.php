
    <body>
        <h2 style="margin-top:0px">Users Read</h2>
        <table class="table">
	    <tr><td>Username</td><td><?php echo $username; ?></td></tr>
	    <tr><td>Nama</td><td><?php echo $nama; ?></td></tr>
	    <tr><td>Email</td><td><?php echo $email; ?></td></tr>
	    <tr><td>Alamat</td><td><?php echo $alamat; ?></td></tr>
	    <tr><td>Kota</td><td><?php echo $kota; ?></td></tr>
	    <tr><td>Provinsi</td><td><?php echo $provinsi; ?></td></tr>
	    <tr><td>Telepon</td><td><?php echo $telepon; ?></td></tr>
	    <?php if ($id_level==1) { ?>
	    	<tr><td>Id Level</td><td><?php echo 'Admin'?></td></tr>
	   	<?php  }else { ?>
	   		<tr><td>Id Level</td><td><?php echo 'User'?></td></tr>
	   	<?php } ?>
	   	<?php if ($is_aktive==1) { ?>
	    	<tr><td>Is Aktive</td><td><?php echo 'Aktive'?></td></tr>
	   	<?php  }else { ?>
	   		<tr><td>Is Aktive</td><td><?php echo 'Non Aktive'?></td></tr>
	   	<?php } ?>
	    <tr><td>Create Date</td><td><?php echo $create_date; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('users') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>