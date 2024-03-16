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
$email="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT logo_url,bg_img_url,email from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $email=$row['email'];
    }
}
$s_item_id =0;
$image_url_id=0;
$title = "";
$dis ="";
$price ="";
$symbol ="";
$old_price ="";
$sold_out = 1;
$currency_id = 0;
$url_image= "";
$image_urls = array();
$discount = 0;
$duration= 0;
if(isset($_GET['id'])){
    $s_item_id=$_GET['id'];
    $sql="SELECT a.*,b.curr_id as  mcurr_id FROM tbl_treatment as a INNER JOIN tbl_hotel as b ON a.hotel_id=b.hotel_id WHERE a.`hotel_id` =  $hotel_id and a.isactive= 1 and a.wb_id = $s_item_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $title=$row['title'];
            $dis=$row['description']; 
            $price =$row['price'];
            $currency_id =$row['mcurr_id'];
            $url_image = $row['image_url'];
            $discount  = $row['discount'];
            $duration  = $row['duration'];

        }
    }
    //$image_urls = array_filter($image_urls, '');

    //Curancy
    $sql4="SELECT * FROM `tbl_currency` WHERE `curr_id` =  $currency_id";
    $result4 = $conn->query($sql4);       
    if ($result4 && $result4->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result4)) {
            $symbol = $row1['symbol'];

        }}

}
if(isset($_POST['submit'])){
    $your_name=$_POST['your_name'];
    $room_number=$_POST['room_number'];
    $number_of_people=$_POST['number_of_people'];
    $date=$_POST['request_date'];
    $time=$_POST['request_time'];
    $feedback_contact = $_POST['feedback_contact'];
    $other_notes = $_POST['othernotes'];
    $time  = date("H:i", strtotime($time));


    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");



    $sql1="INSERT INTO `tbl_treatment_requests`( `guest_name`, `guest_name_it`, `guest_name_de`, `room_num`, `attendees_count`, `booking_date`, `booking_time`, `feedback_type`, `feedback_type_it`, `feedback_type_de`, `feedback_contact`, `other_notes`, `other_notes_it`, `other_notes_de`, `wb_id`, `status_id`, `entryby_id`, `entryby_ip`, `entry_time`, `last_editby_id`, `last_editby_ip`, `last_edit_time`) 
    VALUES (
'$your_name','$your_name','$your_name','$room_number',$number_of_people,'$date','$time','Email','Email',
'Email','$feedback_contact',
'$other_notes','$other_notes','$other_notes',$s_item_id,1,$user_id,'$entryby_ip','$entry_time',$user_id,'$last_editby_ip',
'$last_edit_time')";

    $stmt = $conn->query($sql1);
    if($stmt){
        $from="";
        $from=$feedback_contact;

        $subject=$title." Treatment Request";
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message="Name : ".$your_name."<br>"."Room No : ".$room_number."<br>"."No Of Persons : ".$number_of_people."<br>"."Date : ".$date." Time : ".$time."<br>"."Contact : ".$feedback_contact."<br>"."Note : ".$other_notes;

        mail($email,$subject,$message,$headers);


        echo '<script>alert("The request has been sent!!!"); window.location.href = "treatments";</script>';    
    }else{
        echo '<script>alert("Something went wrong!!!");</script>';
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
        <title>Hotel - Treatment Details</title>
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
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

        <style>
            #imagewrap {
                position: relative;
            }
            .gallery img{
                border: 1px solid black;
            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
            #mborder-radius {
                border-radius: 7px;
            }
        </style>
        <style>
            *, *::before, *::after {
                box-sizing: inherit;
                margin: 0;
                padding: 0;
            }
        </style>
        <script>
            var toggle = function() {
                var mydiv = document.getElementById('newpost');
                if (mydiv.style.display === 'block' || mydiv.style.display === '')
                    mydiv.style.display = 'none';
                else
                    mydiv.style.display = 'block'
            }

        </script>
        <script>
            function feedbacktype(text){
                document.getElementById("feedback_text").innerHTML = text;
                myButton = document.getElementById("feedback_contact_id");
                if(text == "Your Email address:"){
                    myButton.type = "email"; 
                } 
                else{
                    myButton.type = "text"; 
                }  
            }
        </script>
    </head>
    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <h3 class="textstyle back-button" onclick="window.location = 'treatments'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                        <br>
                        <br>
                    </div>
                    <div class="col-xl-5 col-md-5 col-sm-5 mt--1">
                        <h2 class="textstyle"><?php 
    if($url_image != "") { echo $title;  }?></h2>
                    </div>
                </div>
                <?php  if($url_image == "") { ?> <div class="row"> <h2 class="textstyle"><?php echo $title; }?></h2></div>
                <div class="row">
                    <?php if($url_image != ""){ ?>
                    <div class ="col-xl-5 col-md-5 col-sm-5">
                        <img  src="HolidayFriendAdmin/<?php echo $url_image ?>" class="w-100">
                    </div>
                    <?php }?>
                    <!--                    Close here-->

                    <?php if($url_image != ""  ){?> <div class="col-xl-1 col-md-1 col-sm-1"></div><?php }?>
                    <div <?php if($url_image == ""  ){?>class ="col-xl-8 col-md-8 col-sm-8  div-shadow-mobile " <?php }else{?>class ="col-xl-6 col-md-6 col-sm-6   div-shadow-mobile" <?php }?> >
                        <div class="bg-white image-containe hover-affect-div bgfull-affect-div">
                            <div class="row">
                                <div class ="col-xl-12 col-md-12 col-sm-12 pt-3">
                                    <span><?php echo $dis ?></span>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class ="col-xl-12 col-md-12 col-sm-12">
                                    <span class="mb-3"><?php echo "Price: ".number_format($price).$symbol ?></span >
                                </div>
                            </div>
                            <?php if($duration != 0){
                            ?>
                            <div class="row">
                                <div class ="col-xl-12 col-md-12 col-sm-12 mb-3">
                                    <span ><?php echo "Duration: ".$duration." minutes" ?></span >
                                </div>
                            </div>
                            <?php }?>
                            <?php if($discount != 0){
                            ?>
                            <div class="row">
                                <div class ="col-xl-12 col-md-12 col-sm-12 mb-3">
                                    <span ><b><?php echo "- ".$discount."% discount

" ?></b></span >
                                </div>
                            </div>
                            <?php }?>
                            <?php if($sold_out==1){
    //Phone No
    $phone = "";
    $sqlp="SELECT `phone` FROM `tbl_hotel` WHERE `hotel_id` = $hotel_id";
    $resultp = $conn->query($sqlp);       
    if ($resultp && $resultp->num_rows > 0) {
        while($row0 = mysqli_fetch_array($resultp)) {
            $phone = $row0['phone'];

        }}
                            ?> 
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12" style="text-align:right;">
                                    <a    onclick="toggle();" class="btn  text-white button-background-color btn-primary mt-4 mb-3" href="javascript:void(0)">
                                        <i class="fa fa-envelope text-white"></i>  Request</a>
                                    <a class="btn  text-white button-background-color btn-primary mt-4 mb-3" href="tel:<?php echo $phone ?>">
                                        <i class="fa fa-phone text-white"></i></a>

                                </div>
                            </div>

                            <div id="newpost" Style ="display : none">
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Your name *</label>
                                                <input type="text" name="your_name" id="your_name_id" class="form-control" placeholder="Your name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-6  pr-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Room number *</label>
                                                <input type="text" name="room_number" id="room_number_id" class="form-control" placeholder="Room number" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Number of people</label>
                                                <select name="number_of_people" class="form-control">
                                                    <option value='1'>1</option>
                                                    <option value='2'>2</option>
                                                    <option value='3'>3</option>
                                                    <option value='4'>4</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6 col-md-6 col-sm-6  pr-2">
                                            <div class="form-group">
                                                <label class="form-control-label">Date</label>
                                                <input type="date" name="request_date" class="form-control" placeholder="Room number" required>

                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Desired time</label>
                                                <input type="time" name="request_time"  class="form-control" placeholder="Room number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" id="row_mobile">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-control-label" id="feedback_text">Your Email:</label>
                                                <input type="text" name="feedback_contact" id="feedback_contact_id" class="form-control" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="row_mobile">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-control-label">Other notes</label>
                                                <textarea type="text" name="othernotes" id="feedback_contact_id" class="form-control" placeholder="" ></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="custom-control custom-control-alternative custom-checkbox">
                                            <input class="custom-control-input" id="customCheckLogin" type="checkbox" required>
                                            <label class="custom-control-label" for="customCheckLogin">
                                                <span class="text-muted">I have read and accept the <a href="privacy">privacy policy</a></span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row mt-3 mb-3">
                                        <button type="submit" name="submit" value="Order" class="btn  text-white button-background-color btn-primary mb-3"><i class='fa fa-envelope text-white'></i> Request</button>
                                    </div>
                                </form>
                            </div>
                            <?php }?>
                            <!--                            Hear its end-->
                        </div>
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

        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>

        <script type="text/javascript">
            //initializing your javascript
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