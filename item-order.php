<?php
include 'util-config.php';

function getIPAddress() {  
    //whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    //whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$phone="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT logo_url,bg_img_url,phone from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $phone=$row['phone'];
    }
}


$item_id =0;
$title = "";
$description ="";


$image_urls= array();

if(isset($_GET['id'])){

    $item_id=$_GET['id'];

    $sql="SELECT * FROM `tbl_custom_entity` Where custe_id=$item_id AND `isactive` = 1";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $title=$row['title'];
            $description =$row['description'];
        }
    }


    //Images
    $sql3="SELECT `img_url` FROM `tbl_custom_entity_gallery` WHERE `custe_id` = $item_id ";
    $result3 = $conn->query($sql3);       
    if ($result3 && $result3->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result3)) {
            $url_image = $row1['img_url'];
            array_push($image_urls,$url_image);
        }}

}

if(isset($_POST['submit'])){
    $firstname=$_POST['input_first_name'];
    $lastname=$_POST['input_last_name'];
    $roomnumber=$_POST['input_room_number'];
    $comments=$_POST['input_wish'];
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");


    $sql="INSERT INTO `tbl_custom_entity_order`(`custe_id`, `first_name`, `last_name`, `room_number`, `comment`, `entrytime`, `entrybyip`, `lastedittime`, `lasteditbyip`, `status_id`) VALUES ($item_id,'$firstname','$lastname','$roomnumber','$comments','$entry_time','$entryby_ip','$last_edit_time','$last_editby_ip',1)";

    $stmt = $conn->query($sql);

    if(!$stmt){
        echo '<script>alert("Something went wrong!!!");</script>';
    }else{
        echo '<script>alert("Order Message Sent..."); window.location.href = "item";</script>';    
    }

}

?>


<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>Box Order</title>
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
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                    <div class="col-xl-7 col-md-7 col-sm-7 pl-2">
                        <h2 class="textstyle"><?php echo $title ?></h2>
                    </div>
                </div>

                <div class="row " >
                    <div class ="col-xl-5 col-md-5 col-sm-5">
                        <?php 
    $length = count($image_urls);
        if($length>0){
                        ?>
                        <div class="row m-0">
                            <div class="col-xl-9 col-md-9 col-sm-9 bgfull-affect-div">
                                <ul class="slides">
                                    <?php

            for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li id="slide<?php echo $x+1 ?>" class="d-flex">
                                        <a class="galleryItem" href="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>"> <img  src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" class="w-100 h-100 d-flex"> </a> 
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


                    <div class ="col-xl-7 col-md-7 col-sm-7 mt-2 pr-3 pl-3 pb-3 mobile_padding_none bgfull-affect-div">

                        <?php if($description != ""){ ?>
                        <div class="row m-0 bg-white-opacity pt-3 pr-3 pl-3 pb-3 div-shadow-mobile">
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <h2>Description</h2>
                            </div>
                            <div class="col-xl-12 col-md-12 col-sm-12">
                                <?php echo $description; ?>
                            </div>
                        </div>
                        <?php }?>


                        <div class="row m-0 bg-white-opacity pt-3 pr-3 pl-3 pb-3 div-shadow-mobile">
                            <div class="col-xl-12 col-md-12 col-sm-12" style="text-align:right;">
                                <a href="javascript:void(0)" onclick="order_expand()" class="btn  text-white button-background-color btn-primary">Order <i class="fa fa-envelope text-white"></i></a>
                                <a href="tel:<?php echo $phone; ?>" class="btn  text-white button-background-color btn-primary"><i class="fa fa-phone text-white" aria-hidden="true"></i></a>
                            </div>  
                        </div>

                        <form method="post">
                            <div class="row m-0 bg-white-opacity pt-3 pr-3 pl-3 pb-3 div-shadow-mobile" id="order_div" style="display:none;">
                                <div class="col-xl-12 col-md-12 col-sm-12">
                                    <hr class="m-0 mb-3">
                                    <h3>Order</h3>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6">
                                    <div class="form-group p-2">
                                        <label class="form-control-label" for="input_first_name">First Name</label>
                                        <input type="text" id="input_first_name" name="input_first_name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6">
                                    <div class="form-group p-2">
                                        <label class="form-control-label" for="input_last_name">Last Name</label>
                                        <input type="text" id="input_last_name" name="input_last_name" class="form-control"  required>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12">
                                    <div class="form-group p-2">
                                        <label class="form-control-label" for="input_room_number">Room Number</label>
                                        <input type="text" id="input_room_number" name="input_room_number" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12">
                                    <div class="form-group p-2">
                                        <label class="form-control-label" for="input_wish">Your wishes (time, number, ...)</label>
                                        <textarea type="text" id="input_wish" name="input_wish" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 p-2 mb-4">
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        <input class="custom-control-input" id=" customCheckLogin" type="checkbox" required>
                                        <label class="custom-control-label" for=" customCheckLogin">
                                            <span class="text-muted">I have read and accept the <a href="privacy">privacy policy</a></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 p-2">
                                    <input type="submit" name="submit" value="Order" class="btn  text-white button-background-color btn-primary" />
                                </div>
                            </div>
                        </form>

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
            var i=1;
            function order_expand(){

                if(i==1){
                    $('#order_div').slideDown();
                    i=2;
                }else{
                    $('#order_div').slideUp();
                    i=1;
                }
            }

        </script>
        <?php  include 'util-js-files.php' ?>

    </body>

</html>