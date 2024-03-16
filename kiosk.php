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
if(isset($_GET['cat_id'])){
    $cat_id=$_GET['cat_id'];
    $sql="SELECT category FROM `tbl_kiosk_category` WHERE kcat_id=$cat_id";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $cat_name=$row['category'];
        }
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
        <title>Hotel - Kiosk</title>
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
                window.location = 'kiosk?cat_id='+val;
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
                        <h3 class="textstyle back-button" onclick="window.location = 'content'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h1 class="textstyle"><?php
    $sql="SELECT * FROM  tbl_kiosk_rename WHERE hotel_id=$hotel_id";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            echo $row['title'];
        }else{
            echo 'Kiosk';
        }
                            ?><?php if($cat_name!=""){echo " - ".$cat_name; } ?></h1>
                    </div>


                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>

                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <span class="category-select">
                            <h3 class="textstyle" style="display:inline;">Category: </h3>
                            <select onchange="categoryselected(this.value)">
                                <option value="0">All</option>
                                <?php 

                                $sql="SELECT * FROM `tbl_kiosk_category` ";

                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($cat_id==$row[0]){
                                            echo '<option selected value='.$row[0].'>'.$row[1].'</option>';
                                        }else{
                                            echo '<option value='.$row[0].'>'.$row[1].'</option>';    
                                        }

                                    }
                                }
                                ?>
                            </select>
                        </span>
                    </div>

                </div>

                <div class="row mt-4">

                    <?php
                    if($cat_id==0){
                        $sql="SELECT * FROM `tbl_kiosk` WHERE `hotel_id` = $hotel_id AND `isactive` = 1 ORDER BY position_order";
                    }else{
                        $sql="SELECT * FROM `tbl_kiosk` WHERE `hotel_id` = $hotel_id AND `isactive` = 1 AND kcat_id=$cat_id ORDER BY position_order";
                    }

                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="col-xl-3 col-md-3 col-sm-3">
                        <a class="nav-link" href="./show?id=<?php echo $row[0] ?>" target="_blank">
                            <div class="card card-profile hover-affect-div">
                                <img src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" style="max-height:300px;" alt="Image placeholder" class="card-img-top card-img-bottom div-shadow-mobile">
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
