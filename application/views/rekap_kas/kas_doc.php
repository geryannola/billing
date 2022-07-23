<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            .word-table {
                border:1px solid black !important; 
                border-collapse: collapse !important;
                width: 100%;
            }
            .word-table tr th, .word-table tr td{
                border:1px solid black !important; 
                padding: 5px 10px;
            }
        </style>
    </head>
    <body>
        <h2>Kas_masjid List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl Km</th>
		<th>Uraian Km</th>
		<th>Masuk</th>
		<th>Keluar</th>
		<th>Jenis</th>
		
            </tr><?php
            foreach ($rekap_kas_masjid_data as $rekap_kas_masjid)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $rekap_kas_masjid->tgl_km ?></td>
		      <td><?php echo $rekap_kas_masjid->uraian_km ?></td>
		      <td><?php echo $rekap_kas_masjid->masuk ?></td>
		      <td><?php echo $rekap_kas_masjid->keluar ?></td>
		      <td><?php echo $rekap_kas_masjid->jenis ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>