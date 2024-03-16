<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
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
$sql="SELECT a.*,b.wellness_category FROM tbl_treatment as a INNER JOIN tbl_treatment_category as b ON a.wlc_id=b.wlc_id WHERE `hotel_id` =  $hotel_id and isactive= 1 ORDER BY a.wlc_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['wlc_id']);
}
$cat_unique_id = array_unique($cat_unique_id);
$cat_unique_id = array_values($cat_unique_id);
$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);
$s_cat_id=0;
$category_name = "";
if(isset($_GET['s_cat_id'])){
    $s_cat_id=$_GET['s_cat_id'];
    $sql="SELECT * FROM tbl_treatment_category WHERE wlc_id=$s_cat_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $category_name=$row[1];
        }
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
        <title>Wellness &amp; Beauty</title>
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
                left: 0px;
                border-radius: 0px 3px 3px 0;
                color: white;
                padding-left: 5px;
                padding-right: 5px;
                display: inline-block;

            }
            .text-block1 {
                left: -4px;
                color: white;
                border-radius: 0px 3px 3px 0;
                padding-left: 5px;
                padding-right: 5px;
                position: absolute;
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
            function check1() {

                var id = document.getElementById('cat_value').value;

                if (id != "") {
                    if(id == 0){
                        window.location.href = "treatments";
                    }else{
                        window.location.href = "treatments?s_cat_id=" + id;
                    }
                } else{
                    alert('Oops.!!');
                }
            }
        </script>

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
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>

                    </div>
                </div>
                <div class="row pt-3 mb-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 21";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 21";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                    ?>
                    <div class="col-xl-8 col-md-8 col-sm-8">
                        <?php  if ($s_cat_id==0){ ?>
                        <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                        <?php
}
                        else{
                        ?>
                        <h1 class="textstyle"><?php echo $moduleName." - ".$category_name?></h1>
                        <?php                    
                        }

                        ?>
                    </div>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <span class="category-select">
                            <h3 class="textstyle" style="display:inline;">Category: </h3>
                            <select name="catagory_id" id="cat_value"  onchange="check1()">
                                <option value="0">All</option>
                                <?php 
                                $sql="SELECT * FROM tbl_treatment_category";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($row[0]==$s_cat_id){
                                            echo '<option selected  value='.$row[0].'>'.$row[1].'</option>';
                                        }else{
                                            echo '<option value='.$row[0].'>'.$row[1].'</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </span>
                    </div>
                </div>
                <?php
                if ($s_cat_id==0){
                ?>
                <!--                Recommendation of the day-->

                <?php 
                    $wb_id =0;
                    $recomaneded_discount = 0;
                    $recomaneded_title = "";
                    $recomaneded_description = "";
                    $recomaneded_url = "";
                    $recomaneded_duration = "";
                    $sql="SELECT * FROM `tbl_treatment` WHERE isactive = 1 and hotel_id=$hotel_id and `discount` > 0  ORDER BY `tbl_treatment`.`discount` DESC LIMIT 0, 1";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            $wb_id=$row[0];
                            $recomaneded_discount=$row['discount'];
                            $recomaneded_title=$row['title'];
                            $recomaneded_description=$row['description'];
                            $recomaneded_duration=$row['duration'];
                            $recomaneded_url = $row['image_url'];
                        }
                        $recomaneded_description = $recomaneded_description;
                        if (strlen($recomaneded_description) > 152) {
                            $stringCut = substr($recomaneded_description, 0, 152);
                            $endPoint = strrpos($stringCut, ' ');

                            //if the string doesn't contain any space then it will cut without word basis.
                            $recomaneded_description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $recomaneded_description .= '{...}';
                        }else{  

                        }
                ?>
                <div class="row bg-gradient-default-1 ">
                    <?php   
                        $ext = strtolower(pathinfo($recomaneded_url, PATHINFO_EXTENSION));
                        if(in_array($ext, $supported_image)){ 
                    ?>
                    <div class="col-xl-3 mt-3 mb-3 ml-3 mr-3">
                        <img height="100%" width="100%" src="HolidayFriendAdmin/<?php echo $recomaneded_url ?>" />
                    </div>
                    <?php    
                        } ?> 
                    <div class="col-xl-6 mt-4 ml-4 mr-4">
                        <span class="text-white">Recommendation of the day</span>

                        <h1 id="recomandation" style="cursor:pointer;" onclick="detail(<?php echo $wb_id ?>)"><?php echo $recomaneded_title ?></h1>

                        <span  class="text-white"><?php echo $recomaneded_description ?></span><br>
                        <h4 class="text-white"><b><?php echo $recomaneded_discount."% discount" ?></b></h4><br>
                        <a  class="btn bg-white mt-4 mb-3" href="treatments_detail?id=<?php echo $wb_id ?>">
                            Request availability</a>
                    </div>
                </div>
                <?php

                    }
                ?>
                <!--                  Bwlow Start the div-->
                <?php
                    $url_image ="";
                    $sql="SELECT a.*,b.wellness_category,c.curr_id AS mcurr_id FROM tbl_treatment as a INNER JOIN tbl_treatment_category as b ON a.wlc_id=b.wlc_id INNER JOIN tbl_hotel as c ON a.hotel_id=c.hotel_id WHERE a.`hotel_id` = $hotel_id and a.isactive= 1 ORDER BY a.wlc_id, a.position_order, a.position_order";
                    $result2 = $conn->query($sql);
                    $i = 0;
                    $j = 0;       
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $id = $row['wb_id'];
                            $curr_id = $row['mcurr_id'];
                            $price = $row['price'];
                            $old_price = $row['old_price'];
                            $description = $row['description'];
                            $url_image = $row['image_url'];
                            if (strlen($description) > 152) {
                                $stringCut = substr($description, 0, 152);
                                $endPoint = strrpos($stringCut, ' ');

                                //if the string doesn't contain any space then it will cut without word basis.
                                $description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                $description .= '{...}';
                            }else{  

                            }

                            $currency_symbol = "";
                            $sql4="SELECT  `symbol` FROM `tbl_currency` WHERE `curr_id` = $curr_id";
                            $result4 = $conn->query($sql4);       
                            if ($result4 && $result4->num_rows > 0) {
                                while($row4 = mysqli_fetch_array($result4)) {
                                    $currency_symbol = $row4['symbol'];
                                }}
                            if($cat_unique_id[$i] == $row['wlc_id']){
                                if($j == 0){
                ?>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h2 class="textstyle ml-3"><?php echo $row['wellness_category'] ?></h2>
                    </div>
                </div> 
                <?php
                    $j=1; 
                                    echo "<div class='row'>";    
                                }
                ?>
                <div class="col-xl-4 col-md-4 col-sm-4">

                    <?php 

                                $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>

                    <div class="mr-3 ml-3 mt-2 image-container">
                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-2 image-container" style="cursor:pointer;" onclick="detail(<?php echo $row[0]; ?>)">

                        <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                        <div class="text-block bg-gradient-default-1">
                            <?php if($old_price!=0){ ?>
                            <h3  class="mt-2 inline-block text-gray p-2"><s><?php echo number_format($old_price).$currency_symbol." " ?></s></h3>
                            <h2 class="text-white mt-2 inline-block p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                            <?php
                                                   }else{
                            ?>    

                            <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                            <?php
                                } ?>
                        </div>



                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity bgfull-affect-div mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $row[0]; ?>)">
                        <div class="div-title-background-1 row">
                            <h2 class="heading-title-background w-100"><?php echo $row['title'] ?></h2>
                        </div>
                        <hr>
                        <?php  if(!in_array($ext, $supported_image)){ ?>

                        <div class="text-block1 bg-gradient-default-1 row">
                            <?php if($old_price!=0){ ?>
                            <h3  class="mt-2 inline-block text-gray p-2"><s><?php echo  number_format($old_price).$currency_symbol." " ?></s></h3>
                            <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                            <?php
                                                   }else{
                            ?>    

                            <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                            <?php
                                } ?>
                        </div>

                        <div class="row mt-5 pt-5">
                            <?php echo $description ?>
                        </div>

                        <?php       }else{ ?>
                        <div class="row">
                            <?php echo $description ?>
                        </div>
                        <?php }?>
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
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h2 class="textstyle mt-3 ml-3"><?php echo $row['wellness_category'] ?></h2>
                    </div>
                </div>                        
                <?php
                    $j=1;  
                                }
                ?>
                <div class='row'>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <?php 

                                $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>

                        <div class="mr-3 ml-3 mt-2 image-container">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-2 image-container" style="cursor:pointer;" onclick="detail(<?php echo $row[0]; ?>)">

                            <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                            <div class="text-block bg-gradient-default-1">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray p-2"><s><?php echo number_format($old_price).$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    
                                <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity bgfull-affect-div mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $row[0]; ?>)">
                            <div class="div-title-background-1 row">
                                <h2 class="heading-title-background w-100"><?php echo $row['title'] ?></h2>
                            </div>
                            <hr>
                            <?php  if(!in_array($ext, $supported_image)){ ?>

                            <div class="text-block1 bg-gradient-default-1 row">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray p-2"><s><?php echo  number_format($old_price).$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>

                            <div class="row mt-5 pt-5">
                                <p><?php echo $description ?></p>
                            </div>

                            <?php       }else{ ?>
                            <div class="row">
                                <p><?php echo $description ?></p>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php    
                            }

                        }
                    }
                }else{
                    ?>
                    <!--                    this is else When catagory-->
                    <div class="row" class="bg-white" >

                        <div class="col-xl-4 col-md-4 col-sm-4">
                            <?php
                    $sql="SELECT a.*,b.wellness_category,c.curr_id AS mcurr_id FROM tbl_treatment as a INNER JOIN tbl_treatment_category as b ON a.wlc_id=b.wlc_id INNER JOIN tbl_hotel as c ON a.hotel_id=c.hotel_id WHERE a.`hotel_id` = $hotel_id and a.isactive= 1 and a.wlc_id = $s_cat_id ORDER BY a.wlc_id, a.position_order, a.position_order";
                    $result = $conn->query($sql);
                    $count = ceil(($result->num_rows) / 3);
                    $i=1;
                    $j=1;
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            $id = $row['wb_id'];
                            $curr_id = $row['mcurr_id'];
                            $old_price = $row['old_price'];
                            $description = $row['description'];
                            $url_image = $row['image_url'];
                            if (strlen($description) > 152) {
                                $stringCut = substr($description, 0, 152);
                                $endPoint = strrpos($stringCut, ' ');

                                //if the string doesn't contain any space then it will cut without word basis.
                                $description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                $description .= '{...}';
                            }else{  

                            }
                            $currency_symbol = "";
                            $sql4="SELECT  `symbol` FROM `tbl_currency` WHERE `curr_id` = $curr_id";
                            $result4 = $conn->query($sql4);       
                            if ($result4 && $result4->num_rows > 0) {
                                while($row4 = mysqli_fetch_array($result4)) {
                                    $currency_symbol = $row4['symbol'];
                                }}
                            if($i <= $count){
                                if($j==$result->num_rows && $j > 1){
                            ?>
                        </div>
                        <?php  break; } ?> 
                        <?php 

                                $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>

                        <div class="mr-3 ml-3 mt-2 image-container">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-2 image-container" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">

                            <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                            <div class="text-block bg-gradient-default-1">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray p-2"><s><?php echo number_format($old_price).$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity bgfull-affect-div mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">
                            <div class="div-title-background-1 row">
                                <h2 class="heading-title-background w-100"><?php echo $row['title'] ?></h2>
                            </div>
                            <hr>
                            <?php  if(!in_array($ext, $supported_image)){ ?>
                            <div class="text-block1 bg-gradient-default-1 row">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray p-2"><s><?php echo  number_format($old_price).$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="row mt-5 pt-5">
                                <p><?php echo $description ?></p>
                            </div>

                            <?php       }else{ ?>
                            <div class="row">
                                <p><?php echo $description ?></p>
                            </div>
                            <?php }?>
                        </div>
                        <?php
                                $i++;
                                $j++;
                            }else{
                        ?>
                    </div>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <?php 

                                $ext = strtolower(pathinfo($url_image, PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>

                        <div class="mr-3 ml-3 mt-2 image-container">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-2 image-container" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">

                            <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                            <div class="text-block bg-gradient-default-1">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo number_format($old_price).$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity bgfull-affect-div mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">
                            <div class="div-title-background-1 row">
                                <h2 class="heading-title-background w-100"><?php echo $row['title'] ?></h2>
                            </div>
                            <hr>
                            <?php  if(!in_array($ext, $supported_image)){ ?>
                            <div class="text-block1 bg-gradient-default-1 row">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo  number_format($old_price).$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 p-2 inline-block"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2 p-2"><?php echo number_format($row['price']).$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="row mt-5 pt-5">
                                <p><?php echo $description ?></p>
                            </div>

                            <?php       }else{ ?>
                            <div class="row">
                                <p><?php echo $description ?></p>
                            </div>
                            <?php }?>
                        </div>
                        <?php
                                $i=2;
                            }
                        ?>
                        <?php
                        }
                    }
                        ?>
                    </div>
                    <?php

                }
                    ?>



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
                function detail(value){
                    window.location.href = "treatments_detail?id=" + value;
                }


            </script>


            <?php  include 'util-js-files.php' ?>

            </body>

        </html>
