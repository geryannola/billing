<body>
	<h2 style="margin-top:0px">Users Read</h2>
	<table class="table">
		<tr>
			<td>Nama Cabang</td>
			<td><?php echo $cabang; ?></td>
		</tr>
		<tr>
			<td>Alamat</td>
			<td><?php echo $alamat; ?></td>
		</tr>
		<tr>
			<td>User Mikrotik</td>
			<td><?php echo $user_mikrotik; ?></td>
		</tr>
		<tr>
			<td>Password Mikrotik</td>
			<td><?php echo $pass_mikrotik; ?></td>
		</tr>
		<tr>
			<td>IP Mikrotik</td>
			<td><?php echo $ip_mikrotik; ?></td>
		</tr>
		<tr>
			<td>Domain</td>
			<td><?php echo $domain; ?></td>
		</tr>
		<?php if ($is_aktive == 1) { ?>
			<tr>
				<td>Is Aktive</td>
				<td><?php echo 'Aktive' ?></td>
			</tr>
		<?php  } else { ?>
			<tr>
				<td>Is Aktive</td>
				<td><?php echo 'Non Aktive' ?></td>
			</tr>
		<?php } ?>
		<tr>
			<td>Create Date</td>
			<td><?php echo $create_date; ?></td>
		</tr>
		<tr>
			<td></td>
			<td><a href="<?php echo site_url('cabang') ?>" class="btn btn-default">Cancel</a></td>
		</tr>
	</table>
</body>