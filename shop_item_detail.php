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
$item_name = "";
$dis ="";
$price ="";
$symbol ="";
$old_price ="";
$sold_out = 0;
$currency_id = 0;
$image_urls= array();
$discount = 0;
if(isset($_GET['id'])){
    $s_item_id=$_GET['id'];
    $sql="SELECT a.*,b.category,c.curr_id AS mcurr_id FROM tbl_shop_items as a INNER JOIN tbl_shop_items_category as b ON a.shc_id=b.shc_id INNER JOIN tbl_hotel  as c ON c.hotel_id=a.hotel_id  WHERE a.`hotel_id` =  $hotel_id and a.isactive= 1 and a.shi_id = $s_item_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $item_name=$row['item_name'];
            $dis=$row['description'];
            $price =$row['price'];
            $currency_id =$row['mcurr_id'];
            $sold_out =$row['in_stock'];
        }
    }


    //Images
    $sql3="SELECT  `img_url` FROM `tbl_shop_items_gallery` WHERE `shi_id` = $s_item_id";
    $result3 = $conn->query($sql3);       
    if ($result3 && $result3->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result3)) {
            $url_image = $row1['img_url'];
            array_push($image_urls,$url_image);
        }}
    //Curancy
    $sql4="SELECT * FROM `tbl_currency` WHERE `curr_id` =  $currency_id";
    $result4 = $conn->query($sql4);       
    if ($result4 && $result4->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result4)) {
            $symbol = $row1['symbol'];

        }}
    //Discount;
    $sql4="SELECT  `discount` FROM `tbl_shop_item_discount_t` WHERE `shi_id` = $s_item_id";
    $result4 = $conn->query($sql4);       
    if ($result4 && $result4->num_rows > 0) {
        while($row1 = mysqli_fetch_array($result4)) {
            $discount = $row1['discount'];

        }}
}
if(isset($_POST['submit'])){
    $your_name=$_POST['your_name'];
    $room_number=$_POST['room_number'];
    $quantity=$_POST['quantity'];
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;

    $sql1="INSERT INTO `tbl_shop_items_request_t`( `name`, `name_it`, `name_de`, `room_no`, `quantity`, `shi_id`, `status_id`, `hotel_id`, `entryby_ip`, `entry_time`) 
    VALUES ('$your_name','$your_name','$your_name','$room_number',$quantity,$s_item_id,1,$hotel_id,
        '$entryby_ip',' $entry_time')";

    $stmt = $conn->query($sql1);
    if($stmt){
        $subject=$item_name." Shop Item Order";
        $headers = "From: " . strip_tags($your_name) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message="Name : ".$your_name."<br>"."Room No : ".$room_number."<br>"."Item Name : ".$item_name."<br>"."Quantity : ".$quantity."<br>"."Time : ".$entry_time;
        
        mail($email,$subject,$message,$headers);
        
        echo '<script>alert("Order has been submitted!!!"); window.location.href = "shop";</script>';    
    }else{
        echo '<script>alert("Something Went Wrong!!!");</script>';
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
        <title>Hotel - Item Detail</title>
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
        <style>
            .gallery img{
                border: 1px solid black;
            }
            .image-container {
                position: relative;
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

            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
        </style>

        <style>
            ul.images {
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: row;
                width: 900px;
                overflow-x: auto;
            }

            ul.images li {
                flex: 0 0 auto;
                width: 150px;
                height: 150px;
            }

            ol, ul { list-style: none }

            *, *::before, *::after {
                box-sizing: inherit;
                margin: 0;
                padding: 0;
            }

            .container_slider {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
            }

            .thumbnails {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                line-height: 0;  
                height: 400px;
                width: 100px;
            }

            .thumbnails li {
                -webkit-box-flex: 1;
                -ms-flex: auto;


            }

            .thumbnails a { display: block; }

            .thumbnails img {
                width: 12vmin;
                height: 10vmin;
                -o-object-fit: cover;
                object-fit: cover;
                -o-object-position: top;
                object-position: top;
            }

            .slides { overflow: hidden; }



            .slides li {
                position: absolute;
                z-index: 1;
            }
            @-webkit-keyframes 
            slide {  0% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                }
                100% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                }
            }
            @keyframes 
            slide {  0% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                }
                100% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                }
            }

            .slides li:target {
                z-index: 3;
                -webkit-animation: slide 1s 1;
            }
            @-webkit-keyframes 
            hidden {  0% {
                z-index: 2;
                }
                100% {
                    z-index: 2;
                }
            }
            @keyframes 
            hidden {  0% {
                z-index: 2;
                }
                100% {
                    z-index: 2;
                }
            }

            .slides li:not(:target) { -webkit-animation: hidden 1s 1; }
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
                        <h3 class="textstyle back-button" onclick="window.location = 'shop'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                    <div class="col-xl-5 col-md-5 col-sm-5 mt--1">
                        <h2 class="textstyle"><?php $length = count($image_urls);
        if($length!=0) {echo $item_name ;} ?></h2>
                    </div>
                </div>
                <?php  if($length==0) { ?> <div class="row"> <h2 class="textstyle"><?php echo $item_name; ?></h2></div> <?php }?>
                <div class="row">
                    <?php if($length!=0){ ?>
                    <div class ="col-xl-5 col-md-5 col-sm-5">
                        <div class="row m-0">
                            <div class="col-xl-9 col-md-9 col-sm-9">
                                <ul class="slides">
                                    <?php

    for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li id="slide<?php echo $x+1 ?>" class="d-flex">
                                        <a class="galleryItem" href="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>"> <img  src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" class="w-100 h-100 d-flex"> </a> 
                                    </li>

                                    <?php
    }
                                    ?>

                                </ul>
                            </div>


                            <div class="col-xl-3 col-md-3 col-sm-3 mt-10" id="slider_event_images_mobile"  style="bottom:0px;display:none;">

                                <ul class="images w-100" <?php if($length > 4){ ?> style ="overflow-y: scroll" <?php }?>>
                                    <?php
    for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li class="w-25 h-25"> <a href="#slide<?php echo $x+1 ?>"><img class="w-100 h-100" src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" /></a> </li>
                                    <?php
    }

                                    ?>
                                </ul>

                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3" id="slider_event_images_desktop">
                                <ul class="h-40" <?php if($length > 4){ ?> style ="overflow-y: scroll" <?php }?>>
                                    <?php
    for ($x = 0; $x < $length; $x++) {
                                    ?>
                                    <li> <a href="#slide<?php echo $x+1 ?>"><img class="w-100 h-100" src="HolidayFriendAdmin/<?php echo $image_urls[$x] ?>" /></a> </li>
                                    <?php
    }

                                    ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                    <?php }else{

}    ?>
                    <!--                    Close here-->

                    <?php if($length != 0 ){?> <div class="col-xl-1 col-md-1 col-sm-1"></div><?php }?>

                    <div <?php if($length == 0 ){?>class ="col-xl-8 col-md-8 col-sm-8  div-shadow-mobile " <?php }else{?>class ="col-xl-6 col-md-6 col-sm-6   div-shadow-mobile" <?php }?> >
                        <div class="bg-white image-containe hover-affect-div bgfull-affect-div">
                            <div class="text-block1">
                                <?php if($sold_out!=0){ ?>
                                <?php
}else{
                                ?>      
                                <img height="90%" width="90%" src="assets/img/icons/sold.png" />
                                <?php
} ?>
                            </div>
                            <div class="row">
                                <div class ="col-xl-12 col-md-12 col-sm-12 pt-3">
                                    <span><?php echo $dis ?></span>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class ="col-xl-12 col-md-12 col-sm-12">
                                    <span class="mb-3"><?php echo "Price: ".$price.$symbol ?></span >
                                </div>
                            </div>
                            <?php if($discount != 0){
                            ?>
                            <div class="row">
                                <div class ="col-xl-12 col-md-12 col-sm-12 mb-3">
                                    <span ><b><?php echo "- ".$discount."%" ?></b></span >
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
                                        <i class="ni ni-cart text-white"></i>  Order</a>
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
                                                <label class="form-control-label">Quantity</label>
                                                <select name="quantity" class="form-control">
                                                    <option value='1'>1</option>
                                                    <option value='2'>2</option>
                                                    <option value='3'>3</option>
                                                    <option value='4'>4</option>
                                                    <option value='5'>5</option>
                                                    <option value='6'>6</option>
                                                    <option value='7'>7</option>
                                                    <option value='8'>8</option>
                                                    <option value='9'>9</option>
                                                    <option value='10'>10</option>
                                                    <option value='11'>11</option>
                                                    <option value='12'>12</option>
                                                    <option value='13'>13</option>
                                                    <option value='14'>14</option>
                                                    <option value='15'>15</option>
                                                    <option value='16'>16</option>
                                                    <option value='17'>17</option>
                                                    <option value='18'>18</option>
                                                    <option value='19'>19</option>
                                                    <option value='20'>20</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <p><?php echo "You can pay the amount of ".$symbol." ".$price.
                                " easily together with the bill of your stay. The order will be prepared at the reception on the day of your departure."
                                                ?>
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
                                        <button type="submit" name="submit" value="Order" class="btn  text-white button-background-color btn-primary mb-3"><i class='ni ni-cart text-white '></i> Order</button>
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