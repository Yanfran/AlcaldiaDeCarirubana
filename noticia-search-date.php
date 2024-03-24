<?php
session_start();
include("./conexion/conexion.php");                        
$conexion=conexion();                           

    if (isset($_GET['date1']) && isset($_GET['date2'])) {
        $date1=date("Y-m-d", strtotime($_GET['date1']));
        $date2=date("Y-m-d", strtotime($_GET['date2']));
        $categoria=$_GET['categoria'];
        $permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_.@/ ";

            for ($i=0; $i<strlen($date1); $i++){ 
                if (strpos($permitidos, substr($date1,$i,1))===false){ 
                ?>
                <script>
                alert("Formato no valido");
                window.location.href = "noticias.php";
                </script>               

                <?php
                 return false; 
                } 
            }

            for ($i=0; $i<strlen($date2); $i++){ 
                if (strpos($permitidos, substr($date2,$i,1))===false){ 
                ?>
                <script>
                alert("Formato no valido");
                window.location.href = "noticias.php";
                </script>               

                <?php
                 return false; 
                } 
            }

            for ($i=0; $i<strlen($categoria); $i++){ 
                if (strpos($permitidos, substr($categoria,$i,1))===false){ 
                ?>
                <script>
                alert("Formato no valido");
                window.location.href = "eventos.php";
                </script>               

                <?php
                 return false; 
                } 
            } 
              
        
            
?>
        
        <?php include ("componentes/header.php"); ?>

        <!-- main header -->
            <?php include ("./componentes/menu.php"); ?>        
        <!-- main-header end -->


        <!-- Page Title -->
        <section class="page-title blog-page style-two" style="background-image: url(./img/inicio/banner_blog/banner-pequeno-1.jpg);">
            <div class="auto-container">
                <div class="content-box">
                    <div class="title centred">
                        <span class="category"><i class="flaticon-star"></i>Noticias</span>
                        <h1>ALCALDÍA DE CARIRUBANA</h1>
                    </div>
                </div>
            </div>
            <div class="lower-box">
                <div class="auto-container">
                    <div class="post-content">
                        <div class="left-column">
                        </div>
                        <div class="right-column">
                            <div class="share-box" style="margin-right: 70px;">
                                <a href="blog-details.html">
                                    Compartir
                                </a>
                            </div>
                            <div 
                                class="team-block-one wow fadeInUp animated animated" 
                                data-wow-delay="00ms" 
                                data-wow-duration="1500ms" 
                                style="margin-top: -250px; margin-left: 110px; position: absolute;">
                                <div class="inner-box" style="background: transparent; box-shadow: none!important">
                                    <div class="lower-content">
                                        <ul class="othre-info clearfix" style="padding-top: 210px;">                     
                                            <li class="share-option" style="margin-left: 0px!important;">
                                                <i class="share-icon flaticon-share"></i>
                                                <ul class="share-links clearfix">
                                                    <li>
                                                        <a class="js-textareacopybtn" href="#">
                                                            <i class="fas fa-copy"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://twitter.com/intent/tweet?text=Noticias&url=https://alcaldiadecarirubana.com/noticias.php" target="_blank">
                                                            <i class="fab fa-twitter"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://api.whatsapp.com/send?text=Noticias%20https://alcaldiadecarirubana.com/noticias.php" target="_blank">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u=https://alcaldiadecarirubana.com/noticias.php" target="_blank">
                                                            <i class="fab fa-facebook-f"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Page Title -->


        <!-- sidebar-page-container -->
        <section class="sidebar-page-container sec-pad-2">
            <div class="auto-container">
                <input type="text" class="js-copytextarea" value="" style="display: block; background: #f5f5f6;color: #f5f5f6; position: absolute; margin-left: 20px;"> 
                <h2 class="ml-3 my-2">Resultado para rango de fechas: 
                    <span class="mr-3 ml-2" style="font-size: 24px; font-weight: 700;">
                        <?php echo $_GET['date1'];?>
                    </span> 
                    <span style="font-size: 24px; font-weight: 700;">
                        <?php echo $_GET['date2']; ?>
                    </span>
                </h2>
                <div class="row clearfix">
                    <div class="col-lg-8 col-md-12 col-sm-12 content-side">                        
                        <!-- news-section -->
                        <section class="news-section blog-grid">
                            <div class="auto-container">
                                <div class="row clearfix">
                                    <?php

                            $limite = 10;
                            $totalQuery="SELECT COUNT(*) FROM noticias";
                            $resultNoticias=mysqli_query($conexion, $totalQuery);
                            $totalNoticias = mysqli_fetch_row($resultNoticias);
                            $totalBotones = round($totalNoticias[0] / $limite);
                            // die($totalBotones);   

                            if (isset($_GET['limite'])) {
                            
                                   $sql="SELECT t1.id, t1.titulo, t1.fecha, t1.periodista, t1.ruta, t2.descripcion as categoria
                                    FROM noticias t1
                                    INNER JOIN categoria_noticias t2
                                    ON t1.id_categoria = t2.id 
                                    WHERE t1.fecha BETWEEN '$date1' AND '$date2' AND t2.descripcion LIKE '$categoria%'
                                     AND t1.status = 1 ORDER BY t1.id DESC LIMIT ".$_GET['limite'].",".$limite." ";

                                } else {

                                    $sql="SELECT t1.id, t1.titulo, t1.fecha, t1.periodista, t1.ruta, t2.descripcion as categoria
                                    FROM noticias t1
                                    INNER JOIN categoria_noticias t2
                                    ON t1.id_categoria = t2.id 
                                    WHERE t1.fecha BETWEEN '$date1' AND '$date2' AND t2.descripcion LIKE '$categoria%'
                                     AND t1.status = 1 ORDER BY t1.id DESC LIMIT ".$limite." ";
                            }
      
                            $result=mysqli_query($conexion, $sql);               

                            if (mysqli_num_rows($result) > 0) {                                                        
                                while ($fila = mysqli_fetch_array($result)) {
                                    ?> 

                                    <div class="col-lg-6 col-md-6 col-sm-12 news-block">                        
                                        <div class="news-block-one wow fadeInUp animated animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                            <div class="inner-box">
                                                <div class="image-box">
                                                    <figure class="image">
                                                        <a href="noticia.php?id=<?php echo $fila['id']; ?>"><i class="fas fa-link"></i></a>
                                                        <img src="./img/inicio/sesion_noticias_principales/<?php echo $fila['ruta']; ?>" alt="" loading="lazy">
                                                    </figure>
                                                    <div class="post-date">
                                                        <h3>
                                                            <?php echo date("d", strtotime($fila['fecha'])); ?>
                                                            <span><?php echo date("m/Y", strtotime($fila['fecha'])) ?></span>
                                                        </h3>
                                                    </div>
                                                </div>
                                                <div class="lower-content">
                                                    <div class="category">
                                                        <a href="blog.html">
                                                            <i class="flaticon-star"></i>
                                                            <?php echo $fila['categoria']; ?>
                                                        </a>
                                                    </div>
                                                    <h4>
                                                        <a href="noticia.php?id=<?php echo $fila['id']; ?>">
                                                            <?php echo $fila['titulo']; ?>
                                                        </a>
                                                    </h4>
                                                    <ul class="post-info clearfix">
                                                        <li><i class="far fa-user"></i><a href="blog-details.html"><?php echo $fila['periodista']; ?></a></li>
                                                        <!-- <li><i class="far fa-comment"></i><a href="blog-details.html">2 Comments</a></li> -->
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>                    
                                    </div>
                                    
                                    <?php 
                                        }
                                    } else {
                                        echo "<h3 class='ml-3 my-4'>Sin resultados para 
                                        '".$_GET['date1']."' - '".$_GET['date2']." '</h3>";
                                    }
                                    ?>

                                </div>
                                <div class="pagination-wrapper centred">
                                    <ul class="pagination clearfix">
                                        <?php 

                                            if (isset($_GET['limite'])) {
                                                if ($_GET['limite'] > 0) {

            echo '<li>
                    <a href="noticia-search-date.php?date1='.$date1.'&date2='.$date2.'&categoria='.$categoria.'&limite='.($_GET['limite']-10).'">
                    <i class="far fa-angle-double-left"></i>
                    </a>
                </li>';
                                                }
                                            }

            for ($k=0; $k < $totalBotones ; $k++) { 
                echo '<li><a href="noticia-search-date.php?date1='.$date1.'&date2='.$date2.'&categoria='.$categoria.'&limite='.($k*10).'">'.($k+1).'</a></li>';
            }

                                            if (isset($_GET['limite'])) {
                                                if ($_GET['limite']+10 < $totalBotones*10) {
                echo '<li>
                    <a href="noticia-search-date.php?date1='.$date1.'&date2='.$date2.'&categoria='.$categoria.'&limite='.($_GET['limite']+10).'">
                        <i class="far fa-angle-double-right"></i>
                    </a>
                </li>';    
                                                }
                                            } else {
                    echo '<li>
                            <a href="noticia-search-date.php?date1='.$date1.'&date2='.$date2.'&categoria='.$categoria.'&limite=10">
                                <i class="far fa-angle-double-right"></i>
                            </a>
                        </li>';
                                            }

                                        ?>
                                        <!-- <li><a href="blog.html" class="current">1</a></li>
                                        <li><a href="blog.html">2</a></li> -->
                                        
                                    </ul>
                                </div>
                            </div>
                        </section>
                        <!-- news-section end -->
                    </div>
                    <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                        <div class="blog-sidebar">
                            <div class="search-widget">
                                <form action="noticia-search.php" method="GET" class="search-form">
                                    <div class="form-group">
                                        <input type="search" name="texto" placeholder="Buscar ..." required="">
                                        <button type="submit"><i class="far fa-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="sidebar-widget category-widget">
                                <div class="widget-title">
                                    <h3>Filtrar Noticia</h3>
                                </div>
                                <div class="widget-content">                                     
                                    <form 
                                    style="margin-top: 10px; margin-bottom:-9px;" 
                                    action="noticia-search-date.php" 
                                    method="GET" 
                                    class="search-form">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group"
                                                style="border: solid #f2f2f2;padding: 6px;border-radius: 10px;">
                                                    <input type="text" style="background: transparent;" autocomplete="off" name="date1" placeholder="Fecha inicio" id="datepicker">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group"
                                                style="border: solid #f2f2f2;padding: 6px;border-radius: 10px;">
                                                    <input type="text" style="background: transparent;" autocomplete="off" name="date2" placeholder="Fecha fin" id="datepicker2">       
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                
                                                      <ul class="category-list clearfix">
                                                        <?php 
                                                            $sql2="SELECT * FROM categoria_noticias WHERE status = 1 ORDER BY id ASC";
                                                            $result2=mysqli_query($conexion, $sql2);                        
                                                            while ($fila2 = mysqli_fetch_array($result2)) {
                                                        ?>
                                                    <li>
                                                        
                                                        <div class="form-check">
                                                          <input class="form-check-input" type="radio" name="categoria" id="exampleRadios1" value="<?php echo $fila2['descripcion']; ?>" checked>
                                                          
                                                            <?php echo $fila2['descripcion']; ?>
                                                            <span style="position: absolute;right: 0px;"> 
                                                            <?php 
                                                                $sql3="SELECT COUNT(*) FROM noticias WHERE status = 1 && id_categoria ='".$fila2['id']."' ";
                                                                $result3=mysqli_query($conexion, $sql3);                        
                                                                $fila3 = mysqli_fetch_row($result3);
                                                                echo $fila3[0 ]
                                                            ?>
                                                            </span>

                                                        </div>
                                                        
                                                    </li>
                                                        <?php } ?>
                                                    </ul>
                                                
                                            </div>


                                            <div class="col-md-12 mb-4">
                                                <button class="btn btn-primary btn-block" type="submit" style="border-radius: 20px;">
                                                    <i class="far fa-search" style="right: 30px; top: 10px; font-size: 20px; color: white; position: absolute;"></i>
                                                    Buscar
                                                </button>
                                            </div>

                                        </div>                                        
                                    </form>
                                </div>
                            </div>                 
                            <div class="sidebar-widget post-widget">
                                <div class="widget-title">
                                    <h3>Noticias Recientes</h3>
                                </div>
                                <div class="widget-content">
                                <?php 
                                    $sql2="SELECT * FROM noticias WHERE fecha = (SELECT MAX(fecha) FROM noticias) AND status = 1 ORDER BY id DESC LIMIT 3";
                                    $result2=mysqli_query($conexion, $sql2);                        
                                    while ($fila2 = mysqli_fetch_array($result2)) {
                                ?>
                                    <div class="post">
                                        <figure class="post-thumb">
                                            <a href="noticia.php?id=<?php echo $fila2['id']; ?>">
                                            <img src="./img/inicio/sesion_noticias_principales/<?php echo $fila2['ruta']; ?>" style="width: 70px; height: 70px;" alt="<?php echo $fila2['titulo']; ?>" loading="lazy">
                                            </a>
                                        </figure>
                                        <h6>
                                            <a href="noticia.php?id=<?php echo $fila2['id']; ?>">
                                            <?php echo $fila2['titulo']; ?>
                                            </a>
                                        </h6>
                                        <p><i class="far fa-calendar"></i><?php echo $fila2['fecha']; ?></p>
                                    </div>                                    
                                <?php } ?>
                                </div>
                            </div>
                          <!--   <div class="sidebar-widget archives-widget">
                                <div class="widget-title">
                                    <h3>Archives</h3>
                                </div>
                                <div class="widget-content">
                                    <div class="select-box">
                                        <div class="icon-box"><i class="far fa-calendar"></i></div>
                                        <select class="wide">
                                           <option data-display="November 2020">November 2020</option>
                                           <option value="1">Nov 2019</option>
                                           <option value="2">Oct 2019</option>
                                           <option value="3">Sep 2019</option>
                                           <option value="4">Aug 2019</option>
                                        </select>
                                    </div>
                                </div>
                            </div> -->
                            <!-- <div class="sidebar-widget tags-widget">
                                <div class="widget-title">
                                    <h3>Popular Tags</h3>
                                </div>
                                <div class="widget-content">
                                    <ul class="tags-list clearfix">
                                        <li><a href="blog-details.html">Activities</a></li>
                                        <li><a href="blog-details.html">Certificates</a></li>
                                        <li><a href="blog-details.html">Culture</a></li>
                                        <li><a href="blog-details.html">Departments</a></li>
                                        <li><a href="blog-details.html">Drinks & Food</a></li>
                                        <li><a href="blog-details.html">Mayor</a></li>
                                        <li><a href="blog-details.html">Recreation</a></li>
                                        <li><a href="blog-details.html">Taxes & Bills</a></li>
                                        <li><a href="blog-details.html">Transport</a></li>
                                        <li><a href="blog-details.html">Utilities</a></li>
                                    </ul>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- sidebar-page-container end -->


        <?php include ("./componentes/footer-2.php"); ?>


<?php         

    } else {
        header("Location: ./noticias.php");
    }
?>
