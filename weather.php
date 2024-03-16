<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$full_dates=array();
$show_dates=array();
$weather_name="";
$selected_weather="";
$current_date = date("D d.m.Y");
$next_date = date('D d.m.Y', strtotime(' +1 day'));
//
//$dayofweek = date('w', strtotime($current_date));
//$current_day    = date('Y-m-d', strtotime(($day - $dayofweek).' day', strtotime($date)));
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
$weather_name ="";
if(isset($_GET['weather_name'])){
    $weather_name=$_GET['weather_name'];
}
if(isset($_GET['selected_weather'])){
    $selected_weather=$_GET['selected_weather'];
}

?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>Hotel - Weather</title>
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
        <script>
            function weekdateselected(v){
                window.location = v;
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
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <?php 

    $sql="SELECT * FROM `tbl_weather` WHERE `hotel_id` = $hotel_id and isactive= 1";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $title_wt=$row[2];

                $weather_url_today=$row[5];


                $title_fw=$row[8];

                $forecast_url=$row[11];

                $title_dw=$row[14];

                $district_weather_url=$row[17];

                $title_mw=$row[20];

                $mountain_weather_today_url=$row[23];



                $moduleName = "";
                $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 2";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result)) {
                        $moduleName= $row['user_module_name'];
                    }
                } 
                if ($moduleName==""){
                    $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 2";
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


                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>
                </div>
                <div class="row pt-3" id="weekdates_desktop">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <a class="<?php if($_GET['selected_weather']==""){ echo 'active_weather_btn'; } ?> btn-sm btn  text-white button-background-color <?php if(isset($_GET['selected_weather'])){echo '';}else{echo 'active';} ?>"   href="<?php if(isset($_GET['weather_name'])){echo 'weather?weather_name='.$weather_name;}else{echo 'weather';} ?>">Today Weather</a>
                        <?php if($forecast_url !=""){ ?>
                        <a class=" <?php if($_GET['selected_weather']=="forecast"){ echo 'active_weather_btn'; } ?> btn-sm btn  text-white button-background-color <?php if(isset($_GET['selected_weather']) && $selected_weather=='forecast'){echo 'active';}else{echo '';} ?>" href="<?php if(isset($_GET['weather_name'])){echo 'weather?weather_name='.$weather_name.'&selected_weather=forecast';}else{echo 'weather?selected_weather=forecast';} ?>">Forecast</a>
                        <?php } if($district_weather_url !=""){ ?>
                        <a class=" <?php if($_GET['selected_weather']=="district"){ echo 'active_weather_btn'; } ?> btn-sm btn  text-white button-background-color  <?php if(isset($_GET['selected_weather']) && $selected_weather=='district'){echo 'active';}else{echo '';} ?>" href="<?php if(isset($_GET['weather_name'])){echo 'weather?weather_name='.$weather_name.'&selected_weather=district';}else{echo 'weather?selected_weather=district';} ?>">District weather</a>
                        <?php } if($mountain_weather_today_url != ""){ ?>
                        <a class=" <?php if($_GET['selected_weather']=="mountain"){ echo 'active_weather_btn'; } ?> btn-sm btn  text-white button-background-color  <?php if(isset($_GET['selected_weather']) && $selected_weather=='mountain'){echo 'active';}else{echo '';} ?>" href="<?php if(isset($_GET['weather_name'])){echo 'weather?weather_name='.$weather_name.'&selected_weather=mountain';}else{echo 'weather?selected_weather=mountain';} ?>">Mountain weather</a>
                        <?php } ?>
                    </div>
                </div>
                <div class="row pt-3" id="weekdates_mobile" style="display:none;">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <select name="week_dates" onchange="weekdateselected(this.value)">
                            <option  <?php if($selected_weather==""){
                echo  "selected"  ;
            }?> value="weather.php?">Today Weather</option>
                            <?php if($forecast_url !=""){ ?>
                            <option <?php if($selected_weather=="forecast"){
                echo  "selected"  ;
            }?> value="weather.php?selected_weather=forecast">Forecast</option>
                            <?php } if($district_weather_url !=""){ ?>
                            <option <?php if($selected_weather=="district"){
                echo  "selected"  ;
            }?> value="weather.php?selected_weather=district">District</option>
                            <?php } if($mountain_weather_today_url !=""){ ?>
                            <option <?php if($selected_weather=="mountain"){
                echo  "selected"  ;
            }?> value="weather.php?selected_weather=mountain">Mountain</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php
                if ($selected_weather==""){
                ?>
                <div class="row pt-5">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h2 class="textstyle">The weather forecast for today, <?php echo $current_date?></h2>
                    </div>
                </div>
                <div class="row bgfull-affect-div bg-white">
                    <div class="col-xl-6 col-md-6 col-sm-6 p-4">
                        <h1><?php echo $title_wt; ?></h1>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <?php echo $weather_url_today; ?>
                    </div>
                </div>
                <?php
                }
                elseif($selected_weather=="forecast"){


                ?>
                <?php
                    if($forecast_url!=""){        
                ?>
                <div class="row pt-5">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h2 class="textstyle">The weather forecast for the next days</h2>
                    </div>
                </div>
                <div class="row bgfull-affect-div bg-white">
                    <div class="col-xl-6 col-md-6 col-sm-6 p-4">
                        <h1> <?php echo $title_fw; ?></h1>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6 p-3">
                        <?php echo $forecast_url; ?>
                    </div>
                </div>
                <?php 
                    }
                ?>
                <?php
                }
                elseif($selected_weather=="district"){


                ?>
                <?php
                    if($district_weather_url!=""){        
                ?>
                <div class="row pt-5">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h2 class="textstyle">District weather</h2>
                    </div>

                </div>
                <div class="row bgfull-affect-div bg-white">
                    <div class="col-xl-6 col-md-6 col-sm-6 p-4">
                        <h1> <?php echo $title_dw; ?></h1>
                    </div>
                    <div class="col-xl-12 col-md-12 col-sm-12 pb-3 pl-3">
                        <?php echo $district_weather_url; ?>
                    </div>
                </div>
                <?php 
                    }
                ?>
                <?php
                }
                elseif($selected_weather=="mountain"){

                ?>
                <div class="row pt-5">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h2 class="textstyle">The weather forecast for today, <?php echo $current_date?></h2>
                    </div>

                </div>
                <div class="row bgfull-affect-div bg-white">
                    <div class="col-xl-6 col-md-6 col-sm-6 p-4">
                        <h1> <?php echo $title_mw; ?></h1>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <?php echo $mountain_weather_today_url; ?>
                    </div>
                </div>

                <?php
                }
                }
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