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
        <title>Custom Module</title>
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

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                        <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 12";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 12";
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
                    <div class="col-xl-4 col-md-4 col-sm-4   div-shadow-mobile mb-1">
                        <?php

    $sql="SELECT * FROM `tbl_items` WHERE `hotel_id` = $hotel_id AND isactive=1 Order By position_order";



        $result = $conn->query($sql);
        $count = ceil(($result->num_rows) / 3);
        $i=1;
        $j=1;

        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $id=$row['item_id'];
				 $link_url=$row['link_url'];
                $img_url="";
                $sql_inner="SELECT img_url FROM `tbl_items_gallery` where item_id=$id";
                $result_inner = $conn->query($sql_inner);

                if ($result_inner && $result_inner->num_rows > 0) {
                    while($row_inner = mysqli_fetch_array($result_inner)) {
                        $img_url=$row_inner['img_url'];
                    }
                }

                if($i <= $count){
                    if($j==$result->num_rows && $j > 1){
                        ?>
                    </div>
                    <?php  break; } ?> 
                    <?php 
                    $ext = strtolower(pathinfo($img_url, PATHINFO_EXTENSION));
                    if(!in_array($ext, $supported_image)){ ?>
                    <div class="mr-3 ml-3 mt-4">

                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-4 pointer" onclick="show_details('<?php echo $link_url; ?>',<?php echo $id; ?>)">
                        <img src="HolidayFriendAdmin/<?php echo $img_url; ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity bg-affect-div div-shadow-mobile mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div pointer" onclick="show_details('<?php echo $link_url; ?>',<?php echo $id; ?>)">
                        <div class="div-title-background">
                            <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>
                        </div>

                        <hr class="m-0 mb-3">
                        <p><?php echo substr($row['description'],0,200); ?> [...]</p>
                    </div>
                    <?php
                    $i++;
                    $j++;
                }else{
                    ?>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 div-shadow-mobile mb-1">
                    <?php 
                    $ext = strtolower(pathinfo($img_url, PATHINFO_EXTENSION));
                    if(!in_array($ext, $supported_image)){ ?>
                    <div class="mr-3 ml-3 mt-4">

                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-4 pointer" onclick="show_details('<?php echo $link_url; ?>',<?php echo $id; ?>)">
                        <img src="HolidayFriendAdmin/<?php echo $img_url ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity bg-affect-div  mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div pointer" onclick="show_details('<?php echo $link_url; ?>',<?php echo $id; ?>)">
                        <div class="div-title-background">
                            <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>
                        </div>
                        <hr class="m-0 mb-3">
                        <p><?php echo substr($row['description'],0,200); ?> [...]</p>
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

        <script>
            function show_details(value,id){
                if(value==""){
                    window.location = "customentity-show?id="+id;
                }else{
                    window.location = "customentity-link?id="+id;
                }
            }
        </script>
        <?php  include 'util-js-files.php' ?>
    </body>

</html>
