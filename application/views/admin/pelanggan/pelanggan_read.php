<body>
    <h2 style="margin-top:0px">User Pelanggan</h2>
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
            <td><a href="<?php echo site_url('admin/pelanggan') ?>" class="btn btn-default">Cancel</a></td>
        </tr>
    </table>
</body>