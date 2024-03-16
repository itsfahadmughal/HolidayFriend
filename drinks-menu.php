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
$sql="SELECT a.*,b.category FROM tbl_drinks_menu as a INNER JOIN tbl_drinks_category as b ON a.drc_id=b.drc_id WHERE `hotel_id` =  $hotel_id and isactive= 1 ORDER BY a.drc_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['drc_id']);
}
$cat_unique_id = array_unique($cat_unique_id);
$cat_unique_id = array_values($cat_unique_id);
$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);
$t_cat_id=0;
$category_name = "";
if(isset($_GET['t_cat_id'])){
    $t_cat_id=$_GET['t_cat_id'];
    $sql="SELECT * FROM tbl_drinks_category WHERE drc_id=$t_cat_id";
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
        <title>Drinks Menu</title>
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
            .hero-image {
                height: 50%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
            }
            .hero-text {
                text-align: bottom;
                position: absolute;
                top: 90%;
                height: 50px;
                left: 50%;
                width: 100%;
                padding: 10px;
                transform: translate(-50%, -50%);
                color: white;
                background: rgba(0, 0, 0, 0.5);
            }
            .iframe-custom-design{
                overflow:hidden;
                border-radius: 5px;
                border:none;
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

            .p{
                font-size:1em;

            }

            .textSizeMedium{
                font-size:14px;

            }

            .hero-image {
                height: 50%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
            }

            .hero-text {
                text-align: bottom;
                position: absolute;
                top: 90%;
                height: 50px;
                left: 50%;
                width: 100%;
                padding: 10px;
                transform: translate(-50%, -50%);
                color: white;
                background: rgba(0, 0, 0, 0.5);
            }
            .iframe-custom-design{
                overflow:hidden;
                border-radius: 5px;
                border:none;
            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }

            .underline{
                height:1px;
                background-color:gray;
            }
            .underline2{
                height:1px;
                background-color:gray;
            }
            .priceElement{
                border-top: 5px solid #c5c5d8 ;
                /* color:c5c5d8 */
                float:right;
            }



        </style>
        <script>
            function check1() {

                var id = document.getElementById('cat_value').value;

                if (id != "") {
                    if(id == 0){
                        window.location.href = "drinks-menu";
                    }else{
                        window.location.href = "drinks-menu?t_cat_id=" + id;
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
                <div class="row pt-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 18";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 18";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
                    ?>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <?php  if ($t_cat_id==0){ ?>
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
                    <div class="col-xl-4 col-md-6 col-sm-6">

                    </div>

                    <div class="col-xl-4 col-md-6 col-sm-6">
                        <span class="category-select">
                            <h3 class="textstyle" style="display:inline;">Category: </h3>
                            <select name="catagory_id" id="cat_value"  onchange="check1()">
                                <option value="0">All</option>
                                <?php 
                                $sql="SELECT * FROM tbl_drinks_category";
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($row[0]==$t_cat_id){
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
                if ($t_cat_id==0){
                    $sql="SELECT a.*,b.category,c.symbol FROM tbl_drinks_menu as a INNER JOIN tbl_drinks_category as b ON a.drc_id=b.drc_id INNER JOIN tbl_hotel as d ON a.hotel_id=d.hotel_id INNER JOIN tbl_currency as c ON d.curr_id=c.curr_id WHERE a.`hotel_id` = $hotel_id and a.isactive= 1 ORDER BY a.drm_id";
                    $result2 = $conn->query($sql);
                    $i = 0;
                    $j = 0;       
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            $DrinkId           =$row["drm_id"]; // drink Menu
                            $DrinkCatId        =$row["drc_id"];  // drink category
                            $Title             =$row["drink_title"];
                            $Description       =$row["description"];
                            $Region            =$row["drink_region"];
                            $Style             =$row["drink_style"];
                            $Recommendation    =$row["recommended_for"];
                            $GlassPrice        =$row["unit_price"];
                            $BottlePrice       =$row["bottle_price"];
                            $Currency          =$row["symbol"];
                            $ImageLink         =$row["img_url"];
                            $DrinkCategoryName =$row["category"];
                            if($cat_unique_id[$i] == $row['drc_id']){
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
                <?php  $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(in_array($ext, $supported_image)) {?>
                <div class="col-xl-6 col-md-6 col-sm-6 mt-3 ">
                    <div class="bg-white mr-3 ml-3 bg-white hover-affect-div  bgfull-affect-div  ">
                        <div class="pt-2">
                            <div class="row">
                                <div class="col-xl-7 col-md-7 col-sm-7 col-xs-7"> <!-- inner column starts -->
                                    <div class="pt-2">
                                        <?php echo $Title; ?>
                                        <div class="underline "></div>   <!-- Underline -->
                                        <span> <i><p> <?php echo $Description; ?></p></i></span>
                                    </div>
                                    <div class="textSizeMedium">
                                        <?php if($Region != ""){ ?>
                                        <strong>Region:</strong> <?php echo $Region; ?> <br>
                                        <?php }
                                                                      if($Style != ""){
                                        ?>
                                        <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                        <?php } if($Recommendation != ""){ ?>
                                        <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                        <?php } ?>
                                        <div class="priceElement" >

                                            <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Glass</strong> <br> <?php }} ?>
                                            <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottle</strong><?php }} ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-md-5 col-sm-7 col-xs-7 pt-5">
                                    <img class="img-fluid pl-5"  src="HolidayFriendAdmin/<?php echo $ImageLink?>" alt="" >
                                </div>
                            </div><br>

                        </div> <!-- inner row Class ends -->
                    </div>
                </div>
                <?php }else { ?>

                <div class="col-xl-6 col-md-6 col-sm-6 mt-3  ">
                    <div class=" mr-3 ml-3 hover-affect-div  bgfull-affect-div   bg-white">

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12"> <!-- inner column starts -->
                                <div class="pt-2">
                                    <?php echo $Title; ?>
                                    <div class="underline2"></div>   <!-- Underline -->
                                    <span> <i> <p><?php echo $Description; ?></p></i></span>
                                </div>
                                <div class="textSizeMedium">
                                    <?php if($Region != ""){ ?>
                                    <strong>Region:</strong> <?php echo $Region; ?> <br>
                                    <?php }
                             if($Style != ""){
                                    ?>
                                    <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                    <?php } if($Recommendation != ""){ ?>
                                    <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                    <?php } ?>
                                    <div class="priceElement " >
                                        <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Bicchiere</strong> <br> <?php }} ?>
                                        <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottiglia</strong><?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div><br>


                    </div>
                </div>
                <?php  }?>
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
                    <?php  $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(in_array($ext, $supported_image)) {?>
                    <div class="col-xl-6 col-md-6 col-sm-6 mt-3 ">
                        <div class="bg-white mr-3 ml-3 bg-white hover-affect-div  bgfull-affect-div  ">
                            <div class="pt-2">
                                <div class="row">
                                    <div class="col-xl-7 col-md-7 col-sm-7 col-xs-7"> <!-- inner column starts -->
                                        <div class="pt-2">
                                            <?php echo $Title; ?>
                                            <div class="underline "></div>   <!-- Underline -->
                                            <span> <i><p> <?php echo $Description; ?></p></i></span>
                                        </div>
                                        <div class="textSizeMedium">
                                            <?php if($Region != ""){ ?>
                                            <strong>Region:</strong> <?php echo $Region; ?> <br>
                                            <?php }
                                                                      if($Style != ""){
                                            ?>
                                            <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                            <?php } if($Recommendation != ""){ ?>
                                            <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                            <?php } ?>
                                            <div class="priceElement" >
                                                <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Glass</strong> <br> <?php }} ?>
                                                <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottle</strong><?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-5 col-md-5 col-sm-7 col-xs-7 pt-5">
                                        <img class="img-fluid pl-5"  src="HolidayFriendAdmin/<?php echo $ImageLink?>" alt="" >
                                    </div>
                                </div><br>

                            </div> <!-- inner row Class ends -->
                        </div>
                    </div>
                    <?php }else { ?>

                    <div class="col-xl-6 col-md-6 col-sm-6 mt-3  ">
                        <div class=" mr-3 ml-3 hover-affect-div  bgfull-affect-div   bg-white">

                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12"> <!-- inner column starts -->
                                    <div class="pt-2">
                                        <?php echo $Title; ?>
                                        <div class="underline2"></div>   <!-- Underline -->
                                        <span> <i> <p><?php echo $Description; ?></p></i></span>
                                    </div>
                                    <div class="textSizeMedium">
                                        <?php if($Region != ""){ ?>
                                        <strong>Region:</strong> <?php echo $Region; ?> <br>
                                        <?php }
                                 if($Style != ""){
                                        ?>
                                        <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                        <?php } if($Recommendation != ""){ ?>
                                        <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                        <?php } ?>
                                        <div class="priceElement " >
                                            <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Bicchiere</strong> <br> <?php }} ?>
                                            <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottiglia</strong><?php }} ?>
                                        </div>
                                    </div>
                                </div>
                            </div><br>


                        </div>
                    </div>
                    <?php  }?>
                    <?php    
                            }

                        }
                    }
                }else{
                    ?>
                    <!--                    This is else   -->
                    <div class="row" class="bg-white" >
                        <div class="col-xl-6 col-md-6 col-sm-6 mt-3  ">
                            <?php 
                    $sql="SELECT a.*,b.category,c.symbol FROM tbl_drinks_menu as a INNER JOIN tbl_drinks_category as b ON a.drc_id=b.drc_id INNER JOIN tbl_hotel as d ON a.hotel_id=d.hotel_id INNER JOIN tbl_currency as c ON d.curr_id=c.curr_id WHERE a.`hotel_id` = $hotel_id and a.isactive= 1 and  a.drc_id =  $t_cat_id ORDER BY a.drm_id";
                    $result = $conn->query($sql);
                    $count = ceil(($result->num_rows) / 2);
                    $i=1;
                    $j=1;
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            $DrinkId           =$row["drm_id"]; // drink Menu
                            $DrinkCatId        =$row["drc_id"];  // drink category
                            $Title             =$row["drink_title"];
                            $Description       =$row["description"];
                            $Region            =$row["drink_region"];
                            $Style             =$row["drink_style"];
                            $Recommendation    =$row["recommended_for"];
                            $GlassPrice        =$row["unit_price"];
                            $BottlePrice       =$row["bottle_price"];
                            $Currency          =$row["symbol"];
                            $ImageLink         =$row["img_url"];
                            $DrinkCategoryName =$row["category"];
                            if($i <= $count){
                                if($j==$result->num_rows && $j > 1){
                            ?>
                        </div>
                        <?php  break; } ?> 



                        <?php  $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(in_array($ext, $supported_image)) {?>

                        <div class="bg-white mr-3 ml-3 mt-3 bg-white hover-affect-div  bgfull-affect-div  ">
                            <div class="pt-2">
                                <div class="row">
                                    <div class="col-xl-7 col-md-7 col-sm-7 col-xs-7"> <!-- inner column starts -->
                                        <div class="pt-2">
                                            <?php echo $Title; ?>
                                            <div class="underline "></div>   <!-- Underline -->
                                            <span> <i><p> <?php echo $Description; ?></p></i></span>
                                        </div>
                                        <div class="textSizeMedium">
                                            <?php if($Region != ""){ ?>
                                            <strong>Region:</strong> <?php echo $Region; ?> <br>
                                            <?php }
                                                                      if($Style != ""){
                                            ?>
                                            <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                            <?php } if($Recommendation != ""){ ?>
                                            <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                            <?php } ?>
                                            <div class="priceElement" >
                                                <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Glass</strong> <br> <?php }} ?>
                                                <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottle</strong><?php }} ?>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-xl-5 col-md-5 col-sm-5 col-xs-5 pt-5">
                                    <img class="img-fluid pl-5"  src="HolidayFriendAdmin/<?php echo $ImageLink?>" alt="" >
                                </div>
                            </div><br>

                        </div> <!-- inner row Class ends -->
                    </div>

                    <?php }else { ?>


                    <div class=" mr-3 ml-3 mt-3 hover-affect-div  bgfull-affect-div   bg-white">

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12"> <!-- inner column starts -->
                                <div class="pt-2">
                                    <?php echo $Title; ?>
                                    <div class="underline2"></div>   <!-- Underline -->
                                    <span> <i> <p><?php echo $Description; ?></p></i></span>
                                </div>
                                <div class="textSizeMedium">
                                    <?php if($Region != ""){ ?>
                                    <strong>Region:</strong> <?php echo $Region; ?> <br>
                                    <?php }
                                 if($Style != ""){
                                    ?>
                                    <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                    <?php } if($Recommendation != ""){ ?>
                                    <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                    <?php } ?>
                                    <div class="priceElement" >
                                        <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Glass</strong> <br> <?php }} ?>
                                        <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottle</strong><?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><br>


                </div>

                <?php  } ?>


                <?php
                                $i++;
                                $j++;
                            }else{
                ?>
            </div>
            <?php  $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(in_array($ext, $supported_image)) {?>
            <div class="col-xl-6 col-md-6 col-sm-6 mt-3 ">
                <div class="bg-white mr-3 ml-3 mt-3 bg-white hover-affect-div  bgfull-affect-div  ">
                    <div class="pt-2">
                        <div class="row">
                            <div class="col-xl-7 col-md-7 col-sm-7 col-xs-7"> <!-- inner column starts -->
                                <div class="pt-2">
                                    <?php echo $Title; ?>
                                    <div class="underline "></div>   <!-- Underline -->
                                    <span> <i><p> <?php echo $Description; ?></p></i></span>
                                </div>
                                <div class="textSizeMedium">
                                    <?php if($Region != ""){ ?>
                                    <strong>Region:</strong> <?php echo $Region; ?> <br>
                                    <?php }
                                                                      if($Style != ""){
                                    ?>
                                    <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                    <?php } if($Recommendation != ""){ ?>
                                    <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                    <?php } ?>
                                    <div class="priceElement " >
                                        <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Bicchiere</strong> <br> <?php }} ?>
                                        <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottiglia</strong><?php }} ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5 col-md-5 col-sm-5 col-xs-5 pt-5">
                                <img class="img-fluid pl-5"  src="HolidayFriendAdmin/<?php echo $ImageLink?>" alt="" >
                            </div>
                        </div><br>

                    </div> <!-- inner row Class ends -->
                </div>

                <?php }else { ?>

                <div class="col-xl-6 col-md-6 col-sm-6 mt-3  ">
                    <div class=" mr-3 ml-3 mt-3 hover-affect-div  bgfull-affect-div   bg-white">

                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-xs-12"> <!-- inner column starts -->
                                <div class="pt-2">
                                    <?php echo $Title; ?>
                                    <div class="underline2"></div>   <!-- Underline -->
                                    <span> <i> <p><?php echo $Description; ?></p></i></span>
                                </div>
                                <div class="textSizeMedium">
                                    <?php if($Region != ""){ ?>
                                    <strong>Region:</strong> <?php echo $Region; ?> <br>
                                    <?php }
                             if($Style != ""){
                                    ?>
                                    <strong>Style:</strong>  <?php echo $Style; ?> <br>
                                    <?php } if($Recommendation != ""){ ?>
                                    <strong>Recommended for:</strong><i> <?php echo $Recommendation; ?> </i><br>
                                    <?php } ?>
                                    <div class="priceElement " >
                                        <?php if($GlassPrice > 0){ echo $GlassPrice." ".$Currency; if($GlassPrice != ""){?> <strong>/ Bicchiere</strong> <br> <?php }} ?>
                                        <?php if($BottlePrice > 0){ echo $BottlePrice." ".$Currency; if($BottlePrice != ""){ ?><strong>/ Bottiglia</strong><?php }} ?>
                                    </div>
                                </div>
                            </div>
                        </div><br>


                    </div>

                    <?php  }?>
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
                //                Close
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
        <?php  include 'util-js-files.php' ?>


    </body>

</html>
