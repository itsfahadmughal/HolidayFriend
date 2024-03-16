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
$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>Hotel - Information</title>
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
    </head>
    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                </div>

                <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 1";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 1";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                ?>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                    </div>
                </div>
                <?php 
                $sql="SELECT check_in_time,check_out_time from tbl_hotel where hotel_id=$hotel_id";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $check_in_time=$row['check_in_time'];
                        $check_out_time=$row['check_out_time'];

                        if($check_in_time != ""){
                            $check_in_time1 = (explode(":",$check_in_time));
                            $check_in_time = $check_in_time1[0].":".$check_in_time1[1];
                        }
                        if($check_out_time != ""){
                            $check_out_time1 = (explode(":",$check_out_time));
                            $check_out_time = $check_out_time1[0].":".$check_out_time1[1]; 
                        }

                    }
                }
                ?>
                <div class="row">

                    <?php if($check_in_time != ""){ ?>
                    <div class="col-xl-6 col-md-6 col-sm-6 mt-3">
                        <div class="bg-title  mr-3 ml-3 hover-affect-div bgfull-affect-div">
                            <div class="justify-content-between d-flex strip-background-gradient p-2">
                                <h1 class="text-white">Check-in</h1>
                                <h1 class="text-white"><span class="text-white" style="font-size:12px;">from</span><?php echo $check_in_time ?></h1>
                            </div>
                        </div>
                    </div>
                    <?php }
                    if($check_out_time != ""){
                    ?>
                    <div class="col-xl-6 col-md-6 col-sm-6 mt-3">
                        <div class="bg-title mr-3 ml-3 hover-affect-div bgfull-affect-div">
                            <div class="justify-content-between d-flex strip-background-gradient p-2">
                                <h1 class="text-white">Check-out</h1>
                                <h1 class="text-white"><span class="text-white" style="font-size:12px;">until</span><?php echo $check_out_time ?></h1>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                </div>

                <div class="row">
                    <?php 
                    $sql="SELECT `meal_title`, `meal_title_it`, `meal_title_de`, `from_time`, `to_time` FROM `tbl_hotel_meal_times` WHERE `hotel_id` = $hotel_id and isactive=1 ORDER BY position_order";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                    ?>
                    <div class="col-xl-6 col-md-6 col-sm-6 mt-3">
                        <div class="bg-title mr-3 ml-3 hover-affect-div bgfull-affect-div">
                            <div class="justify-content-between d-flex strip-background-gradient p-2">
                                <h1 class="text-white">Opening Times Restaurant</h1>
                            </div>
                        </div>
                        <div class="mr-3 ml-3 bg-white-opacity hover-affect-div bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12 mr-3 ml-3 pt-3">
                                <?php
                        while($row = mysqli_fetch_array($result)) {

                            $from_time1 = (explode(":",$row['from_time']));
                            $from_time = $from_time1[0].":".$from_time1[1];

                            $to_time1 = (explode(":",$row['to_time']));
                            $to_time = $to_time1[0].":".$to_time1[1];

                                ?>
                                <div class="justify-content-between d-flex pr-5 ml-3 mb--2"><h3><?php echo $row['meal_title']; ?>:</h3><p><?php echo $from_time; ?> - <?php echo $to_time; ?></p></div>
                                <?php
                        }

                                ?>
                            </div>
                        </div>
                    </div>

                    <?php }   
                    $sql="SELECT `service_title`, `service_title_it`, `service_title_de`, `from_time`, `to_time` FROM `tbl_hotel_wellness` WHERE `hotel_id` = $hotel_id and isactive=1 ORDER BY position_order";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                    ?>

                    <div class="col-xl-6 col-md-6 col-sm-6 mt-3">
                        <div class="bg-title  mr-3 ml-3 hover-affect-div bgfull-affect-div">
                            <div class="justify-content-between d-flex strip-background-gradient p-2">
                                <h1 class="text-white">Wellness</h1>
                            </div>
                        </div>
                        <div class="mr-3 ml-3 bg-white-opacity hover-affect-div bgfull-affect-div">
                            <div class="col-xl-12 col-md-12 col-sm-12 mr-3 ml-3 pt-3">
                                <?php
                        while($row = mysqli_fetch_array($result)) {

                            $from_time1 = (explode(":",$row['from_time']));
                            $from_time = $from_time1[0].":".$from_time1[1];

                            $to_time1 = (explode(":",$row['to_time']));
                            $to_time = $to_time1[0].":".$to_time1[1];
                                ?>
                                <div class="justify-content-between d-flex pr-5 ml-3 mb--2"><h3><?php echo $row['service_title']; ?>:</h3><p><?php echo $from_time; ?> - <?php echo $to_time; ?></p></div>
                                <?php
                        }

                                ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>


                </div>

                <div class="row">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <?php

                        $sql="SELECT `title`, `title_it`, `title_de`, `description`, `description_it`, `description_de`, `img_url` FROM `tbl_hotel_wall` WHERE `hotel_id` = $hotel_id and isactive=1 ORDER BY position_order";
                        $result = $conn->query($sql);
                        $count = ceil(($result->num_rows) / 3);
                        $i=1;
                        $j=1;

                        if ($result && $result->num_rows > 0) {
                            while($row = mysqli_fetch_array($result)) {
                                if($i <= $count){
                                    if($j==$result->num_rows && $j > 1){
                        ?>
                    </div>
                    <?php  break; } ?> 
                    <?php 
                                    $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                    if(!in_array($ext, $supported_image)){ ?>
                    <div class="mr-3 ml-3 mt-4">

                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-4">
                        <img  src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div bgfull-affect-div">
                        <div class="div-title-background-1">
                            <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>
                        </div>
                        <hr>
                        <div class="mobile-padding-information"><p><?php echo $row['description'] ?></p></div>
                    </div>
                    <?php
                                        $i++;
                                    $j++;
                                }else{
                    ?>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4">
                    <?php 
                                    $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                    if(!in_array($ext, $supported_image)){ ?>
                    <div class="mr-3 ml-3 mt-4">
                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-4">
                        <img src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div bgfull-affect-div">
                        <div class="div-title-background-1">
                            <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>
                        </div>
                        <hr>
                        <div class="mobile-padding-information"><p><?php echo $row['description'] ?></p></div>
                    </div>
                    <?php
                                        $i=2;
                                }
                    ?>



                    <?php
                            }
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
