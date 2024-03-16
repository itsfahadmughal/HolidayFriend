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
$id_counter = 0;
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url=$title="";
$wkp_id=0;
$id_counter = 0;
$current_date = date("l, d.m.Y");
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

//
$cat_unique_id = array();
$sql="SELECT a.*,c.item_name,e.category,e.mlc_id FROM tbl_meal_menu as a INNER JOIN tbl_meal_items as c ON a.mli_id=c.mli_id INNER JOIN tbl_meal_categories as e ON a.mlc_id=e.mlc_id WHERE c.hotel_id = $hotel_id and a.isactive = 1 ORDER BY a.mlc_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['mlc_id']);
}
$cat_unique_id = array_unique($cat_unique_id);
$cat_unique_id = array_values($cat_unique_id);
if(isset($_POST['submit'])){
    $dmo_id = 0;
    $you_name=$_POST['m_name'];
    $room_no=$_POST['input_room_number'];
    $other_information=$_POST['other_information'];
    $counter=$_POST['counter'];
    $entry_time=date("Y-m-d H:i:s");
    $entryby_ip=getIPAddress();
    $group_no= array();
    $quantity= array();
    for($i=0;$i< $counter;$i++){
        $an =  $i;
        $quantity1[$i]=$_POST['quantity'.$an];
        if($quantity1[$i] != 0){
            $number[$i]=$_POST['group_no'.$an];
            $number1[$i]=$_POST['quantity'.$an];
            array_push($quantity,$number1[$i]);
            array_push($group_no,$number[$i]);
        }
    }
    if(sizeof($quantity) != 0){
        $sql2="INSERT INTO `tbl_day_menu_orders`( `name`,`name_it`,`name_de`, `roon_no`,  `other_information`, `hotel_id`,`entryby_ip`, `entry_time`, `status_id`) VALUES ('$you_name','$you_name','$you_name','$room_no','$other_information',$hotel_id,'$entryby_ip','$entry_time',1)";
        $stmt1 = $conn->query($sql2);

        if($stmt1){

            $sql="SELECT MAX(`dmo_id`) FROM `tbl_day_menu_orders`";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $dmo_id=$row[0];

                }
            }
            $stmt3 ="";
            for($j=0;$j<sizeof($quantity);$j++){
                $sql3="INSERT INTO `tbl_daymenu_order_detail`( `dmo_id`, `group_id`, `quantity`) VALUES ($dmo_id,$group_no[$j],$quantity[$j])";
                $stmt3 = $conn->query($sql3);
            } 
            if($stmt3){
                $subject="Menu Order";
                $headers = "From: " . strip_tags($you_name) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $message="Name : ".$you_name."<br>"."Room No : ".$room_no."<br>"."Notes : ".$other_information."<br>"."Time : ".$entry_time;

                mail($email,$subject,$message,$headers);

                echo '<script>alert("Your order has been submitted");</script>';
            }
            else{
                echo '<script>alert("Something Went Wrong!!!");</script>';
            }


        }else{
            echo '<script>alert("Something Went Wrong!!!");</script>';
        }


    }
    else{
        echo '<script>alert("Please select at least one dish to order.");</script>';
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
        <title>Room Service</title>
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
        <script src="jquery.js"></script>

        <!--        For Min Max-->

        <script>
            function increaseValue(id) {
                var value = parseInt(document.getElementById('number'+id).value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                document.getElementById('number'+id).value = value;
            }

            function decreaseValue(id) {
                var value = parseInt(document.getElementById('number'+id).value, 10);
                value = isNaN(value) ? 0 : value;
                value < 1 ? value = 1 : '';
                value--;
                document.getElementById('number'+id).value = value;
            }
        </script>
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
            #des_id p {
                font-size: 13px;
            }

            input[type=number]::-webkit-inner-spin-button,
            input[type=number]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            } margin: 0;

        </style>
        <style>
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
        </style>
        <script>
            function increaseValue(id) {
                var value = parseInt(document.getElementById('number'+id).value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                document.getElementById('number'+id).value = value;
            }

            function decreaseValue(id) {
                var value = parseInt(document.getElementById('number'+id).value, 10);
                value = isNaN(value) ? 0 : value;
                value < 1 ? value = 1 : '';
                value--;
                document.getElementById('number'+id).value = value;
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
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <?php $sql="SELECT a.*,c.item_name,c.description,e.category,e.mlc_id FROM tbl_meal_menu as a INNER JOIN tbl_meal_items as c ON a.mli_id=c.mli_id INNER JOIN tbl_meal_categories as e ON a.mlc_id=e.mlc_id WHERE c.hotel_id = $hotel_id and a.isactive = 1 ORDER BY a.group_num,a.is_package";
        $result2 = $conn->query($sql);
        $i = 0;
        $j = 0;
        $is_date = 0;
        $icon_url= "";
        if ($result2 && $result2->num_rows > 0) {
            $is_same_grp=0;
            $previous_group = 100;
            while($row = mysqli_fetch_array($result2)) {
                $item_name = $row['item_name'];
                $description = $row['description'];
                $ispakge = $row['is_package'];
                $is_same_grp = $row['group_num'];
                $icon_id=$row['icon_id'];
                $sql4="SELECT  `icon_url` FROM `tbl_util_icons_t` WHERE `icon_id` = $icon_id";
                $result4 = $conn->query($sql4);       
                if ($result4 && $result4->num_rows > 0) {
                    while($row4 = mysqli_fetch_array($result4)) {
                        $icon_url = $row4['icon_url'];
                    }}
                if($cat_unique_id[$i] == $row['mlc_id']){
                    if($j == 0){
                        if($is_date==0){
                    ?>
                    <div class="row mt-5">
                        <div class="col-xl-12 col-md-12 col-sm-12 ">
                            <h1 class="textstyle" style="text-align: center"><?php echo $row['category'].", ".$current_date; ?>  </h1>
                        </div>
                    </div>

                    <?php
                            $is_date = 1;
                        }else{
                    ?>
                    <div class="row mt-5">
                        <div class="col-xl-12 col-md-12 col-sm-12 ">
                            <h1 class="textstyle" style="text-align: center"><?php echo $row['category'];?>  </h1>
                        </div>
                    </div>

                    <?php
                        }
                    ?>

                    <?php
                        $j=1; 
                    }
                    ?>
                    <div class="row bg-white p-4 bgfull-affect-div">
                        <?php
                    if($is_same_grp == $previous_group){
                        ?>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-3" style="font-size:12px; text-align: center; font-weight: 700;">
                            <p style="font-size:12px;" ><b>OR</b></p> 
                        </div>
                        <?php    
                    }
                        ?>
                        <div class="col-xl-12 col-md-12 col-sm-12 ml-0 mr-0 mb-0 mt-0" style="text-align: center;">
                            <p class="ml-0 mr-0 mb-0 mt-0"><?php echo $item_name; ?></p> 
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 ml-0 mr-0 mb-0 mt-0" id="des_id" style="text-align: center;">
                            <p><?php echo $description ?></p>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-0" style="font-size:13px; text-align: center;">
                            <img src="HolidayFriendAdmin/<?php echo $icon_url?>"/>
                        </div>
                        <?php 
                            if($ispakge==1){
                        ?>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-0" style="font-size:13px; text-align: center;">
                            <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                            <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                            <input type="text" style="display :none"  name="group_no<?php echo $id_counter?>" value="<?php echo $is_same_grp  ?>" >
                            <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-0" style="font-size:13px; text-align: center;">
                            <img src="HolidayFriendAdmin/images/icons/default_menu_trenner.png"/>
                        </div>
                        <?php 

                            $id_counter++;


                            }?>

                    </div>



                    <?php
                }else{

                    $i+=1; 
                    $j=0;
                    if($j == 0){
                    ?>
                    <div class="row mt-5">
                        <div class="col-xl-12 col-md-12 col-sm-12">
                            <h1 class="textstyle" style="text-align: center"><?php echo $row['category'];?>  </h1>
                        </div>
                    </div>
                    <?php
                        $j=1;     
                    }
                    ?>
                    <div class="row bg-white p-4 bgfull-affect-div">
                        <?php
                    if($is_same_grp == $previous_group){
                        ?>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-3" style="font-size:12px; text-align: center; font-weight: 700;
                                                                                               ">
                            <p style="font-size:12px;" ><b>OR</b></p> 
                        </div>
                        <?php    
                    }
                        ?>
                        <div class="col-xl-12 col-md-12 col-sm-12 ml-0 mr-0 mb-0 mt-0" style="text-align: center;">
                            <p><?php echo $item_name; ?></p> 
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 ml-0 mr-0 mb-0 mt-0" id="des_id" style="text-align: center;">
                            <p><?php echo $description ?></p>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-0" style="font-size:13px; text-align: center;">
                            <img src="HolidayFriendAdmin/<?php echo $icon_url?>"/>
                        </div>

                        <?php 
                            if($ispakge==1){
                        ?>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-0" style="font-size:13px; text-align: center;">
                            <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                            <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                            <input type="text" style="display :none"  name="group_no<?php echo $id_counter?>" value="<?php echo $is_same_grp  ?>" >
                            <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12  ml-0 mr-0 mb-0 mt-0" style="font-size:13px; text-align: center;">
                            <img src="HolidayFriendAdmin/images/icons/default_menu_trenner.png"/>
                        </div>
                        <?php 
                            $id_counter++;
                            }?>
                        <?php
                    if(1== 1){
                        ?>
                        <?php    
                    }
                        ?>
                    </div>
                    <?php


                }
                $previous_group = $is_same_grp;

            }

        } ?>

                    <div class="row bg-white p-3 mt-5 bgfull-affect-div">

                        <div class="col-xl-12 col-md-12 col-sm-12 pl-2">
                            <h3>Order for <?php echo $current_date?>.</h3>
                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12">

                            <div class="row mr-0 ml-0">
                                <div class="col-xl-6 col-md-6 col-sm-6 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Name *</label>
                                        <input type="text" name="m_name" id="input-first-name" class="form-control" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-room-number">Room number *</label>
                                        <input type="text" id="input-room-number" name="input_room_number"  class="form-control" placeholder="Room Number" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 pl-2">
                            <div class="row mr-0 ml-0 mb-2">
                                <div class="form-group" style="width: 100%;">
                                    <label class="form-control-label" for="registeration_comment">Other information</label>
                                    <textarea rows="4" class="p-2 form-control" id="registeration_comment" name="other_information"></textarea>
                                </div>
                            </div>
                            <div class="row mr-0 ml-0 mt-2 mb-2">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox" required>
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span class="text-muted">I have read and accept the <a href="privacy">privacy policy</a></span>
                                    </label>
                                </div>
                            </div>
                            <div class="row mr-0 ml-0 mt-3 mb-2">
                                <input type="submit" name="submit" value="Order" 
                                       class="btn  text-white button-background-color btn-primary" />
                            </div>
                        </div>
                    </div>
                    <input type="text" style="display :none"  name="counter" value="<?php echo $id_counter  ?>" >
                </form>

                <div class="row bg-white  mt-4 bgfull-affect-div">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="row mr-2 ml-2">
                            <?php
    $icon_id ="";
                                $icon_url ="";
                                $sql="SELECT * FROM tbl_classification_t WHERE hotel_id=$hotel_id and isactive = 1";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                            ?>
                            <div class="col-xl-12 col-md-12 col-sm-12 pt-2 pr-2 pl-2">
                                <span>Classification</span>
                            </div>
                            <?php                
                                    while($row = mysqli_fetch_array($result)) {
                                        $name=$row[1];
                                        $icon_id=$row[4];
                                        $sql4="SELECT  `icon_url` FROM `tbl_util_icons_t` WHERE `icon_id` = $icon_id";
                                        $result4 = $conn->query($sql4);       
                                        if ($result4 && $result4->num_rows > 0) {
                                            while($row4 = mysqli_fetch_array($result4)) {
                                                $icon_url = $row4['icon_url'];
                                            }}
                            ?>
                            <div class="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2">
                                <p style="color:#888;font-size:75%;"><img src="HolidayFriendAdmin/<?php echo $icon_url?>"/>
                                    | <strong><?php echo $name; ?></strong></p>
                            </div>
                            <?php    
                                    }
                                }
                            ?>
                        </div>

                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <div class="row mr-2 ml-2">
                            <?php
                            $sql="SELECT * FROM tbl_food_allergens WHERE hotel_id=$hotel_id and isactive = 1";
                            $result = $conn->query($sql);
                            if ($result && $result->num_rows > 0) {
                            ?>
                            <div class="col-xl-12 col-md-12 col-sm-12 pt-2 pr-2 pl-2">
                                <span>Allergens</span>
                            </div>
                            <?php 
                                $icon_id ="";
                                $icon_url ="";
                                while($row = mysqli_fetch_array($result)) {
                                    $name=$row[1];
                                    $icon_id=$row[16];
                                    $sql4="SELECT  `icon_url` FROM `tbl_util_icons_t` WHERE `icon_id` = $icon_id";
                                    $result4 = $conn->query($sql4);       
                                    if ($result4 && $result4->num_rows > 0) {
                                        while($row4 = mysqli_fetch_array($result4)) {
                                            $icon_url = $row4['icon_url'];
                                        }}
                            ?>
                            <div class="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2">
                                <p style="color:#888;font-size:75%;"><img src="HolidayFriendAdmin/<?php echo $icon_url?>"/>
                                    | <strong><?php echo $name; ?></strong></p>
                            </div>
                            <?php    
                                }
                            }
                            ?>
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
        <!-- Optional JS -->
        <script src="assets/vendor/chart.js/dist/Chart.min.js"></script>
        <script src="assets/vendor/chart.js/dist/Chart.extension.js"></script>
        <!-- Argon JS -->
        <script src="assets/js/argon.js?v=1.2.0"></script>

        <?php  include 'util-js-files.php' ?>

    </body>

</html>
