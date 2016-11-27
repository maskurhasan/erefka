<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";

$module = $_GET['module'];
$act = $_GET['act'];

$id_Kegiatan = $_POST['id_Kegiatan'];
$id_Skpd = $_POST['id_Skpd'];
$Prioritas = $_POST['Prioritas'];
$NomorSurat = $_POST['NomorSurat'];
$Perihal = $_POST['Perihal'];
$tgl_Surat = $_POST['tgl_Surat'];
$tgl_Mulai = $_POST['tgl_Mulai'];
$tgl_Selesai = $_POST['tgl_Selesai'];
$Pukul = $_POST['Pukul'];
$Deskripsi = $_POST['Deskripsi'];
$Tempat = $_POST['Tempat'];
$DibukaOleh = $_POST['DibukaOleh'];

if ($act == "add" and $module == "kegiatan") {

//file spm
$tahun = $_SESSION[thn_Login];
$gantinamasurat = $id_Skpd."_".acaknmfile()."_y";
$gantinamalampiran = $id_Skpd."_".acaknmfile()."_x";

$file = array('surat' => 'fl_Surat','lampiran'=>'fl_Lampiran');
foreach ($file as $key => $value) {
  //$uploadfile = $nm_file_upload.$key;
  $uploadfile = basename($_FILES[$value][name]);
  $extension = end(explode(".",$uploadfile));
  //$gantinama = $id_Skpd."_".acaknmfile()."_".$key;
  $gantinama = "$"."gantinama".$key;
  if($key == 'surat') {
    $namafolder = "../media/surat/$tahun/";
    $gantinama = $gantinamasurat;
    $nm_file_surat = $gantinamasurat.'.'.$extension;
  } elseif($key == 'lampiran') {
    $namafolder = "../media/lampiran/$tahun/";
    $gantinama = $gantinamalampiran;
    $nm_file_lampiran = $gantinamalampiran.'.'.$extension;
  } else {
    echo "bb";
  }
  $pindah_foto = move_uploaded_file($_FILES[$value][tmp_name],$namafolder.$gantinama.'.'.$extension);
}

    if(isset($_POST[simpan])) {
        $qry = mysql_query("INSERT INTO kegiatan (id_Skpd,
                                                Prioritas,
                                                NomorSurat,
                                                Perihal,
                                                tgl_Surat,
                                                tgl_Mulai,
                                                tgl_Selesai,
                                                Pukul,
                                                Deskripsi,
                                                Tempat,
                                                DibukaOleh,
                                                fl_Surat,
                                                fl_Lampiran,
																						Create_at)
                                      VALUES ('$id_Skpd',
                                              '$Prioritas',
                                              '$NomorSurat',
                                              '$Perihal',
                                              '$tgl_Surat',
                                              '$tgl_Mulai',
                                              '$tgl_Selesai',
                                              '$Pukul',
                                              '$Deskripsi',
                                              '$Tempat',
                                              '$DibukaOleh',
                                              '$nm_file_surat',
                                              '$nm_file_lampiran',
																							now())");
        //if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        //  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        //}
        if ($qry)
            {
                header('location:../main.php?module=kegiatan');
            }
        else
            {
                echo mysql_error();
            }
      } else {
        echo "gagal";
      }
} elseif($act == "edit" and $module == "kegiatan"){
  //status SPM bisa berubah jika nilai kegiatan lebih kecil sama dengan ANggaran
  //nilai total kegiatanspm
  if(isset($_POST[simpan])) {
    if($StatusKegiatan == 0) {

    	$qry = mysql_query("UPDATE kegiatan SET id_Skpd='$id_Skpd',
                                          Prioritas='$Prioritas',
                                          NomorSurat='$NomorSurat',
                                          Perihal='$Perihal',
                                          tgl_Surat='$tgl_Surat',
                                          tgl_Mulai='$tgl_Mulai',
                                          tgl_Selesai='$tgl_Selesai',
                                          Pukul='$Pukul',
                                          Deskripsi='$Deskripsi',
                                          Tempat='$Tempat',
                                          DibukaOleh='$DibukaOleh',
                                          fl_Surat='$nm_file_surat',
                                          fl_Lampiran='$nm_file_lampiran',
                                          Update_at=now()
    																		WHERE id_Kegiatan = '$id_Kegiatan'");
    	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
    	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
    	//}
    	if ($qry)
    			{
    					header('location:../main.php?module=kegiatan');
    			}
    	else
    			{
    					echo mysql_error();
    			}
    } else {
      echo "<script type=text/javascript>window.alert('Error : Maaf Kegiatan sudah dilaksanakan')
                  window.location.href='../main.php?module=kegiatan'</script>";
    }
  } else {
    //gagal simpan
    header('location:../main.php?module=spm');
  }

} elseif($act == "datakegiatan" and $module == "spm"){
      $Nilai = $_POST[Nilai];
      $id_DataKegiatan = $_POST['id_DataKegiatan'];
      //data rincian spm
      if(isset($_POST[simpan])) {
        //periksa nilai kegiatan spm jika melebihi sisa anggaran
        $target = $_POST[AnggaranTarget];
        $TotalSmntara = $_POST[TotalSmntara];
        //Anggaran Kegiatan Sementara
        $AnggaranInput = $Nilai+$TotalSmntara;
        if($AnggaranInput <= $target){
          $q = mysql_query("SELECT id_DataKegiatan FROM rincspm WHERE id_Spm = '$id_Spm' AND id_DataKegiatan = '$id_DataKegiatan'");
          $hit = mysql_num_rows($q);
          if($hit < 1) {
            $qry = mysql_query("INSERT INTO rincspm (id_Spm,id_DataKegiatan,Nilai,Create_at)
                                      VALUES ('$id_Spm','$id_DataKegiatan','$Nilai',now())");

          	if ($qry)
          			{
          					header('location:../main.php?module=spm&act=kegiatan&id='.$id_Spm.'');
          			}
          	else
          			{
          					echo mysql_error();
          			}
          } else {
            //maaf kegiatan telah ada
            echo "<script type=text/javascript>window.alert('Error : Kegiatan SPM telah dipilih')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
          }
        } else {
          echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan melebihi Target SPP ".angkrp($target)."')
                      window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }



} elseif ($act == "datakegiatanedit" and $module == "spm") {
      $Nilai = $_POST[Nilai];
      $id_DataKegiatan = $_POST['id_DataKegiatan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      //data rincian spm
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_POST[simpan])) {
        if($_POST[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $NilaiLama = $_POST[NilaiLama];
            $AnggaranInput = $Nilai+$TotalSmntara-$NilaiLama;
          if($AnggaranInput <= $target){
            $qry = mysql_query("UPDATE rincspm SET Nilai = '$Nilai' WHERE id_Rincspm = '$id_Rincspm'");

            if ($qry)
                {
                    header('location:../main.php?module=spm&act=kegiatan&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Anggaran Kegiatan melebihi Target SPP ".angkrp($target)."')
                        window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

} elseif ($act == "potongan" and $module == "spm") {
      $JnsPotongan = $_POST[JnsPotongan];
      $NilaiPotongan = $_POST['NilaiPotongan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      //data rincian spm
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_POST[simpan])) {
        if($_POST[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $TotalPot = $_POST[TotalPot];
            $NilaiPotongan = $_POST[NilaiPotongan];
            $TotalPotongan = $NilaiPotongan+$TotalPot;

          if($TotalPotongan <= $TotalSmntara){
            $qry = mysql_query("INSERT INTO potonganspm (id_Spm,JnsPotongan,NilaiPotongan) VALUES ('$id_Spm','$JnsPotongan','$NilaiPotongan')");

            if ($qry)
                {
                    header('location:../main.php?module=spm&act=potongan&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Potongan SPM Kegiatan melebihi Target SPP ".angkrp($TotalSmntara)."')
                        window.location.href='../main.php?module=spm&act=potongan&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

} elseif ($act == "editpotongan" and $module == "spm") {
      $JnsPotongan = $_POST['JnsPotongan'];
      $NilaiPotongan = $_POST['NilaiPotongan'];
      $id_Rincspm = $_POST['id_Rincspm'];
      $id_PotonganSpm = $_POST['id_PotonganSpm'];
      //periksa nilai kegiatan spm jika melebihi sisa anggaran
      if(isset($_POST[simpan])) {
        if($_POST[StatusSpm]==0) {
            $target = $_POST[AnggaranTarget];
            $TotalSmntara = $_POST[TotalSmntara];
            $TotalPot = $_POST[TotalPot];
            $NilaiPotongan = $_POST[NilaiPotongan];
            $TotalPotongan = $NilaiPotongan+$TotalPot;

          if($TotalPotongan <= $TotalSmntara) {
            $qry = mysql_query("UPDATE potonganspm SET JnsPotongan='$JnsPotongan',
                                                        NilaiPotongan='$NilaiPotongan'
                                                        WHERE id_PotonganSpm = '$id_PotonganSpm'");
            if ($qry)
                {
                    header('location:../main.php?module=spm&act=potongan&id='.$id_Spm.'');
                }
            else
                {
                    echo mysql_error();
                }
          } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf Potongan SPM Kegiatan melebihi Target SPP ".angkrp($TotalSmntara)."')
                        window.location.href='../main.php?module=spm&act=potongan&id=$id_Spm'</script>";
          }
        } else {
            echo "<script type=text/javascript>window.alert('Error : Maaf SPM sudah Final')
                				window.location.href='../main.php?module=spm&act=kegiatan&id=$id_Spm'</script>";
        }
      } else {
        echo "error simpan";
      }

}
