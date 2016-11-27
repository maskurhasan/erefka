<?php
session_start();

if (empty($_SESSION[UserName]) AND empty($_SESSION[PassWord])) {
    echo "<center>Untuk mengakses modul, Anda harus login <br>";
    echo "<a href=index.php><b>LOGIN</b></a></center>";
} else {
$cek=user_akses($_GET['module'],$_SESSION['id_User']);
if($cek==1 OR $_SESSION['UserLevel']=='1') {  
//----------------------------------
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/pagination.php";

  switch ($_GET[act]) {
    default:
          //----------------------------------  
          
          echo "<div class=module>
            <h2><span>Rincian Kegiatan SKPD</span></h2>
            <div class=module-table-body>
            <table>
            <tr>
            <td>Urusan </td><td><select class=input-short  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($r=mysql_fetch_array($q)) {
                  echo "<option value=$r[id_Urusan]>$r[id_Urusan] $r[nm_Urusan]</option>";
                }         
                echo "</select></td>
            </tr>
            <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder='pilih Bid.Urusan' id=id_BidUrusan onchange='pilih_BidUrusan(this.value);'>
                <option value=#>Pilih Bid.Urusan</option></select></td>
            </tr>
            <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Program</option></select></td>
            </tr>
            </table>
            <hr />
            <table width='700px' cellspacing=0 cellpadding=0>
            <tr><td><form method=get action=$_SERVER[PHPSELF]>
            <input name='module' type=hidden value=subkegiatan>
            <input type=text name='q' size='10'>
            <select name='t'>
              <option value='nm'>Kegiatan</option>
              <option value='kode'>Kode</option>
            </select>
            <button type='submit' value=''><i class='fa fa-search'></i> C a r i</button></form></td>
            <td></td><td align='right'><button name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=datakegiatan&act=add'\"><i class='fa fa-plus'></i> Tambah Program Kegiatan</button></td></tr>
            </table>
            <table class='tabel' width='700px'>
            <thead><tr><th>#</th>
            <th>Kode</th><th style=width:30%>Nama Kegiatan</th><th>Anggaran</th><th>Nama PPK</th>
            <th>Aksi</th></tr></thead><tbody>";
            $page = 1;
            if (isset($_GET['page']) && !empty($_GET['page']))
                $page = (int)$_GET['page'];
            $q = $_GET['q'];
            $t = $_GET['t'];
            if($_GET['t'] == 'nm') {
              $nmkeg = "AND b.nm_Kegiatan LIKE '%$q%' ";
            } elseif($_GET['t']=='kode') {
              $kode = "AND a.id_Kegiatan = '$q' ";
            } 
            
            $sql = "SELECT b.nm_Kegiatan,a.id_DataKegiatan,a.id_Kegiatan,a.AnggKeg,c.nm_Ppk 
                                      FROM kegiatan b, datakegiatan a
                                      LEFT JOIN ppk c 
                                      ON a.id_Ppk = c.id_Ppk  
                                      WHERE a.id_Skpd = '$_SESSION[id_Skpd]' 
                                      AND a.id_Kegiatan = b.id_Kegiatan 
                                      AND a.TahunAnggaran = '$_SESSION[thn_Login]' 
                                      $nmkeg $kode ORDER BY a.id_DataKegiatan ASC";
            $dataTable = getTableData($sql, $page);
            //$query=mysql_query($sql);
            //$no = 1;
            //while($dt=mysql_fetch_array($query)) 
            foreach ($dataTable as $i => $dt) 
            {
            $no = ($i + 1) + (($page - 1) * 10);
            $no % 2 === 0 ? $alt="alt" : $alt="";
                  echo "<tr class=$alt><td>".$no++."</td>
                          <td>$dt[id_Kegiatan]</td>
                          <td>$dt[nm_Kegiatan]</td>
                          <td align=left>".number_format($dt[AnggKeg])."</td>
                          <td>$dt[nm_Ppk]</td>
                          <td class=align-center>";
                            echo "<a href='?module=subkegiatan&act=sub&id=$dt[id_DataKegiatan]'><i class='fa fa-list'></i>  Sub Kegiatan</a>
                                  <a href='?module=subkegiatan&act=editx&id=$dt[id_DataKegiatan]'><i class='fa fa-edit fa-lg'></i> Edit</a> ";
                            echo '<a href="modul/act_moddatakegiatan.php?module=subkegiatan&act=delete&id='.$dt[id_DataKegiatan].'" onclick="return confirm(\'Yakin untuk menghapus data ini?\')"><i class="fa fa-trash-o fa-lg"></i> Hapus</a>';
                            echo "</td>
                          </tr>";
            } 
            echo "</tbody></table>";
            showPagination($sql);
            echo "</form></div></div>";
    
    //echo '<td class=align-center><button type=button onClick="window.location.href=\'?module=subkegiatan&act=sub&id='.$dt[id_DataKegiatan].'\';"><i class="fa fa-list"></i>  Sub Kegiatan</button></td></td>';
    
    break;
    case "editx":
          $sql = mysql_query("SELECT * FROM datakegiatan WHERE id_DataKegiatan = '$_GET[id]'");
          $r = mysql_fetch_array($sql);
          //parse id program k jd id
          $id_Urusan = substr($r[id_Kegiatan], 0,1);
          
          $id_BidUrusan = substr($r[id_Kegiatan], 0,3);
          $id_Program = substr($r[id_Kegiatan], 0,5);
          echo "<div class='grid_7'>";
         echo "<form method=post action='modul/act_modsubkegiatan.php?module=subkegiatan&act=editx'>
                <table>
        <tr>
        <td>Urusan </td><td><select class='input-short'  name=id_Urusan placeholder=pilih Urusan id=id_Urusan onchange='pilih_Urusan(this.value);'>
                <option selected>Pilih Urusan</option>";
                $q=mysql_query("SELECT * FROM urusan");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_Urusan] == $id_Urusan) {
                    echo "<option value=$rx[id_Urusan] selected>$rx[id_Urusan] $rx[nm_Urusan]</option>";
                  } else {
                    echo "<option value=$rx[id_Urusan]>$rx[id_Urusan] $rx[nm_Urusan]</option>";
                  }
                }             
                echo "</select></td>
        </tr>
        <tr>
                <td>Bid. Urusan : </td><td><select class='input-short' name=id_BidUrusan  placeholder=pilih Urusan id=id_BidUrusan onchange='vw_tbl(this.value);'>
                <option value=#>Pilih Bid.Urusan</option>";
                $q=mysql_query("SELECT * FROM bidurusan WHERE id_Urusan = '$id_Urusan'");
                while ($rx=mysql_fetch_array($q)) {
                  $id_BidUrusan1 = substr($rx[id_BidUrusan],-2);
                  if($rx[id_BidUrusan] == $id_BidUrusan) {
                    echo "<option value=$rx[id_BidUrusan] selected>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                  } else {
                    echo "<option value=$rx[id_BidUrusan]>$id_BidUrusan1 $rx[nm_BidUrusan]</option>";
                  }
                }
                echo "</select></td>
        </tr>
        <tr>
                <td>Program : </td><td><select class='input-short' name=id_Program  placeholder=pilih Program id=id_Program onchange=''>
                <option value=#>Pilih Program</option>";
                $q=mysql_query("SELECT * FROM program WHERE id_BidUrusan = '$id_BidUrusan'");
                while ($rx=mysql_fetch_array($q)) {
                  $id_Program1 = substr($rx[id_Program],-2);
                  if($rx[id_Program] == $id_Program) {
                    echo "<option value=$rx[id_Program] selected>$id_Program1 $rx[nm_Program]</option>";
                  } else {
                    echo "<option value=$rx[id_Program]>$id_Program1 $rx[nm_Program]</option>";
                  }
                }
                echo "</select></td>
        </tr>
        <tr>
                <td>Kegiatan : </td><td><select class='input-short' name=id_Kegiatan  placeholder=pilih Kegiatan id=id_Kegiatan onchange='pilih_Kegiatan(this.value)'>
                <option value=#>Pilih Kegiatan</option>";
                $q=mysql_query("SELECT * FROM kegiatan WHERE id_Program = '$id_Program'");
                while ($rx=mysql_fetch_array($q)) {
                  $kd_Kegiatan = substr($rx[id_Kegiatan],-2,2);
                  if($rx[id_Kegiatan] == $r[id_Kegiatan]) {
                    echo "<option value=$rx[id_Kegiatan] selected>$kd_Kegiatan $rx[nm_Kegiatan]</option>";
                  } else {
                    echo "<option value=$rx[id_Kegiatan]>$kd_Kegiatan $rx[nm_Kegiatan]</option>";
                  }
                }
                $q = mysql_query("SELECT * FROM kegiatan WHERE id_Kegiatan = '$r[id_Kegiatan]'");
                $rx = mysql_fetch_assoc($q);
                echo "</select></td>
        </tr>
         <tr>
                <td>Anggaran : </td><td><input type=text name=AnggKeg placeholder=Anggaran value=$r[AnggKeg]></td>
        </tr>
        <tr>
                <td>Nama Kegiatan : </td><td><textarea rows='7' cols='90'class='input-short' name='nm_Kegiatan' id='nm_Kegiatan'>$rx[nm_Kegiatan] $_SESSION[id_Skpd]</textarea></td>
        </tr>
        <tr>
                <td>PPK </td><td><select class='input-short'  name='id_Ppk' placeholder=pilih PPK id=id_Ppk required>
                <option value=''>Pilih</option>";
                $q=mysql_query("SELECT * FROM ppk WHERE id_Skpd='$_SESSION[id_Skpd]'");
                while ($rx=mysql_fetch_array($q)) {
                  if($rx[id_Ppk]==$r[id_Ppk]) {
                    echo "<option value=$rx[id_Ppk] selected>$rx[nm_Ppk]</option>";
                  } else {
                    echo "<option value=$rx[id_Ppk]>$rx[nm_Ppk]</option>";
                  }
                }         
                echo "</select></td>
        </tr>
        <tr>
                <td>
                <input type=hidden name=id_Session value=$_SESSION[Sessid] />
                <input type=hidden name=id_DataKegiatan value=$r[id_DataKegiatan] />
                </td>
        <td>
        <input class='submit-green' type='submit' name='simpan' value=Simpan /> 
                <input class='submit-gray' type='reset' value=Reset />
                <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>
                </td>
        </tr>
        </table
                </form>
                <div class=bottom-spacing>
                
                </div>";
          //akhir grid 7
          echo "</div>";
    break;
    case "sub":
          $sql = mysql_query("SELECT c.nm_Program, b.nm_Kegiatan,a.AnggKeg,d.nm_Ppk  
                              FROM kegiatan b, program c,datakegiatan a 
                              LEFT JOIN ppk d
                              ON a.id_Ppk = d.id_Ppk 
                              WHERE a.id_DataKegiatan = '$_GET[id]' 
                              AND a.id_Kegiatan = b.id_Kegiatan 
                              AND b.id_Program = c.id_Program 
                              AND a.id_Skpd = '$_SESSION[id_Skpd]'");
          $r=mysql_fetch_array($sql);
          echo "
                <table>
                <tr>
                <td width=30%>Program</td><td>:</td><td>$r[nm_Program]</td>
                </tr>
                <tr>
                <td>Kegiatan</td><td>:</td><td>$r[nm_Kegiatan]</td>
                </tr>
                <tr>
                <td>PPK</td><td>:</td><td>$r[nm_Ppk]</td>
                </tr>
                <tr>
                <td>Anggaran</td><td>:</td><td>".number_format($r[AnggKeg])."</td>
                </tr>
                <tr>
                <td>&nbsp;</td><td></td>
                <td><button type='reset' onClick=\"window.location.href='?module=subkegiatan'\"><i class='fa fa-arrow-left'></i> Kembali</button>
                    <button type='button' name='tambahsubdak' id='tomboltambahsub' onClick=\"window.location.href='?module=subkegiatan&act=add&id=$_GET[id]'\"><i class='fa fa-plus'></i> Tambah</button></td>
                </tr>
                </table><hr />";
            echo "<h2><span>Data Rincian Kegiatan</span></h2>";
                $sql = mysql_query("SELECT * FROM datakegiatan a,subkegiatan b 
                                      WHERE a.id_DataKegiatan = b.id_DataKegiatan AND a.id_Skpd = '$_SESSION[id_Skpd]' AND a.id_DataKegiatan = '$_GET[id]'");
                $hit = mysql_num_rows($sql);
                if($hit < 1) {
                  echo "<p>Tidak ada data, silahkan <a href=?module=subkegiatan&act=add&id=$_GET[id]>Entry Data Baru</a></p>";
                  //echo "Belum ada data";
                } else {
         
            echo "<table width='700px' cellspacing=0 cellpadding=0>
                <tr><td><input type=text size='20'><button type='submit' value=''><i class='fa fa-search'></i> C a r i</button></td>
                <td></td><td align='right'><button name='tambahsubdak' type=submit onClick=\"window.location.href='?module=subkegiatan&act=add&id=$_GET[id]'\" $disabled><i class='fa fa-plus'></i> Tambah Sub Kegiatan</button></td></tr>
                </table>
                <table class=tabel width='700px'>
                <thead><tr><th style=width:5%>#</th>
                <th style=width:25%>Nama Kegiatan</th><th style=width:10%>PAGU(Rp.)</th><th style=width:10%>Aksi</th></tr></thead><tbody>";
                  
                
                  $no=1;
                  while($dt = mysql_fetch_array($sql)) {
  					       $no % 2 === 0 ? $alt="alt" : $alt="";
                    echo "<tr class=$alt><td>".$no++."</td>
                            <td>$dt[nm_SubKegiatan]</td>
                            <td align=right>".frm_angka($dt[nl_Pagu])."</td>
                            <td class=align-center>
                            <a id=id_SubKegiatan href='?module=subkegiatan&act=edit&id=$dt[id_SubKegiatan]'><i class='fa fa-edit'></i> Edit</button>";
  						              echo ' | <a id=id_SubKegiatanx onClick="return confirm(\'Yakin Hapus data ini?\')" href="modul/act_modsubkegiatan.php?module=subkegiatan&act=deletexx&id='.$dt[id_SubKegiatan].'"><i class="fa fa-trash-o"></i> Hapus</a>';
                            echo "</td>
                            </tr>";
                  }
                } 
     
    break;
	case "add":
      $sql = mysql_query("SELECT a.tr_Satu,a.tr_Dua,a.tr_Tiga,a.tr_Empat, 
                                  b.trg_Keu1,b.trg_Keu2,b.trg_Keu3,b.trg_Keu4,
                                  a.AnggKeg,SUM(b.nl_Pagu) AS totalnlpagu 
                          FROM datakegiatan a 
                          LEFT JOIN subkegiatan b 
                          ON a.id_DataKegiatan = b.id_DataKegiatan  
                          WHERE a.id_DataKegiatan = '$_GET[id]'");
      $r=mysql_fetch_array($sql);
      //tanggal default pelaksanaan
      $tglawal = $_SESSION[thn_Login]."-01-01";
      $tglakhir = $_SESSION[thn_Login]."-12-31";
      $anggaran = $r['AnggKeg']-$r['totalnlpagu'];
			echo "<h2><span>Tambah Rincian Kegiatan</span></h2>";
			echo "<form method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=add').">
                <table width='100%'>
                <tr><td class='cc'>Nama Rincian </td><td><input type=text name='nm_SubKegiatan' id='nm_SubKegiatan' placeholder='Nama Rincian' size=50 required>&nbsp;<input type='checkbox' name='JnsSubKeg' id='group1' value='f'> Fisik</td>
                </tr>
                <tr><td class='cc'>Nilai PAGU </td><td><input type=text class='' name='nl_Pagu' placeholder='Nilai PAGU' value=$anggaran required></td></tr>
                <tr><td class='cc'>Nilai Fisik </td><td><input type=text class='' name='nl_Fisik' placeholder='Nilai Fisik'></td></tr>
                <tr><td class='cc'>Nilai Kontrak </td><td><input type=text class='' name='nl_Kontrak' placeholder='Nilai Kontrak'></td></tr>
                <tr><td class='cc'>Volume </td><td><input type=text class='' name='jml_Volume' placeholder='Volume' required></td></tr>
                <tr><td class='cc'>Sumber Dana </td><td><select class=''  name=id_SbDana placeholder='pilih Sumber' onchange='' required>
                <option selected>Sumber Dana</option>";
                  $qx=mysql_query("SELECT * FROM sumberdana");
                  while ($rx=mysql_fetch_array($qx)) {
                    echo "<option value=$rx[id_SbDana]>$rx[id_SbDana] $rx[nm_SbDana]</option>";
                  }         
                  echo "</select></td></tr>
                <tr><td class='cc'>Alamat Lokasi </td><td><input type=text class='' name='AlamatLokasi' placeholder='Alamat' required></td></tr>
                <tr><td class='cc'>Kecamatan</td><td><select class='' name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);' required>
                <option selected>Kecamatan</option>";
                  $qx=mysql_query("SELECT * FROM kecamatan");
                  while ($rx=mysql_fetch_array($qx)) {
                    echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                  }         
                  echo "</select>&nbsp;Desa :<select class=input-short  name=id_Desa placeholder=Desa id=id_Desa onchange=''></select></td></tr>
                <tr><td>Pelaksana </td><td><input type='text' class='input-short' name='pelaksana2' id='pelaksana2'></td></tr>
                <tr><td>Konsultan </td><td> Perencana : <input type=text class='input-short' name='konsPerencana' placeholder='Kons. Perencana'> Pengawas : <input type=text class='input-short' name='konsPengawas' placeholder='Kons. Pengawas'></td></tr>
                <tr><td>Nomor Kontrak </td><td><input type=text class='input-short' name='no_Kontrak' placeholder='Nomor Kontrak'></td></tr>
                <tr><td>Waktu Pekerjaan </td><td> Mulai : <input type='date' class='input-short' name='tgl_Mulai' placeholder='tgl Mulai' value=$tglawal> Tanggal Selesai : <input type=date id='datepicker' class='' name='tgl_Selesai' placeholder='tgl selesai' value=$tglakhir></td></tr>
                <tr><td>Target  Fisik</td><td><input type=text class='input-short required' name='trg_Fisik' placeholder='Fisik'></td></tr>
                <tr><td>Target Keuangan : </td>";
                //ini adalah nilai untuk Triwulan inisiasi nilai awal
               
                $satu = $r['tr_Satu']-$r['trg_Keu1'];
                $dua = $r['tr_Dua']-$r['trg_Keu2'];
                $tiga = $r['tr_Tiga']-$r['trg_Keu3'];
                $empat = $r['tr_Empat']-$r['trg_Keu4'];
          echo "<td><input type=text class='' name='trg_Keu1' placeholder='Triwulan I' value=$satu required>
                <input type=text class='' name='trg_Keu2' value=$dua placeholder='Triwulan II'></td></tr>
                <tr><td>&nbsp;</td><td><input type=text class=' digits' name='trg_Keu3' value=$tiga placeholder='Triwulan III'>
                <input type=text class='' name='trg_Keu4' value=$empat placeholder='Triwulan IV'>
                <input type=checkbox id='bagirata' name='bagirata' value='bagirata'> Bagi Rata</td></tr>
                <tr><td class='cc'>&nbsp;</td>
                <td>
                <input type=hidden name=id_Skpd value='$_SESSION[id_Skpd]'>
                <input type=hidden name=TahunAnggaran value='$_SESSION[thn_Login]'>
                <input type=hidden name=id_DataKegiatan value='$_GET[id]'>
                <button type='submit' name='simpan'><i class='fa fa-save'></i> Simpan</button> 
                <button type='reset'><i class='fa fa-refresh'></i> Reset</button> 
				<button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button></td></tr>
                </table>
                </form>
                <div class=bottom-spacing>
                </div>";
	break;
    case "edit":
			$q = mysql_query("SELECT * FROM subkegiatan WHERE id_SubKegiatan = '$_GET[id]'");
			$r = mysql_fetch_array($q);

			//cek jika fisik
			$r[JnsSubKeg]=='f' ? $cekk = "checked" : "";
			echo "<h2><span>Edit Rincian Kegiatan</span></h2>";
			echo "<form method=post id=frm_tambah action=".htmlspecialchars('modul/act_modsubkegiatan.php?module=subkegiatan&act=edit').">
                <table width='100%' id='table_form'>
                <tr><td>Nama Rincian </td><td><input type=text class='required' name='nm_SubKegiatan' placeholder='Nama Rincian' value='$r[nm_SubKegiatan]'>&nbsp;<input type='checkbox' name='JnsSubKeg' id='group1' value='f' $cekk> Fisik</td></tr>
                <tr><td>Nilai PAGU </td><td><input type=text class='' name='nl_Pagu' placeholder='Nilai PAGU' value='$r[nl_Pagu]'></td></tr>
                <tr><td>Nilai Fisik </td><td><input type=text class='input-short digits' name='nl_Fisik' placeholder='Nilai Fisik' value='$r[nl_Fisik]'> </td></tr>
                <tr><td>Nilai Kontrak </td><td><input type=text class='input-short digits' name='nl_Kontrak' placeholder='Nilai Kontrak' value='$r[nl_Kontrak]'></td></tr>
                <tr><td>Volume </td><td><input type=text class='input-short required' name='jml_Volume' placeholder='Volume' value='$r[jml_Volume]'></td></tr>
                <tr><td>Sumber Dana </td><td><select class='input-medium required'  name=id_SbDana placeholder='pilih Sumber' onchange=''>
                <option selected>Sumber Dana</option>";
                  $qx=mysql_query("SELECT * FROM sumberdana");
                  while ($rx=mysql_fetch_array($qx)) {
                  	if($rx[id_SbDana]==$r[id_SbDana]) {
                    	echo "<option value=$rx[id_SbDana] selected>$rx[id_SbDana] $rx[nm_SbDana]</option>";
                	}else{
                    	echo "<option value=$rx[id_SbDana]>$rx[id_SbDana] $rx[nm_SbDana]</option>";
                	}
                  }         
                  echo "</select></td></tr>
                <tr><td>Alamat Lokasi </td><td><input type=text class='input-medium required' name='AlamatLokasi' placeholder='Alamat' value='$r[AlamatLokasi]'></td></tr>
                <tr><td>Kecamatan</td><td><select class=input-short  name=id_Kecamatan placeholder=Kecamatan id=id_Kecamatan onchange='pilih_kecamatan(this.value);'>
                <option selected>Kecamatan</option>";
                  $qx=mysql_query("SELECT * FROM kecamatan");
                  while ($rx=mysql_fetch_array($qx)) {
                  	$idkec = substr($r[id_Desa], 0,7);
                  	if($rx[id_Kecamatan]==$idkec) {
                    	echo "<option value=$rx[id_Kecamatan] selected>$rx[nm_Kecamatan]</option>";
                    }else{
                    	echo "<option value=$rx[id_Kecamatan]>$rx[nm_Kecamatan]</option>";
                    }
                  }         
                  echo "</select>&nbsp;Desa :<select class=input-short  name=id_Desa placeholder=Desa id=id_Desa onchange=''>";
                  $qx=mysql_query("SELECT * FROM desa");
                  while ($rx=mysql_fetch_array($qx)) {
                  	if($rx[id_Desa]==$r[id_Desa]) {
                    	echo "<option value=$rx[id_Desa] selected>$rx[nm_Desa]</option>";
                    }else{
                    	echo "<option value=$rx[id_Desa]>$rx[nm_Desa]</option>";
                    }
                  } 

                  echo "</select></td></tr>";
                //$r[Pelaksana] = 'Swakelola' ? $cek = 'Checkhed' : $cek = 
                 if($r[Pelaksana] == "Swakelola") {
                 	$cek = "checked";
                  $isicek = "";
                 }else {
                 	$cek = "";
                 	$cek1 = "checked";
                 	$isicek = $r[Pelaksana];
                 }
                echo "<tr><td>Pelaksana </td><td><input type='text' class='input-short required' name='pelaksana2' id='pelaksana2' value='$r[Pelaksana]'></td></tr>
                <tr><td>Konsultan </td><td>Perencana : <input type=text class='input-short' name='konsPerencana' placeholder='Kons. Perencana' value='$r[konsPerencana]'> Pengawas : <input type=text class='input-short' name='konsPengawas' placeholder='Kons. Pengawas' value='$r[konsPengawas]'></td></tr>
                <tr><td>Nomor Kontrak </td><td><input type=text class='input-short' name='no_Kontrak' placeholder='Nomor Kontrak' value='$r[no_Kontrak]'></td></tr>
                <tr><td>Waktu Pekerjaan</td><td>Mulai : <input type=date class='input-short' name='tgl_Mulai' placeholder='tgl Mulai' value='$r[tgl_Mulai]'> Tanggal Selesai : <input type=date class='input-short' name='tgl_Selesai' placeholder='tgl selesai' value='$r[tgl_Selesai]'></td></tr>
                <tr><td>Target Fisik</td><td><input type=text class='input-short required' name='trg_Fisik' placeholder='Fisik' value='$r[trg_Fisik]'></td></tr>
                <tr><td>Target Keuangan </td><td>
                <input type=text class='input-short digits' name='trg_Keu1' placeholder='Triwulan I' value='$r[trg_Keu1]'>
                <input type=text class='input-short digits' name='trg_Keu2' placeholder='Triwulan II' value='$r[trg_Keu2]'></td></tr>
                <tr><td>&nbsp;</td><td>
                <input type=text class='input-short digits' name='trg_Keu3' placeholder='Triwulan III' value='$r[trg_Keu3]'>
                <input type=text class='input-short digits' name='trg_Keu4' placeholder='Triwulan IV' value='$r[trg_Keu4]'>
                <input type=checkbox id='bagirata' name='bagirata' value='bagirata'> Bagi Rata</td></tr>
                <tr><td>&nbsp;</td><td>
                <input type=hidden name=id_Skpd value=$_SESSION[id_Skpd] />
                <input type=hidden name=nl_PaguLama value=$r[nl_Pagu] />
                <input type=hidden name=id_SubKegiatan value=$r[id_SubKegiatan] />
                <input type=hidden name=TahunAnggaran value=$_SESSION[thn_Login] />
                <input type='hidden' name='id_DataKegiatan' value='$r[id_DataKegiatan]' />
                <button type='submit' name='simpan'><i class='fa fa-save'></i> Simpan</button> 
                <button type='reset'><i class='fa fa-refresh'></i> Reset</button> 
				        <button type='reset' onClick='window.history.back()'><i class='fa fa-arrow-left'></i> Kembali</button>";
          echo "</td></tr>
                </table>
                </form>";
    break;
  }//end switch
} //end tanpa hak akses
} //end tanpa session

?>
<script type="text/javascript">



$('#frm_tambah').validate();
$( "#datepicker" ).datepicker();
//disable jika swakelola
$("#tomboltambahsub").click(function(){ 
  $("#frm_tambah").show();
  //$("#subkegiatan1").hide();
});

$(function() {
  enable_cb();
  $("#group1").click(enable_cb);
});

function enable_cb() {
  if (this.checked) {
    $("input.group1").removeAttr("disabled");
  } else {
    $("input.group1").attr("disabled", true);
  }
}

$("#bulanan").hide();
$(function() {
  pertriwulan();
  $("#triwulan").click(pertriwulan);
});
function pertriwulan() {
  if (this.checked) {
    $("#bulanan").show();
  } else {
    $("#bulanan").hide();
  }
}

function pilih_kecamatan(id_Kecamatan)
{
  $.ajax({
    url: '../library/desa.php',
    data : 'id_Kecamatan='+id_Kecamatan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Desa').html(response);
        }
    });
}

function pilih_Urusan(id_Urusan)
{
  $.ajax({
    url: '../library/bidangurusan.php',
    data : 'id_Urusan='+id_Urusan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#id_BidUrusan').html(response);
        }
    });
}

function pilih_BidUrusan(id_BidUrusan)
{
  $.ajax({
    url: '../library/program.php',
    data : 'id_BidUrusan='+id_BidUrusan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
    success: function(response){
      $('#id_Program').html(response);
      }
    });
}

function pilih_Program(id_Program)
{
  $.ajax({
        url: '../library/kegiatan.php',
        data : 'id_Program='+id_Program,
    type: "post", 
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#id_Kegiatan').html(response);
        }
    });
}



function pilih_Kegiatan(id_Kegiatan)
{
  $.ajax({
        url: '../library/nm_kegiatan.php',
        data : 'id_Kegiatan='+id_Kegiatan,
    type: "post", 
        dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#nm_Kegiatan').html(response);
        }
    });
}


function vw_tbl(id_Program)
{
  $.ajax({
    url: '../library/vw_kegiatan.php',
    data: 'id_Program='+id_Program,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#vw_kegiatan').html(response);
        }
    });
}
function ax_form_subkegiatan(id_SubKegiatan)
{
  $.ajax({
    url: '../library/ax_subkegiatan.php',
    data: 'id_SubKegiatan='+id_SubKegiatan,
    type: "post", 
    dataType: "html",
    timeout: 10000,
        success: function(response){
      $('#frm_tambah').html(response);
        }
    });
}


  //kembali 
  $(".batal").click(function(event) {
    event.preventDefault();
    history.back(1);
});
$("#myTable").tablesorter({widgets: ['zebra'],
  headers: {7: {sorter: true}}
})
.tablesorterPager({container: $("#pager")});   
</script>
