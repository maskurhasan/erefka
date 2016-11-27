<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";

$module = $_GET['module'];
$act = $_GET['act'];

$id_Notulen = $_POST['id_Notulen'];
$id_Kegiatan = $_POST['id_Kegiatan'];
$id_Skpd = $_POST['id_Skpd'];
$Permasalahan = $_POST['Permasalahan'];
$Saran = $_POST['Saran'];
$Keputusan = $_POST['Keputusan'];
$tgl_Notulen = $_POST['tgl_Notulen'];

if($act == "add" and $module == "notulen") {
  if(isset($_POST[simpan])) {

      $qry = mysql_query("INSERT INTO notulen (id_Kegiatan)
                                      VALUES ('$id_Kegiatan')");

      if ($qry)
          {
              header('location:../main.php?module=notulen&act=add&id='.$id_Kegiatan.'');
          }
      else
          {
              echo mysql_error();
          }
    } else {
      echo "gagal";
    }


} elseif($act == "edit1" and $module == "notulen") {

  if(isset($_POST[simpan])) {
    $Tujuanrapat = $_POST['Tujuanrapat'];

      if(!empty($_FILES[LampiranNotulen][name])) {
        $tahun = $_SESSION[thn_Login];
        $gantinamafile = $id_Skpd."_".acaknmfile()."_v";

        $uploadfile = basename($_FILES[LampiranNotulen][name]);
        $extension = end(explode(".",$uploadfile));
          //$gantinama = $id_Skpd."_".acaknmfile()."_".$key;
        $gantinama = $gantinamafile;
        $namafolder = "../media/lampirannotulen/$tahun/";
        $nm_file_lmp = $gantinama.'.'.$extension;
        $pindah_foto = move_uploaded_file($_FILES[LampiranNotulen][tmp_name],$namafolder.$gantinama.'.'.$extension);

      } else {
        //jika tdak ada gambar diupload
        $nm_file_lmp = $_POST[LampHid];
      }

      $qry = mysql_query("UPDATE notulen SET Tujuanrapat='$Tujuanrapat',
                                              Permasalahan='$Permasalahan',
                                              Saran='$Saran',
                                              Keputusan='$Keputusan',
                                              LampiranNotulen='$nm_file_lmp'
                                        WHERE id_Notulen = '$_POST[id_Notulen]'");

      if ($qry)
          {
              header('location:../main.php?module=notulen&act=add&id='.$id_Kegiatan.'');
          }
      else
          {
              echo mysql_error();
          }
    } else {
      echo "gagal";
    }

} elseif ($act == "add" and $module == "notulenxxxx") {
exit('Tambah');
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
    header('location:../main.php?module=kegiatan');
  }

}
