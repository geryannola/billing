<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA PELANGGAN</h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">

				<table class='table table-bordered'>

					<tr>
						<td width='200'>Nama Pelanggan <?php echo form_error('nama_pelanggan') ?></td>
						<td><input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" placeholder="Nama Pelanggan" value="<?php echo $nama_pelanggan; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Alamat <?php echo form_error('alamat') ?></td>
						<td><input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat" value="<?php echo $alamat; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>No HP/Wa <?php echo form_error('no_wa') ?></td>
						<td><input type="text" class="form-control" name="no_wa" id="no_wa" placeholder="No Hp/Wa" value="<?php echo $no_wa; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>IP<?php echo form_error('ip') ?></td>
						<td><input type="text" class="form-control" name="ip" id="ip" placeholder="IP" value="<?php echo $ip; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Username <?php echo form_error('username') ?></td>
						<td><input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Password <?php echo form_error('password') ?></td>
						<td><input type="text" class="form-control" name="password" id="password" placeholder="Password" value="<?php echo $password; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Nama Wifi <?php echo form_error('r_wifi') ?></td>
						<td><input type="text" class="form-control" name="r_wifi" id="r_wifi" placeholder="Nama Wifi" value="<?php echo $r_wifi; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Wifi Password <?php echo form_error('r_password') ?></td>
						<td><input type="text" class="form-control" name="r_password" id="r_password" placeholder="Wifi Password" value="<?php echo $r_password; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Tgl Mulai <?php echo form_error('tgl_mulai') ?></td>
						<td><input type="date" class="form-control" name="tgl_mulai" id="tgl_mulai" placeholder="Tanggal Mulai" value="<?php echo $tgl_mulai; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Cabang <?php echo form_error('id_cabang') ?></td>
						<td><select class="form-control" name="id_cabang" id="id_cabang">
								<option value=''>-- Pilih --</option>
								<?php foreach ($cabang as $rows) { ?>
									<?php if ($id_cabang == $rows['id_cabang']) { ?>
										<option value="<?php echo $rows['id_cabang'] ?>" selected><?php echo $rows['cabang'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['id_cabang'] ?>"><?php echo $rows['cabang'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Paket <?php echo form_error('id_paket') ?></td>
						<td><select class="form-control" name="id_paket" id="id_paket">
								<option value=''>-- Pilih --</option>
								<?php foreach ($paket as $rows) { ?>
									<?php if ($id_paket == $rows['id_paket']) { ?>
										<option value="<?php echo $rows['id_paket'] ?>" selected><?php echo $rows['nama_paket'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['id_paket'] ?>"><?php echo $rows['nama_paket'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Status Pelanggan <?php echo form_error('is_aktive') ?></td>
						<td>
							<select class="form-control" name="is_aktive">
								<?php if ($is_aktive == '1') { ?>
									<option value="1" selected>Aktive</option>
									<option value="2">Non Aktive</option>
								<?php } else if ($is_aktive == '2') { ?>
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
						<td><input type="hidden" name="id_pelanggan" value="<?php echo $id_pelanggan; ?>" />
							<input type="hidden" name="id_user" value="<?php echo $id_user; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('pelanggan') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>