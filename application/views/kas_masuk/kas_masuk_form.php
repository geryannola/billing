<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA </h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">

				<table class='table table-bordered'>

					<tr>
						<td width='200'>Tgl Km <?php echo form_error('tgl_km') ?></td>
						<td><input type="date" class="form-control" name="tgl_km" id="tgl_km" placeholder="Tgl Km" value="<?php echo $tgl_km; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Uraian Km <?php echo form_error('uraian_km') ?></td>
						<td><input type="text" class="form-control" name="uraian_km" id="uraian_km" placeholder="Uraian Km" value="<?php echo $uraian_km; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Masuk <?php echo form_error('masuk') ?></td>
						<td><input type="number" class="form-control" name="masuk" id="masuk" placeholder="Masuk" value="<?php echo $masuk; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Cara Bayar <?php echo form_error('id_cara_bayar') ?></td>
						<td><select class="form-control" name="id_cara_bayar" id="id_cara_bayar">
								<option value=''>-- Pilih --</option>
								<?php foreach ($cara_bayar as $rows) { ?>
									<?php if ($id_cara_bayar == $rows['id_cara_bayar']) { ?>
										<option value="<?php echo $rows['id_cara_bayar'] ?>" selected><?php echo $rows['cara_bayar'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['id_cara_bayar'] ?>"><?php echo $rows['cara_bayar'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="id_km" value="<?php echo $id_km; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('kas_masuk') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>