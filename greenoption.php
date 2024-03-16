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
$email="";
if(session_id()==''){
    session_start();
}

include 'util-session.php';

$sql="SELECT logo_url,bg_img_url,phone,email from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $phone=$row['phone'];
        $email=$row['email'];
    }
}

if(isset($_POST['submit'])){
    $name=$_POST['input_name'];
    $room=$_POST['input_room'];
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $sql="INSERT INTO `tbl_greenoption`(`name`, `room_number`, `hotel_id`, `entrybytime`, `entrybyip`, `status_id`) VALUES ('$name','$room',$hotel_id,'$entry_time','$entryby_ip',1)";

    $stmt = $conn->query($sql);

    if(!$stmt){
        echo '<script>alert("Something went wrong!!!");</script>';
    }else{  
        $from=$name;
        $subject="Green Options";
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message="Do without cleaning tomorrow "."<br>"."Name : ".$name."<br>"."Room No : ".$room;
        mail($email,$subject,$message,$headers);
        echo '<script>alert("Your selection for tomorrow has been submitted!!!"); window.location.href = "index"; </script>';
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
        <title>Green Option</title>
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
            .badge{
                width: 160px;
                position: absolute;
                right: 15px;
                top: 15px;
            }
        </style>



    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>
            
            <div class="container-fluid mt-3">
                <div class="mobile_height_blank"></div>
                <!--                back-arrow-img-->
                <div class="row">
                    <div class ="col-xl-2 col-md-2 col-sm-2"></div>
                    <div class="col-xl-5 col-md-5 col-sm-5">
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class ="col-xl-2 col-md-2 col-sm-2"></div>

                    <div class ="col-xl-8 col-md-8 col-sm-8 mt-2 pr-3 pl-3 pb-3 mobile_padding_none">
                        <div class="mr-3 ml-3 mt-4">
                            <img src="../HolidayFriend/assets/img/icons/green.jpg" alt="" class="card-img-top">
                        </div>

                        <div class="bg-white-opacity mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-4 bg-affect-div">
                            <form method="post">
                                <div class="row m-0 bg-white-opacity pt-3 pr-3 pl-3 pb-3 div-shadow-mobile" id="order_div">
                                    <div class="col-xl-12 col-md-12 col-sm-12 align-text-center">
                                        <h3>Green Option - Cancel room cleaning</h3>
                                        <p>Are you staying longer than one night? Help us to reduce the <br> environmental impact and postpone the daily room cleaning.</p>
                                    </div>

                                    <div class="col-xl-12 col-md-12 col-sm-12 align-text-center" style="display:none;" id="submitted_message">
                                        <p class="btn w-75" href="javascript:void(0)" style="background:rgba(100,146,73,.4);color:#3c763d;">Your selection for tomorrow has been submitted</p>
                                    </div>

                                    <div class="col-xl-12 col-md-12 col-sm-12 align-text-center" id="yes_button" onclick="yesclicked()">
                                        <a class="btn w-75" href="javascript:void(0)" style="background:rgba(100,146,73,.4);color:#3c763d;"><h3 style="left:0px;color:#fff;display:inline;">Yes! </h3> Do without cleaning tomorrow</a>
                                    </div>
                                    <div class="col-xl-12 col-md-12 col-sm-12 align-text-center mt-3" id="no_button" onclick="noclicked()">
                                        <a class="btn w-75" href="javascript:void(0)" style="background:hsla(0,0%,56.5%,.4);color:#4a4a4a;"><h3 style="left:0px;color:#fff;display:inline;">No! </h3> Please clean my room today</a>
                                    </div>



                                    <div class="col-xl-2 col-md-2 col-sm-2" id="field1" style="display:none;">

                                    </div>
                                    <div class="col-xl-5 col-md-5 col-sm-5" id="field2" style="display:none;">
                                        <div class="form-group p-2">
                                            <input type="text" name="input_name" class="form-control" placeholder="Name" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-md-3 col-sm-3" id="field3" style="display:none;">
                                        <div class="form-group p-2">
                                            <input type="text" name="input_room" class="form-control" placeholder="Room" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-md-2 col-sm-2" id="field4" style="display:none;">

                                    </div>

                                    <div class="col-xl-12 col-md-12 col-sm-12 p-1 align-text-center search_event_by_date_desktop" id="field5" style="display:none;">
                                        <input style="background:#649249;color:#fff;" type="submit" name="submit" value="I don't want cleaning tomorrow" class="btn w-70 mobile-width-btn" />
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                    <div class ="col-xl-2 col-md-2 col-sm-2"></div>

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
            var msg=document.getElementById("submitted_message");
            var yesbtn=document.getElementById("yes_button");
            var nobtn=document.getElementById("no_button");
            var f1=document.getElementById("field1");
            var f2=document.getElementById("field2");
            var f3=document.getElementById("field3");
            var f4=document.getElementById("field4");
            var f5=document.getElementById("field5");

            function noclicked(){
                yesbtn.style="display:none;";
                nobtn.style="display:none;";
                msg.style="display:block;";
            }

            function yesclicked(){
                yesbtn.style="display:none;";
                nobtn.style="display:none;";
                f1.style="display:block;";
                f2.style="display:block;";
                f3.style="display:block;";
                f4.style="display:block;";
                f5.style="display:block;";
            }

        </script>
        <?php  include 'util-js-files.php' ?>
    </body>

</html>