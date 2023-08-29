<?php
$dt1 = $tgl_1;
$dt2 = $tgl_2;
// var_dump($dt1);
?>

<?php
$saldo = $total_masuk - $total_keluar;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Laporan Kas</title>
</head>

<body>
  <center>
    <h2>Laporan Rekapitulasi Kas</h2>
    <h3>ABhostpot</h3>
    <p>Periode : <?php $a = $dt1;
                  echo date("d-M-Y", strtotime($a)) ?> s/d <?php $b = $dt2;
                                                            echo date("d-M-Y", strtotime($b)) ?>
    <p>________________________________________________________________________</p>

    <table border="1" cellspacing="0">
      <thead>
        <tr>
          <th>No.</th>
          <th>Tanggal</th>
          <th>Uraian</th>
          <th>Pemasukan</th>
          <th>Pengeluaran</th>
        </tr>
      </thead>
      <tbody>
        <?php

        if (isset($_POST["btnCetak"])) {

          // $sql_tampil = "select * from kas_masuk where tgl_km BETWEEN '$dt1' AND '$dt2' order by tgl_km asc";
          // $query_tampil = mysqli_query($koneksi, $sql_tampil);
          $no = 1;
          // while ($data = mysqli_fetch_array($query_tampil, MYSQLI_BOTH)) {
          foreach ($kas_data as $kas) {
        ?>
            <tr>
              <td><?php echo $no; ?></td>
              <td><?php $tgl = $kas->tgl_km;
                  echo date("d/M/Y", strtotime($tgl)) ?></td>
              <td><?php echo $kas->uraian_km; ?></td>
              <td align="right"><?php echo number_format($kas->masuk); ?></td>
              <td align="right"><?php echo number_format($kas->keluar); ?></td>
            </tr>
        <?php
            $no++;
          }
        }
        ?>
      </tbody>
      <tr>
        <td colspan="3">Total Pemasukan</td>
        <td colspan="2"><?php echo number_format($total_masuk); ?></td>
      </tr>
      <tr>
        <td colspan="4">Total Pengeluaran</td>
        <td><?php echo number_format($total_keluar); ?></td>
      </tr>
      <tr>
        <td colspan="3">Saldo Kas</td>
        <td colspan="2"><?php echo number_format($saldo); ?></td>
      </tr>
    </table>
  </center>

  <script>
    window.print();
  </script>
</body>

</html>