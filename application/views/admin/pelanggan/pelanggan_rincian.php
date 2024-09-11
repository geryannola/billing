<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning box-solid">

                    <div class="box-header">
                        <h3 class="box-title">KELOLA DATA PELANGGAN</h3>
                    </div>

                    <div class="box-body">
                        <div class="row" style="margin-bottom: 10px">
                            <div class="col-md-4 text-center">
                                <div style="margin-top: 8px" id="message">
                                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table">
                                    <tr>
                                        <td>Nama Pelanggan</td>
                                        <td><?php echo $nama_pelanggan; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td><?php echo $alamat; ?></td>
                                    </tr>
                                    <tr>
                                        <td>No Hp/ WA</td>
                                        <td><?php echo $no_wa; ?></td>
                                    </tr>
                                    <tr>
                                        <td>IP</td>
                                        <td><?php echo $ip; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Username</td>
                                        <td><?php echo $username; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td><?php echo $password; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Wifi</td>
                                        <td><?php echo $r_wifi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Wifi Password</td>
                                        <td><?php echo $r_password; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Mulai</td>
                                        <td><?php echo $tgl_mulai; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Cabang</td>
                                        <td><?php echo $cabang; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Paket</td>
                                        <td><?php echo $nama_paket; ?></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td><a href="<?php echo site_url('admin/pelanggan') ?>"
                                                class="btn btn-default">Cancel</a></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="box-body" style="overflow-x: scroll; ">
                            <table class="table table-bordered" style="margin-bottom: 10px">
                                <tr>
                                    <th>No</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah</th>
                                    <th>Status Bayar</th>
                                </tr><?php
                                        $start = 0;
                                        // foreach ($pelanggan_data as $pelanggan) {
                                        foreach ($riwayat_data as $riwayat) {
                                        ?>
                                <tr>
                                    <td width="10px"><?php echo ++$start ?></td>
                                    <td><?php echo $riwayat->tahun ?></td>
                                    <td><?php echo $riwayat->nama_bulan ?></td>
                                    <td><?php echo $riwayat->tgl_bayar ?></td>
                                    <td><?php echo number_format($riwayat->jml_tagihan) ?></td>
                                    <td><?php echo $riwayat->cara_bayar ?></td>
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