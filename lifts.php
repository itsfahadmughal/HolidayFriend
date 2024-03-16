<?php
include 'util-config.php';
$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$cat_id=0;
$cat_name="";

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
if(isset($_GET['cat_id'])){
    $cat_id=$_GET['cat_id'];
    $sql="SELECT area_name FROM `tbl_area` WHERE area_id=$cat_id";

    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $cat_name=$row['area_name'];
        }
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
        <title>Hotel - Ski Resort</title>
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

        </style>
        <script>
            function categoryselected(val){
                window.location = 'lifts?cat_id='+val;
            }

        </script>

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
                        <h3 class="textstyle back-button" onclick="window.location = 'skiing'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                </div>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>


                    <div class="col-xl-4 col-md-4 col-sm-4">

                    </div>

                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <span class="category-select">
                            <h3 class="text-white" style="display:inline;">Place: </h3>
                            <select onchange="categoryselected(this.value)">
                                <option value="0">All</option>
                                <?php 

    $sql="SELECT * FROM tbl_area as a inner join tbl_hotel as b on a.hotel_id=b.hotel_id inner join tbl_user as c on b.user_id=c.user_id where c.user_id='".$_SESSION['Userid']."'";

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
                    </div>

                </div>

                <div class="row mt-4">
                    <div class="col-xl-12 col-md-12 col-sm-12 bg-white-opacity align-text-center p-3 scroll-bar-x-smallscreen div-shadow-mobile bgfull-affect-div">
                        <table class="w-100">
                            <tbody>
                                <?php
                                if($cat_id>0){
                                    $sql="SELECT a.*,b.type,c.measuring_unit FROM `tbl_skiing_lift` as a INNER JOIN tbl_skiing_lift_type as b ON a.skl_typeid = b.skl_typeid INNER JOIN tbl_util_measuring_units as c ON a.munit_id=c.munit_id WHERE a.hotel_id=$hotel_id AND a.isactive=1 AND a.area_id=$cat_id ORDER BY a.area_id";
                                }else{
                                    $sql="SELECT a.*,b.type,c.measuring_unit FROM `tbl_skiing_lift` as a INNER JOIN tbl_skiing_lift_type as b ON a.skl_typeid = b.skl_typeid INNER JOIN tbl_util_measuring_units as c ON a.munit_id=c.munit_id WHERE hotel_id=$hotel_id AND isactive=1 ORDER BY area_id";
                                }

                                $skl_typeid=0;
                                $i=1;
                                $j=1;
                                $k=1;
                                $result = $conn->query($sql);
                                if ($result && $result->num_rows > 0) {
                                    while($row = mysqli_fetch_array($result)) {
                                        if($i==1){
                                            $j=2;
                                            $skl_typeid=$row['skl_typeid'];
                                ?>

                                <h1 class=" page-title-text" style="text-align:left;">lifts<?php if($cat_id>0){ echo ' - '.$cat_name;} ?></h1>

                                <?php
                                        }
                                        if($row['skl_typeid']==$skl_typeid){

                                            $i=2;
                                        }else{
                                            $j=2;
                                ?>

                                <h1 class="page-title-text" style="text-align:left;">lifts<?php if($cat_id>0){ echo ' - '.$cat_name;} ?></h1>

                                <?php
                                        }
                                ?>

                                <?php if($row['skl_typeid']==$skl_typeid && $j==1){

                                }else{ ?>
                                <tr>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Name</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">State</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Type</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Bike Transport</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Opening Hours</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Valley</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Mountain</th>
                                    <th class="pr-5 pl-2 pt-3 pb-3 ">Duration</th>
                          
                                </tr>
                                <?php 
                                    $j=1;} ?>

                                <tr <?php if($k%2!=0){?> style="background-color:#e9e9e9" <?php } ?>>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['name'] ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3"><?php if($row['isclosed']==0){echo "Closed";}else{"Open";}  ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3"><?php echo $row['type'] ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php if($row['isbike']==0){echo "No";}else{ echo "Yes";} ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['date_from'].' - '.$row['date_to'].'<br>'.$row['day_from'].' - '.$row['day_to'].'<br>'.$row['time_from'].' - '.$row['time_to']; ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['valley_height'].' '.$row['measuring_unit'] ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['mountain_height'].' '.$row['measuring_unit'] ?></td>
                                    <td class="pr-5 pl-2 pt-3 pb-3 "><?php echo $row['duration']." min" ?></td>
                                 
                                </tr>


                                <?php
                                    $k++;
                                    }
                                }
                                ?>

                            </tbody>
                        </table>

                    </div>
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
        <?php  include 'util-js-files.php' ?>

    </body>

</html>
