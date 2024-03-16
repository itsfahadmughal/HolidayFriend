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
$item_lenth = 0;

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
$sql="SELECT a.*,b.title FROM tbl_room_service_detail as a INNER JOIN tbl_room_service_category as b ON a.rmsr_id=b.rmsr_id WHERE a.isactive = 1 and a.hotel_id = $hotel_id ORDER BY a.rmsr_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['rmsr_id']);
}
$cat_unique_id = array_unique($cat_unique_id);
$cat_unique_id = array_values($cat_unique_id);
$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);
if(isset($_POST['submit'])){
    $rso_id = 0;
    $you_name=$_POST['you_name'];
    $room_no=$_POST['room_no'];
    $time_time=$_POST['time_time'];
    $rmsd_id =$_POST['mid'];
    $counter=$_POST['counter'];
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");;
    $arrayids = explode("-",$rmsd_id);
    $number = array();
    $quantity= array();
    $ids= array();
    $other_information=$_POST['other_information'];
    for($i=0;$i<$counter;$i++){
        $an =  $i;
        $number[$i]=$_POST['quantity'.$an];
        if($number[$i] != 0){
            array_push($quantity,$number[$i]);
            array_push($ids,$arrayids[$i]);
        }

    }
    if(sizeof($quantity) != 0){
        $sql2="INSERT INTO `tbl_room_service_order_t`( `name`, `roon_no`, `hotel_id`, `time`, `other_information`, `entryby_ip`, `entry_time`, `status_id`) VALUES ('$you_name','$room_no',$hotel_id,'$time_time','$other_information','$entryby_ip','$entry_time',1)";
        $stmt1 = $conn->query($sql2);
        if($stmt1){
            $sql="SELECT MAX(`rso_id`) FROM `tbl_room_service_order_t`";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $rso_id=$row[0];

                }
            }
            $stmt3 ="";
            for($j=0;$j<sizeof($quantity);$j++){
                $sql3="INSERT INTO `tbl_room_service_all_orders_t`(`rmsd_id`, `rso_id`, `quantity`) VALUES ($ids[$j],$rso_id,$quantity[$j])";
                $stmt3 = $conn->query($sql3);
            } 
            if($stmt3){

                $subject="Room Service Order";
                $headers = "From: " . strip_tags($you_name) . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                $message="Name : ".$you_name."<br>"."Room No : ".$room_no."<br>"."Notes : ".$other_information."<br>"."Delivery Time : ".$time_time;

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
                <div class="row pt-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 19";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 19";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                    ?>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row bg-white p-3 bgfull-affect-div">
                        <div class="col-xl-4 col-md-4 col-sm-4">

                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12" id="repeat_div" style="border: 1px solid #dee2e6;">

                            <div class="row mr-2 ml-2">
                                <div class="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-first-name">Your name:</label>
                                        <input type="text" name="you_name" id="input-first-name" class="form-control" placeholder="Your name" required>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-md-2 col-sm-2 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last-name">Room number:</label>
                                        <input type="text" id="input-last-name" name="room_no" class="form-control" placeholder="Room number" required>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-age">When should the order be served?</label>
                                        <input type="time" id="input-age" name="time_time" class="form-control" placeholder="">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--                        Items Services-->
                        <div class="col-xl-12 col-md-12 col-sm-12 mt-3">
                            <div class="row ml-0">


                                <?php
                                $idsarray ="";
                                $item_name = "";
                                $item_price ="";
                                $currency_symbol = "";
                                $item_url = "";
                                $sql="SELECT a.*,b.title,c.curr_id as mcurr_id FROM tbl_room_service_detail as a INNER JOIN tbl_room_service_category as b ON a.rmsr_id=b.rmsr_id INNER JOIN tbl_hotel as c ON a.hotel_id= c.hotel_id WHERE a.isactive = 1 and a.hotel_id = $hotel_id ORDER BY a.rmsr_id";
                                $result2 = $conn->query($sql);
                                $i = 0;
                                $j = 0;
                                $p = 0;
                                $q = 0;

                                if ($result2 && $result2->num_rows > 0) {
                                    $lenth = $result2->num_rows;

                                ?>
                                <div class ="col-xl-12 col-md-12 col-sm-12"> 
                                    <input type="text" style="display :none" name="array_lenth" value="
                                                                                                       <?php echo $lenth  ?>" >
                                </div>
                                <?php
                                    while($row = mysqli_fetch_array($result2)) {

                                        $mapping_id = $row['mapping_id'];
                                        $rmsr_id = $row['rmsr_id'];
                                        $rmsd_id = $row['rmsd_id'];
                                        $item_price = $row['price'];
                                        $currency_id = $row['mcurr_id'];
                                        $table = explode("-",$mapping_id);
                                        $table_name = $table[1];
                                        $table_id = $table[0];
                                ?>


                                <?php
                                        $sql4="SELECT  `symbol` FROM `tbl_currency` WHERE `curr_id` = $currency_id";
                                        $result4 = $conn->query($sql4);       
                                        if ($result4 && $result4->num_rows > 0) {
                                            while($row4 = mysqli_fetch_array($result4)) {
                                                $currency_symbol = $row4['symbol'];
                                            }}

                                        if($table_name=="drink"){
                                            $sql10="SELECT * FROM `tbl_drinks_menu` WHERE `drm_id` = $table_id";
                                            $result10 = $conn->query($sql10);       
                                            if ($result10 && $result10->num_rows > 0) {
                                                while($row10 = mysqli_fetch_array($result10)) {
                                                    $item_name = $row10['drink_title'];
                                                    $item_url = $row10['img_url'];
                                                }}
                                            if($p == 0){
                                ?>
                                <div class="col-xl-12 col-md-12 col-sm-12 ml-0"><h1>Beverages</h1></div>
                                <?php
                                                $p = 1;
                                            }

                                        }
                                        elseif($table_name=="meal"){
                                            $sql20="SELECT * FROM `tbl_meal_items` WHERE `mli_id` = $table_id";
                                            $result20 = $conn->query($sql20);       
                                            if ($result20 && $result20->num_rows > 0) {
                                                while($row20 = mysqli_fetch_array($result20)) {
                                                    $item_name = $row20['item_name'];
                                                    $item_url = $row20['img_url'];
                                                }}
                                            if($q == 0){
                                ?>
                                <div class="col-xl-12 col-md-12 col-sm-12 ml-0"><h1>Products</h1></div>
                                <?php
                                                $q = 1;
                                            }


                                        }
                                        if($item_name != ""){
                                            $idsarray  = $idsarray.$rmsd_id."-";
                                ?>
                                <input type="text" style="display :none"  name="mid" value="
                                                                                            <?php echo $idsarray  ?>" >
                                <?php
                                    if($cat_unique_id[$i] == $rmsr_id){
                                        if($j == 0){
                                ?>
                                <div class="col-xl-12 col-md-12 col-sm-12 ml-0">

                                    <h2 class="page-title-text"><?php echo $row['title'] ?></h2>
                                </div>

                                <?php
                                    $j=1;             
                                        }
                                ?>
                                <div class="col-xl-6 col-md-6 col-sm-6">
                                    <div class="row ml-0 mt-3">
                                        <div class="col-xl-9 col-md-9 col-sm-9 mt-2">
                                            <div class="row ml-0">
                                                <div class="col-xl-6 col-md-6 col-sm-6">
                                                    <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                                                    <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                                                    <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-6 mt-2">

                                                    <span Style ="font-size: 13px;"><?php echo $item_name." ".$item_price.$currency_symbol ?> </span>

                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-xl-3 col-md-3 col-sm-3">
                                            <?php $ext = strtolower(pathinfo($item_url, PATHINFO_EXTENSION));
                                        if(in_array($ext, $supported_image)){ ?>
                                            <img  height = "100px" width ="100px" src="HolidayFriendAdmin/<?php echo $item_url ?>" />
                                            <?php } ?>
                                        </div>


                                    </div></div>


                                <?php    }else{
                                        $j=0;
                                        $i+=1; 
                                        if($j == 0){
                                ?>
                                <div class="col-xl-12 col-md-12 col-sm-12 ml-0">
                                    <h2 class="page-title-text"><?php echo $row['title'] ?></h2>
                                </div>
                                <?php  

                                        }
                                ?>
                                <div class="col-xl-6 col-md-6 col-sm-6">
                                    <div class="row ml-0 mt-3">
                                        <div class="col-xl-9 col-md-9 col-sm-9 mt-2">
                                            <div class="row ml-0">
                                                <div class="col-xl-6 col-md-6 col-sm-6">
                                                    <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                                                    <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>" />
                                                    <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                                                </div>
                                                <div class="col-xl-6 col-md-6 col-sm-6 mt-2">

                                                    <span Style ="font-size: 13px;"><?php echo $item_name." ".$item_price.$currency_symbol ?> </span>

                                                </div>
                                            </div>    
                                        </div>
                                        <div class="col-xl-3 col-md-3 col-sm-3">
                                            <?php $ext = strtolower(pathinfo($item_url, PATHINFO_EXTENSION));
                                        if(in_array($ext, $supported_image)){ ?>
                                            <img name = '<?php echo $mapping_id ?>' height = "100px" width ="100px" src="HolidayFriendAdmin/<?php echo $item_url ?>" />
                                            <?php } ?>
                                        </div>
                                    </div></div>    
                                <?php
                                        $j=1;}
                                ?>
                                <?php
                                            $id_counter++;         

                                        }
                                    }
                                }

                                ?>

                            </div>
                        </div>
                        <!--                        Here End-->
                        <div class="col-xl-12 col-md-12 col-sm-12 mt-3">
                            <div class="row mr-0 ml-0 mt-2 mb-2">
                                <div class="form-group" style="width: 100%;">
                                    <label class="form-control-label" for="registeration_comment">Other information</label>
                                    <textarea rows="4" class="p-2 form-control" id="registeration_comment" name="other_information"></textarea>
                                </div>
                            </div>
                            <div class="row mr-0 ml-0 mt-3 mb-2">
                                <input type="submit" name="submit" value="Order" class="btn  text-white button-background-color btn-primary" />
                            </div>
                        </div>

                    </div>
                    <input type="text" style="display :none"  name="counter" value="<?php echo $id_counter;   ?>" >
                </form>

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
