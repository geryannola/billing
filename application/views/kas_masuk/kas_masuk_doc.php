<!doctype html>
<html>
    <head>
        <title>BILLING ABhostpot</title>
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
        <h2>Kas List</h2>
        <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Tgl Km</th>
		<th>Uraian Km</th>
		<th>Masuk</th>
            </tr><?php
            foreach ($kas_masjid_data as $kas_masjid)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $kas_masjid->tgl_km ?></td>
		      <td><?php echo $kas_masjid->uraian_km ?></td>
		      <td><?php echo $kas_masjid->masuk ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
    </body>
</html>