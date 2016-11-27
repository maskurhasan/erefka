<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";


$module = $_GET['module'];
$act = $_GET['act'];

$id_Spm = $_POST['id_Spm'];
$id_User = $_POST['id_User'];
$id_Skpd = $_POST['id_Skpd'];
$Jenis = $_POST['Jenis'];

if ($act == "add" and $module == "verifikasi") {

    if(isset($_POST[simpan])) {
        $qry = mysql_query("INSERT INTO verifikasi (id_Spm,
                                              id_User,
                                              tgl_Ver,
																						Create_at)
                                      VALUES ('$id_Spm',
                                            '$id_User',
                                            '$tgl_Ver',
																							now())");
        //if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        //  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        //}
        if ($qry)
            {
                header('location:../main.php?module=verifikasi&act=add&id='.$id_Spm.'');
            }
        else
            {
                echo mysql_error();
            }
      } else {
        echo "gagal";
      }
} elseif($act == "edit" and $module == "verifikasi"){

	$qry = mysql_query("UPDATE spm SET Jenis='$Jenis',
																			Nomor='$Nomor',
																			Tanggal='$Tanggal',
																			Anggaran='$Anggaran',
																			KepalaSkpd='$KepalaSkpd',
																			Bendahara='$Bendahara',
																			Keterangan='$Keterangan',
                                      StatusSpm = '$StatusSpm',
																			Update_at=now()
																		WHERE id_Spm = '$id_Spm'");
	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
	//}
	if ($qry)
			{
					header('location:../main.php?module=spm');
			}
	else
			{
					echo mysql_error();
			}

} elseif($act == "ubahstatus" and $module == "verifikasi"){

      if(isset($_POST['simpan'])) {
        $StatusVer = $_POST['StatusVer'];
        $tgl_Ver = $_POST['tgl_Ver'];
        $id_Ver = $_POST['id_Ver'];

        $qry = mysql_query("UPDATE verifikasi SET StatusVer = '$StatusVer',
                                            tgl_Ver = '$tgl_Ver',
      																			Update_at=now()
      																		WHERE id_Ver = '$id_Ver'");
      	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
      	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
      	//}
      	if ($qry)
      			{
                if($StatusVer == 0) {
                  header('location:../main.php?module=verifikasi&act=add&id='.$id_Ver.'');
                } else {
                  header('location:../main.php?module=verifikasi');
                }
      			}
      	else
      			{
      					echo mysql_error();
      			}

      }



} elseif($act == "pengebud" and $module == "pengesahanbud"){
      if(isset($_POST['simpan'])) {
        if($_POST[StatusSp2d]==0) {
          $StatusPengbud = $_POST['StatusPengbud'];
          $tgl_Pengbud = $_POST['tgl_Pengbud'];
          $id_Ver = $_POST['id_Ver'];
          $qry = mysql_query("UPDATE verifikasi SET StatusPengbud = '$StatusPengbud',
                                              tgl_Pengbud = '$tgl_Pengbud',
        																			Update_at=now()
        																		WHERE id_Ver = '$id_Ver'");
        	//if($_POST['UserLevel']=="Operator" AND !empty(($_POST['berimodul'])) {
        	//  $qr1 = mysql_query("INSERT INTO aksesmodul(id_User,id_Modul) VALUES (101,SELECT)")
        	//}
        	if ($qry)
        			{
                  if($StatusPengbud == '1') {
                    header('location:../main.php?module=pengesahanbud&act=add&id='.$id_Ver.'');
                  } else {
                    header('location:../main.php?module=pengesahanbud');
                  }
        			}
        	else
        			{
        					echo mysql_error();
        			}
        } else {
          //jika sudah Cetak SP2D tidak bisa diubah lagi
          echo "<script type=text/javascript>window.alert('Error : SP2D Sudah dicetak')
              				window.location.href='../main.php?module=pengesahanbud&act=add&id=$_POST[id_Ver]'</script>";
        }

      }



} elseif($act == "add" and $module == "sp2d"){
      if(isset($_POST['simpan'])) {
        if($_POST[StatusPengbud]==2) {
          //exit($_POST[StatusSp2d]);
          $StatusSp2d = $_POST['StatusSp2d'];
          $NomorSp2d = $_POST['NomorSp2d'];
          $tgl_Sp2d = $_POST['tgl_Sp2d'];
          $id_Ver = $_POST['id_Ver'];
          $qry = mysql_query("UPDATE verifikasi SET
                                              NomorSp2d = '$NomorSp2d',
                                              tgl_Sp2d = '$tgl_Sp2d',
                                              StatusSp2d = '$StatusSp2d',
                                              Update_at=now()
                                            WHERE id_Ver = '$id_Ver'");

          if ($qry)
              {
                  //if($StatusSp2d == '1') {
                  //  header('location:../main.php?module=sp2d&act=daftarspm');
                  //} else {
                    header('location:../main.php?module=sp2d');
                  //}
              }
          else
              {
                  echo mysql_error();
              }
        } else {
          //jika sudah Cetak SP2D tidak bisa diubah lagi
          echo "<script type=text/javascript>window.alert('Error : SP2D Sudah dicetak')
                      window.location.href='../main.php?module=sp2d&act=daftarspm</script>";
        }

      }



} elseif($act == "edit" and $module == "sp2d"){
      if(isset($_POST['simpan'])) {
        if($_POST[StatusSp2d]==1) {

          $StatusSp2d = $_POST['StatusSp2d'];
          $NomorSp2d = $_POST['NomorSp2d'];
          $tgl_Sp2d = $_POST['tgl_Sp2d'];
          $id_Ver = $_POST['id_Ver'];
          $qry = mysql_query("UPDATE verifikasi SET
                                              NomorSp2d = '$NomorSp2d',
                                              tgl_Sp2d = '$tgl_Sp2d',
                                              StatusSp2d = '$StatusSp2d',
                                              Update_at=now()
                                            WHERE id_Ver = '$id_Ver'");

          if ($qry)
              {
                  if($StatusSp2d == '1') {
                    header('location:../main.php?module=sp2d&act=daftarspm');
                  } else {
                    header('location:../main.php?module=sp2d');
                  }
              }
          else
              {
                  echo mysql_error();
              }
        } else {
          //jika sudah Cetak SP2D tidak bisa diubah lagi
          echo "<script type=text/javascript>window.alert('Error : SP2D Sudah Final')
                      window.location.href='../main.php?module=sp2d'</script>";
        }

      }



} elseif ($act == "akses" and $module == "user") {
        if(isset($_POST[Simpan])) {
          $id_Modul = $_POST[id_Modul];
          $id_User = $_POST[id_User];
          $qw = mysql_query("DELETE FROM aksesmodul WHERE id_User = '$id_User'");
          if($qw) {
              for ($i=0 ; $i < count($id_Modul);$i++) {
                  $id_Modulx = $id_Modul[$i];
                  $q = mysql_query("INSERT INTO aksesmodul (id_User, id_Modul) VALUES ('$id_User','$id_Modulx')");
              }
              if ($q) {
                header('Location:../main.php?module=user');
              } else {
                echo mysql_error();
              }
          }
        } else { echo "gagal"; }

}
