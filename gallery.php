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
        <title>Hotel - Photogallery</title>
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
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 9";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 9";
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

                <?php
                $sql_avb="SELECT * FROM `tbl_gallery` WHERE `hotel_id` = $hotel_id AND isactive = 1 ORDER BY position_order";
                $result = $conn->query($sql_avb);       
                if ($result && $result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $id=$row['pgl_id'];
                ?>

                <div class="row bg-white bgfull-affect-div mt-2">

                    <?php
                        $img_url="";
                        $count="";
                        $sql_inner="SELECT count(*) as total, img_url FROM `tbl_gallery_images` WHERE `pgl_id` = $id AND isactive = 1";
                        $result_inner = $conn->query($sql_inner);       
                        if ($result_inner && $result_inner->num_rows > 0) {
                            while($row_inner = mysqli_fetch_array($result_inner)) {
                                $img_url=$row_inner['img_url'];
                                $count=$row_inner['total'];
                            }
                        }
                    ?>
                    <div class="col-xl-3 col-md-3 col-sm-3">
                        <a href="gallerypage.php?id=<?php echo $id; ?>"><img class="w-100 h-100" src="HolidayFriendAdmin/<?php echo $img_url; ?>" /></a>
                    </div>
                    <div class="col-xl-9 col-md-9 col-sm-9 p-3">

                        <a href="gallerypage.php?id=<?php echo $id; ?>"><h1><?php echo $row['title'] ?></h1></a>
                        <p>Images : <?php echo $count; ?> Pc's</p>
                        <p><?php echo $row['description'] ?></p>

                        <div class="row"><h3 class="inline-heading-block mt-4 p-3 mobile_margin_none"> Share : </h3><a href="http://www.facebook.com/share.php?u=www.holidayFriend.com/gallerypage.php?id=<?php echo $id ?>" target="_blank"><i class="fab fa-facebook p-2 mt-4 mobile_margin_none" style="font-size:40px;"></i></a><a href="https://web.whatsapp.com/send?text=www.holidayFriend.com/gallerypage.php?id=<?php echo $id ?>" target="_blank"><i class="fab fa-whatsapp p-2 mt-4 mobile_margin_none" style="font-size:40px;"></i></a></div>

                    </div>

                </div>

                <?php }
                } ?>

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
