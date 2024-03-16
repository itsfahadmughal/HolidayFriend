<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$hotel_name="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT logo_url,bg_img_url,hotel_name from tbl_hotel where hotel_id=$hotel_id and isactive=1";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $hotel_name=$row['hotel_name'];
    }
}else{
    echo "<script>alert('Hotel Not Found.');</script>";
    exit;
}

$user_id=$_SESSION['user_id'];

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
            .iframe-custom-design{
                overflow:hidden;
                border-radius: 5px;
                border:none;
            }
        </style>
        <style>
            .responsive-height{
                height: 180px;
            }
            @media (min-width: 275px) and (max-width: 767px) {
                .responsive-height-mobile{
                    height: 100% !important;
                }
            }
        </style>

    </head>

    <body class="bgimg" style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>
            <div class="container-fluid mt-4 mobile-padding-top-covid">

                <div class="row p-2 pointer">
                    <div class="col-xl-12 col-md-12 col-sm-12 pl-4 pr-3 pt-2 pb-2 backgroundstyle" >
                        <h1 class="m-0" style="color:6F6F6E;">Welcome in the <?php echo $hotel_name; ?></h1>
                    </div>
                </div>

                <div class="row">


                    <?php
                    $sql="SELECT a.*,b.* FROM tbl_user_module_map as a INNER JOIN tbl_util_modules as b ON a.umod_id=b.umod_id WHERE a.user_id=$user_id and a.isactive=1 order by position_order";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                    <div class="col-xl-3 col-md-3 col-sm-3">
                        <a class="nav-link" href="<?php echo $row['main_url']; ?>">
                            <div class="card card-profile hover-affect-div">

                                <?php if($row['module_img']==""){ ?>

                                <img src="HolidayFriendAdmin/images/dashboard/<?php echo str_replace(" ","-",$row['module_name']); ?>.jpg" alt="Image placeholder" class="card-img-top 
                                 responsive-height-mobile">

                                <?php }else{ ?>

                                <img src="HolidayFriendAdmin/<?php echo $row['module_img']; ?>" alt="Image placeholder1" class="card-img-top  responsive-height-mobile">

                                <?php } ?>

                                <div class="card-body" style="padding:0 !important;">
                                    <h6 class="h4 pl-2 pt-1">
                                        <?php if($row['user_module_name']==""){echo $row['module_name']; }else{echo $row['user_module_name']; } ?>
                                    </h6>
                                </div>
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
