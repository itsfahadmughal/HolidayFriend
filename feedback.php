<?php
include 'util-config.php';

function getIPAddress() {
    //whether ip is from the share internet
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    //whether ip is from the proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    //whether ip is from the remote address
    else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


$hotel_id=0;
$user_id=0;
$logo_url="";
$bg_url="";
$errorComment="";

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


if(isset($_GET["roomNo"])){
    $rating=array();
    $rating_for=array("Cleanliness","Food","Comfort","Service","Free time activities","Entire vacation");

    $RoomNo     = $_GET["roomNo"];
    $Comments   = $_GET["comments"];
    $GuestName  = $_GET["name"];
    $rating[0]  = $_GET["cleanliness"];
    $rating[1]  = $_GET["food"];
    $rating[2]  = $_GET["comfort"];
    $rating[3]  = $_GET["service"];
    $rating[4]  = $_GET["free_time"];
    $rating[5]  = $_GET["entire_vacation"];

    $ip  = getIPAddress();


    $FeedBackQuery="INSERT INTO `tbl_hotel_feedback`( `room_num`, `comments`,`comments_it`, `comments_de`,  `guest_name`, `guest_name_it`, `guest_name_de`, `hotel_id`, `entryby_ip`)
            VALUES ('$RoomNo', '$Comments', '$Comments', '$Comments', '$GuestName', '$GuestName', '$GuestName', $hotel_id, '$ip')";
    $MakeQuery = $conn->prepare($FeedBackQuery);
    $Execute=$MakeQuery->execute();

    if($Execute){
        $last_id = $conn->insert_id;
        for($i=0;$i<6;$i++){
            $sql3="INSERT INTO `tbl_hotel_feedback_rating`(`hfb_id`, `rating_for`, `rating_val`) VALUES ($last_id,'$rating_for[$i]',$rating[$i])";
            $result3 = $conn->query($sql3);
        }
        if($result3){
            echo '<script>alert("Comments Submitted, Thank You for your time"); window.location.href = "index";</script>';
        }
    }else{
        echo '<script>alert("Something went wrong"); window.location.href = "feedback.php";</script>';
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
        <title>Feedback</title>
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

            .textSizeSmall{
                font-size:15px;
            }

            p{
                font-family: Montserrat, "Helvetica Neue", Helvetica, Arial, sans-serif;
                style:normal;
                weight:100;
                size:10px;
                line-height: 21px;
                color: #4a4a4a
            }

            .textSizeMedium{
                font-size:14px;

            }
            @media (min-width: 275px) and (max-width: 767px) {
                .back-arrow-img{
                    content:url("./assets/img/icons/back-arrow-blue.png");
                    width: 15px !important;
                    margin-bottom: 2px;
                }
            }

            .underline{
                width:300px;
                height:1px;
                background-color:gray;
            }
            .underline2{
                width:380px;
                height:1px;
                background-color:gray;
            }
            .priceElement{
                border-top: 5px solid #c5c5d8 ;
                /* color:c5c5d8 */
                float:right;
            }
            .Outer{
                border:4px solid #F9FAFA;
            }

            .php{
                margin-top:10px;
                width:50px;
                height:50px;
                float:left;

            }


        </style>
    </head>

    <body class="bgimg" style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)
                               no-repeat fixed center center;" >
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content mb-4" id="panel">
            <?php  include 'util-header.php' ?>
            <div class="mobile_height_blank"></div>
            <div class="mobile_height_blank"></div>
            <div class="row mt-3">
                <div class="col-xl-12 col-md-12 col-sm-12">
                    <h3 class="textstyle back-button" onclick="window.location = 'index'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                </div>
            </div>

            <?php 
    $moduleName = "";
        $sql="SELECT * FROM `tbl_user_module_map` WHERE `user_id` = $user_id and `umod_id` = 15";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                $moduleName= $row['user_module_name'];
            }
        } 
        if ($moduleName==""){
            $sql="SELECT * FROM `tbl_util_modules` WHERE `umod_id` = 15";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $moduleName= $row['module_name'];
                }
            } 
        }
            ?>
            <div class="row pt-3">
                <div class="col-xl-4 col-md-4 col-sm-4">
                    <h1 class="textstyle"><?php echo $moduleName; ?></h1>
                </div>
            </div>
            <div class="row bg-white-opacity bgfull-affect-div">
                <div class="col-sl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-4 mt-3">

                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 pl-2">
                            <div class="mb-4 pt-3 " style="letter-spacing: 0; font-size: 14px;">
                                We hope you are enjoying your stay! Send us a short message with your opinion and help us to improve the quality of our service.
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-3 pl-2 pb-4">
                            <!-- Rating -->
                            <div class="div">
                                <label class="form-group" for="" style="margin-bottom:-10px;">
                                    Cleanliness
                                </label><br>
                                <input type="hidden" id="php1_hidden" value="1">
                                <img src="assets/img/icons/star1.png" onclick="change(this.id);" id="php1" class="php">
                                <input type="hidden" id="php2_hidden" value="2">
                                <img src="assets/img/icons/star1.png" onclick="change(this.id);" id="php2" class="php">
                                <input type="hidden" id="php3_hidden" value="3">
                                <img src="assets/img/icons/star1.png" onclick="change(this.id);" id="php3" class="php">
                                <input type="hidden" id="php4_hidden" value="4">
                                <img src="assets/img/icons/star1.png" onclick="change(this.id);" id="php4" class="php">
                                <input type="hidden" id="php5_hidden" value="5">
                                <img src="assets/img/icons/star1.png" onclick="change(this.id);" id="php5" class="php">
                            </div>
                            <input type="hidden" name="phprating" id="phprating" value="0">
                        </div>

                        <div class="col-xl-3 col-md-3 col-sm-3 pl-2 pb-4">
                            <!-- Rating -->
                            <div class="div">
                                <label class="form-group" for="" style="margin-bottom:-10px;">
                                    Food
                                </label><br>
                                <input type="hidden" id="pphp1_hidden" value="1">
                                <img src="assets/img/icons/star1.png" onclick="change1(this.id);" id="pphp1" class="php">
                                <input type="hidden" id="pphp2_hidden" value="2">
                                <img src="assets/img/icons/star1.png" onclick="change1(this.id);" id="pphp2" class="php">
                                <input type="hidden" id="pphp3_hidden" value="3">
                                <img src="assets/img/icons/star1.png" onclick="change1(this.id);" id="pphp3" class="php">
                                <input type="hidden" id="pphp4_hidden" value="4">
                                <img src="assets/img/icons/star1.png" onclick="change1(this.id);" id="pphp4" class="php">
                                <input type="hidden" id="pphp5_hidden" value="5">
                                <img src="assets/img/icons/star1.png" onclick="change1(this.id);" id="pphp5" class="php">
                            </div>
                            <input type="hidden" name="pphprating1" id="pphprating1" value="0">
                        </div>

                        <div class="col-xl-3 col-md-3 col-sm-3 pl-2 pb-4">
                            <!-- Rating -->
                            <div class="div">
                                <label class="form-group" for="" style="margin-bottom:-10px;">
                                    Comfort
                                </label><br>
                                <input type="hidden" id="2php1_hidden" value="1">
                                <img src="assets/img/icons/star1.png" onclick="change2(this.id);" id="2php1" class="php">
                                <input type="hidden" id="2php2_hidden" value="2">
                                <img src="assets/img/icons/star1.png" onclick="change2(this.id);" id="2php2" class="php">
                                <input type="hidden" id="2php3_hidden" value="3">
                                <img src="assets/img/icons/star1.png" onclick="change2(this.id);" id="2php3" class="php">
                                <input type="hidden" id="2php4_hidden" value="4">
                                <img src="assets/img/icons/star1.png" onclick="change2(this.id);" id="2php4" class="php">
                                <input type="hidden" id="2php5_hidden" value="5">
                                <img src="assets/img/icons/star1.png" onclick="change2(this.id);" id="2php5" class="php">
                            </div>
                            <input type="hidden" name="2phprating2" id="2phprating2" value="0">
                        </div>

                        <div class="col-xl-3 col-md-3 col-sm-3 pl-2 pb-4">
                            <!-- Rating -->
                            <div class="div">
                                <label class="form-group" for="" style="margin-bottom:-10px;">Service</label><br>
                                <input type="hidden" id="3php1_hidden" value="1">
                                <img src="assets/img/icons/star1.png" onclick="change3(this.id);" id="3php1" class="php">
                                <input type="hidden" id="3php2_hidden" value="2">
                                <img src="assets/img/icons/star1.png" onclick="change3(this.id);" id="3php2" class="php">
                                <input type="hidden" id="3php3_hidden" value="3">
                                <img src="assets/img/icons/star1.png" onclick="change3(this.id);" id="3php3" class="php">
                                <input type="hidden" id="3php4_hidden" value="4">
                                <img src="assets/img/icons/star1.png" onclick="change3(this.id);" id="3php4" class="php">
                                <input type="hidden" id="3php5_hidden" value="5">
                                <img src="assets/img/icons/star1.png" onclick="change3(this.id);" id="3php5" class="php">
                            </div>
                            <input type="hidden" name="3phprating3" id="3phprating3" value="0">
                        </div>

                        <div class="col-xl-3 col-md-3 col-sm-3 pl-2 pb-4">
                            <!-- Rating -->
                            <div class="div">
                                <label class="form-group" for="" style="margin-bottom:-10px;">Free time activities</label><br>
                                <input type="hidden" id="4php1_hidden" value="1">
                                <img src="assets/img/icons/star1.png" onclick="change4(this.id);" id="4php1" class="php">
                                <input type="hidden" id="4php2_hidden" value="2">
                                <img src="assets/img/icons/star1.png" onclick="change4(this.id);" id="4php2" class="php">
                                <input type="hidden" id="4php3_hidden" value="3">
                                <img src="assets/img/icons/star1.png" onclick="change4(this.id);" id="4php3" class="php">
                                <input type="hidden" id="4php4_hidden" value="4">
                                <img src="assets/img/icons/star1.png" onclick="change4(this.id);" id="4php4" class="php">
                                <input type="hidden" id="4php5_hidden" value="5">
                                <img src="assets/img/icons/star1.png" onclick="change4(this.id);" id="4php5" class="php">
                            </div>
                            <input type="hidden" name="4phprating4" id="4phprating4" value="0">
                        </div>

                        <div class="col-xl-3 col-md-3 col-sm-3 pl-2 pb-4">
                            <!-- Rating -->
                            <div class="div">
                                <label class="form-group" for="" style="margin-bottom:-10px;">Entire vacation</label><br>
                                <input type="hidden" id="5php1_hidden" value="1">
                                <img src="assets/img/icons/star1.png" onclick="change5(this.id);" id="5php1" class="php">
                                <input type="hidden" id="5php2_hidden" value="2">
                                <img src="assets/img/icons/star1.png" onclick="change5(this.id);" id="5php2" class="php">
                                <input type="hidden" id="5php3_hidden" value="3">
                                <img src="assets/img/icons/star1.png" onclick="change5(this.id);" id="5php3" class="php">
                                <input type="hidden" id="5php4_hidden" value="4">
                                <img src="assets/img/icons/star1.png" onclick="change5(this.id);" id="5php4" class="php">
                                <input type="hidden" id="5php5_hidden" value="5">
                                <img src="assets/img/icons/star1.png" onclick="change5(this.id);" id="5php5" class="php">
                            </div>
                            <input type="hidden" name="5phprating5" id="5phprating5" value="0">
                        </div>


                        <div class="col-xl-12 col-md-12 col-sm-12 pl-2 ">
                            <div class="form-group mb-3">
                                <label class="form-group" for="" style="margin-bottom:-10px;">
                                    Note / What did you particularly like, what can we improve?
                                </label> *
                                <textarea class="form-control" name="comments" id="comments" rows="2" cols="100" required></textarea>    <!--Comments input-->
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-group" for="" style="margin-bottom:-10px;">
                                    Room Number (Optional)
                                </label><br>
                                <input type="text" name="roomNo" id="roomNo" class="form-control" >   <!--Room No input-->
                            </div>
                            <div class="form-group mb-3">
                                <label class="form-group" for="" style="margin-bottom:-10px;">
                                    Name (Optional)
                                </label><br>
                                <input type="text" name="name" id="name" class="form-control"> <!--Name input-->

                            </div><br>
                        </div><!-- ROW Ends -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12   ml-4 pl-2 "><!--Grid  -->
                            <input class="form-check-input" type="checkbox" required style="cursor: pointer;" >
                            <label class="form-check-label"  style="cursor: pointer;">
                                I have read and accept the <a href="privacy" style="text-decoration:none;">privacy policy</a>
                            </label>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 ml-2 mt-2">
                            <button onclick="send_feedback()" type="submit" name="submit" class="btn text-white button-background-color btn-primary">Submit</button>
                        </div>
                    </div>       <!-- Row END -->

                </div>   <!-- OUter Cols END -->
            </div>   <!-- Inner rows END -->

        </div>

        <!-------------------------------- Wine Cards Ends ---------------->



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

        <script>
            var rating_="1";
            var rating1_="1";
            var rating2_="1";
            var rating3_="1";
            var rating4_="1";
            var rating5_="1";

            function change(id)
            {
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating_=rating;
                document.getElementById(cname+"rating").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById(cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById(cname+j).src="assets/img/icons/star1.png";
                }
            }

            function change1(id)
            {
                var cname=document.getElementById(id).className; //php1
                var rating=document.getElementById(id+"_hidden").value; //php2
                rating1_=rating;
                document.getElementById("p"+cname+"rating1").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("p"+cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("p"+cname+j).src="assets/img/icons/star1.png";
                }
            }

            function change2(id)
            {
                var cname=document.getElementById(id).className; //php2
                var rating=document.getElementById(id+"_hidden").value;
                rating2_=rating;
                document.getElementById("2"+cname+"rating2").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("2"+cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("2"+cname+j).src="assets/img/icons/star1.png";
                }
            }

            function change3(id)
            {
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating3_=rating;
                document.getElementById("3phprating3").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("3"+cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("3"+cname+j).src="assets/img/icons/star1.png";
                }
            }

            function change4(id)
            {
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating4_=rating;
                document.getElementById("4phprating4").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("4"+cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("4"+cname+j).src="assets/img/icons/star1.png";
                }
            }

            function change5(id)
            {
                var cname=document.getElementById(id).className;
                var rating=document.getElementById(id+"_hidden").value;
                rating5_=rating;
                document.getElementById("5phprating5").innerHTML=rating;

                for(var i=rating;i>=1;i--)
                {
                    document.getElementById("5"+cname+i).src="assets/img/icons/star2.png";
                }
                var id=parseInt(rating)+1;
                for(var j=id;j<=5;j++)
                {
                    document.getElementById("5"+cname+j).src="assets/img/icons/star1.png";
                }
            }

            function send_feedback(){  
                var comment_ = document.getElementById("comments").value;
                var room_ = document.getElementById("roomNo").value;
                var name_ = document.getElementById("name").value;

                window.location.href="feedback.php?comments="+comment_+"&roomNo="+room_+"&name="+name_+"&cleanliness="+rating_+"&food="+rating1_+"&comfort="+rating2_+"&service="+rating3_+"&free_time="+rating4_+"&entire_vacation="+rating5_;

            }

        </script>


    </body>

</html>