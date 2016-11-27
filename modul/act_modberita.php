<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";

$module = $_GET['module'];
$act = $_GET['act'];

$id_Berita = $_POST['id_Berita'];
$Kategori = $_POST['Kategori'];
$id_Skpd = $_POST['id_Skpd'];
$tgl_Berita = $_POST['tgl_Berita'];
$Judul = $_POST['Judul'];
$Ringkasan = $_POST['Ringkasan'];
$Isiberita = $_POST['Isiberita'];
$Statusberita = $_POST['Statusberita'];

if($act == "add" and $module == "berita") {
  if(isset($_POST[simpan])) {
    if(!empty($_FILES[fl_Berita][name])) {
      $tahun = $_SESSION[thn_Login];
      $gantinamafile = $id_Skpd."_".acaknmfile()."_u";

      $uploadfile = basename($_FILES[fl_Berita][name]);
      $extension = end(explode(".",$uploadfile));
        //$gantinama = $id_Skpd."_".acaknmfile()."_".$key;
      $gantinama = $gantinamafile;
      $namafolder = "../media/berita/$tahun/";
      $nm_fl_berita = $gantinama.'.'.$extension;
      $pindah_foto = move_uploaded_file($_FILES[fl_Berita][tmp_name],$namafolder.$gantinama.'.'.$extension);

    } else {
      //jika tdak ada gambar diupload
      $nm_fl_berita = "";
    }

      $qry = mysql_query("INSERT INTO berita (id_Skpd,Kategori,tgl_Berita,Judul,Ringkasan,Isiberita,fl_Berita,Statusberita,Create_at)
                                      VALUES ('$id_Skpd','$Kategori','$tgl_Berita','$Judul','$Ringkasan','$Isiberita','$nm_fl_berita','$Statusberita',now())");

      if ($qry)
          {
              header('location:../main.php?module=berita');
          }
      else
          {
              echo mysql_error();
          }
    } else {
      echo "gagal";
    }


} elseif($act == "edit" and $module == "berita") {

  if(isset($_POST[simpan])) {
    if(!empty($_FILES[fl_Berita][name])) {
      $tahun = $_SESSION[thn_Login];
      $gantinamafile = $id_Skpd."_".acaknmfile()."_u";

      $uploadfile = basename($_FILES[fl_Berita][name]);
      $extension = end(explode(".",$uploadfile));
        //$gantinama = $id_Skpd."_".acaknmfile()."_".$key;
      $gantinama = $gantinamafile;
      $namafolder = "../media/berita/$tahun/";
      $nm_fl_berita = $gantinama.'.'.$extension;
      $pindah_foto = move_uploaded_file($_FILES[fl_Berita][tmp_name],$namafolder.$gantinama.'.'.$extension);

    } else {
      //jika tdak ada gambar diupload
      $nm_fl_berita = $_POST['fl_BeritaHidd'];
    }

      $qry = mysql_query("UPDATE berita SET Kategori='$Kategori',
                                            tgl_Berita='$tgl_Berita',
                                            Judul='$Judul',
                                            Ringkasan='$Ringkasan',
                                            Isiberita='$Isiberita',
                                            fl_Berita='$nm_fl_berita',
                                            Statusberita='$Statusberita',
                                            Update_at=now()
                                        WHERE id_Berita='$id_Berita'");

      if ($qry)
          {
              header('location:../main.php?module=berita');
          }
      else
          {
              echo mysql_error();
          }
    } else {
      echo "gagal";
    }



} else {
  echo "gagal";
}
