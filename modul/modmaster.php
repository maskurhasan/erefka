<?php

session_start();

include "../config/koneksi.php";
include "../config/errormode.php";

                if($_SESSION['UserLevel']==3) {
                $sql = "SELECT label,link,icon FROM menu WHERE parent_id = 2 
                        AND operator= 1 
                        AND publish = 'Y' 
                        ORDER BY urutan ASC";
                } elseif($_SESSION['UserLevel']==2) {
                $sql = "SELECT label,link,icon FROM menu WHERE parent_id = 2 
                        AND admskpd= 1 
                        AND publish = 'Y'
                        ORDER BY urutan ASC";
                } else {
                $sql = "SELECT label,link,icon FROM menu WHERE parent_id = 2 
                        AND publish = 'Y'
                        ORDER BY urutan ASC";    
                }
                $q = mysql_query($sql);
                //WHILE($r=mysql_fetch_array($q)) {
                //    echo '<button class="btn btn-info btn-fill" type="submit" onClick=\'location.href="'.$r['link'].'"\'><i class="'.$r['icon'].'"></i> '.$r['label'].'</button>';
                //}


echo '<div class="col-md-12">
        <div class="card">
          <div class="content">';
          WHILE($r=mysql_fetch_array($q)) {
            echo '<button class="btn btn-info btn-fill" type="submit" onClick=\'location.href="'.$r['link'].'"\'><i class="'.$r['icon'].'"></i> '.$r['label'].'</button> ';
          }
          
          echo '</div>
        </div>
      </div>';


?>