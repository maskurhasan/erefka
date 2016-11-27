<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";

$module = $_GET['module'];
$act = $_GET['act'];

$id_Status = $_POST['id_Status'];
$id_Skpd = $_POST['id_Skpd'];
$thn_Anggaran = $_POST['thn_Anggaran'];
$StatusDataKegiatan = $_POST['StatusDataKegiatan'];
$StatusSubKegiatan = $_POST['StatusSubKegiatan'];
$StatusRealisasi = $_POST['StatusRealisasi'];



//cek nilai anggaran
$qc = mysql_query("SELECT a.apbd,a.apbn,a.dak,SUM(b.AnggKeg) AS Anggaran 
                    FROM skpd a, datakegiatan b 
                    WHERE a.id_Skpd = '$_POST[id_Skpd]' 
                    AND b.TahunAnggaran = '$_POST[thn_Anggaran]' 
                    AND a.id_Skpd = b.id_Skpd");
$rc = mysql_fetch_array($qc);

if ($act == "add" and $module == "statusfinal") {
      if($_SESSION['thn_Login'] == $thn_Anggaran) {  
        $qry = mysql_query("INSERT INTO statusfinal (id_Skpd, 
                                              thn_Anggaran, 
                                              StatusDataKegiatan, 
                                              StatusSubKegiatan, 
                                              StatusRealisasi,
                                              tgl_Input) 
                                      VALUES ('$id_Skpd', 
                                              '$thn_Anggaran', 
                                              '$StatusDataKegiatan', 
                                              '$StatusSubKegiatan', 
                                              '$StatusRealisasi',
                                              now())");
        if ($qry)
            {
                header("location:../main.php?module=statusfinal&act=add&id=$id_Skpd");
            }
        else 
            {
                echo mysql_error();
            }
      } else {
        echo "<script type=text/javascript>window.alert('Tahun Anggaran tidak sama dengan Tahun Login')
          window.location.href='../main.php?module=statusfinal&act=add&id=$_POST[id_Skpd]'</script>";
      }
} elseif($act == "edit" and $module == "statusfinal"){
  if(isset($_POST['simpan']) AND $_POST['StatusDataKegiatan'] == "final") {
      if($rc['apbd'] <> $rc['Anggaran']) {
        echo "<script type=text/javascript>window.alert('Nilai anggaran lebih besar atau kurang dari pagu')
          window.location.href='../main.php?module=statusfinal&act=add&id=$id_Skpd'</script>";
      } else {

          $qry = mysql_query("UPDATE statusfinal SET thn_Anggaran = '$thn_Anggaran', 
                                                StatusDataKegiatan='$StatusDataKegiatan',
                                                StatusSubKegiatan='$StatusSubKegiatan',
                                                tgl_Input=now() 
                                        WHERE id_Status = '$id_Status'");
          if ($qry)
              {
                  header("location:../main.php?module=statusfinal&act=add&id=$id_Skpd");
              }
          else 
              {
                  echo mysql_error();
              }
      }
  }elseif($act=="edit" and $module == "statusfinal") {
    if(isset($_POST['simpan']) AND $_POST['StatusDataKegiatan'] == "final" AND $_POST['StatusSubKegiatan'] == "final") {
      if($rc['apbd'] <> $rc['Anggaran']) {
        echo "<script type=text/javascript>window.alert('Nilai anggaran lebih besar atau kurang dari pagu')
          window.location.href='../main.php?module=statusfinal&act=add&id=$_POST[id_Status]'</script>";
      } else {
          //exit($StatusSubKegiatan);
          $qry = mysql_query("UPDATE statusfinal SET thn_Anggaran = '$thn_Anggaran',  
                                                StatusSubKegiatan='$StatusSubKegiatan', 
                                                tgl_Input=now() 
                                        WHERE id_Status = '$id_Status'");
          if ($qry)
              {
                  header("location:../main.php?module=statusfinal&act=add&id=$id_Skpd");
              }
          else 
              {
                  echo mysql_error();
              }
      }
  } 
  }elseif(isset($_POST['simpan']) AND $_POST['StatusDataKegiatan'] == "final" AND $_POST['StatusSubKegiatan'] == "final" AND $_POST['StatusRealisasi'] == "final") {
      if($rc['apbd'] <> $rc['Anggaran']) {
        echo "<script type=text/javascript>window.alert('Nilai anggaran lebih besar atau kurang dari pagu')
          window.location.href='../main.php?module=statusfinal&act=add&id=$_POST[id_Status]'</script>";
      } else {
          $qry = mysql_query("UPDATE statusfinal SET thn_Anggaran = '$thn_Anggaran',  
                                                StatusRealisasi='$StatusRealisasi', 
                                                tgl_Input=now() 
                                        WHERE id_Status = '$id_Status'");
          if ($qry)
              {
                  header("location:../main.php?module=statusfinal&act=add&id=$id_Skpd");
              }
          else 
              {
                  echo mysql_error();
              }
      }
  } else {
    $qry = mysql_query("UPDATE statusfinal SET thn_Anggaran = '$thn_Anggaran',  
                                                StatusRealisasi='$StatusRealisasi', 
                                                StatusDataKegiatan = '$StatusDataKegiatan',
                                                StatusSubKegiatan = '$StatusSubKegiatan',
                                                tgl_Input=now() 
                                        WHERE id_Status = '$id_Status'");
          if ($qry)
              {
                  header("location:../main.php?module=statusfinal&act=add&id=$id_Skpd");
              }
          else 
              {
                  echo mysql_error();
              }
  }
} elseif($act == "delete" and $module == "user"){
      //jika user dihapus
  


} 