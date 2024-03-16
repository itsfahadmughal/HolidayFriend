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

$supported_image = array(
    'gif',
    'jpg',
    'jpeg',
    'png'
);

$spc_id=0;
$cat_name="";

if(isset($_GET['cat'])){
    $spc_id=$_GET['cat'];
    $sql="SELECT * FROM `tbl_sport_activity_cat` WHERE spc_id=$spc_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            if($row['title'] != ""){
                $cat_name=$row['title'];    
            }
        }
    }
}

$place_id=0;
if(isset($_GET['place_id'])){
    $place_id=$_GET['place_id'];
}
$cat_id=0;
if(isset($_GET['cat_id'])){
    $cat_id=$_GET['cat_id'];
}

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>Sport - <?php echo $cat_name; ?></title>
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
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }
        </style>

        <script>
            var catid=<?php echo $cat_id ?>;
            var placeid=<?php echo $place_id ?>;
            var cat=<?php echo $spc_id ?>;
            var name='<?php echo $cat_name ?>';

            function categoryselected(val){
                if(placeid==null){
                    window.location = 'active-subcat?cat='+cat+'&name='+name+'&cat_id='+val;    
                }else{
                    window.location = 'active-subcat?cat='+cat+'&name='+name+'&cat_id='+val+'&place_id='+placeid;
                }

            }
            function placeselected(value){
                if(catid==null){
                    window.location = 'active-subcat?cat='+cat+'&name='+name+'&place_id='+value;
                }else{
                    window.location = 'active-subcat?cat='+cat+'&name='+name+'&place_id='+value+'&cat_id='+catid;    
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
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'active'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h1 class="textstyle"><?php echo $cat_name; ?></h1>
                    </div>


                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>

                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <span class="category-select mt-2">
                            <h3 class="textstyle ml-2" style="display:inline;">Category: </h3>
                            <select onchange="categoryselected(this.value)">
                                <option value="0">All</option>
                                <?php 

                                $sql="SELECT * FROM `tbl_sport_activity_subcat` where spc_id=$spc_id";

                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($cat_id==$row[0]){
                                            echo '<option selected value='.$row[0].'>'.$row[1].'</option>';
                                        }else{
                                            echo '<option value='.$row[0].'>'.$row[1].'</option>';    
                                        }

                                    }
                                }
                                ?>
                            </select>
                        </span>

                        <span class="category-select mt-2">
                            <h3 class="textstyle" style="display:inline;">Place: </h3>
                            <select onchange="placeselected(this.value)">
                                <option value="0">All</option>
                                <?php 

                                $sql="SELECT * FROM tbl_area as a inner join tbl_hotel as b on a.hotel_id=b.hotel_id inner join tbl_user as c on b.user_id=c.user_id where c.user_id='".$_SESSION['Userid']."'";

                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($place_id==$row[0]){
                                            echo '<option selected value='.$row[0].'>'.$row[1].'</option>';
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





                <div class="row">
                    <div class="col-xl-4 col-md-4 col-sm-4 div-shadow-mobile mt-2">
                        <?php

                        if($place_id != 0 && $cat_id != 0){
                            $sql="SELECT a.spac_id,a.title FROM `tbl_sport_activity` as a INNER JOIN tbl_sport_activity_subcat as b ON a.spsc_id= b.spsc_id INNER JOIN tbl_sport_activity_cat as c ON c.spc_id=b.spc_id WHERE c.spc_id=$spc_id AND a.isactive=1 AND a.hotel_id=$hotel_id AND a.area_id=$place_id AND a.spsc_id=$cat_id ORDER BY position_order";
                        }else if($place_id != 0){
                            $sql="SELECT a.spac_id,a.title FROM `tbl_sport_activity` as a INNER JOIN tbl_sport_activity_subcat as b ON a.spsc_id= b.spsc_id INNER JOIN tbl_sport_activity_cat as c ON c.spc_id=b.spc_id WHERE c.spc_id=$spc_id AND a.isactive=1 AND a.hotel_id=$hotel_id AND a.area_id=$place_id  ORDER BY position_order";
                        }elseif($cat_id != 0){
                            $sql="SELECT a.spac_id,a.title FROM `tbl_sport_activity` as a INNER JOIN tbl_sport_activity_subcat as b ON a.spsc_id= b.spsc_id INNER JOIN tbl_sport_activity_cat as c ON c.spc_id=b.spc_id WHERE c.spc_id=$spc_id AND a.isactive=1 AND a.hotel_id=$hotel_id AND a.spsc_id=$cat_id ORDER BY position_order";  
                        }else{
                            $sql="SELECT a.spac_id,a.title FROM `tbl_sport_activity` as a INNER JOIN tbl_sport_activity_subcat as b ON a.spsc_id= b.spsc_id INNER JOIN tbl_sport_activity_cat as c ON c.spc_id=b.spc_id WHERE c.spc_id=$spc_id AND a.isactive=1 AND a.hotel_id=$hotel_id ORDER BY position_order";
                        }
                        $result = $conn->query($sql);
                        $count = ceil(($result->num_rows) / 3);
                        $i=1;
                        $j=1;

                        if ($result && $result->num_rows > 0) {
                            while($row = mysqli_fetch_array($result)) {
                                $id=$row['spac_id'];
                                $img_url="";
                                $sql_inner="SELECT img_url FROM `tbl_sport_activity_gallery` where spac_id=$id";
                                $result_inner = $conn->query($sql_inner);

                                if ($result_inner && $result_inner->num_rows > 0) {
                                    while($row_inner = mysqli_fetch_array($result_inner)) {
                                        $img_url=$row_inner['img_url'];
                                    }
                                }

                                if($i <= $count){
                                    if($j==$result->num_rows && $j > 1){
                        ?>
                    </div>
                    <?php  break; } ?> 
                    <?php 
                                    $ext = strtolower(pathinfo($img_url, PATHINFO_EXTENSION));
                                    if(!in_array($ext, $supported_image)){ ?>
                    <div class="mr-3 ml-3 mt-4">

                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-4 pointer bg-affect-div" onclick="show_details(<?php echo $id; ?>)">
                        <img src="HolidayFriendAdmin/<?php echo $img_url; ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity bg-affect-div mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div pointer" onclick="show_details(<?php echo $id; ?>)">
                        <div class="div-title-background-1">
                            <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>
                        </div>

                        <?php 
                                        $sql_inner2="SELECT a.*,b.tag_title FROM `tbl_sport_activity_tag_map` as a INNER JOIN tbl_util_tags as b ON a.utag_id=b.utag_id WHERE spac_id = $id";
                                    $result_inner2 = $conn->query($sql_inner2);

                                    if ($result_inner2 && $result_inner2->num_rows > 0) {
                                        while($row_inner2 = mysqli_fetch_array($result_inner2)) {
                        ?>
                        <hr class="m-0 mb-3">
                        <p class="justify-content-between d-flex"><span><?php echo $row_inner2['tag_title']; ?></span> <span><?php echo $row_inner2['description']; ?></span></p>
                        <?php
                                        }
                                    }
                        ?>

                    </div>
                    <?php
                                    $i++;
                                    $j++;
                                }else{
                    ?>
                </div>
                <div class="col-xl-4 col-md-4 col-sm-4 div-shadow-mobile mt-2">
                    <?php 
                                    $ext = strtolower(pathinfo($img_url, PATHINFO_EXTENSION));
                                    if(!in_array($ext, $supported_image)){ ?>
                    <div class="mr-3 ml-3 mt-4">

                    </div>
                    <?php }else{?>
                    <div class="mr-3 ml-3 mt-4 pointer bg-affect-div" onclick="show_details(<?php echo $id; ?>)">
                        <img src="HolidayFriendAdmin/<?php echo $img_url ?>" alt="" class="card-img-top">
                    </div>
                    <?php } ?>
                    <div class="bg-white-opacity bg-affect-div mobile-margin-information mr-3 ml-3 pr-3 pl-3 pt-3 pb-1 hover-affect-div pointer" onclick="show_details(<?php echo $id; ?>)">
                        <div class="div-title-background-1">
                            <h2 class="heading-title-background"><?php echo $row['title'] ?></h2>
                        </div>
                        <?php 
                                        $sql_inner2="SELECT a.*,b.tag_title FROM `tbl_sport_activity_tag_map` as a INNER JOIN tbl_util_tags as b ON a.utag_id=b.utag_id WHERE spac_id = $id";
                                    $result_inner2 = $conn->query($sql_inner2);

                                    if ($result_inner2 && $result_inner2->num_rows > 0) {
                                        while($row_inner2 = mysqli_fetch_array($result_inner2)) {
                        ?>
                        <hr class="m-0 mb-3">
                        <p class="justify-content-between d-flex"><span><?php echo $row_inner2['tag_title']; ?></span> <span><?php echo $row_inner2['description']; ?></span></p>
                        <?php
                                        }
                                    }
                        ?>
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
            function show_details(value){
                window.location = 'sport-active-show?id='+value;
            }
        </script>
        <?php  include 'util-js-files.php' ?>
    </body>

</html>
