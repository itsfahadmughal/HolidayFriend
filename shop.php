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
$sql="SELECT a.*,b.category FROM tbl_shop_items as a INNER JOIN tbl_shop_items_category as b ON a.shc_id=b.shc_id WHERE `hotel_id` = $hotel_id and isactive=1 ORDER BY a.shc_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['shc_id']);
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
    $sql="SELECT * FROM tbl_shop_items_category WHERE shc_id=$s_cat_id";
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
        <title>Shop</title>
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
                padding-left: 20px;
                padding-right: 20px;
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
            function check1() {

                var id = document.getElementById('cat_value').value;

                if (id != "") {
                    if(id == 0){
                        window.location.href = "shop";
                    }else{
                        window.location.href = "shop?s_cat_id=" + id;
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
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 8";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 8";
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
                    <div class="col-xl-4 col-md-4 col-sm-4 mb-2">
                        <span class="category-select">
                            <h3 class="textstyle" style="display:inline;">Category: </h3>
                            <select name="catagory_id" id="cat_value"  onchange="check1()">
                                <option value="0">All</option>
                                <?php 
                                $sql="SELECT * FROM tbl_shop_items_category";
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
                    $sid_id =0;
                    $recomaneded_item = 0;
                    $recomaneded_item_name = "";
                    $recomaneded_item_discount = 0;
                    $recomaneded_item_dis = "";
                    $recomaneded_item_url = "";
                    $sql="SELECT tbl_shop_item_discount_t.*,tbl_shop_items.isactive FROM tbl_shop_item_discount_t INNER JOIN tbl_shop_items ON tbl_shop_item_discount_t.shi_id = tbl_shop_items.shi_id WHERE tbl_shop_items.isactive = 1 AND tbl_shop_item_discount_t.isactive = 1 AND tbl_shop_items.hotel_id = $hotel_id AND tbl_shop_item_discount_t.discount > 0 ORDER BY tbl_shop_item_discount_t.discount DESC LIMIT 0, 1";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            $recomaneded_item=$row[1];
                            $recomaneded_item_discount=$row[2];
                        }
                    }
                    $sql30="SELECT * FROM tbl_shop_items WHERE shi_id=$recomaneded_item";
                    $result30 = $conn->query($sql30);
                    if ($result30 && $result30->num_rows > 0) {
                        while($row = mysqli_fetch_array($result30)) {
                            $sid_id = $row[0];
                            $recomaneded_item_name=$row['item_name'];
                            $recomaneded_item_dis=$row['description'];
                        }
                        $sql40="SELECT  `img_url` FROM `tbl_shop_items_gallery` WHERE `shi_id` = $sid_id  LIMIT 1";
                        $result40 = $conn->query($sql40);       
                        if ($result40 && $result40->num_rows > 0) {
                            while($row1 = mysqli_fetch_array($result40)) {
                                $recomaneded_item_url = $row1['img_url'];
                            }}
                        if (strlen($recomaneded_item_dis) > 152) {
                            $stringCut = substr($recomaneded_item_dis, 0, 152);
                            $endPoint = strrpos($stringCut, ' ');

                            //if the string doesn't contain any space then it will cut without word basis.
                            $recomaneded_item_dis = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                            $recomaneded_item_dis .= '{...}';
                        }else{  

                        }
                ?>
                <div class="row bg-gradient-default-1">
                    <?php   
                        $ext = strtolower(pathinfo($recomaneded_item_url, PATHINFO_EXTENSION));
                        if(in_array($ext, $supported_image)){ 
                    ?>
                    <div class="col-xl-3 mt-3 mb-3 ml-3 mr-3">
                        <img height="100%" width="100%" src="HolidayFriendAdmin/<?php echo $recomaneded_item_url ?>" />

                    </div> 
                    <?php } ?>
                    <div class="col-xl-6 mt-4 ml-4 mr-4">
                        <span class="text-white">Recommendation of the day</span>

                        <h1 id="recomandation" style="cursor:pointer;" onclick="detail(<?php echo $sid_id ?>)"><?php echo $recomaneded_item_name ?></h1>
                        <span  class="text-white"><?php echo $recomaneded_item_dis ?></span><br>
                        <h3 class="text-white"><strong><?php echo "- ".$recomaneded_item_discount."% discount" ?></strong></h3><br>
                        <a  class="btn bg-white mt-4 mb-3" href="shop_item_detail?id=<?php echo $sid_id ?>">
                            Detail</a>
                    </div>
                </div>
                <?php

                    }
                ?>

                <!--                  Bwlow Start the div-->
                <?php
                    $sql="SELECT a.*,b.category,c.curr_id as mcurr_id  FROM tbl_shop_items as a INNER JOIN tbl_shop_items_category as b ON a.shc_id=b.shc_id INNER JOIN tbl_hotel  as c ON a.hotel_id=c.hotel_id WHERE a.`hotel_id` = $hotel_id and a.isactive= 1 ORDER BY a.shc_id";
                    $result2 = $conn->query($sql);
                    $i = 0;
                    $j = 0;       
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $id = $row['shi_id'];
                            $curr_id = $row['mcurr_id'];
                            $old_price = $row['old_price'];
                            $sold_out = $row['in_stock'];
                            $description = $row['description'];
                            if (strlen($description) > 152) {
                                $stringCut = substr($description, 0, 152);
                                $endPoint = strrpos($stringCut, ' ');

                                //if the string doesn't contain any space then it will cut without word basis.
                                $description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                $description .= '{...}';
                            }else{  

                            }
                            $url_image ="";
                            $currency_symbol = "";
                            $sql3="SELECT  `img_url` FROM `tbl_shop_items_gallery` WHERE `shi_id` = $id  LIMIT 1";
                            $result3 = $conn->query($sql3);       
                            if ($result3 && $result3->num_rows > 0) {
                                while($row1 = mysqli_fetch_array($result3)) {
                                    $url_image = $row1['img_url'];
                                }}
                            $sql4="SELECT  `symbol` FROM `tbl_currency` WHERE `curr_id` = $curr_id";
                            $result4 = $conn->query($sql4);       
                            if ($result4 && $result4->num_rows > 0) {
                                while($row4 = mysqli_fetch_array($result4)) {
                                    $currency_symbol = $row4['symbol'];
                                }}
                            if($cat_unique_id[$i] == $row['shc_id']){
                                if($j == 0){
                ?>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h2 class="textstyle ml-3"><?php echo $row['category'] ?></h2>
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
                            <h3  class="mt-2 inline-block text-gray"><s><?php echo $old_price.$currency_symbol." " ?></s></h3>
                            <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                            <?php
                                                   }else{
                            ?>    

                            <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                            <?php
                                } ?>
                        </div>
                        <div class="text-block1">
                            <?php if($sold_out!=0){ ?>
                            <?php
                                }else{
                            ?>      
                            <img height="100%" width="100%" src="assets/img/icons/sold.png" />
                            <?php
                                } ?>
                        </div>


                    </div>
                    <?php } ?>
                    <div class="bgfull-affect-div bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $row[0]; ?>)">
                        <div class="div-title-background-1 row">
                            <h2 class="heading-title-background"><?php echo $row['item_name'] ?></h2>
                        </div>
                        <hr>
                        <?php  if(!in_array($ext, $supported_image)){ ?>
                        <div class="text-block3 bg-gradient-default-1 row">
                            <?php if($old_price!=0){ ?>
                            <h3  class="mt-2 inline-block text-gray"><s><?php echo  $old_price.$currency_symbol." " ?></s></h3>
                            <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                            <?php
                                                   }else{
                            ?>    

                            <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                            <?php
                                } ?>
                        </div>
                        <div class="row mt-5">
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
                            else{ 
                                $i+=1; 
                                $j=0;
                                echo "</div>";
                                if($j == 0){ 
                ?> 
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h2 class="textstyle mt-3 ml-3"><?php echo $row['category'] ?></h2>
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
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo $old_price.$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="text-block1">
                                <?php if($sold_out!=0){ ?>
                                <?php
                                }else{
                                ?>      
                                <img height="100%" width="100%" src="assets/img/icons/sold.png" />
                                <?php
                                } ?>
                            </div>


                        </div>
                        <?php } ?>
                        <div class="bgfull-affect-div bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $row[0]; ?>)">
                            <div class="div-title-background-1 row">
                                <h2 class="heading-title-background"><?php echo $row['item_name'] ?></h2>
                            </div>
                            <hr>
                            <?php  if(!in_array($ext, $supported_image)){ ?>
                            <div class="text-block3 bg-gradient-default-1 row">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo  $old_price.$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="row mt-5">
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
                    $sql="SELECT a.*,b.category,c.curr_id as mcurr_id  FROM tbl_shop_items as a INNER JOIN tbl_shop_items_category as b ON a.shc_id=b.shc_id INNER JOIN tbl_hotel  as c ON a.hotel_id=c.hotel_id WHERE a.`hotel_id` = $hotel_id and a.isactive= 1 and a.shc_id =  $s_cat_id  ORDER BY a.shc_id";
                    $result = $conn->query($sql);
                    $count = ceil(($result->num_rows) / 3);
                    $i=1;
                    $j=1;
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            $id = $row['shi_id'];
                            $curr_id = $row['mcurr_id'];
                            $old_price = $row['old_price'];
                            $sold_out = $row['in_stock'];
                            $description = $row['description'];
                            if (strlen($description) > 152) {
                                $stringCut = substr($description, 0, 152);
                                $endPoint = strrpos($stringCut, ' ');

                                //if the string doesn't contain any space then it will cut without word basis.
                                $description = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                $description .= '{...}';
                            }else{  

                            }
                            $url_image ="";
                            $currency_symbol = "";
                            $sql3="SELECT  `img_url` FROM `tbl_shop_items_gallery` WHERE `shi_id` = $id  LIMIT 1";
                            $result3 = $conn->query($sql3);       
                            if ($result3 && $result3->num_rows > 0) {
                                while($row1 = mysqli_fetch_array($result3)) {
                                    $url_image = $row1['img_url'];
                                }}
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
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo $old_price.$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="text-block1">
                                <?php if($sold_out!=0){ ?>
                                <?php
                                }else{
                                ?>      
                                <img height="100%" width="100%" src="assets/img/icons/sold.png" />
                                <?php
                                } ?>
                            </div>


                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity bgfull-affect-div mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">
                            <div class="div-title-background-1 row">
                                <h2 class="heading-title-background"><?php echo $row['item_name'] ?></h2>
                            </div>
                            <hr>
                            <?php  if(!in_array($ext, $supported_image)){ ?>
                            <div class="text-block3 bg-gradient-default-1 row">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo  $old_price.$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="row mt-5">
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

                        <div class="mr-3 ml-3 mt-2 image-container ">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-2 image-container" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">

                            <img src="HolidayFriendAdmin/<?php echo $url_image ?>" alt="" class="card-img-top"/>
                            <div class="text-block bg-gradient-default-1">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo $old_price.$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="text-block1">
                                <?php if($sold_out!=0){ ?>
                                <?php
                                }else{
                                ?>      
                                <img height="100%" width="100%" src="assets/img/icons/sold.png" />
                                <?php
                                } ?>
                            </div>


                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity bgfull-affect-div mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div" style="cursor:pointer;" onclick="detail(<?php echo $id; ?>)">
                            <div class="div-title-background-1 row">
                                <h2 class="heading-title-background"><?php echo $row['item_name'] ?></h2>
                            </div>
                            <hr>
                            <?php  if(!in_array($ext, $supported_image)){ ?>
                            <div class="text-block3 bg-gradient-default-1 row">
                                <?php if($old_price!=0){ ?>
                                <h3  class="mt-2 inline-block text-gray"><s><?php echo  $old_price.$currency_symbol." " ?></s></h3>
                                <h2 class="text-white mt-2 inline-block"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                                       }else{
                                ?>    

                                <h2 class="text-white mt-2"><?php echo $row['price'].$currency_symbol ?></h2>
                                <?php
                                } ?>
                            </div>
                            <div class="row mt-5">
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
                    window.location.href = "shop_item_detail?id=" + value;
                }


            </script>
            <?php  include 'util-js-files.php' ?>

            </body>

        </html>
