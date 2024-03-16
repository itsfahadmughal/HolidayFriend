<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$from_date="";
$to_date="";

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
if(isset($_GET['from_date'])){
    $from_date=$_GET['from_date'];
}
if(isset($_GET['to_date'])){
    $to_date=$_GET['to_date'];
}


?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
        <meta name="author" content="Creative Tim">
        <title>Hotel - Event</title>
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
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }

            .text-block {
                position: absolute;
                top: 5px;
                right: 0px;
                color: white;
                padding-right: 10px;
                padding-left: 10px;
                padding-bottom: 10px;
                padding-top: 7px;
                display: inline-block;

            }

        </style>

    </head>

    <body class="bgimg" style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="container-fluid mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i>Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 7";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 7";
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

                    <div class="col-xl-8 col-md-8 col-sm-8">
                        <span class="category-select">
                            <input class="btn-sm  btn  text-white button-background-color" id="from_date" type="text" onfocus="(this.type='date')" value="<?php if(isset($_GET['from_date'])){echo $from_date;}else{echo 'From';} ?>" />
                            <input class="btn-sm   btn  text-white button-background-color " id="to_date" type="text" onfocus="(this.type='date')" value="<?php if(isset($_GET['to_date'])){echo $to_date;}else{echo 'Until';} ?>" />
                            <span id="search_event_by_date_desktop" style="padding:6px;cursor:pointer;" onclick="searchByDate()"><i class="fas fa-search button-background-color" style="padding:3px;color:#fff;font-size:20px;"></i></span>
                            <button class=" btn  text-white button-background-color  btn-sm w-95 mt-2 ml-2" id="search_event_by_date_mobile" style="display:none;" onclick="searchByDate()">Search</button>
                        </span>
                    </div>

                </div>

                <div class="row mt-4">

                    <?php
                    if($from_date=="" || $to_date==""){
                        $sql="SELECT a.*,b.avl_date,b.from_time FROM `tbl_events` as a INNER JOIN tbl_events_availability as b on a.evnt_id=b.evnt_id WHERE a.hotel_id=$hotel_id AND a.isactive=1 ORDER BY b.avl_date DESC";
                    }else{
                        $sql="SELECT a.*,b.avl_date,b.from_time FROM `tbl_events` as a INNER JOIN tbl_events_availability as b on a.evnt_id=b.evnt_id WHERE a.hotel_id=$hotel_id AND a.isactive=1 AND b.avl_date BETWEEN '$from_date' AND '$to_date' ORDER BY b.avl_date DESC";
                    }

                    $avb_date="";
                    $i=1;
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                            if($i==1){
                                $avb_date=$row['avl_date'];
                    ?>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle"><?php echo date('l', strtotime($avb_date)).', '.$row['avl_date'] ?></h1>
                    </div>
                    <?php
                            }




                            if($row['avl_date']==$avb_date){

                                $i=2;
                            }else{
                    ?>
                    <div class="col-xl-12 col-md-12 col-sm-12">
                        <h1 class="textstyle"><?php echo date('l', strtotime($avb_date)).', '.$row['avl_date'] ?></h1>
                    </div>
                    <?php
                        $avb_date=$row['avl_date'];
                                $i=2;
                            }


                            $img_url="";
                            $sql_inner="SELECT `img_url` FROM `tbl_events_gallery` WHERE isactive = 1 AND evnt_id = $row[0] LIMIT 1";
                            $result_inner = $conn->query($sql_inner);
                            if ($result_inner && $result_inner->num_rows > 0) {
                                while($row_inner = mysqli_fetch_array($result_inner)) {
                                    $img_url=$row_inner['img_url'];
                                }
                            }

                    ?>
                    <div class="col-xl-4 col-md-4 col-sm-4 div-shadow-mobile ">
                        <a class="nav-link" href="event-show?id=<?php echo $row[0] ?>">
                            <div class="card card-profile hover-affect-div bg-affect-div">
                                <?php if($img_url != ""){ ?>
                                <img src="HolidayFriendAdmin/<?php echo $img_url; ?>" style="max-height:300px;" alt="Image placeholder" class="card-img-top card-img-bottom">
                                <div class="text-block bg-gradient-default-1">
                                    <h3 class="text-white m-0" style="text-align:center;"><?php echo $row['from_time'] ?></h3>
                                    <h5 class="text-white m-0" style="text-align:center;">o'clock</h5>
                                </div>
                                <?php } ?>
                                <div class="card-body pb-2 pl-0 pr-0">
                                    <h5 class="h3 pl-2 pt-1">
                                        <?php echo $row['title']; ?>
                                    </h5>
                                    <hr class="blue-background">
                                    <h3 class="inline-heading-block p-2"><i class="ni ni-calendar-grid-58"></i> &nbsp;&nbsp; <?php echo $row['avl_date']; ?></h3>
                                </div>
                            </div>
                        </a>

                    </div>

                    <?php 
                        }
                    }else{
                    ?>

                    <div class="col-xl-12 col-md-12 col-sm-12 mt-5 pt-5">
                        <h1 class="textstyle align-text-center">No Events Found.</h1>
                    </div>

                    <?php 
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
            function searchByDate(){
                var from= document.getElementById("from_date").value;
                var to= document.getElementById("to_date").value;

                console.log(from);
                console.log(to);

                if(from=="" || from=="From" || to=="" || to=="Until"){

                }else{
                    if(from <= to){
                        window.location = 'event?from_date='+from+'&to_date='+to;
                    }else{
                        alert("Please Select Valid Dates...");
                    }
                }
            }

        </script>
        <?php  include 'util-js-files.php' ?>



    </body>

</html>
