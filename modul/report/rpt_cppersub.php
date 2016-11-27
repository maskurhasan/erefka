<?php
session_start();
if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {

//----------------------------------
include "../../config/koneksi.php";
include "../../config/fungsi.php";
include "../../config/fungsi_indotgl.php";
include "../../asset/css/printer.css";
include "../../config/errormode.php";
?>
<html>
<head>
<style type="text/css">
.style4 {font-size: 10; }
.style7 {   font-size: 10;
    color: #265180;
    font-family: Georgia, "Times New Roman", Times, serif;
}
</style>
<script language="javascript" type="text/javascript">
window.print();
</script>
<title>Laporan</title>
</head>
<body>
<?php  
function rlsbulan($id_Bulan,$id_Subkegiatan){
    $q = mysql_query("SELECT a.rls_Keu2 keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND a.id_Subkegiatan = '$id_Subkegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    $bln_lalu = $id_Bulan - 1;
    return $r['keu'];
}
function maxbulan($id_SubKegiatan){
    $q = mysql_query("SELECT MAX(a.id_Bulan) AS bulan
                        FROM realisasi a 
                        WHERE  a.id_Subkegiatan = '$id_Subkegiatan'");
    $r = mysql_fetch_array($q);
    return $r['bulan'];
}
function totalkeg($id_Bulan,$id_Subkegiatan){
    $q = mysql_query("SELECT a.rls_Keu2 AS keu 
                        FROM realisasi a,subkegiatan b 
                        WHERE a.id_Subkegiatan = b.id_Subkegiatan 
                        AND a.id_Subkegiatan = '$id_DataKegiatan' 
                        AND a.id_Bulan = '$id_Bulan'");
    $r = mysql_fetch_array($q);
    return $r['keu'];
}
$qskpd = mysql_query("SELECT nm_Skpd FROM skpd WHERE id_Skpd = '$_SESSION[id_Skpd]'");
$rskpd = mysql_fetch_array($qskpd);
                echo "<div id=print>
                <div align=center>
                <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0>
                <tr align=center><td>LAPORAN REALISASI FISIK DAN KEUANGAN</td></tr>
                <tr align=center><td>".strtoupper($rskpd[nm_Skpd])."</td></tr>
                <tr align=center><td>Tahun Anggaran : $_SESSION[thn_Login]</td></tr></table></div>  
                <table class=basic width=796 border=0 align=center cellpadding=0 cellspacing=0 id=tablemodul1>
                <thead>
                <tr align=center>
                  <th></th>
                  <th colspan=2>Program/Kegiatan</th>
                  <th>Anggaran</th>
                  <th>Jan</th>
                  <th>Feb</th>
                  <th>Mar</th>
                  <th>Apr</th>
                  <th>Mei</th>
                  <th>Jun</th>
                  <th>Jul</th>
                  <th>Ags</th>
                  <th>Sep</th>
                  <th>Okt</th>
                  <th>Nop</th>
                  <th>Des</th>
                  <th>TOTAL</th>
                </tr>
                <tr>
                  <th>1</th>
                  <th colspan=2>2</th>
                  <th>3</th>
                  <th>4</th>
                  <th>5</th>
                  <th>6</th>
                  <th>7</th>
                  <th>8</th>
                  <th>9</th>
                  <th>10</th>
                  <th>11</th>
                  <th>12</th>
                  <th>13</th>
                  <th>14</th>
                  <th>15</th>
                  <th>16</th>
                </tr>
                </thead>
                <tbody>";
                //dapatkan nilai target keu perbulan
                //tri I
                //$key = $arrtriwulan[5];
                //echo $key;
                
               $q = mysql_query("SELECT * 
                                  FROM datakegiatan a, kegiatan b 
                                  WHERE a.id_Kegiatan = b.id_Kegiatan 
                                  AND a.id_Skpd = '$_SESSION[id_Skpd]' 
                                  AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                                  GROUP BY b.id_Program");
               $no = 1;
               while($r=mysql_fetch_array($q)) {
                  $q1 = mysql_query("SELECT nm_Program, id_Program  
                                      FROM program 
                                      WHERE id_Program = '$r[id_Program]'");
                  $r1=mysql_fetch_array($q1);
                  //while ($r1=mysql_fetch_array($q1)) {
                  echo "<tr>
                    <td></td>
                    <td colspan=2><b>$r1[nm_Program]</b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>";

                    $q2 = mysql_query("SELECT a.nm_Kegiatan, b.id_DataKegiatan,c.nm_Ppk 
                                        FROM kegiatan a, datakegiatan b 
                                        LEFT JOIN ppk c
                                        ON b.id_Ppk = c.id_Ppk 
                                        WHERE a.id_Kegiatan = b.id_Kegiatan 
                                        AND b.id_Skpd = '$r[id_Skpd]' 
                                        AND b.TahunAnggaran = '$r[TahunAnggaran]' 
                                        AND a.id_Program = '$r1[id_Program]'");
                    while ($r2=mysql_fetch_array($q2)) {
                      echo "<tr>
                      <td>".$no++."</td>
                      <td colspan=2>$r2[nm_Kegiatan]</td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      <td></td>
                      </tr>";

                      $q3 = mysql_query("SELECT a.nm_SubKegiatan,a.nl_Pagu,a.id_Subkegiatan 
                                        FROM subkegiatan a 
                                        LEFT JOIN sumberdana b 
                                        ON a.id_SbDana = b.id_SbDana 
                                        WHERE a.id_DataKegiatan = '$r2[id_DataKegiatan]'");
                      while ($r3=mysql_fetch_array($q3)) {

                        echo "<tr>
                        <td></td>
                        <td></td>
                        <td>$r3[nm_SubKegiatan]</td>
                        <td>".number_format($r3['nl_Pagu'])."</td>";
                        for ($i=1; $i <= 12; $i++) { 
                        //cari 0 jika bulan 2
                        //$bulanlalu = rlsbulanlalu($i,$r2['id_DataKegiatan']);
                        $bulanini = rlsbulan($i,$r3['id_Subkegiatan']);
                        //echo "<td>".number_format(rlsbulanlalu(3,$r2['id_DataKegiatan']))."</td>";
                        //$hasil = $bulanini - $bulanlalu;
                        if($hasil < 0) {
                            $t = 0;
                        } else {
                            $t = $hasil;
                        }
                        echo "<td>".number_format($bulanini)."</td>";
                        }
                        $total = totalkeg(maxbulan($r3['id_Subkegiatan']),$r3['id_Subkegiatan']);
                        echo "<td>".maxbulan($r3['id_Subkegiatan'])."</td>
                        </tr>";
                      } //r3
                  } //r2
                } //r1
                echo "</tr>
          
                </tbody>
                </table>
                       
            <div style='clear: both'></div>
        </div>";

} //tanpa session
?>
</body>
</html>