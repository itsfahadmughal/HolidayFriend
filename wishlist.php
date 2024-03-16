<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$id_counter = 0;
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
$id = 0;
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Wishlist</title>
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
            .image-container {
                position: relative;
            }
            .text-block {
                position: absolute;
                top: 10px;
                right: 0px;
                border-radius: 0px 3px 3px 0;
                color: white;
                padding-left: 15px;
                padding-right: 15px;
                display: inline-block;

            }
            .text-block3 {  
                position: absolute;
                left: -4px;
                color: white;
                border-radius: 0px 3px 3px 0;
                width: auto;
                padding-left: 20px;
                padding-right: 20px;
                display: inline-block;

            }
            .text-block1 {
                height: 150px;
                width: 120px;
                position: absolute;
                top: 0px;
                right: 0px;
                color: white;
                padding-left: 20px;
                padding-right: 20px;
                display: inline-block;

            }
            .inline-block{
                display: inline-block;
            }
            #recomandation{
                color:white;    
            }
            #recomandation:hover {
                color:white;
                text-decoration: underline;
            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
        </style>
        <style type="text/css">
            .value-button {
                display: inline-block;
                border: 1px solid #ddd;
                margin: 0px;
                width: 40px;
                height: 20px;
                text-align: center;
                vertical-align: middle;
                padding: 11px 0;
                background: #eee;
                -webkit-touch-callout: none;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }
            .value-button:hover {
                cursor: pointer;
            }
            #decrease{


            }
            .number {
                text-align: center;
                border: none;
                border-top: 1px solid #ddd;
                border-bottom: 1px solid #ddd;
                margin: 0px;
                width: 30px;
                height: 30px;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            } margin: 0;
        </style>

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center;" class="pb-6 bgimg">
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
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 25";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 25";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                    ?>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mt-3 p-3">
                        <a href="wishlist_detail.php">
                            <div class=" bg-white pt-4 pb-4 bgfull-affect-div">
                                <h2 class="text-center textstyle">All Categories</h2>
                            </div>
                        </a>
                    </div>
                    <?php
                    $title = "";
                    $sql="SELECT DISTINCT a.`wilc_id`,b.title FROM `tbl_wish_item` as a INNER JOIN tbl_wishlist_category as b ON a.`wilc_id`=b.`wilc_id` WHERE a.`hotel_id` = $hotel_id and a.isactive=1";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            $title= $row['title'];
                            $id= $row['wilc_id'];

                    ?>
                    <div class="col-md-4 mt-3 p-3">
                        <a href="wishlist_detail.php?id=<?php echo $id; ?>">
                            <div class=" bg-white pt-4 pb-4 bgfull-affect-div">
                                <h2 class="text-center textstyle"><?php echo $title; ?></h2>
                            </div>
                        </a>
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
