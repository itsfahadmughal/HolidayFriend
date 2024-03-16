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
$sql="SELECT a.*,b.category FROM tbl_team_members as a INNER JOIN tbl_team_category as b ON a.tmc_id=b.tmc_id WHERE `hotel_id` = $hotel_id and isactive=1 ORDER BY a.tmc_id";
$result1 = $conn->query($sql);
while($row = mysqli_fetch_array($result1)) {
    array_push($cat_unique_id,$row['tmc_id']);
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
    $sql="SELECT * FROM tbl_team_category WHERE tmc_id=$t_cat_id";
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
        <title>Team</title>
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
        </style>
        <script>
            function check1() {

                var id = document.getElementById('cat_value').value;

                if (id != "") {
                    if(id == 0){
                        window.location.href = "team";
                    }else{
                        window.location.href = "team?t_cat_id=" + id;
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
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 20";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 20";
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
                                $sql="SELECT * FROM tbl_team_category";
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
                    $sql="SELECT a.*,b.category FROM tbl_team_members as a INNER JOIN tbl_team_category as b ON a.tmc_id=b.tmc_id WHERE `hotel_id` =  $hotel_id and isactive= 1 ORDER BY a.tmc_id";
                    $result2 = $conn->query($sql);
                    $i = 0;
                    $j = 0;       
                    if ($result2 && $result2->num_rows > 0) {
                        while($row = mysqli_fetch_array($result2)) {
                            if($cat_unique_id[$i] == $row['tmc_id']){
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
                                $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>

                    <div class="mr-3 ml-3 mt-2">
                        <img src="assets/img/icons/img_avatar.png" alt="" class="card-img-top">
                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-2">
                        <img src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div bgfull-affect-div">
                        <div class="div-title-background-1">
                            <h2 class="heading-title-background"><?php echo $row['first_name'] ?></h2>
                        </div>
                        <hr>
                        <p><?php echo $row['description'] ?></p>
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
                                $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>
                        <div class="mr-3 ml-3 mt-2">
                            <img src="assets/img/icons/img_avatar.png" alt="" class="card-img-top">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-2">
                            <img src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" alt="" class="card-img-top">
                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div bgfull-affect-div">
                            <div class="div-title-background-1">
                                <h2 class="heading-title-background"><?php echo $row['first_name'] ?></h2>
                            </div>
                            <hr>
                            <p><?php echo $row['description'] ?></p>
                        </div>
                    </div>
                    <?php    
                            }

                        }
                    }
                }else{
                    ?>
                    <!--                    This is else-->
                    <div class="row" class="bg-white" >
                        <div class="col-xl-4 col-md-4 col-sm-4">
                            <?php
                    $sql="SELECT a.*,b.category FROM tbl_team_members as a INNER JOIN tbl_team_category as b ON a.tmc_id=b.tmc_id WHERE `hotel_id` =  $hotel_id and a.tmc_id =  $t_cat_id and isactive= 1 ORDER BY a.tmc_id";
                    $result = $conn->query($sql);
                    $count = ceil(($result->num_rows) / 3);
                    $i=1;
                    $j=1;
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            if($i <= $count){
                                if($j==$result->num_rows && $j > 1){
                            ?>
                        </div>
                        <?php  break; } ?> 
                        <?php 
                                $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>
                        <div class="mr-3 ml-3 mt-4">
                            <img src="assets/img/icons/img_avatar.png" alt="" class="card-img-top">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-4">
                            <img src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" alt="" class="card-img-top">
                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 mt--2 hover-affect-div bgfull-affect-div" >
                            <div class="">
                                <h2 class="heading-title-background div-title-background-1"><?php echo $row['first_name'] ?></h2>
                                <hr>
                                <p><?php echo $row['description'] ?></p>

                            </div>
                        </div>
                        <?php
                                    $i++;
                                $j++;
                            }else{
                        ?>
                    </div>
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <?php 
                                $ext = strtolower(pathinfo($row['img_url'], PATHINFO_EXTENSION));
                                if(!in_array($ext, $supported_image)){ ?>
                        <div class="mr-3 ml-3 mt-4">
                            <img src="assets/img/icons/img_avatar.png" alt="" class="card-img-top">
                        </div>
                        <?php }else{?>
                        <div class="mr-3 ml-3 mt-4">
                            <img src="HolidayFriendAdmin/<?php echo $row['img_url'] ?>" alt="" class="card-img-top">
                        </div>
                        <?php } ?>
                        <div class="bg-white-opacity mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 mt--2 hover-affect-div bgfull-affect-div">
                            <div class="">
                                <h2 class="heading-title-background div-title-background-1"><?php echo $row['first_name'] ?></h2>
                                <hr>
                                <p><?php echo $row['description'] ?></p>
                            </div>

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
            <?php  include 'util-js-files.php' ?>



            </body>

        </html>
