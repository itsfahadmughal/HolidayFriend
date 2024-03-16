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


?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>HolidayFriend - Dashboard</title>
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

        <style>
            .hero-image {
                height: 50%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
            }

            .hero-text {
                text-align: bottom;
                position: absolute;
                top: 90%;
                height: 50px;
                left: 50%;
                width: 100%;
                padding: 10px;
                transform: translate(-50%, -50%);
                color: white;
                background: rgba(0, 0, 0, 0.5);
            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
        </style>

    </head>

    <body class="bgimg" style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="container-fluid mt-3">

                <div class="mobile_height_blank"></div>

                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 6";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 6";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                    ?>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                    </div>
                </div>

                <div class="row">

                    <?php
                    $sql="SELECT a.*,b.* FROM tbl_kiosk as a LEFT OUTER JOIN tbl_kiosk_rename as b on a.hotel_id=b.hotel_id WHERE a.hotel_id=$hotel_id and a.isactive=1";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        $row = mysqli_fetch_array($result);
                    ?>
                    <div class="col-xl-3 col-md-3 col-sm-3">
                        <a class="nav-link" href="./kiosk">
                            <div class="card card-profile hover-affect-div div-shadow-mobile">
                                <img src="<?php if($row['image_url'] == ""){ echo "HolidayFriendAdmin/images/dashboard/Reading-Corner.jpg"; }else{ echo 'HolidayFriendAdmin/'.$row['image_url']; } ?>" alt="Image placeholder" class="card-img-top">
                                <div class="card-body" style="padding:0 !important;">
                                    <h5 class="h3 pl-2 pt-1">
                                         <?php if($row['title'] == ""){ echo "Kiosk"; }else{ echo $row['title']; } ?>
                                    </h5>
                                </div>
                            </div>
                        </a>

                    </div>


                    <?php 
                    }
                    ?>

                    <?php
                    $sql="SELECT a.*,b.* FROM `tbl_media_carrier` as a LEFT OUTER JOIN tbl_media_carrier_rename as b on a.hotel_id=b.hotel_id WHERE a.hotel_id=$hotel_id and a.isactive=1";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                         $row = mysqli_fetch_array($result);
                    ?>
                    <div class="col-xl-3 col-md-3 col-sm-3">
                        <a class="nav-link" target="_blank" href="<?php echo $row['link_url']; ?>">
                            <div class="card card-profile hover-affect-div div-shadow-mobile">
                                <img src="<?php if($row['image_url'] == ""){ echo "HolidayFriendAdmin/images/dashboard/media-carrier.jpg"; }else{ echo 'HolidayFriendAdmin/'.$row['image_url']; } ?>" alt="Image placeholder" class="card-img-top">
                                <div class="card-body" style="padding:0 !important;">
                                    <h5 class="h3 pl-2 pt-1">
                                        <?php if($row['title'] == ""){ echo "Media Carrier"; }else{ echo $row['title']; } ?>
                                    </h5>
                                </div>
                            </div>
                        </a>

                    </div>


                    <?php 
                        
                    }
                    ?>

                </div>



            </div>
        </div>

        <!-- Argon Scripts -->
        <!-- Core -->
        <script src="assets/vendor/jquery/dist/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>
        <?php  include 'util-js-files.php' ?>


    </body>

</html>
