<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$cat_id=0;
$cat_name="";

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
        <title>Hotel - Ski Snow</title>
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
        <script>
            function categoryselected(val){
                window.location = 'slopes?cat_id='+val;
            }

        </script>

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
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>


                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-xl-12 col-md-12 col-sm-12 bg-white-opacity align-text-center p-3 scroll-bar-x-smallscreen div-shadow-mobile bgfull-affect-div">
                        <table class="w-100">
                            <tbody>
                                <?php

    $sql="SELECT a.*,c.measuring_unit FROM `tbl_skiing_snow_height` as a INNER JOIN tbl_util_measuring_units as c ON a.munit_id1=c.munit_id WHERE a.hotel_id=$hotel_id AND a.isactive=1";

        $skish_id=0;
        $i=1;
        $j=1;
        $k=1;
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                if($i==1){
                    $j=2;
                    $skish_id=$row['skish_id'];
                                ?>

                                <h1 class=" page-title-text" style="text-align:left;">Snow</h1>
                                <tr>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Name</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Station Height</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Snow Height</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Last Snowfall</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Last Snowfall Height</th>
                                </tr>

                                <?php
                }
                if($row['skish_id']==$skish_id){

                    $i=2;
                }
                                ?>

                            <?php if($row['skish_id']==$skish_id && $j==1){

                                }else{ ?>

                                <?php 
                                    $j=1;} ?>

                                <tr <?php if($k%2!=0){?> style="background-color:#e9e9e9" <?php } ?>>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['title'] ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3"><?php echo $row['station_height'].' '.$row['measuring_unit']  ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3"><?php echo $row['snow_height'].' '.$row['measuring_unit'] ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['last_snowfall_dt']; ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['last_snowfall_height'].' '.$row['measuring_unit'] ?></td>
                                </tr>


                                <?php
                                    $k++;
            }
        }
                                ?>

                            </tbody>
                        </table>

                    </div>
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
