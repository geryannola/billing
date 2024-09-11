<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA PAKET</h3>
                    </div>

                    <div class="box-body">
                        <div class='row'>
                            <div class='col-md-9'>
                                <div style="padding-bottom: 10px;"'>
        <?php echo anchor(site_url('admin/paket/create'), '<i class="fa fa-wpforms" aria-hidden="true"></i> Tambah Data', 'class="btn btn-danger btn-sm"'); ?>
		<!-- <?php echo anchor(site_url('paket/excel'), '<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export Ms Excel', 'class="btn btn-success btn-sm"'); ?> -->
	</div>
            </div>
            <div class=' col-md-3'>
                                    <form action="<?php echo site_url('admin/paket/index'); ?>" class="form-inline"
                                        method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                                            <span class="input-group-btn">
                                                <?php
												if ($q <> '') {
												?>
                                                <a href="<?php echo site_url('admin/paket'); ?>"
                                                    class="btn btn-sm btn-default">Reset</a>
                                                <?php
												}
												?>
                                                <button class="btn btn-sm btn-primary" type="submit">Search</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>


                            <div class="row" style="margin-bottom: 10px">
                                <div class="col-md-4 text-center">
                                    <div style="margin-top: 8px" id="message">
                                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                    </div>
                                </div>
                                <div class="col-md-1 text-right">
                                </div>
                                <div class="col-md-3 text-right">

                                </div>
                            </div>
                            <div class="box-body" style="overflow-x: scroll; ">
                                <table class="table table-bordered" style="margin-bottom: 10px">
                                    <tr>
                                        <th>No</th>
                                        <th>Mikrotik</th>
                                        <th>Nama</th>
                                        <th>Jenis</th>
                                        <th>id</th>
                                        <th>Status Aktive</th>
                                        <th>Action</th>
                                    </tr><?php
											foreach ($paket_data as $paket) {
											?>
                                    <tr>
                                        <td width="10px"><?php echo ++$start ?></td>
                                        <td><?php echo $paket->mikrotik ?></td>
                                        <td><?php echo $paket->nama_paket ?></td>
                                        <td><?php echo $paket->service ?></td>
                                        <td><?php echo $paket->profile ?></td>
                                        <?php if ($paket->is_aktive == 1) { ?>
                                        <td>Aktive</td>
                                        <?php } else { ?>
                                        <td>Non Aktive </td>
                                        <?php } ?>
                                        <td style="text-align:center" width="200px">
                                            <?php
												echo anchor(site_url('admin/paket/read/' . $paket->id_paket), '<i class="fa fa-eye" aria-hidden="true"></i>', 'class="btn btn-success btn-sm"');
												echo '  ';
												echo anchor(site_url('admin/paket/update/' . $paket->id_paket), '<i class="fa fa-pencil-square-o" aria-hidden="true"></i>', 'class="btn btn-primary btn-sm"');
												echo '  ';
												?>
                                            <a href="paket/delete/<?= $paket->id_paket; ?>"
                                                class="btn btn-danger btn-sm"
                                                onclick=" return confirm('Apakah Kamu Benar Menghapus')"><i
                                                    class="fa fa-trash-o" aria-hidden="true"></i></a>
                                        </td>
                                    </tr>
                                    <?php
											}
									?>
                                </table>
                                <div class="row">
                                    <div class="col-md-6">

                                    </div>
                                    <div class="col-md-6 text-right">
                                        <?php echo $pagination ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
</div>