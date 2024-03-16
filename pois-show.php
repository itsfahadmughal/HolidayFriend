<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT logo_url,bg_img_url from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
    }
}


$spac_id =0;
$title = "";
$description ="";
$address ="";
$phone = "";
$email = "";
$web = "";
$longitude = 0;
$latitude = 0;
$city = "";
$area = "";


$image_urls= array();

if(isset($_GET['id'])){

    $insur_id=$_GET['id'];

    $sql="SELECT a.*,c.area_name FROM `tbl_in_surround` as a INNER JOIN tbl_area as c ON a.area_id=c.area_id WHERE `hotel_id` = $hotel_id AND `insur_id` = $insur_id AND `isactive` = 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $title=$row['title'];
            $description =$row['description'];
            $address =$row['address'];
            $phone=$row['phone'];
            $email=$row['email'];
            $web =$row['web'];
            $longitude =$row['longitude'];
            $latitude =$row['latitude'];
            $city =$row['cityid'];
            $area =$row['area_name'];
        }
    }


    //Images
    $sql3="SELECT `img_url` FROM `tbl_in_surround_images` WHERE `insur_id` = $insur_id ";
    $result3 = $conn->query($sql3);       
    if ($result3 && $result3->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result3)) {
            $url_image = $row1['img_url'];
            array_push($image_urls,$url_image);
        }}

}
?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>In The Surround</title>
        <!-- Favicon -->
        <link rel="icon" href="<?php echo 'HolidayFriendAdmin/'.$logo_url; ?>" type="image/png">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
        <!-- Icons -->
        <link rel="stylesheet" href="assets/vendor/nucleo/css/nucleo.css" type="text/css">
        <link rel="stylesheet" href="assets/vendor/@fortawesome/fontawesome-free/css/all.min.css" type="text/css">
        <!-- Page plugins -->
        <!-- Argon CSS -->
        <link rel="stylesheet" href="assets/css/argon.css?v=1.2.0" type="text/css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <script src="assets/js/jquery.min.js"></script>
        <!-- Magnific Popup core JS file -->
        <script src="assets/js/jquery.magnific-popup.js"></script>

        <link href="assets/calendar/css/mobiscroll.javascript.min.css" rel="stylesheet" />
        <script src="assets/calendar/js/mobiscroll.javascript.min.js"></script>


        <style>
            .gallery img {
                border: 1px solid black;
            }
            .image-container {
                position: relative;
            }
            .text-block {
                position: absolute;
                top: 10px;
                left: 0px;
                color: white;
                padding-left: 20px;
                padding-right: 20px;
                display: inline-block;
            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
        </style>

        <style>
            ul.images {
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: row;
                width: 900px;
                overflow-x: auto;
            }

            ul.images li {
                flex: 0 0 auto;
                width: 150px;
                height: 150px;
            }

            ol, ul { list-style: none }

            *, *::before, *::after {
                box-sizing: inherit;
                margin: 0;
                padding: 0;
            }

            .container_slider {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
            }

            .thumbnails {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                line-height: 0;  
                height: 400px;
                width: 100px;
            }

            .thumbnails li {
                -webkit-box-flex: 1;
                -ms-flex: auto;


            }

            .thumbnails a { display: block; }

            .thumbnails img {
                width: 12vmin;
                height: 10vmin;
                -o-object-fit: cover;
                object-fit: cover;
                -o-object-position: top;
                object-position: top;
            }

            .slides { overflow: hidden; }



            .slides li {
                position: absolute;
                z-index: 1;
            }
            @-webkit-keyframes 
            slide {  0% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                }
                100% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                }
            }
            @keyframes 
            slide {  0% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                }
                100% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                }
            }

            .slides li:target {
                z-index: 3;
                -webkit-animation: slide 1s 1;
            }
            @-webkit-keyframes 
            hidden {  0% {
                z-index: 2;
                }
                100% {
                    z-index: 2;
                }
            }
            @keyframes 
            hidden {  0% {
                z-index: 2;
                }
                100% {
                    z-index: 2;
                }
            }

            .slides li:not(:target) { -webkit-animation: hidden 1s 1; }
        </style>

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="container-fluid mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-5 col-md-5 col-sm-5">
                        <h3 class="textstyle back-button" onclick="window.location = 'pois'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                        <br>
                        <br>
                        <br>
                    </div>
                    <div class="col-xl-7 col-md-7 col-sm-7 pl-2">
                        <h2 class="textstyle"><?php echo $title ?></h2>
                    </div>
                </div>

                <div class="row">
                    <div class ="col-xl-5 col-md-5 col-sm-5">
                        <?php 
    $length = count($image_urls);
        if($length>0){
                        ?>
                        <div class="row m-0">
                            <div class="col-xl-9 col-md-9 col-sm-9">
                                <ul class="slides">
                                    <?php

            for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li id="slide<?php echo $x+1 ?>" class="d-flex">
                                        <a class="galleryItem " href="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>"> <img  src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" class="w-100 h-100 d-flex"> </a> 
                                    </li>

                                    <?php
            }
                                    ?>

                                </ul>
                            </div>


                            <div class="col-xl-3 col-md-3 col-sm-3 mt-10" id="slider_event_images_mobile"  style="bottom:0px;display:none;">

                                <ul class="images w-100" <?php if($length > 4){ ?> style ="overflow-y: scroll" <?php }?>>
                                    <?php
            for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li class="w-25 h-25"> <a href="#slide<?php echo $x+1 ?>"><img class="w-100 h-100" src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" /></a> </li>
                                    <?php
            }

                                    ?>
                                </ul>

                            </div>



                            <div class="col-xl-3 col-md-3 col-sm-3" id="slider_event_images_desktop">
                                <ul class="h-40" <?php if($length > 4){ ?> style ="overflow-y: scroll" <?php }?>>
                                    <?php
            for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li> <a href="#slide<?php echo $x+1 ?>"><img class="w-100 h-100" src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" /></a> </li>
                                    <?php
            }

                                    ?>
                                </ul>
                            </div>

                        </div>

                        <?php   } ?>
                    </div>


                    <div class ="col-xl-7 col-md-7 col-sm-7  pr-3 pl-3 pb-3 mobile_padding_none">

                        <?php if($description != ""){ ?>
                        <div class="row m-0 bg-white-opacity pt-3 pr-3 pl-3 pb-3 bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <h2>Description</h2>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <?php echo $description; ?>
                            </div>
                        </div>
                        <?php }?>
                        <div class="row m-0 bg-white-opacity mt-2 pt-3 pr-3 pl-3 pb-3 bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <h4 class="mt--2"><i  style="padding:5px;" class="fas fa-map-marker-alt mr-2 icon-color"></i>Address &amp; Contact</h4>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <p> <?php echo $address; ?></p>
                                <p class="mt--3"> <?php echo $area; ?>, <?php echo $city; ?></p>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <p ><?php echo $email ?></p>
                                <p class="mt--3"><?php echo $phone ?></p>
                                <p class="mt--3"><?php echo $web ?></p>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <?php if($phone != ""){ ?>
                                <a href="tel:<?php echo $phone; ?>"><i style="background-color:#F6F6F6;font-size:20px;padding:8px;" class="fa fa-phone mt-3 icon-color"></i></a>
                                <?php }if($email != ""){ ?>
                                <a href="mailto:<?php echo $email; ?>"><i style="background-color:#F6F6F6;font-size:20px;padding:8px;" class="fa fa-envelope icon-color"></i></a>
                                <?php }if($web != ""){ ?>
                                <a href="<?php echo $web; ?>" target="_blank"><i style="background-color:#F6F6F6;font-size:20px;padding:8px;" class="fas fa-globe mt-3 icon-color"> Web</i></a>
                                <?php }if($latitude != 0 || $latitude != null){ ?>
                                <a href="https://www.google.com/maps/dir/?api=1&destination=<?php echo $latitude; ?>,<?php echo $longitude; ?>" target="_blank"><i style="background-color:#F6F6F6;font-size:20px;padding:8px;" class="fas fa-map-marker-alt mt-3 icon-color"> On Map</i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <?php 
                        $sql_inner2="SELECT b.short_name FROM `tbl_in_surround_mon_map` as a INNER JOIN tbl_util_months as b ON a.mon_id=b.mon_id WHERE a.insur_id = $insur_id";
                        $result_inner2 = $conn->query($sql_inner2);
                        $mon_names=array();
                        $months=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
                        if ($result_inner2 && $result_inner2->num_rows > 0) {
                            while($row_inner2 = mysqli_fetch_array($result_inner2)) {
                                $mon_name = $row_inner2['short_name'];
                                array_push($mon_names,$mon_name);
                            }
                        }
                        if(sizeof($mon_names)>0){
                        ?>
                        <div class="row m-0 bg-white-opacity mt-2 pt-3 pr-3 pl-3 pb-3 bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12"><h4><i style="padding:5px;" class="fas fa-clock mr-2 icon-color"></i>Recommended Season</h4></div>
                            <?php
                            for($i=0;$i<sizeof($months);$i++){

                            ?>
                            <div class="col-xl-2 col-md-2 col-sm-2 p-1 w-25">
                                <?php
                                if(in_array($months[$i], $mon_names)){
                                ?>
                                <h5 style="background-color:#32325d;text-align:center;" class="text-white pt-3 pb-3"><?php echo $months[$i] ?></h5>
                                <?php
                                }else{
                                ?>
                                <h5 style="background-color:#F6F6F6;" class="align-text-center pt-3 pb-3"><?php echo $months[$i] ?></h5>
                                <?php }
                                ?>
                            </div>
                            <?php 
                            }
                            ?>
                        </div>
                        <?php
                        } ?>

                        <?php 
                        $sql_time="SELECT * FROM `tbl_in_surround_timeperiod` WHERE `insur_id` = $insur_id ";
                        $result_time = $conn->query($sql_time);       
                        if ($result_time && $result_time->num_rows > 0) {
                        ?>
                        <div class="row m-0 bg-white-opacity mt-2 pt-3 pr-3 pl-3 pb-3 bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <h4 class="mt--2"><i  style="padding:5px;" class="fas fa-clock mr-2 icon-color"></i>Opening Hours</h4>
                                <?php
                            while($row_time = mysqli_fetch_array($result_time)) {
                                if($row_time['is_closed']==1){
                                ?>
                                <p class="p-2 background-color-open-hours">TIME PERIOD <br> <?php echo $row_time['from_date'] ?> - <?php echo $row_time['to_date'] ?></p>
                                <p>Closed</p>
                                <?php 
                                }else{
                                    $sql_inner="SELECT * FROM `tbl_in_surround_timeperiod_det` WHERE `instp_id` = $row_time[0] ";
                                    $result_inner = $conn->query($sql_inner);       
                                    if ($result_inner && $result_inner->num_rows > 0) {
                                        while($row_inner = mysqli_fetch_array($result_inner)) {
                                ?>
                                <div class="row m-0 scroll-bar-x-smallscreen">
                                    <table class="w-100">
                                        <tbody>
                                            <tr>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 background-color-open-hours w-200px">TIME PERIOD <br> <span style="font-size:12px;"><?php echo $row_time['from_date'] ?> - <?php echo $row_time['to_date'] ?></span></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Mon<br><br></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Tue<br><br></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Wed<br><br></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Thu<br><br></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Fri<br><br></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Sat<br><br></p>
                                                </th>
                                                <th class="pr-1 pl-1">
                                                    <p class="p-2 align-text-center background-color-open-hours">Sun<br><br></p>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td class="pr-1 pl-1">
                                                    <p class="p-2 border-open-hours w-200px"> <?php echo $row_inner['title'] ?> <br> <span style="font-size:12px;"><?php echo $row_inner['from_time'] ?> - <?php echo $row_inner['from_time'] ?></span></p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center">
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['monday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center" >
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['tuesday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center" >
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['wednesday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center">
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['thursday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center">
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['friday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center">
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['saturday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                                <td class="pr-1 pl-1 align-text-center">
                                                    <p class="pt-3 border-open-hours">
                                                        <?php if($row_inner['sunday']==1){ ?>
                                                        <i class="fas fa-check-circle" style="font-size:20px;"></i>
                                                        <?php  }else{?>
                                                        <i class="fas" style="font-size:20px;"></i>
                                                        <?php }?>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                                <?php
                                        }
                                    }
                                }
                            }

                        }
                                ?>
                            </div>


                        </div>

                        <?php 
                        $sql_fac="SELECT a.*,b.title FROM `tbl_in_surround_service` as a INNER JOIN tbl_util_facilities as b ON a.ufsc_id=b.ufsc_id WHERE `insur_id` = $insur_id ";
                        $result_fac = $conn->query($sql_fac);       
                        if ($result_fac && $result_fac->num_rows > 0) {

                        ?>
                        <div class="row m-0 bg-white-opacity mt-2 pt-3 pr-3 pl-3 pb-3 bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <h4 class="mt--2"><i  style="padding:5px;" class="fas fa-plus mr-2 icon-color"></i>Services / facility</h4>

                                <?php
                            while($row_fac = mysqli_fetch_array($result_fac)) {
                                ?>


                                <h5><?php echo $row_fac['title']; ?>:</h5>
                                <span><?php echo $row_fac['description']; ?></span>       

                                <?php
                            }

                        }

                                ?>
                            </div>


                        </div>


                    </div>
                </div>
            </div>
        </div>

        <!-- Argon Scripts -->
        <!-- Core -->

        <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>

        <script type="text/javascript">
            //initializing your javascript
            $(document).ready(function() {
                $('.image-link').magnificPopup({type:'image'});

                $('.galleryItem').magnificPopup({
                    gallery: {
                        enabled: true
                    },
                    type: 'image'
                    // other options
                });

            });

        </script>
        <?php  include 'util-js-files.php' ?>

    </body>

</html>