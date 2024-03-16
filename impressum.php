<?php
include 'util-config.php';

function getIPAddress() {  
    //whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    //whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$phone="";
$name="";
$description="";
$address="";
$email="";
$web="";
$imprint="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT a.hotel_name,a.description,a.address,a.email,a.web_url,a.logo_url,a.bg_img_url,a.phone,b.imprint from tbl_hotel as a LEFT OUTER JOIN tbl_hotel_more_detail as b on a.hotel_id=b.hotel_id where a.hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $phone=$row['phone'];
        $name=$row['hotel_name'];
        $description=$row['description'];
        $address=$row['address'];
        $email=$row['email'];
        $web=$row['web_url'];
        $imprint=$row['imprint'];
    }
}
$bg_btn_color="";
$sql1="SELECT btn_color_code from tbl_hotel_more_detail where hotel_id=$hotel_id";
$result1 = $conn->query($sql1);
if ($result1 && $result1->num_rows > 0) {
    while($row = mysqli_fetch_array($result1)) {
        $bg_btn_color=$row['btn_color_code'];
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
        <title>Imprint</title>
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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <script src="assets/js/jquery.min.js"></script>
        <!-- Magnific Popup core JS file -->
        <script src="assets/js/jquery.magnific-popup.js"></script>

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="container-fluid mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row mb--3">
                    <div class="col-xl-7 col-md-7 col-sm-7 pl-2">
                        <h2 class="textstyle">Imprint</h2>
                    </div>
                </div>

                <div class="row">

                    <div class ="col-xl-12 col-md-12 col-sm-12 mt-2 p-4 mobile_padding_none bg-white-opacity bgfull-affect-div">
                        <h3><?php echo $name; ?></h3>
                        <p><?php echo $address; ?></p>
                        <p>Tel: <?php echo $phone; ?></p>
                        <p>Email: <?php echo $email; ?></p>
                   <p>Web: <a href="<?php echo $web; ?>" target="_blank" style="color:#6F6F6E;" ><?php echo $web; ?></a></p>
                        <p><?php echo $imprint; ?></p>
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
        <script type="text/javascript">
            var y = document.getElementsByClassName("text-primary1");
            var str = "<?php echo $bg_btn_color ?>";
            if(str == ""){
                for (i = 0; i < y.length; i++) {
                    y[i].style.color = "#172b4d";
                }
            }
            else{
                for (i = 0; i < y.length; i++) {
                    y[i].style.color = str;
                }
            }
        </script>


        <?php  include 'util-js-files.php' ?>
    </body>

</html>