<div class="content-wrapper">

    <section class="content">
        <div class="box box-warning box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">INPUT DATA</h3>
            </div>
            <form action="<?php echo $action; ?>" method="post">

                <table class='table table-bordered'>
                    <tr>
                        <td width='200'>Service <?php echo form_error('service') ?></td>
                        <td>
                            <select class="form-control" name="service">
                                <?php $service = $data_paket['service'] ?>
                                <?php if ($service=='hostpot') { ?>
                                <option value="hostpot" selected>Hostpot</option>
                                <option value="ppp">PPP</option>
                                <?php }else if ($service=='ppp'){ ?>
                                <option value="hostpot">Hostpot</option>
                                <option value="ppp" selected>PPP</option>
                                <?php }else {?>
                                <option value="">-- Pilih --</option>
                                <option value="hostpot">Hostpot</option>
                                <option value="ppp">PPP</option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width='200'>Nama <?php echo form_error('nama_paket') ?></td>
                        <td><input type="text" class="form-control" name="nama_paket" id="nama_paket"
                                placeholder="Nama Paket" value="<?php echo $nama_paket; ?>" /></td>
                    </tr>
                    <tr>
                        <td width='200'>Harga <?php echo form_error('harga_paket') ?></td>
                        <td><input type="text" class="form-control" name="harga_paket" id="harga_paket"
                                placeholder="Harga Paket" value="<?php echo $harga_paket; ?>" /></td>
                    </tr>
                    <tr>
                        <td width='200'>Limit <?php echo form_error('limit_paket') ?></td>
                        <td><input type="text" class="form-control" name="limit_paket" id="limit_paket"
                                placeholder="Limit Paket" value="<?php echo $limit_paket; ?>" /></td>
                    </tr>
                    <tr>
                        <td width='200'>Status Paket <?php echo form_error('is_aktive') ?></td>
                        <td>
                            <select class="form-control" name="is_aktive">
                                <?php $is_aktive = $data_paket['is_aktive'] ?>
                                <?php if ($is_aktive==1) { ?>
                                <option value="1" selected>Aktive</option>
                                <option value="2">Non Aktive</option>
                                <?php }else if ($is_aktive==2){ ?>
                                <option value="1">Aktive</option>
                                <option value="2" selected>Non Aktive</option>
                                <?php }else {?>
                                <option value="">-- Pilih --</option>
                                <option value="1">Aktive</option>
                                <option value="2">Non Aktive</option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="hidden" name="id_paket" value="<?php echo $id_paket; ?>" />
                            <input type="hidden" name="profile" value="<?php echo $profile; ?>" />
                            <button type="submit" class="btn btn-danger"><i class="fa fa-floppy-o"></i>
                                <?php echo $button ?></button>
                            <a href="<?php echo site_url('admin/paket') ?>" class="btn btn-info"><i
                                    class="fa fa-sign-out"></i> Kembali</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
</div>
</div>