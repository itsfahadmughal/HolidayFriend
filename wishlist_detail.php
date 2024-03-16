<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$id_counter = 0;
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
$cat_unique_id = array();
$sql="SELECT a.*,b.title FROM tbl_wish_item as a INNER JOIN tbl_wishlist_category as b ON a.wilc_id=b.wilc_id WHERE a.`hotel_id` = $hotel_id and isactive=1 ORDER BY a.wilc_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['wilc_id']);
}
$cat_unique_id = array_unique($cat_unique_id);
$cat_unique_id = array_values($cat_unique_id);
$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png');

$mcatid = 0;
if(isset($_GET['id'])){
    $mcatid = $_GET['id'];
}else{
    $mcatid = 0;
}

if(isset($_POST['submit'])){
    $rso_id = 0;
    $name=$_POST['name'];
    $email=$_POST['email'];
    $rmsd_id =$_POST['mid'];
    $counter=$_POST['counter'];;
    $arrayids = explode("-",$rmsd_id);
    $number = array();
    $quantity= array();
    $ids= array();
    for($i=0;$i<$counter;$i++){
        $an =  $i;
        $number[$i]=$_POST['quantity'.$an];
        if($number[$i] != 0){
            array_push($quantity,$number[$i]);
            array_push($ids,$arrayids[$i]);
        }

    }
    if(sizeof($quantity) != 0){
        $sql2="INSERT INTO `tbl_wishlist_requests`( `name`, `email`, `hotel_id`, `is_delete`, `isactive`) VALUES ('$name','$email',$hotel_id,0,1)";
        $stmt1 = $conn->query($sql2);
        if($stmt1){
            $sql="SELECT MAX(`wilr_id`) FROM `tbl_wishlist_requests`";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $rso_id=$row[0];

                }
            }
            $stmt3 ="";
            for($j=0;$j<sizeof($quantity);$j++){
                $sql3="INSERT INTO `tbl_wishlist_item_request_map`(`wil_id`, `wilr_id`, `quantity`) VALUES ($ids[$j],$rso_id,$quantity[$j])";
                $stmt3 = $conn->query($sql3);
            } 
            if($stmt3){
                echo '<script>alert("Your Request has been submitted"); window.location.href = "index";</script>';
            }
            else{
                echo '<script>alert("Something Went Wrong!!!");</script>';
            }


        }else{
            echo '<script>alert("Something Went Wrong!!!");</script>';
        }
    }
    else{
        echo '<script>alert("Please select at least one Item to order.");</script>';
    }
}
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Wishlist</title>
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
            .image-container {
                position: relative;
            }
            .text-block {
                position: absolute;
                top: 10px;
                right: 0px;
                border-radius: 0px 3px 3px 0;
                color: white;
                padding-left: 15px;
                padding-right: 15px;
                display: inline-block;

            }
            .text-block3 {  
                position: absolute;
                left: -4px;
                color: white;
                border-radius: 0px 3px 3px 0;
                width: auto;
                padding-left: 20px;
                padding-right: 20px;
                display: inline-block;

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
            .inline-block{
                display: inline-block;
            }
            #recomandation{
                color:white;    
            }
            #recomandation:hover {
                color:white;
                text-decoration: underline;
            }
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

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'wishlist'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 25";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 25";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                    ?>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                    </div>
                </div>


                <?php 
                if($mcatid == 0 ){
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row bg-white p-3 bgfull-affect-div">
                        <div class="col-xl-12 col-md-12 col-sm-12" style="border: 1px solid #dee2e6;">

                            <div class="row mr-2 ml-2">
                                <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 m-0">
                            <!--                  Bwlow Start the div-->
                            <?php
                    $sql="SELECT a.*,b.title as mtitle,c.curr_id as mcurr_id FROM tbl_wish_item as a INNER JOIN tbl_wishlist_category as b ON a.wilc_id= b.wilc_id INNER JOIN tbl_hotel as c ON a.hotel_id= c.hotel_id WHERE a.isactive = 1 and a.hotel_id = $hotel_id ORDER BY a.wilc_id";
                    $result2 = $conn->query($sql);
                    $i = 0;
                    $j = 0; 
                    $idsarray ="";
                    if ($result2 && $result2->num_rows > 0) {
                        $lenth = $result2->num_rows;
                            ?>
                            <div class ="col-xl-12 col-md-12 col-sm-12 m-0"> 
                                <input type="text" style="display :none" name="array_lenth" value="
                                                                                                   <?php echo $lenth  ?>" >
                            </div>
                            <?php
                                while($row = mysqli_fetch_array($result2)) {
                                    $rmsd_id = $row['wil_id'];
                                    $curr_id = $row['mcurr_id'];
                                    $url_image=$row['image'];
                                    $title=$row['title'];
                                    $currency_symbol = "";
                                    $sql4="SELECT  `symbol` FROM `tbl_currency` WHERE `curr_id` = $curr_id";
                                    $result4 = $conn->query($sql4);       
                                    if ($result4 && $result4->num_rows > 0) {
                                        while($row4 = mysqli_fetch_array($result4)) {
                                            $currency_symbol = $row4['symbol'];
                                        }}
                                    $idsarray  = $idsarray.$rmsd_id."-";
                            ?>
                            <input type="text" style="display :none"  name="mid" value="
                                                                                        <?php echo $idsarray  ?>" >
                            <?php
                                if($cat_unique_id[$i] == $row['wilc_id']){
                                    if($j == 0){
                            ?>
                            <div class="row pt-3 m-0">
                                <div class="col-xl-12 col-md-12 col-sm-12 m-0">
                                    <h2 class="textstyle ml-3"><?php echo $row['mtitle'] ?></h2>
                                </div>
                            </div> 
                            <?php
                                $j=1; 
                                        echo "<div class='row m-0'>";    
                                    }
                            ?>
                            <div class="col-xl-3 col-md-3 col-sm-3 m-0">
                                <?php 
                                    $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                    if(!in_array($ext, $supported_image)){ ?>

                                <div class="mr-3 ml-3 mt-2 image-container">
                                </div>
                                <?php }else{?>
                                <div class="mr-3 ml-3 mt-2 image-container">

                                    <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                                    <?php 
                                        if($row['price'] != 0){ 
                                    ?>
                                    <div class="text-block bg-gradient-default-1">
                                        <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                    </div>
                                    <?php }?>
                                </div>
                                <?php } ?>
                                <div class="image-container bgfull-affect-div bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div  m-0">
                                    <div class="row ml-0 ">
                                        <div class="col-xl-12 col-md-12 col-sm-12 ml-3">
                                            <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                                            <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                                            <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="div-title-background-1 row  m-0">
                                        <h4 class="heading-title-background  m-0"><?php echo $title; ?></h4>
                                    </div>
                                    <?php  if(!in_array($ext, $supported_image)){ 
                                        if($row['price'] != 0){
                                    ?>
                                    <div class="text-block bg-gradient-default-1">  
                                        <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                    </div>

                                    <?php      } } ?> 
                                </div>
                            </div>
                            <?php    
                                }
                                    else{ 
                                        $i+=1; 
                                        $j=0;
                                        echo "</div>";
                                        if($j == 0){ 
                            ?> 
                            <div class="row pt-3 m-0">
                                <div class="col-xl-12 col-md-12 col-sm-12 m-0">
                                    <h2 class="textstyle mt-3 ml-3"><?php echo $row['mtitle'] ?></h2>
                                </div>
                            </div>                        
                            <?php
                                $j=1;  
                                        }
                            ?>
                            <div class='row m-0'>
                                <div class="col-xl-3 col-md-3 col-sm-3 m-0">
                                    <?php 

                                        $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                        if(!in_array($ext, $supported_image)){ ?>

                                    <div class="mr-3 ml-3 mt-2 image-container">
                                    </div>
                                    <?php }else{?>
                                    <div class="mr-3 ml-3 mt-2 image-container">

                                        <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>

                                        <?php if($row['price'] != 0){ ?>
                                        <div class="text-block bg-gradient-default-1">
                                            <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <?php } ?>
                                    <div class="image-container bgfull-affect-div bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div  m-0">
                                        <div class="row ml-0 ">
                                            <div class="col-xl-12 col-md-12 col-sm-12 ml-3">
                                                <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                                                <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                                                <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                                                <hr> 
                                            </div>
                                        </div>
                                        <div class="div-title-background-1 row  m-0">
                                            <h4 class="heading-title-background  m-0"><?php echo $title; ?></h4>
                                        </div>
                                        <?php  if(!in_array($ext, $supported_image)){ 
                                            if($row['price'] != 0){
                                        ?>
                                        <div class="text-block bg-gradient-default-1">  
                                            <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                        </div>

                                        <?php      } } ?> 
                                    </div>
                                </div>
                                <?php    
                                    }
                                    $id_counter++;  
                                }
                    }
                                ?>
                            </div>
                        </div>
                        <!--                        Wish List Services-->

                        <!--                        Here End-->
                        <div class="col-xl-12 col-md-12 col-sm-12 mt-3 ml-3">
                            <div class="row mr-0 ml-0 mt-3 mb-2">
                                <input type="submit" name="submit" value="Request" class="btn  text-white button-background-color btn-primary" />
                            </div>
                        </div>

                    </div>
                    <input type="text" style="display :none"  name="counter" value="<?php echo $id_counter;   ?>" >
                </form>

                <?php 
                }else {
                ?>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row bg-white p-3 bgfull-affect-div">
                        <div class="col-xl-12 col-md-12 col-sm-12" style="border: 1px solid #dee2e6;">

                            <div class="row mr-2 ml-2">
                                <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="name">Name:</label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                    <div class="form-group">
                                        <label class="form-control-label" for="email">Email:</label>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-12 col-md-12 col-sm-12 m-0">
                            <!--                  Bwlow Start the div-->
                            <?php
                    $sql="SELECT a.*,b.title as mtitle,c.curr_id as mcurr_id FROM tbl_wish_item as a INNER JOIN tbl_wishlist_category as b ON a.wilc_id= b.wilc_id INNER JOIN tbl_hotel as c ON a.hotel_id= c.hotel_id WHERE a.isactive = 1 and a.hotel_id = $hotel_id and a.wilc_id = $mcatid";
                    $result2 = $conn->query($sql);
                    $i = 0;
                    $j = 0; 
                    $idsarray ="";
                    if ($result2 && $result2->num_rows > 0) {
                        $lenth = $result2->num_rows;
                            ?>
                            <div class ="col-xl-12 col-md-12 col-sm-12 m-0"> 
                                <input type="text" style="display :none" name="array_lenth" value="
                                                                                                   <?php echo $lenth  ?>" >
                            </div>
                            <?php
                                while($row = mysqli_fetch_array($result2)) {
                                    $rmsd_id = $row['wil_id'];
                                    $curr_id = $row['mcurr_id'];
                                    $url_image=$row['image'];
                                    $title=$row['title'];
                                    $currency_symbol = "";
                                    $sql4="SELECT  `symbol` FROM `tbl_currency` WHERE `curr_id` = $curr_id";
                                    $result4 = $conn->query($sql4);       
                                    if ($result4 && $result4->num_rows > 0) {
                                        while($row4 = mysqli_fetch_array($result4)) {
                                            $currency_symbol = $row4['symbol'];
                                        }}
                                    $idsarray  = $idsarray.$rmsd_id."-";
                            ?>
                            <input type="text" style="display :none"  name="mid" value="
                                                                                        <?php echo $idsarray  ?>" >
                            <?php
                                if(1==1){
                                    if($j == 0){
                            ?>
                            <div class="row pt-3 m-0">
                                <div class="col-xl-12 col-md-12 col-sm-12 m-0">
                                    <h2 class="textstyle ml-3"><?php echo $row['mtitle'] ?></h2>
                                </div>
                            </div> 
                            <?php
                                $j=1; 
                                        echo "<div class='row m-0'>";    
                                    }
                            ?>
                            <div class="col-xl-3 col-md-3 col-sm-3 m-0">
                                <?php 
                                    $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                    if(!in_array($ext, $supported_image)){ ?>

                                <div class="mr-3 ml-3 mt-2 image-container">
                                </div>
                                <?php }else{?>
                                <div class="mr-3 ml-3 mt-2 image-container">

                                    <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                                    <?php 
                                        if($row['price'] != 0){ 
                                    ?>
                                    <div class="text-block bg-gradient-default-1">
                                        <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                    </div>
                                    <?php }?>
                                </div>
                                <?php } ?>
                                <div class="image-container bgfull-affect-div bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div  m-0">
                                    <div class="row ml-0 ">
                                        <div class="col-xl-12 col-md-12 col-sm-12 ml-3">
                                            <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                                            <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                                            <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="div-title-background-1 row  m-0">
                                        <h4 class="heading-title-background  m-0"><?php echo $title; ?></h4>
                                    </div>
                                    <?php  if(!in_array($ext, $supported_image)){ 
                                        if($row['price'] != 0){
                                    ?>
                                    <div class="text-block bg-gradient-default-1">  
                                        <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                    </div>

                                    <?php      } } ?> 
                                </div>
                            </div>
                            <?php    
                                }
                                    else{ 
                                        $i+=1; 
                                        $j=0;
                                        echo "</div>";
                                        if($j == 0){ 
                            ?> 
                            <div class="row pt-3 m-0">
                                <div class="col-xl-12 col-md-12 col-sm-12 m-0">
                                    <h2 class="textstyle mt-3 ml-3"><?php echo $row['mtitle'] ?></h2>
                                </div>
                            </div>                        
                            <?php
                                $j=1;  
                                        }
                            ?>
                            <div class='row m-0'>
                                <div class="col-xl-3 col-md-3 col-sm-3 m-0">
                                    <?php 

                                        $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                        if(!in_array($ext, $supported_image)){ ?>

                                    <div class="mr-3 ml-3 mt-2 image-container">
                                    </div>
                                    <?php }else{?>
                                    <div class="mr-3 ml-3 mt-2 image-container">

                                        <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>

                                        <?php if($row['price'] != 0){ ?>
                                        <div class="text-block bg-gradient-default-1">
                                            <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <?php } ?>
                                    <div class="image-container bgfull-affect-div bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div  m-0">
                                        <div class="row ml-0 ">
                                            <div class="col-xl-12 col-md-12 col-sm-12 ml-3">
                                                <i class="fa fa-minus btn btn-primary-sm" id="decrease"  onclick="decreaseValue(<?php echo $id_counter?>)"></i>
                                                <input type="number" class="number" id="number<?php echo $id_counter?>" value="0" name="quantity<?php echo $id_counter?>"/>
                                                <i class="fa fa-plus btn btn-primary-sm" id="increase" onclick="increaseValue(<?php echo $id_counter?>)" ></i>
                                                <hr> 
                                            </div>
                                        </div>
                                        <div class="div-title-background-1 row  m-0">
                                            <h4 class="heading-title-background  m-0"><?php echo $title; ?></h4>
                                        </div>
                                        <?php  if(!in_array($ext, $supported_image)){ 
                                            if($row['price'] != 0){
                                        ?>
                                        <div class="text-block bg-gradient-default-1">  
                                            <h4 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h4>
                                        </div>

                                        <?php      } } ?> 
                                    </div>
                                </div>
                                <?php    
                                    }
                                    $id_counter++;  
                                }
                    }
                                ?>
                            </div>
                        </div>
                        <!--                        Wish List Services-->

                        <!--                        Here End-->
                        <div class="col-xl-12 col-md-12 col-sm-12 mt-3 ml-3">
                            <div class="row mr-0 ml-0 mt-3 mb-2">
                                <input type="submit" name="submit" value="Request" class="btn  text-white button-background-color btn-primary" />
                            </div>
                        </div>

                    </div>
                    <input type="text" style="display :none"  name="counter" value="<?php echo $id_counter;   ?>" >
                </form>

                <?php }?>
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