<?php
session_start();
include "../../config/koneksi.php";
include "../../config/fungsi.php";

//cek jika status sudah final
$q = mysql_query("SELECT StatusRealisasi FROM statusfinal WHERE id_Skpd='$_SESSION[id_Skpd]' AND thn_Anggaran='$_SESSION[thn_Login]'");
$r = mysql_fetch_array($q);
if($r['StatusRealisasi'] == "draft") { //cek jika masih draf 
$module = $_GET['module'];
$act = $_GET['act'];

$qd = mysql_query("SELECT a.nl_Pagu,MAX(b.id_Bulan) AS MaxBulan   
                    FROM subkegiatan a,realisasi b 
                    WHERE a.id_SubKegiatan = '$_POST[id_SubKegiatan]' 
                    AND a.id_SubKegiatan = b.id_Realisasi");
$rd = mysql_fetch_array($qd);

$qe = mysql_query("SELECT rls_Keu2    
                    FROM realisasi 
                    WHERE id_SubKegiatan = '$_POST[id_SubKegiatan]' 
                    AND id_Bulan = '$rd[MaxBulan]'");
$re = mysql_fetch_array($qe);



if($_POST['rls_Keu2'] > $rd[nl_Pagu])
    echo "realisasi lebih besar dari Anggaran";
elseif($_POST['rls_Keu2'] < $re['rls_Keu2'] )
    echo "realisasi lebih kecil dari bulan sebelumnya";
else 
    echo "ok";
exit();
if ($act == "add" and $module == "realisasi") {
    if(isset($_POST[simpanx])) { //add data
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_SubKegiatan = $_POST['id_SubKegiatan'];
        $id_Bulan = $_POST['id_Bulan'];
        $rls_Fisik = $_POST['rls_Fisik'];
        $rls_Keu2 = $_POST['rls_Keu2'];
        
        $qry = mysql_query("INSERT INTO realisasi (id_SubKegiatan, 
                                              id_Bulan, 
                                              rls_Fisik, 
                                              rls_Keu2, 
                                              tgl_Input, 
                                              id_Session) 
                                      VALUES ('$id_SubKegiatan', 
                                              '$id_Bulan',
                                              '$rls_Fisik', 
                                              '$rls_Keu2', 
                                              now(), 
                                              '$_SESSION[Sessid]')");
        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan1])) {
        $urut = 1;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan2])) {
        $urut = 2;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan3])) {
        $urut = 3;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan4])) {
        $urut = 4;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan5])) {
        $urut = 5;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan6])) {
        $urut = 6;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan7])) {
        $urut = 7;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan8])) {
        $urut = 8;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan9])) {
        $urut = 9;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan10])) {
        $urut = 10;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan11])) {
        $urut = 11;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } elseif(isset($_POST[simpan12])) {
        $urut = 12;
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Realisasi = $_POST['id_Realisasi'.$urut];
        $rls_Fisik = $_POST['rls_Fisik'.$urut];
        $rls_Keu2 = $_POST['rls_Keu2'.$urut];
        $qry = mysql_query("UPDATE realisasi SET rls_Fisik = '$rls_Fisik', rls_Keu2 = '$rls_Keu2'
                            WHERE id_Realisasi = '$id_Realisasi'");

        if ($qry)
            {
                header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
            }
        else 
            {
                echo mysql_error();
            }
    } else {
        //cek jika sdh ada lampiran bulanan
        $q=mysql_query("SELECT a.id_Realisasi, b.id_Realisasi 
                        FROM lamprealisasi a,lamppermasalahan b 
                        WHERE a.id_Realisasi = '$_POST[id_Realisasi]'
                        OR b.id_Realisasi = '$_POST[id_Realisasi]'");
        $r=mysql_num_rows($q);

        echo $r;
        exit("tutup");

            for ($i=0; $i <=12 ; $i++) { 
              if(isset($_POST['delete'.$i])) {
                $id_DataKegiatan = $_POST['id_DataKegiatan'];
                $id_Realisasi = $_POST['id_Realisasi'.$i];
                $qry = mysql_query("DELETE FROM realisasi WHERE id_Realisasi ='$id_Realisasi'");
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
    }
} elseif($act == "addlamp" and $module == "realisasi"){
        if(isset($_POST['upload'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_Realisasi = $_POST['id_Bulanlamp'];
            $Caption = $_POST['Caption'];

            $nm_file = basename($_FILES['nm_LampRealisasi']['name']);
            $extension = end(explode(".", $nm_file));
            $gantinama = $id_DataKegiatan."_".$id_Realisasi."_".acaknmfile();
            $nm_folder = "image/syaratdokumen/"; //nama folder simpan gambar
            
            $nm_FileUpload = $gantinama.'.'.$extension;
            $pindah_foto = move_uploaded_file($_FILES['nm_LampRealisasi']['tmp_name'], '../../image/'.$gantinama.'.'.$extension);
            
            if($pindah_foto AND !empty($nm_file)) {
                $qry = mysql_query("INSERT INTO lamprealisasi (id_Realisasi, nm_LampRealisasi,Caption,tgl_Input,id_Session)
                                    VALUES ('$id_Realisasi','$nm_FileUpload','$Caption',now(),'$_SESSION[Sessid]')");
                    if ($qry)
                    {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    }
                else 
                    {
                        echo mysql_error();
                    }
            }
        
        } else {
            for ($i=0; $i <=12 ; $i++) { 
              if(isset($_POST['delete'.$i])) {
                $id_DataKegiatan = $_POST['id_DataKegiatan'];
                $id_LampRealisasi = $_POST['id_LampRealisasi'.$i];
                $nm_LampRealisasi = $_POST['nm_LampRealisasi'.$i];
                $qry = mysql_query("DELETE FROM lamprealisasi WHERE id_LampRealisasi ='$id_LampRealisasi'");

                if($qry) {
                    chdir('../../image');
                    $hapusfile = unlink($nm_LampRealisasi);
                    if($hapusfile == "1") {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    } else {
                        echo "Gagal dihapus";
                    }
                }
              }
            }
        }

        

} elseif($act == "masalah" and $module == "realisasi"){
        if(isset($_POST['masalah'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_Realisasi = $_POST['id_Bulanlamp'];
            $nm_Permasalahan = $_POST['nm_Permasalahan'];
            $nm_Solusi = $_POST['nm_Solusi'];
            
            $qry = mysql_query("INSERT INTO lamppermasalahan (id_Realisasi, nm_Permasalahan,nm_Solusi,tgl_Input,id_Session)
                                    VALUES ('$id_Realisasi','$nm_Permasalahan','$nm_Solusi',now(),'$_SESSION[Sessid]')");
                if ($qry)
                    {
                        header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    }
                else 
                    {
                        echo mysql_error();
                    }
        } else {
            for ($i=0; $i <=12 ; $i++) { 
              if(isset($_POST['delete'.$i])) {
                $id_DataKegiatan = $_POST['id_DataKegiatan'];
                $id_LampPermasalahan = $_POST['id_LampPermasalahan'.$i];
                $qry = mysql_query("DELETE FROM lamppermasalahan WHERE id_LampPermasalahan ='$id_LampPermasalahan'");

                if($qry) {
                    header("location:../main.php?module=realisasi&act=add&id=$id_DataKegiatan");
                    } else {
                        echo mysql_error();
                    }
                }
              }
        }
    }
} else { //end jika final 
  echo "<script type=text/javascript>window.alert('Realisasi sudah FINAL / Belum Registrasi T.A')
        window.location.href='../main.php?module=realisasi&act=add&id=$_POST[id_DataKegiatan]'</script>";
} 