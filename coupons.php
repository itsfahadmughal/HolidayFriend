<?php
//require_once("Sessions.php");
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
$errorComment="";

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




if(isset($_POST["Submit"]))
{

    $GuestName  = $_POST["yourName"];
    $RoomNo     = $_POST["roomNo"];
    $Receiver   =$_POST["receivedBy"];
    $Amount     =$_POST["amount"];
    $Comments   = $_POST["message"]; //Personal Message
    $ip  = getIPAddress();

    $OrderQuery="INSERT INTO `tbl_coupon_request`
                                (`guest_name`, `guest_name_it`, `guest_name_de`, `room_num`,
                                  `recipient_name`, `recipient_name_it`, `recipient_name_de`, `amount`,
                                  `comments`, `comments_it`, `comments_de`, `entry_byip`, `status_id`, `hotel_id`)
                                  VALUES
                                  ('$GuestName', '$GuestName', '$GuestName', '$RoomNo',
                                     '$Receiver', '$Receiver', '$Receiver', '$Amount',
                                     '$Comments', '$Comments', '$Comments', '$ip', '1', $hotel_id )";
    $MakeQuery = $conn->prepare($OrderQuery);
    $Execute=$MakeQuery->execute();

    if($Execute)
    {
        echo '<script>alert("Coupon reserved, now it can be redeemed.Please Click Button"); window.location.href = "coupons.php";</script>';

    }
    else
    {
        echo '<script>alert("Something went wrong, plz refresh the page and try again");</script>';
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
        <title>Coupons</title>
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

            .textSizeSmall{
                font-size:15px;
            }

            p{
                font-family: Montserrat, "Helvetica Neue", Helvetica, Arial, sans-serif;
                style:normal;
                weight:100;
                size:10px;
                line-height: 21px;
                color: #4a4a4a
            }

            .textSizeMedium{
                font-size:14px;

            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }

            .underline{
                width:300px;
                height:1px;
                background-color:gray;
            }
            .underline2{
                width:380px;
                height:1px;
                background-color:gray;
            }
            .priceElement{
                border-top: 5px solid #c5c5d8 ;
                /* color:c5c5d8 */
                float:right;
            }
            .Outer{
                border:4px solid #F9FAFA;
            }



        </style>
    </head>

    <body class="bgimg" style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)
                               no-repeat fixed center center;" >
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content mb-4" id="panel">
            <?php  include 'util-header.php' ?>

 <div class="mobile_height_blank"></div>
            <div class="row mt-3">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                </div>
            </div>
                         <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 16";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 16";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                ?>
            <div class="row pt-3">
                <div class="col-xl-4 col-md-4 col-sm-4">
                    <h1 class="textstyle back-button"><?php echo $moduleName; ?></h1>
                </div>
            </div>


            <div class="row bg-white-opacity bgfull-affect-div">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pb-4 pt-2">
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 pl-2  mb-4 pt-3 mobile_margin_padding_none" style="letter-spacing: 0; font-size: 14px; ">

                                <p>The perfect gift - order easily and comfortable:<br>
                                    Please fill out and send the order form. You can pick up the gift voucher at the reception; the billing will be done at your departure.</p>

                            </div>
                        </div>       <!-- Row END -->

                        <div class="row">    <!--Grid Row Div-->
                            <div class=" form-group mt-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 pl-2 mobile_margin_padding_none"><!--Grid  -->
                                <label class="mb-2" for="" style="margin-bottom:-8px;">Your Name</label>
                                <input class="form-control" type="text" name="yourName" required>
                            </div>

                            <div class="form-group mt-3 col-xl-6 col-lg-6 col-md-6 col-sm-12 pl-5  mobile_margin_padding_none"><!--Grid  -->
                                <label class="mb-2" for="roomNo" style="margin-bottom:-8px;">Room Number</label>
                                <input class="form-control" type="text" name="roomNo" required>
                            </div>
                            <div class="form-group col-xl-6 col-lg-6 col-md-6 col-sm-12 pl-2 mt-3 mobile_margin_padding_none"><!--Grid  -->
                                <label class=" mb-2" for="receivedBy" style="margin-bottom:-8px;">Name of the recipient</label>
                                <input class="form-control" type="text" name="receivedBy" style="border-radius:0;" required>
                            </div>



                            <div class="form-group  col-xl-6 col-lg-6 col-md-6 col-sm-12 pl-2 mt-3 pl-5 mobile_margin_padding_none"><!--Grid  -->
                                <label class="mb-2" for="amount" style="margin-bottom:-8px;">Amount</label>
                                <input class="form-control" type="text" name="amount" required>
                            </div>



                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 ml-2 mobile_margin_padding_none"><!--Grid  -->
                                <label class="mb-2" for="message" style="margin-bottom:-8px;">Personal Message</label>
                                <textarea class="form-control" name="message" rows="2" cols="100" required></textarea>    <!--Comments input-->
                            </div><br>

                            <div class="form-group col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-3 ml-4 pl-1"><!--Grid  -->
                                <input class=" bg-btn-secondary form-check-input float-left" type="checkbox" name="checkbox" id="gridCheck1" style="  cursor: pointer;" required >
                                <label class="form-check-label" for="gridCheck1" style="  cursor: pointer;">
                                    I have read and accept the <a href="privacy" style="text-decoration:none;">privacy policy</a>
                                </label>
                            </div>

                        </div> <!--Row for Fields-->

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 pb-3 pl-6 mobile_margin_padding_none"><!--Grid  -->
                            <button type="submit" name="Submit" class="btn  text-white button-background-color btn-primary">Order</button>
                        </div>
                    </form>

                </div>   <!-- OUter Cols END -->
            </div>   <!-- Inner rows END -->
        </div>





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
