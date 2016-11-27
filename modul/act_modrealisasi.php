<?php
session_start();
include "../config/koneksi.php";
include "../config/fungsi.php";
include "../config/errormode.php";

//cek jika status sudah final
$q = mysql_query("SELECT StatusRealisasi FROM statusfinal WHERE id_Skpd='$_SESSION[id_Skpd]' AND thn_Anggaran='$_SESSION[thn_Login]'");
$r = mysql_fetch_array($q);
if($r['StatusRealisasi'] == "draft") { //cek jika masih draf
$module = $_GET['module'];
$act = $_GET['act'];

$qd = mysql_query("SELECT nl_Pagu
                    FROM subkegiatan
                    WHERE id_SubKegiatan = '$_POST[id_SubKegiatan]'");
$rd = mysql_fetch_array($qd);

$id_DataKegiatan = $_POST['id_DataKegiatan'];
$id_SubKegiatan = $_POST['id_SubKegiatan'];
$b1 = $_POST['b1'];
$b2 = $_POST['b2'];
$b3 = $_POST['b3'];
$b4 = $_POST['b4'];
$b5 = $_POST['b5'];
$b6 = $_POST['b6'];
$b7 = $_POST['b7'];
$b8 = $_POST['b8'];
$b9 = $_POST['b9'];
$b10= $_POST['b10'];
$b11 = $_POST['b11'];
$b12 = $_POST['b12'];

$t1 = $_POST['t1'];
$t2 = $_POST['t2'];
$t3 = $_POST['t3'];
$t4 = $_POST['t4'];
$t5 = $_POST['t5'];
$t6 = $_POST['t6'];
$t7 = $_POST['t7'];
$t8 = $_POST['t8'];
$t9 = $_POST['t9'];
$t10= $_POST['t10'];
$t11 = $_POST['t11'];
$t12 = $_POST['t12'];


if($act=="add" AND $module =="realisasi") {
    if(isset($_POST['simpanx'])) { //add data
        //echo $b1;
        //exit("tambah");
        $qry = mysql_query("INSERT INTO realisasi (id_SubKegiatan,
                                                b1,b2,b3,b4,b5,b6,b7,b8,b9,b10,b11,b12,
                                                t1,t2,t3,t4,t5,t6,t7,t8,t9,t10,t11,t12,
                                                Update_at,id_User)
                                    VALUES ('$id_SubKegiatan',
                                            '$b1','$b2','$b3','$b4','$b5','$b6','$b7','$b8','$b9','$b10','$b11','$b12',
                                            '$t1','$t2','$t3','$t4','$t5','$t6','$t7','$t8','$t9','$t10','$t11','$t12',
                                            now(),'$_SESSION[id_User]')");

            if ($qry)
                {
                    header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                }
            else
                {
                    echo mysql_error();
                }

    } else {
        if (isset($_POST['editx'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_SubKegiatan = $_POST['id_SubKegiatan'];
            //exit("ddaa");
            $qry = mysql_query("UPDATE realisasi SET
                                       b1='$b1',b2='$b2',b3='$b3',b4='$b4',b5='$b5',b6='$b6',b7='$b7',b8='$b8',b9='$b9',b10='$b10',b11='$b11',b12='$b12',
                                       t1='$t1',t2='$t2',t3='$t3',t4='$t4',t5='$t5',t6='$t6',t7='$t7',t8='$t8',t9='$t9',t10='$t10',t11='$t11',t12='$t12',
                                       Update_at=now(),id_User='$_SESSION[id_User]'
                                       WHERE id_SubKegiatan = '$id_SubKegiatan'");
            //$qw = mysql_query("DELETE FROM realisasi WHERE id_SubKegiatan = '$id_SubKegiatan'");

                        if ($qry)
                            {
                                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                            }
                        else
                            {
                                echo mysql_error();
                            }
        }
    }

} elseif($act == "addlamp" and $module == "realisasi"){
        if(isset($_POST['upload'])) {
            $tahun = $_SESSION[thn_Login];
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_SubKegiatan = $_POST['id_SubKegiatan'];
            $Caption = $_POST['Caption'];
            $nm_file = basename($_FILES['nm_LampRealisasi']['name']);
            $extension = end(explode(".", $nm_file));
            $gantinama = $id_DataKegiatan."_".$id_SubKegiatan."_".acaknmfile();
            $nm_folder = "image/syaratdokumen/"; //nama folder simpan gambar

            $nm_FileUpload = $gantinama.'.'.$extension;
            //$pindah_foto = move_uploaded_file($_FILES['nm_LampRealisasi']['tmp_name'], '../../img/lampiran/'.$gantinama.'.'.$extension);
            $pindah_foto = move_uploaded_file($_FILES['nm_LampRealisasi']['tmp_name'], '../media/lampiran/'.$tahun.'/'.$gantinama.'.'.$extension);
            
            if($pindah_foto AND !empty($nm_file)) {
                $qry = mysql_query("INSERT INTO lamprealisasi (id_SubKegiatan, nm_LampRealisasi,Caption,tgl_Input,id_User)
                                    VALUES ('$id_SubKegiatan','$nm_FileUpload','$Caption',now(),'$_SESSION[id_User]')");
                    if ($qry)
                    {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    }
                else
                    {
                        echo mysql_error();
                    }
            } else {
                echo "gagal";
            }

        } elseif(isset($_POST['delete'])) {
                $id_DataKegiatan = $_POST['id_DataKegiatan'];
                $id_LampRealisasi = $_POST['id_LampRealisasi'];
                $nm_LampRealisasi = $_POST['nm_LampRealisasi'];
                $qry = mysql_query("DELETE FROM lamprealisasi WHERE id_LampRealisasi ='$id_LampRealisasi'");

                if($qry) {
                    chdir('../../img/lampiran');
                    $hapusfile = unlink($nm_LampRealisasi);
                    if($hapusfile == "1") {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    } else {
                        echo "Gagal dihapus";
                    }
                }
        } elseif(isset($_POST['edit'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_LampRealisasi = $_POST['id_LampRealisasi'];
            $Caption = $_POST['Caption'];

            $qry = mysql_query("UPDATE lamprealisasi  SET  Caption='$Caption',tgl_Input=now(),id_User='$_SESSION[id_User]'
                                                        WHERE id_LampRealisasi='$id_LampRealisasi'");
                if ($qry)
                    {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    }
                else
                    {
                        echo mysql_error();
                    }
        }

} elseif($act == "masalah" and $module == "realisasi"){
        if(isset($_POST['masalah'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $Tanggal = $_POST['Tanggal'];
            $id_SubKegiatan = $_POST['id_SubKegiatan'];
            $nm_Permasalahan = $_POST['nm_Permasalahan'];
            $nm_Solusi = $_POST['nm_Solusi'];

            $qry = mysql_query("INSERT INTO lamppermasalahan (id_SubKegiatan,Tanggal, nm_Permasalahan,nm_Solusi,tgl_Input,id_User)
                                    VALUES ('$id_SubKegiatan','$Tanggal','$nm_Permasalahan','$nm_Solusi',now(),'$_SESSION[id_User]')");
                if ($qry)
                    {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    }
                else
                    {
                        echo mysql_error();
                    }
        } elseif(isset($_POST['delete'])) {
                $id_DataKegiatan = $_POST['id_DataKegiatan'];
                $id_LampPermasalahan = $_POST['delete'];

                $qry = mysql_query("DELETE FROM lamppermasalahan WHERE id_LampPermasalahan ='$id_LampPermasalahan'");

                if($qry) {
                    header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    } else {
                        echo mysql_error();
                    }
        } elseif(isset($_POST['edit'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $Tanggal = $_POST['Tanggal'];
            $id_SubKegiatan = $_POST['id_SubKegiatan'];
            $nm_Permasalahan = $_POST['nm_Permasalahan'];
            $nm_Solusi = $_POST['nm_Solusi'];
            $id_LampPermasalahan = $_POST['id_LampPermasalahan'];

            $qry = mysql_query("UPDATE lamppermasalahan  SET Tanggal='$Tanggal', nm_Permasalahan='$nm_Permasalahan',
                                                            nm_Solusi='$nm_Solusi',tgl_Input=now(),id_User='$_SESSION[id_User]'
                                                        WHERE id_LampPermasalahan='$id_LampPermasalahan'");
                if ($qry)
                    {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    }
                else
                    {
                        echo mysql_error();
                    }
        }



}
} else { //end jika final
  echo "<script type=text/javascript>window.alert('Realisasi sudah FINAL / Belum Registrasi T.A')
        window.location.href='../main.php?module=realisasi&act=add&id=$_POST[id_DataKegiatan]'</script>";
}


?>
