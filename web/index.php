<?php
include "../config/koneksi.php";

?>
<!doctype html>
<!--
  Material Design Lite
  Copyright 2015 Google Inc. All rights reserved.

  Licensed under the Apache License, Version 2.0 (the "License");
  you may not use this file except in compliance with the License.
  You may obtain a copy of the License at

      https://www.apache.org/licenses/LICENSE-2.0

  Unless required by applicable law or agreed to in writing, software
  distributed under the License is distributed on an "AS IS" BASIS,
  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
  See the License for the specific language governing permissions and
  limitations under the License
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A portfolio template that uses Material Design Lite.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <title>Agenda Kegiatan Luwu Utara</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.grey-pink.min.css" />
    <link rel="stylesheet" href="styles.css" />


    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>

<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header mdl-layout__header--waterfall portfolio-header">
            <div class="mdl-layout__header-row portfolio-logo-row">
                <span class="mdl-layout__title">
                    <div class="portfolio-logo"></div>
                    <span class="mdl-layout__title">Agenda Kegiatan Luwu Utara</span>
                </span>
            </div>
            <div class="mdl-layout__header-row portfolio-navigation-row mdl-layout--large-screen-only">
                <nav class="mdl-navigation mdl-typography--body-1-force-preferred-font">
                    <a class="mdl-navigation__link is-active" href="index.html">Portfolio</a>
                    <a class="mdl-navigation__link" href="blog.html">Blog</a>
                    <a class="mdl-navigation__link" href="about.html">About</a>
                    <a class="mdl-navigation__link" href="login.html">Login</a>
                </nav>
            </div>
        </header>
        <div class="mdl-layout__drawer mdl-layout--small-screen-only">
            <nav class="mdl-navigation mdl-typography--body-1-force-preferred-font">
                <a class="mdl-navigation__link is-active" href="index.html">Portfolio</a>
                <a class="mdl-navigation__link" href="blog.html">Blog</a>
                <a class="mdl-navigation__link" href="about.html">About</a>
                <a class="mdl-navigation__link" href="login.html">Login</a>
            </nav>
        </div>
        <main class="mdl-layout__content">
            <div class="mdl-grid portfolio-max-width">
                <?php
                //tampilkan data kegiatan
                $sql = "SELECT * FROM kegiatan";
                $query = mysql_query($sql);
                while($r = mysql_fetch_array($query)) {
                ?>
                <div class="mdl-cell mdl-card mdl-shadow--4dp portfolio-card">
                    <div class="mdl-card__media">
                        <img class="article-image" src="../media/surat/2016/<?php echo $r[fl_Surat] ?>" border="0" alt="">
                    </div>
                    <div class="mdl-card__title">
                        <h2 class="mdl-card__title-text"><?php echo $r[Perihal] ?></h2>
                    </div>
                    <div class="mdl-card__supporting-text">
                        <?php echo $r[Deskripsi] ?>
                    </div>
                    <div class="mdl-card__actions mdl-card--border">
                        <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect mdl-button--accent" href="content.php?id=<?php echo $r[id_Kegiatan] ?>">Read more</a>
                    </div>
                </div>
                <?php
                }
                ?>
                
            </div>
            <footer class="mdl-mini-footer">
                <div class="mdl-mini-footer__left-section">
                    <div class="mdl-logo">Simple portfolio website</div>
                </div>
                <div class="mdl-mini-footer__right-section">
                    <ul class="mdl-mini-footer__link-list">
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Privacy & Terms</a></li>
                    </ul>
                </div>
            </footer>
        </main>
    </div>
    <script src="https://code.getmdl.io/1.1.3/material.min.js"></script>
</body>

</html>
