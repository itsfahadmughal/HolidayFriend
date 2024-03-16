<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$pgl_id=0;
$image_urls=array();


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
if(isset($_GET['id'])){
    $pgl_id=$_GET['id'];
    //Images
    $sql3="SELECT img_url FROM `tbl_gallery_images` WHERE `pgl_id` = $pgl_id AND isactive = 1";
    $result3 = $conn->query($sql3);       
    if ($result3 && $result3->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result3)) {
            $url_image = $row1['img_url'];
            array_push($image_urls,$url_image);
        }}

}else{

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

        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <script src="assets/js/jquery.min.js"></script>
        <!-- Magnific Popup core JS file -->
        <script src="assets/js/jquery.magnific-popup.js"></script>

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
                        <h3 class="textstyle back-button" onclick="window.location = 'gallery'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <?php
    $sql_avb="SELECT * FROM `tbl_gallery` WHERE `pgl_id` = $pgl_id AND isactive = 1";
        $result = $conn->query($sql_avb);       
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                ?>
                <div class="row pt-3">
                    <div class="col-xl-8 col-md-8 col-sm-8">
                        <h1 class="textstyle"><?php echo $row['title'] ?></h1>
                    </div>
                </div>



                <div class="row bg-white">


                    <div class="col-xl-12 col-md-12 col-sm-12 p-3 bgfull-affect-div">
                        <p><?php echo $row['description'] ?></p>
                        <div class="row"><h3 class="inline-heading-block p-2 mobile_margin_none"> Share : </h3><a href="http://www.facebook.com/share.php?u=www.holidayFriend.com/gallerypage.php?id=<?php echo $pgl_id ?>" target="_blank"><i class="fab fa-facebook p-2 mobile_margin_none" style="font-size:30px;"></i></a><a href="https://web.whatsapp.com/send?text=www.holidayFriend.com/gallerypage.php?id=<?php echo $pgl_id ?>" target="_blank"><i class="fab fa-whatsapp p-2 mobile_margin_none" style="font-size:30px;"></i></a></div>
                    </div>

                </div>

                <?php }
        } ?>




                <div class="row mt-3">
                    <?php
                    for($i=0;$i<sizeof($image_urls);$i++) {
                    ?>
                    <div class="col-xl-3 col-md-3 col-sm-3 p-2">
                        <a class="galleryItem" href="HolidayFriendAdmin/<?php echo $image_urls[$i] ?>" > <img class="w-100 h-100 d-flex" src="HolidayFriendAdmin/<?php echo $image_urls[$i]; ?>"/></a>
                    </div>
                    <?php   
                    }
                    ?>
                </div>
            </div>
        </div>
        <script src="assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <!-- Argon Scripts -->
        <script src="assets/vendor/js-cookie/js.cookie.js"></script>
        <script src="assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
        <!-- Optional JS -->
        <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>
        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>

        <script>
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
        </script>
        <?php  include 'util-js-files.php' ?>


    </body>

</html>
