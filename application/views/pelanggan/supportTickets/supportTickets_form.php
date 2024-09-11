<div class="content-wrapper">

	<section class="content">
		<div class="box box-warning box-solid">
			<div class="box-header with-border">
				<h3 class="box-title">INPUT DATA SUPPORT</h3>
			</div>
			<form action="<?php echo $action; ?>" method="post">
				<table class='table table-bordered'>
					<tr>
						<td width='200'>Jenis Support <?php echo form_error('jenis_ticket') ?></td>
						<td><select class="form-control" name="jenis_ticket" id="jenis_ticket">
								<option value=''>-- Pilih --</option>
								<?php foreach ($m_jenis_ticket as $rows) { ?>
									<?php if ($jenis_ticket == $rows['jenis_ticket']) { ?>
										<option value="<?php echo $rows['jenis_ticket'] ?>" selected><?php echo $rows['jenis_ticket'] ?></option>
									<?php } else { ?>
										<option value="<?php echo $rows['jenis_ticket'] ?>"><?php echo $rows['jenis_ticket'] ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<tr>
						<td width='200'>Judul <?php echo form_error('judul_ticket') ?></td>
						<td><input type="text" class="form-control" name="judul_ticket" id="judul_ticket" placeholder="Judul Support" value="<?php echo $judul_ticket; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Pesan <?php echo form_error('pesan_ticket') ?></td>
						<td><input type="text" class="form-control" name="pesan_ticket" id="pesan_ticket" placeholder="Pesan Support" value="<?php echo $pesan_ticket; ?>" /></td>
					</tr>
					<tr>
						<td width='200'>Attachments <?php echo form_error('file') ?></td>
						<td>
							<div class="widget-body">
								<div class="widget-main">
									<div class="col-xs-12">
										<input type="file" name="attachments" id="id-input-file-2" value="<?php echo $Attachments; ?>" required />
									</div>
								</div>
							</div>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="hidden" name="id_support_tickets" value="<?php echo $id_support_tickets; ?>" />
							<input type="hidden" name="create_user" value="<?php echo $create_user; ?>" />
							<button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button ?></button>
							<a href="<?php echo site_url('pelanggan/supportTickets') ?>" class="btn btn-info"><i class="fa fa-sign-out"></i> Kembali</a>
						</td>
					</tr>
				</table>
			</form>
		</div>
</div>
</div>