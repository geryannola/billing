<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA</h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">

				<table class='table table-bordered'>
					<tr>
						<td width='200'>Nama <?php echo form_error('mikrotik') ?></td>
						<td><input type="text" class="form-control" name="mikrotik" id="mikrotik" placeholder="Nama Mikrotik" value="<?php echo $mikrotik; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Alamat <?php echo form_error('user_mikrotik') ?></td>
						<td><input type="text" class="form-control" name="user_mikrotik" id="user_mikrotik" placeholder="User Mikrotik" value="<?php echo $user_mikrotik; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>User Mikrotik <?php echo form_error('user_mikrotik') ?></td>
						<td><input type="text" class="form-control" name="user_mikrotik" id="user_mikrotik" placeholder="User Mikrotik" value="<?php echo $user_mikrotik; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Password Mikrotik <?php echo form_error('pass_mikrotik') ?></td>
						<td><input type="text" class="form-control" name="pass_mikrotik" id="pass_mikrotik" placeholder="Password Mikrotik" value="<?php echo $pass_mikrotik; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>IP Mikrotik <?php echo form_error('ip_mikrotik') ?></td>
						<td><input type="text" class="form-control" name="ip_mikrotik" id="ip_mikrotik" placeholder="IP Mikrotik" value="<?php echo $ip_mikrotik; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Domain <?php echo form_error('domain') ?></td>
						<td><input type="text" class="form-control" name="domain" id="domain" placeholder="Domain" value="<?php echo $domain; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Status Cabang <?php echo form_error('is_aktive') ?></td>
						<td>
							<select class="form-control" name="is_aktive">
								<?php $is_aktive = $data_cabang['is_aktive'] ?>
								<?php if ($is_aktive == 1) { ?>
									<option value="1" selected>Aktive</option>
									<option value="2">Non Aktive</option>
								<?php } else if ($is_aktive == 2) { ?>
									<option value="1">Aktive</option>
									<option value="2" selected>Non Aktive</option>
								<?php } else { ?>
									<option value="">-- Pilih --</option>
									<option value="1">Aktive</option>
									<option value="2">Non Aktive</option>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="id_mikrotik" value="<?php echo $id_mikrotik; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<!-- <a href="<?php echo site_url('mikrotik/mikrotik') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a> -->
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>