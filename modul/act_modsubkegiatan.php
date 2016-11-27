<?php
session_start();
include "../config/koneksi.php";
//include "../config/fungsi.php";
//include "../config/errormode.php";

//cek jika status sudah final
$q = mysql_query("SELECT StatusSubKegiatan FROM statusfinal WHERE id_Skpd='$_SESSION[id_Skpd]' AND thn_Anggaran='$_SESSION[thn_Login]'");
$r = mysql_fetch_array($q);

if($r[StatusSubKegiatan] == "draft") { //cek jika masih draf
//--------------------------------------------------------------------------------------------
$module = $_GET['module'];
$act = $_GET['act'];

//cek anggaran //98759149883,22
$qc = mysql_query("SELECT AnggKeg FROM datakegiatan WHERE id_DataKegiatan = '$_POST[id_DataKegiatan]'");
$rc = mysql_fetch_array($qc);

//cek anggaran sub kegiatan
$qd = mysql_query("SELECT SUM(nl_Pagu) AS jml_anggsub FROM subkegiatan WHERE id_DataKegiatan = '$_POST[id_DataKegiatan]'");
$rd = mysql_fetch_array($qd);
//anggaran sub ditambah anggaran keg baru
//exit("tambah baru");

        $id_SubKegiatan = $_POST['id_SubKegiatan'];
        $id_Desa = $_POST['id_Desa'];
        $AlamatLokasi = $_POST['AlamatLokasi'];
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $nm_SubKegiatan = $_POST['nm_SubKegiatan'];
        $nl_Pagu = $_POST['nl_Pagu'];
        $nl_Fisik = $_POST['nl_Fisik'];
        $nl_Kontrak = $_POST['nl_Kontrak'];
        $nl_Pagu = $_POST['nl_Pagu'];
        $jml_Volume = $_POST['jml_Volume'];
        //$id_SbDana = $_POST['id_SbDana']; sumberdana ada pada table datakegiatan
        $no_Kontrak = $_POST['no_Kontrak'];
        //if($_POST['JnsSubKeg']=='f') {
        //  $JnsSubKeg = 'f';
          $Pelaksana = $_POST[pelaksana2];
          $konsPerencana = $_POST[konsPerencana];
          $konsPengawas = $_POST[konsPengawas];
        //} else {
        //  $JnsSubKeg = 'a';
        //  $Pelaksana = "Swakelola";
        //  $konsPerencana = "-";
        //  $konsPengawas = "-";
        //}
        $tgl_Mulai = $_POST['tgl_Mulai'];
        $tgl_Selesai = $_POST['tgl_Selesai'];
        $trg_Fisik = $_POST['trg_Fisik'];
        if($_POST['nl_Pagu'] <> ($_POST['trg_Keu1']+$_POST['trg_Keu2']+$_POST['trg_Keu3']+$_POST['trg_Keu4'])) {
           echo "<script type=text/javascript>window.alert('Error:Nilai Triwulan tidak sama dengan Nilai Pagu sub kegiatan')
              window.location.href='../main.php?module=subkegiatan&act=sub&id=$_POST[id_DataKegiatan]'</script>";
          exit();
        } else {
          if($_POST['bagirata']=='bagirata') {
            //$a = $_POST['trg_Keu1'];
            //$b = $_POST['trg_Keu2'];
            //$c = $_POST['trg_Keu3'];
            //$d = $_POST['trg_Keu4'];
            //$rata = ($a+$b+$c+$d)/4;
            $rata = $_POST[nl_Pagu]/4;
            $trg_Keu1 = $rata;
            $trg_Keu2 = $rata;
            $trg_Keu3 = $rata;
            $trg_Keu4 = $rata;
          } else {
            $trg_Keu1 = $_POST['trg_Keu1'];
            $trg_Keu2 = $_POST['trg_Keu2'];
            $trg_Keu3 = $_POST['trg_Keu3'];
            $trg_Keu4 = $_POST['trg_Keu4'];
          }
        }
        $tgl_Input = $_POST['tgl_Input'];
        $latitude = mysql_real_escape_string($_POST['latitude']);
        $longitude = mysql_real_escape_string($_POST['longitude']);
        $id_Session = $_SESSION['id_User'];
        $AddType = "m";

  if ($act == "add" and $module == "subkegiatan") {
    $anggbaru = $rd['jml_anggsub']+$_POST['nl_Pagu'];
    //matikan cek nilai anggaran sementara
	//if($rc['AnggKeg'] < $anggbaru ) {
    //    echo "<script type=text/javascript>window.alert('Error:Pagu melebihi nilai Anggaran')
    //          window.location.href='../main.php?module=subkegiatan&act=sub&id=$_POST[id_DataKegiatan]'</script>";
    //} else {
        if(isset($_POST[simpan])) {
          $qry = mysql_query("INSERT INTO subkegiatan (id_Desa,
                                                AlamatLokasi,
                                                id_DataKegiatan,
                                                JnsSubKeg,
                                                nm_SubKegiatan,
                                                nl_Pagu,
                                                nl_Fisik,
                                                nl_Kontrak,
                                                jml_Volume,
                                                id_SbDana,
                                                no_Kontrak,
                                                Pelaksana,
                                                konsPerencana,
                                                konsPengawas,
                                                tgl_Mulai,
                                                tgl_Selesai,
                                                trg_Fisik,
                                                trg_Keu1,
                                                trg_Keu2,
                                                trg_Keu3,
                                                trg_Keu4,
                                                tgl_Input,
                                                Latitude,
                                                Longitude,
                                                id_Session,
                                                AddType)
                                        VALUES ('$id_Desa',
                                                '$AlamatLokasi',
                                                '$id_DataKegiatan',
                                                '$JnsSubKeg',
                                                '$nm_SubKegiatan',
                                                '$nl_Pagu',
                                                '$nl_Fisik',
                                                '$nl_Kontrak',
                                                '$jml_Volume',
                                                '$id_SbDana',
                                                '$no_Kontrak',
                                                '$Pelaksana',
                                                '$konsPerencana',
                                                '$konsPengawas',
                                                '$tgl_Mulai',
                                                '$tgl_Selesai',
                                                '$trg_Fisik',
                                                '$trg_Keu1',
                                                '$trg_Keu2',
                                                '$trg_Keu3',
                                                '$trg_Keu4',
                                                now(),
                                                '$latitude',
                                                '$longitude',
                                                '$id_Session',
                                                '$AddType')");
          if ($qry)
              {
                  header("location:../main.php?module=subkegiatan&act=sub&id=$id_DataKegiatan");
              }
          else
              {
                  echo mysql_error();
              }
          exit();
      }
   // }
  } elseif($act == "edit" and $module == "subkegiatan"){
    $anggbaru = $rd['jml_anggsub']+$_POST['nl_Pagu']-$_POST['nl_PaguLama'];
    //if($rc['AnggKeg'] < $anggbaru ) {
    //    echo "<script type=text/javascript>window.alert('Error:Pagu melebihi nilai Anggaran')
    //          window.location.href='../main.php?module=subkegiatan&act=sub&id=$_POST[id_DataKegiatan]'</script>";
    //} else {
      if(isset($_POST[simpan])) {
          $qry = mysql_query("UPDATE subkegiatan SET id_Desa='$id_Desa',
                                                AlamatLokasi='$AlamatLokasi',
                                                JnsSubKeg='$JnsSubKeg',
                                                nm_SubKegiatan='$nm_SubKegiatan',
                                                nl_Pagu='$nl_Pagu',
                                                nl_Fisik='$nl_Fisik',
                                                nl_Kontrak='$nl_Kontrak',
                                                jml_Volume='$jml_Volume',
                                                id_SbDana='$id_SbDana',
                                                no_Kontrak='$no_Kontrak',
                                                Pelaksana='$Pelaksana',
                                                konsPerencana='$konsPerencana',
                                                konsPengawas='$konsPengawas',
                                                tgl_Mulai='$tgl_Mulai',
                                                tgl_Selesai='$tgl_Selesai',
                                                trg_Fisik='$trg_Fisik',
                                                trg_Keu1='$trg_Keu1',
                                                trg_Keu2='$trg_Keu2',
                                                trg_Keu3='$trg_Keu3',
                                                trg_Keu4='$trg_Keu4',
                                                tgl_Input=now(),
                                                Latitude='$latitude',
                                                Longitude='$longitude',
                                                id_Session='$id_Session'
                                          WHERE id_SubKegiatan = '$id_SubKegiatan'");
          if ($qry)
              {
                  header("location:../main.php?module=subkegiatan&act=sub&id=$id_DataKegiatan");
              }
          else
              {
                  echo mysql_error();
              }
          exit();
        }
    //}
  } elseif ($act == "editx" and $module == "subkegiatan") {
        $id_DataKegiatan = $_POST['id_DataKegiatan'];
        $id_Kegiatan = $_POST['id_Kegiatan'];
        $TahunAnggaran = $_POST['TahunAnggaran'];
        $id_Skpd = $_POST['id_Skpd'];
        $AnggKeg = $_POST['AnggKeg'];
        $id_Ppk = $_POST['id_Ppk'];
        $id_Session = $_SESSION['Sessid'];
        $qry = mysql_query("UPDATE datakegiatan SET id_Kegiatan='$id_Kegiatan',
                                              id_Ppk='$id_Ppk',
                                              id_Session='$id_Session',
                                              AnggKeg='$AnggKeg',
                                              tgl_Input=now()
                                        WHERE id_DataKegiatan = '$id_DataKegiatan'");
        if ($qry)
            {
                header('location:../main.php?module=subkegiatan');
            }
        else
            {
                echo mysql_error();
            }
        exit();

  } elseif ($act == "deletexx" and $module == "subkegiatan") {
          $id_DataKegiatan = $_POST[id_DataKegiatan];
          $id_SubKegiatan = $_GET[id];
          //periksa jika sudah direalisasikan
          $q=mysql_query("SELECT id_SubKegiatan FROM realisasi WHERE id_SubKegiatan = '$id_SubKegiatan'");
          $r=mysql_num_rows($q);
          if($r==0) {
            $qry = mysql_query("DELETE FROM subkegiatan WHERE id_SubKegiatan = '$id_SubKegiatan'");
            if ($qry)
                {
                    header("location:../main.php?module=subkegiatan&act=sub&id=$_GET[dk]");
                }
            else
                {
                    echo mysql_error();
                }
          } else {
             echo "<script type=text/javascript>window.alert('Gagal Hapus:Data telah direalisasikan')
                window.location.href='../main.php?module=subkegiatan'</script>";
          }
  } elseif($act="trgfisik" AND $module="subkegiatan") {
    if(isset($_POST['simpanx'])) { //add data
        for ($i=0; $i < count($_POST['bulan']) ; $i++) {

            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_SubKegiatan = $_POST['id_SubKegiatan'];
            $id_Bulan = $_POST['bulan'][$i];
            $nl_TargetFisik = $_POST['nl_TargetFisik'][$i];
            $nl_TargetKeu = $_POST['nl_TargetKeu'][$i];

            $qry = mysql_query("INSERT INTO targetfisik (id_SubKegiatan,
                                                  id_Bulan,
                                                  nl_TargetFisik,
                                                  nl_TargetKeu)
                                          VALUES ('$id_SubKegiatan',
                                                  '$id_Bulan',
                                                  '$nl_TargetFisik',
                                                  '$nl_TargetKeu')");
        }
            if ($qry)
                {
                    header("location:../main.php?module=subkegiatan&act=sub&id=$id_DataKegiatan");
                }
            else
                {
                    echo mysql_error();
                }

    } else {
        if (isset($_POST['editx'])) {
            $id_DataKegiatan = $_POST['id_DataKegiatan'];
            $id_SubKegiatan = $_POST['id_SubKegiatan'];

            $qw = mysql_query("DELETE FROM targetfisik WHERE id_SubKegiatan = '$id_SubKegiatan'");
                if($qw) {
                    for ($i=0; $i < count($_POST['bulan']) ; $i++) {
                      $id_DataKegiatan = $_POST['id_DataKegiatan'];
                      $id_SubKegiatan = $_POST['id_SubKegiatan'];
                      $id_Bulan = $_POST['bulan'][$i];
                      $nl_TargetFisik = $_POST['nl_TargetFisik'][$i];
                      $nl_TargetKeu = $_POST['nl_TargetKeu'][$i];

                      $qry = mysql_query("INSERT INTO targetfisik (id_SubKegiatan,
                                                            id_Bulan,
                                                            nl_TargetFisik,
                                                            nl_TargetKeu)
                                                    VALUES ('$id_SubKegiatan',
                                                            '$id_Bulan',
                                                            '$nl_TargetFisik',
                                                            '$nl_TargetKeu')");
                    }
                        if ($qry)
                            {
                              header("location:../main.php?module=subkegiatan&act=sub&id=$id_DataKegiatan");
                            }
                        else
                            {
                                echo mysql_error();
                            }
                }
        }
    }

  } else {
    echo "<script type=text/javascript>window.alert('Gagal Hapus:Data telah direalisasikan')
       window.location.href='../main.php?module=subkegiatan'</script>";
  }


}  else { //end jika final
  echo "<script type=text/javascript>window.alert('Sub Kegiatan sudah FINAL / Belum Registrasi T.A')
        window.location.href='../main.php?module=subkegiatan&act=sub&id=$_POST[id_DataKegiatan]'</script>";
}
