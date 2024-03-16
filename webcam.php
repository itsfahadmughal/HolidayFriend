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
        <title>Webcam</title>
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
            .iframe-custom-design{
                overflow:hidden;
                border-radius: 5px;
                border:none;
            }
        </style>

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat scroll center center;" class="pb-6 bgimg">
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
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 22";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 22";
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
                <div class="row" class="bg-white" >
                    <?php
                    $sql="SELECT * FROM `tbl_webcams` WHERE `hotel_id` = $hotel_id and isactive=1 ORDER BY position_order";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <div class=" pr-3 pl-3 pt-3">
                            <iframe height="400" width="100%" scrolling="no" class="iframe-custom-design" src="<?php echo $row['webcam_url']; ?>">
                            </iframe>
                        </div>
                        <div class="bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 mt--2 hover-affect-div mobile_padding_none bgfull-affect-div" >
                            <div class="div-title-background-1">
                                <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>

                            </div>
                        </div>
                    </div>
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
