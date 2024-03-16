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
$privacy="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT a.logo_url,a.bg_img_url,a.phone,b.privacy_policy from tbl_hotel as a LEFT OUTER JOIN tbl_hotel_more_detail as b on a.hotel_id=b.hotel_id where a.hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $phone=$row['phone'];
        $privacy=$row['privacy_policy'];
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
        <title>Privacy</title>
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
                        <h2 class="textstyle">Privacy &amp; Cookies</h2>
                    </div>
                </div>

                <div class="row">

                    <div class ="col-xl-12 col-md-12 col-sm-12 mt-2 p-5 mobile_padding_none bg-white-opacity bgfull-affect-div">

                        <h2>Privacy Policy</h2>
                        <p>The use of “we”, “us”, or “our” in this Privacy Policy refers to the company.</p>

                        <h2>General</h2>
                        <p>We take the protection of your personal information very seriously. Your personal information will be treated in accordance with the provisions of data protection under law. This privacy policy informs you of the purposes for which your personal information is processed, the duration of the processing, the corresponding legal basis, and if applicable the categories of recipients, your privacy rights (the so-called “rights of the person affected”), and other circumstances of privacy rights with the processing of your personal information. As a rule, the use of our website is possible without providing personal information. If you are asked to provide personal information (such as your name, address, or e-mail address), this always takes place on a voluntary basis,, in particular as a result of your browser settings or because it is technically necessary. The following sections will indicated in detail which personal information is processed.</p>

                        <h2>Legal Basis and Duration of the Processing for Bookings</h2>
                        <p>Providing personal information within the framework of bookings is necessary because otherwise, the agreed upon services cannot be provided. The legal basis for the aforementioned data processing is the fulfillment of the agreed upon services for which the party is the affected person or else for which the processing fulfills a legal obligation (Art. 6, Sec. 1, subsec. b and c of the General Data Protection Regulation (GDPR). The data are processed and/or stored until they are no longer applicable.</p>

                        <h2>Data that We Collect Automatically</h2>
                        <p>When you visit our website (or apps), it is possible that we process some data automatically. This possible data could include: the IP address, date, and time of your visit; your hardware, software, and/or browser type, the operating system of your computer, the version of an app, your language settings, and information about clicks and which sites you visited. If you use our services with your mobile device, it is possible that we process some further data: the type of your mobile device and operating system, device-specific settings and properties, your geographical location, information about app crashes, and other system activities. The legal basis for this processing is the fulfillment of the agreed upon services or the technical necessity of the processing or of our legitimate interests, namely, traceability and optimization of our services, whereby the interests or basic rights of the affected party do not take precedence (Art. 6, Sec. 1, subsec. f of the GDPR). Within the context of the latter legal justification, the affected person has a right to object with an interest taking precedence; for details, see the rights of the affected party below. The data are processed and/or stored until the cited purpose is no longer applicable.</p>

                        <h2>Processing Partners, Recipients</h2>
                        <p>We process your personal information with the support of processing partners which support us by providing our services (such as web hosting, e-mail newsletter distribution, etc.) These processing partners are obligated to strictly protect your personal information and may not use your personal information for any purpose other than providing our services. Furthermore, your personal information will only be passed on to service providers that are typical within business such as banks (if you receive money transfers), tax advisors (if you are part of our accounting), distributors (if you receive mail from us), etc. which, on their part, are subject to the provisions under privacy laws.</p>

                        <h2>Hotel Privacy Policy</h2>
                        <p><?php echo $privacy; ?></p>

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