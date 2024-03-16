<?php
include 'util-config.php';
$hotel_id=0;
$user_id=$cat_id=0;
$logo_url="";
$bg_url="";
$full_dates=array();
$show_dates=array();
$start_date="";
$selected_date="";

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

if(isset($_GET['start_date'])){
    $start_date=$_GET['start_date'];
}else{
    $start_date=date("Y-m-d");
}

if(isset($_GET['selected_date'])){
    $selected_date=$_GET['selected_date'];
}
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
        <title>Hotel - Weekly Program</title>
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
            .php{
                margin-top:10px;
                width:50px;
                height:50px;
                float:left;

            }
        </style>

        <script>
            function datechange(value){
                var catid=<?php echo $cat_id; ?>;

                if(catid==null || catid==0){
                    window.location = 'activity-calendar?start_date='+value;    
                }else{
                    window.location = 'activity-calendar?start_date='+value+'&cat_id='+catid;
                }
            }

            function categoryselected(val){
                var startdate='<?php echo $start_date; ?>';
                var selecteddate='<?php echo $selected_date; ?>';

                if(selecteddate != ''){
                    window.location = 'activity-calendar?start_date='+startdate+'&selected_date='+selecteddate+'&cat_id='+val;
                }else{
                    window.location = 'activity-calendar?start_date='+startdate+'&cat_id='+val;
                }
            }
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
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 3";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 3";
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

                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <span class="category-select">
                            <input class="btn btn-sm text-white hover-affect-div button-background-color" type="text" onfocus="(this.type='date')" value="<?php if(isset($_GET['start_date'])){echo $start_date;}else{echo 'Select Date';} ?>" id="date_w" onchange = "datechange(this.value);"  />
                        </span>
                    </div>


                </div>

                <div class="row pt-3" id="weekdates_desktop">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <a class=" <?php if(!isset($_GET['selected_date']) && $selected_date==''){echo 'active_weather_btn';} ?> btn-sm btn  text-white button-background-color  <?php if(isset($_GET['selected_date'])){echo '';}else{echo 'active';} ?>"   href="<?php if(isset($_GET['start_date'])){if(isset($_GET['cat_id'])){echo 'activity-calendar?start_date='.$start_date.'&cat_id='.$cat_id;}else{echo 'activity-calendar?start_date='.$start_date;}}else{if(isset($_GET['cat_id'])){echo 'activity-calendar?cat_id='.$cat_id;}else{echo 'activity-calendar';}} ?>">Whole Week</a>
                        <?php
                        $timestamp=strtotime($start_date);
                        for($i=0;$i<7;$i++){
                            $weekdate = strtotime("+".$i." day",$timestamp);
                            $date = date('d.m', $weekdate);
                            $day = date('l', $weekdate);
                            $full_dates[$i]=date('Y-m-d', $weekdate);
                            $show_dates[$i]=$day.', '.$date;
                        ?>
                        <a class="btn-sm btn  text-white button-background-color btn-primary <?php if(isset($_GET['selected_date']) && $selected_date==$full_dates[$i]){echo 'active_weather_btn';} ?>" href="<?php if(isset($_GET['start_date'])){if(isset($_GET['cat_id'])){echo 'activity-calendar?start_date='.$start_date.'&selected_date='.$full_dates[$i].'&cat_id='.$cat_id;}else{echo 'activity-calendar?start_date='.$start_date.'&selected_date='.$full_dates[$i];}}else{if(isset($_GET['cat_id'])){echo 'activity-calendar?selected_date='.$full_dates[$i].'&cat_id='.$cat_id;}else{echo 'activity-calendar?selected_date='.$full_dates[$i];}} ?>"><?php echo $day.', '.$date; ?></a>
                        <?php } ?>
                    </div>
                </div>

                <div class="row pt-3" id="weekdates_mobile" style="display:none;">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <select name="week_dates" onchange="weekdateselected(this.value)">
                            <option value="<?php if(isset($_GET['start_date'])){if(isset($_GET['cat_id'])){echo 'activity-calendar?start_date='.$start_date.'&cat_id='.$cat_id;}else{echo 'activity-calendar?start_date='.$start_date;}}else{if(isset($_GET['cat_id'])){echo 'activity-calendar?cat_id='.$cat_id;}else{echo 'activity-calendar';}} ?>">Whole Week</option>
                            <?php
                            $timestamp=strtotime($start_date);
                            for($i=0;$i<7;$i++){
                                $weekdate = strtotime("+".$i." day",$timestamp);
                                $date = date('d.m', $weekdate);
                                $day = date('l', $weekdate);
                                $full_dates[$i]=date('Y-m-d', $weekdate);
                                $show_dates[$i]=$day.', '.$date;

                                if($full_dates[$i]==$selected_date){
                            ?>
                            <option selected value="<?php if(isset($_GET['start_date'])){if(isset($_GET['cat_id'])){echo 'activity-calendar?start_date='.$start_date.'&selected_date='.$full_dates[$i].'&cat_id='.$cat_id;}else{echo 'activity-calendar?start_date='.$start_date.'&selected_date='.$full_dates[$i];}}else{if(isset($_GET['cat_id'])){echo 'activity-calendar?selected_date='.$full_dates[$i].'&cat_id='.$cat_id;}else{echo 'activity-calendar?selected_date='.$full_dates[$i];}} ?>"><?php echo $day.', '.$date; ?></option>

                            <?php }else{
                            ?>
                            <option value="<?php if(isset($_GET['start_date'])){if(isset($_GET['cat_id'])){echo 'activity-calendar?start_date='.$start_date.'&selected_date='.$full_dates[$i].'&cat_id='.$cat_id;}else{echo 'activity-calendar?start_date='.$start_date.'&selected_date='.$full_dates[$i];}}else{if(isset($_GET['cat_id'])){echo 'activity-calendar?selected_date='.$full_dates[$i].'&cat_id='.$cat_id;}else{echo 'activity-calendar?selected_date='.$full_dates[$i];}} ?>"><?php echo $day.', '.$date; ?></option>
                            <?php
                                } 
                            } 
                            ?>
                        </select>
                    </div>
                </div>


                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4 category_wkp_div">
                        <h3 class="textstyle" style="display:inline;">Category: </h3>
                        <select name="wpc_id" onchange="categoryselected(this.value)">
                            <option value="0">All</option>
                            <?php 
                            $sql="SELECT * FROM tbl_weekly_programs_category";
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
                    </div>
                </div>


                <?php
                $ft="";
                $tt="";
                $sql1="Weekly Programs not Available.";
                if($selected_date==''){
                    $sub_q2="";
                    if($cat_id==0){
                        $sub_q1="SELECT a.*,b.tag_title FROM `tbl_weekly_programs` as a INNER JOIN tbl_util_tags as b ON a.utag_id=b.utag_id INNER JOIN tbl_weekly_programs_category as c ON a.wpc_id=c.wpc_id WHERE a.isactive=1 AND `hotel_id` = $hotel_id AND (";   
                    }else{
                        $sub_q1="SELECT a.*,b.tag_title FROM `tbl_weekly_programs` as a INNER JOIN tbl_util_tags as b ON a.utag_id=b.utag_id INNER JOIN tbl_weekly_programs_category as c ON a.wpc_id=c.wpc_id WHERE a.isactive=1 AND `hotel_id` = $hotel_id AND a.wpc_id=$cat_id AND (";
                    }

                    for($i=0;$i<sizeof($full_dates);$i++){
                        $sub_q2.="'$full_dates[$i]' BETWEEN a.valid_from AND a.valid_to OR ";
                    }

                    $sub_q3=" ) ORDER BY a.position_order";

                    $sql1=$sub_q1.rtrim($sub_q2,'OR ').$sub_q3;

                }else{
                    if($cat_id==0){
                        $sql1="SELECT a.*,b.tag_title FROM `tbl_weekly_programs` as a INNER JOIN tbl_util_tags as b ON a.utag_id=b.utag_id INNER JOIN tbl_weekly_programs_category as c ON a.wpc_id=c.wpc_id WHERE a.isactive=1 AND `hotel_id` = $hotel_id AND '$selected_date' BETWEEN `valid_from` AND `valid_to` ORDER BY a.position_order";  
                    }else{
                        $sql1="SELECT a.*,b.tag_title FROM `tbl_weekly_programs` as a INNER JOIN tbl_util_tags as b ON a.utag_id=b.utag_id INNER JOIN tbl_weekly_programs_category as c ON a.wpc_id=c.wpc_id WHERE a.isactive=1 AND `hotel_id` = $hotel_id AND a.wpc_id=$cat_id AND '$selected_date' BETWEEN `valid_from` AND `valid_to` ORDER BY a.position_order";  
                    }
                }

                $result1 = $conn->query($sql1);
                if ($result1 && $result1->num_rows > 0) {
                    if($selected_date != ''){ 
                        $i=1;

                        while($row = mysqli_fetch_array($result1)) {
                            $key = array_search($selected_date, $full_dates);
                ?>

                <div class="row pt-4 mb--3">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle">
                            <?php
                            echo $show_dates[$key];
                            ?>
                        </h1>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="hover-affect-div row bgfull-affect-div">
                        <div class="col-xl-8 col-md-8 col-sm-8 bg-white-opacity p-3 ">
                            <h2><?php echo $row['title']; ?></h2>
                            <h4><?php echo $row['sub_title']; ?></h4>
                            <hr>
                            <?php $diff_time=(strtotime(date($row['to_time']))-strtotime($row['from_time']))/60; ?>

                            <h3><?php if($row['from_time'] != "" && $row['to_time'] != ""){ if($diff_time<0){ $ft=explode(':',$row['from_time']); $tt=explode(':',$row['to_time']);  echo '<span style="color:red;">'.$ft[0].':'.$ft[1].' - '.$tt[0].':'.$tt[1].'</span>'; }else{ $ft=explode(':',$row['from_time']); $tt=explode(':',$row['to_time']);  echo $ft[0].':'.$ft[1].' - '.$tt[0].':'.$tt[1]; } } ?> | Meeting point: <?php echo $row['meeting_point']; ?></h3>

                            <p><?php echo $row['description']; ?></p>
                            <span><h3 class="blue-text inline-heading-block"><?php if($row['tag_description'] != ""){ echo $row['tag_title']; } ?></h3> <?php if($row['tag_description'] != ""){ echo ":".$row['tag_description']; } ?></span><br>
                            <h3 class="text-red inline-heading-block"><?php if($row['attention']!=""){ echo "Attention: ".$row['attention']."<br>"; } ?></h3>
                            <span>Max Participants: <?php echo $row['max_participants']; ?><?php if($row['confirmed_participants']!=""){ echo " | Confirmed Participants: ".$row['confirmed_participants']; } ?></span>
                            <div class="mt-4">
                                <?php  if($row['registration_button']==1){ ?>
                                <a class="btn btn-primary text-white hover-affect-div button-background-color" href="weekprogram-registration.php?wkp_id=<?php echo $row[0]; ?>">Register</a>
                                <?php } 
                            if($row['evaluation_button']==1){
                                ?>
                                <a class="btn btn-primary text-white hover-affect-div button-background-color" id="eval-btn-<?php echo $i; ?>" href="javascript:void(0);" onclick="eval_show(<?php echo $i; ?>)">Evaluate <i class="ni ni-like-2 button-background-color"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 bg-white-opacity p-3">
                            <img src="HolidayFriendAdmin/<?php echo $row['img_url']; ?>" class="w-100" />
                        </div>

                        <div class="col-xl-12 col-md-12 col-sm-12 bg-white-opacity pb-3" id="eval-div-<?php echo $i; ?>" style="display:none;">
                            <div class="row">
                                <h3>Have you participated in this activity? We would be glad to know your opinion.</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-md-4 col-sm-4">
                                    <span>Rate</span>
                                    <br>
                                    <div class="form-field-top mb-10">
                                        <!-- Rating -->
                                        <div class="div">
                                            <input type="hidden" id="wkp_id_<?php echo $i; ?>" value="<?php echo $row['wkp_id']; ?>" />
                                            <input type="hidden" id="<?php echo $i; ?>php1_hidden" value="1">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php1" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php2_hidden" value="2">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php2" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php3_hidden" value="3">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php3" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php4_hidden" value="4">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php4" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php5_hidden" value="5">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php5" class="php">
                                        </div>
                                        <input type="hidden" name="phprating" id="phprating" value="0">
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-8 col-sm-8">
                                    <span>Comment</span>
                                    <textarea rows="4" class="w-100" id="feedback_comment_<?php echo $i; ?>"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-sm-6">
                                    <a class="btn  text-white button-background-color btn-primary" href="javascript:void(0);" onclick="send_feedback(<?php echo $i; ?>)">Send feedback</a>
                                    <a class="btn  text-white button-background-color btn-primary" href="javascript:void(0);" onclick="eval_hide(<?php echo $i; ?>)">Abort</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
                            $i++;

                        }
                    }else{
                        $i=1;
                        $j=0;
                        $data=array();
                        while($row = mysqli_fetch_array($result1)){
                            $data[] = $row;
                        }

                        for($k=0;$k<sizeof($full_dates);$k++){
                            $j=0;
                            foreach ($data as $row){

                                if(($full_dates[$k] >= $row['valid_from']) && ($full_dates[$k] <= $row['valid_to'])){
                ?>
                <div class="row pt-4 mb--3">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle">
                            <?php
                                    if($j==0){
                                        echo $show_dates[$k];
                                        $j++;
                                    }

                            ?>
                        </h1>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="hover-affect-div row bgfull-affect-div">
                        <div class="col-xl-8 col-md-8 col-sm-8 bg-white-opacity p-3 ">
                            <h2><?php echo $row['title']; ?></h2>
                            <h4><?php echo $row['sub_title']; ?></h4>
                            <hr>
                            <?php $diff_time=(strtotime(date($row['to_time']))-strtotime($row['from_time']))/60; ?>

                            <h3><?php if($row['from_time'] != "" && $row['to_time'] != ""){ if($diff_time<0){ $ft=explode(':',$row['from_time']); $tt=explode(':',$row['to_time']);  echo '<span style="color:red;">'.$ft[0].':'.$ft[1].' - '.$tt[0].':'.$tt[1].'</span>'; }else{ $ft=explode(':',$row['from_time']); $tt=explode(':',$row['to_time']);  echo $ft[0].':'.$ft[1].' - '.$tt[0].':'.$tt[1]; } } ?> | Meeting point: <?php echo $row['meeting_point']; ?></h3>

                            <p><?php echo $row['description']; ?></p>
                            <span><h3 class="blue-text inline-heading-block"><?php if($row['tag_description'] != ""){ echo $row['tag_title']; } ?></h3> <?php if($row['tag_description'] != ""){ echo ":".$row['tag_description']; } ?></span><br>
                            <h3 class="text-red inline-heading-block"><?php if($row['attention']!=""){ echo "Attention: ".$row['attention']."<br>"; } ?></h3>
                            <span>Max Participants: <?php echo $row['max_participants']; ?><?php if($row['confirmed_participants']!=""){ echo " | Confirmed Participants: ".$row['confirmed_participants']; } ?></span>
                            <div class="mt-4">
                                <?php  if($row['registration_button']==1){ ?>
                                <a class="btn btn-primary text-white hover-affect-div button-background-color" href="weekprogram-registration.php?wkp_id=<?php echo $row[0]; ?>">Register</a>
                                <?php } 
                                    if($row['evaluation_button']==1){
                                ?>
                                <a class="btn btn-primary text-white hover-affect-div button-background-color" id="eval-btn-<?php echo $i; ?>" href="javascript:void(0);" onclick="eval_show(<?php echo $i; ?>)">Evaluate <i class="ni ni-like-2 button-background-color"></i></a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4 col-sm-4 bg-white-opacity p-3">
                            <img src="HolidayFriendAdmin/<?php echo $row['img_url']; ?>" class="w-100" />
                        </div>

                        <div class="col-xl-12 col-md-12 col-sm-12 bg-white-opacity pb-3" id="eval-div-<?php echo $i; ?>" style="display:none;">
                            <div class="row">
                                <h3>Have you participated in this activity? We would be glad to know your opinion.</h3>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-md-4 col-sm-4">
                                    <span>Rate</span>
                                    <br>
                                    <div class="form-field-top mb-10">
                                        <!-- Rating -->
                                        <div class="div">
                                            <input type="hidden" id="wkp_id_<?php echo $i; ?>" value="<?php echo $row['wkp_id']; ?>" />
                                            <input type="hidden" id="<?php echo $i; ?>php1_hidden" value="1">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php1" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php2_hidden" value="2">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php2" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php3_hidden" value="3">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php3" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php4_hidden" value="4">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php4" class="php">
                                            <input type="hidden" id="<?php echo $i; ?>php5_hidden" value="5">
                                            <img src="assets/img/icons/star1.png" onmouseover="change(this.id,<?php echo $i; ?>);" id="<?php echo $i; ?>php5" class="php">
                                        </div>
                                        <input type="hidden" name="phprating" id="phprating" value="0">
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-8 col-sm-8">
                                    <span>Comment</span>
                                    <textarea rows="4" class="w-100" id="feedback_comment_<?php echo $i; ?>"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-sm-6">
                                    <a class="btn  text-white button-background-color btn-primary" href="javascript:void(0);" onclick="send_feedback(<?php echo $i; ?>)">Send feedback</a>
                                    <a class="btn  text-white button-background-color btn-primary" href="javascript:void(0);" onclick="eval_hide(<?php echo $i; ?>)">Abort</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
                                }
                                $i++;
                            }
                        }
                    }
                }else{
                ?>
                <div class="row pt-4 mt-9">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle align-text-center">No Weekly Programm Found.</h1>
                    </div>
                </div>
                <?php
                }
                ?>

            </div>
            <div id="snackbar">Some text some message..</div>
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

            function eval_show(id){
                var eval_btn= document.getElementById("eval-btn-"+id);
                var eval_div= document.getElementById("eval-div-"+id);   

                eval_btn.style.display = 'none';   
                eval_div.style.display = 'inline-block';   

            }
            function eval_hide(id){
                var eval_btn= document.getElementById("eval-btn-"+id);
                var eval_div= document.getElementById("eval-div-"+id);   

                eval_btn.style.display = 'inline-block';   
                eval_div.style.display = 'none';  
            }

            var rating_=1;
            function change(id,n)
            {
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating_=rating;
                document.getElementById(cname+"rating").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById(n+cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById(n+cname+j).src="assets/img/icons/star1.png";
                }
            }

            function send_feedback(id){
                var eval_btn= document.getElementById("eval-btn-"+id);
                var eval_div= document.getElementById("eval-div-"+id);   
                var comment_ = document.getElementById("feedback_comment_"+id).value;
                var wkp_id_ =document.getElementById("wkp_id_"+id).value;
                console.log(eval_btn);
                console.log(eval_div);

                if(comment_==''){
                    var x = document.getElementById("snackbar");
                    x.className = "show";
                    x.innerHTML="Please add feedback.";
                    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                }else{
                    $.ajax({
                        url:"util-add-weekly-program-feedback.php",
                        method:"POST",
                        data:{wkp_id:wkp_id_,rating:rating_,comment:comment_},
                        success:function(data)
                        {
                            eval_btn.style.display = 'inline-block';   
                            eval_div.style.display = 'none';
                            var x = document.getElementById("snackbar");
                            x.className = "show";
                            x.innerHTML=data;
                            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                        }
                    });
                }
            }

        </script>
        <?php  include 'util-js-files.php' ?>



    </body>

</html>
