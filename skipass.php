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
$phone="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT logo_url,bg_img_url,phone from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $phone=$row['phone'];
    }
}

if(isset($_POST['submit'])){
    $firstname[0]=$_POST['input_first_name'];
    $lastname[0]=$_POST['input_last_name'];
    $room[0]=$_POST['input_room_number'];
    $dob[0]=$_POST['input_dob'];
    $gender[0]=$_POST['input_gender'];
    $nod[0]=$_POST['input_nod'];
    $valid_from[0]=$_POST['input_valid'];
    $skipass_type[0]=$_POST['input_skipass_type'];

    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");

    for($i=0;$i<100;$i++){
        if(isset($_POST['input_first_name_'.$i])){
            $firstname[$i+1]=$_POST['input_first_name_'.$i];
            $lastname[$i+1]=$_POST['input_last_name_'.$i];
            $room[$i+1]=$_POST['input_room_number_'.$i];
            $dob[$i+1]=$_POST['input_dob_'.$i];
            $gender[$i+1]=$_POST['input_gender_'.$i];
            $nod[$i+1]=$_POST['input_nod_'.$i];
            $valid_from[$i+1]=$_POST['input_valid_'.$i];
            $skipass_type[$i+1]=$_POST['input_skipass_type_'.$i];
        }else{
            break;
        }
    }

    for($j=0;$j<sizeof($firstname);$j++){
        $sql="INSERT INTO `tbl_skiing_pass_request`(`first_name`, `last_name`, `room_number`, `d_o_b`, `gender`, `number_of_days`, `valid_from`, `skipsty_id`, `hotel_id`, `entrytime`, `entrybyip`, `lastedittime`, `lasteditbyip`, `status_id`) VALUES ('$firstname[$j]','$lastname[$j]','$room[$j]','$dob[$j]','$gender[$j]',$nod[$j],'$valid_from[$j]',$skipass_type[$j],$hotel_id,'$entry_time','$entryby_ip','$last_edit_time','$last_editby_ip',1)";

        $stmt = $conn->query($sql);
    }

    if(!$stmt){
        echo '<script>alert("Something went wrong!!!");</script>';
    }else{
        echo '<script>alert("Order Sent Successfully..."); window.location.href = "skiing";</script>';    
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
        <title>Skipass</title>
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
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css">
        <!-- jQuery 1.7.2+ or Zepto.js 1.0+ -->
        <script src="assets/js/jquery.min.js"></script>
        <!-- Magnific Popup core JS file -->
        <script src="assets/js/jquery.magnific-popup.js"></script>

        <link href="assets/calendar/css/mobiscroll.javascript.min.css" rel="stylesheet" />
        <script src="assets/calendar/js/mobiscroll.javascript.min.js"></script>


        <style>
            .gallery img {
                border: 1px solid black;
            }
            .image-container {
                position: relative;
            }
            .text-block {
                position: absolute;
                top: 10px;
                left: 0px;
                color: white;
                padding-left: 20px;
                padding-right: 20px;
                display: inline-block;
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
            ul.images {
                margin: 0;
                padding: 0;
                display: flex;
                flex-direction: row;
                width: 900px;
                overflow-x: auto;
            }

            ul.images li {
                flex: 0 0 auto;
                width: 150px;
                height: 150px;
            }

            ol, ul { list-style: none }

            *, *::before, *::after {
                box-sizing: inherit;
                margin: 0;
                padding: 0;
            }

            .container_slider {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
            }

            .thumbnails {
                display: -webkit-box;
                display: -ms-flexbox;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                line-height: 0;  
                height: 400px;
                width: 100px;
            }

            .thumbnails li {
                -webkit-box-flex: 1;
                -ms-flex: auto;


            }

            .thumbnails a { display: block; }

            .thumbnails img {
                width: 12vmin;
                height: 10vmin;
                -o-object-fit: cover;
                object-fit: cover;
                -o-object-position: top;
                object-position: top;
            }

            .slides { overflow: hidden; }



            .slides li {
                position: absolute;
                z-index: 1;
            }
            @-webkit-keyframes 
            slide {  0% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                }
                100% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                }
            }
            @keyframes 
            slide {  0% {
                -webkit-transform: translateY(-100%);
                transform: translateY(-100%);
                }
                100% {
                    -webkit-transform: translateY(0%);
                    transform: translateY(0%);
                }
            }

            .slides li:target {
                z-index: 3;
                -webkit-animation: slide 1s 1;
            }
            @-webkit-keyframes 
            hidden {  0% {
                z-index: 2;
                }
                100% {
                    z-index: 2;
                }
            }
            @keyframes 
            hidden {  0% {
                z-index: 2;
                }
                100% {
                    z-index: 2;
                }
            }

            .slides li:not(:target) { -webkit-animation: hidden 1s 1; }
        </style>

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="container-fluid mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row">
                    <div class="col-xl-5 col-md-5 col-sm-5">
                        <h3 class="textstyle back-button" onclick="window.location = 'skiing'"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</h3>
                    </div>
                </div>
                <div class="row mb--3">
                    <div class="col-xl-7 col-md-7 col-sm-7 pl-2">
                        <h2 class="textstyle">Request Skipass</h2>
                    </div>
                </div>

                <div class="row">

                    <div class ="col-xl-12 col-md-12 col-sm-12 mt-2 pr-3 pl-3 pb-3 mobile_padding_none bgfull-affect-div">

                        <form method="post">
                            <div class="row m-0 bg-white-opacity pt-3 pr-3 pl-3 pb-3 div-shadow-mobile" id="order_div">




                                <div id="panel_body_id">
                                    <div id="repeat_div" class="row m-0">
                                        <div class="col-xl-12 col-md-12 col-sm-12">
                                            <p>Here you can request your skipass simply and conveniently from your room. The Skipass will be prepared for you and can be picked up in a few hours at the Reception.</p>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-4">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_first_name">First Name</label>
                                                <input type="text" id="input_first_name" name="input_first_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-4">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_last_name">Last Name</label>
                                                <input type="text" id="input_last_name" name="input_last_name" class="form-control"  required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-4">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_room_number">Room Number</label>
                                                <input type="text" id="input_room_number" name="input_room_number" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_dob">Date of Birth</label>
                                                <input type="date" id="input_dob" name="input_dob" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-md-6 col-sm-6">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_gender">Gender</label>
                                                <select class="form-control" name="input_gender" id="input_gender">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-4">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_nod">Number of Days</label>
                                                <select class="form-control" name="input_nod" id="input_nod">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                    <option value="13">13</option>
                                                    <option value="14">14</option>
                                                    <option value="15">15</option>
                                                    <option value="16">16</option>
                                                    <option value="17">17</option>
                                                    <option value="18">18</option>
                                                    <option value="19">19</option>
                                                    <option value="20">20</option>
                                                    <option value="21">21</option> 
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-4">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_valid">Valid From</label>
                                                <input type="date" id="input_valid" name="input_valid" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4 col-sm-4">
                                            <div class="form-group p-2">
                                                <label class="form-control-label" for="input_skipass_type">Skipass Type</label>
                                                <select class="form-control" name="input_skipass_type" id="input_skipass_type">
                                                    <?php 
    $sql="SELECT * FROM tbl_skiing_pass_type";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while($row = mysqli_fetch_array($result)) {
                                                    ?>
                                                    <option value='<?php echo $row[0]?>'><?php echo $row[1]?></option>
                                                    <?php
            }
        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-xl-12 col-md-12 col-sm-12 p-2 mb-4 justify-content-between d-flex">
                                    <a class="add_remove_reg_participant_btn_wkp btn  text-white button-background-color btn-primary" href="javascript:void(0);" onclick="newinput()"><i class="ni ni-fat-add text-white"></i>Add more participant</a>
                                    <a class="add_remove_reg_participant_btn_wkp btn  text-white button-background-color btn-primary"  href="javascript:void(0);" onclick="newinput_remove()"><i class="ni ni-fat-delete text-white"></i>Remove participant</a>
                                </div>


                                <div class="col-xl-12 col-md-12 col-sm-12 p-2 mb-4">
                                    <div class="custom-control custom-control-alternative custom-checkbox">
                                        <input class="custom-control-input" id=" customCheckLogin" type="checkbox" required>
                                        <label class="custom-control-label" for=" customCheckLogin">
                                            <span class="text-muted">I have read and accept the <a href="privacy">privacy policy</a></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-md-12 col-sm-12 p-2">
                                    <input type="submit" name="submit" value="Order" class="btn  text-white button-background-color btn-primary" />
                                </div>
                            </div>
                        </form>

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


        <script>
            var id = 0;
            var newinput = function() {
                var parent = document.getElementById("panel_body_id");

                var rowdiv1=document.createElement("div");
                rowdiv1.className="row mr-2 ml-2";

                var coldiv1=document.createElement("div");
                coldiv1.className="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2";
                var coldiv2=document.createElement("div");
                coldiv2.className="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2";
                var coldiv3=document.createElement("div");
                coldiv3.className="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2";
                var coldiv4=document.createElement("div");
                coldiv4.className="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2";
                var coldiv5=document.createElement("div");
                coldiv5.className="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2";
                var coldiv6=document.createElement("div");
                coldiv6.className="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2";
                var coldiv7=document.createElement("div");
                coldiv7.className="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2";
                var coldiv8=document.createElement("div");
                coldiv8.className="col-xl-4 col-md-4 col-sm-4 pt-2 pr-2 pl-2";

                var formdiv1=document.createElement("div");
                formdiv1.className="form-group p-2";
                var formdiv2=document.createElement("div");
                formdiv2.className="form-group p-2";
                var formdiv3=document.createElement("div");
                formdiv3.className="form-group p-2";
                var formdiv4=document.createElement("div");
                formdiv4.className="form-group p-2";
                var formdiv5=document.createElement("div");
                formdiv5.className="form-group p-2";
                var formdiv6=document.createElement("div");
                formdiv6.className="form-group p-2";
                var formdiv7=document.createElement("div");
                formdiv7.className="form-group p-2";
                var formdiv8=document.createElement("div");
                formdiv8.className="form-group p-2";


                var label1=document.createElement("label");
                label1.innerHTML="First Name";
                label1.className="form-control-label";
                var field1 = document.createElement("input");
                field1.className = "form-control";
                field1.style = "display:block;";
                field1.name = "input_first_name_" + id;
                field1.setAttribute("required","");

                var label2=document.createElement("label");
                label2.innerHTML="Last Name";
                label2.className="form-control-label";
                var field2 = document.createElement("input");
                field2.className = "form-control";
                field2.style = "display:block;";
                field2.name = "input_last_name_" + id;
                field2.setAttribute("required","");

                var label8=document.createElement("label");
                label8.innerHTML="Room Number";
                label8.className="form-control-label";
                var field8 = document.createElement("input");
                field8.className = "form-control";
                field8.style = "display:block;";
                field8.name = "input_room_number_" + id;
                field8.setAttribute("required","");

                var label3=document.createElement("label");
                label3.innerHTML="Date of Birth";
                label3.className="form-control-label";
                var field3 = document.createElement("input");
                field3.className = "form-control";
                field3.style = "display:block;";
                field3.name = "input_dob_" + id;
                field3.type="date";

                var label4=document.createElement("label");
                label4.innerHTML="Gender";
                var field4 = document.createElement("select");
                field4.className = "form-control";
                field4.style = "display:block;";
                field4.name = "input_gender_" + id;

                var subfield4=document.createElement("option");
                subfield4.value="male";
                subfield4.text="Male";
                field4.appendChild(subfield4);
                var subfield4=document.createElement("option");
                subfield4.value="female";
                subfield4.text="Female";
                field4.appendChild(subfield4);

                var label5=document.createElement("label");
                label5.innerHTML="Number of Days";
                var field5 = document.createElement("select");
                field5.className = "form-control";
                field5.style = "display:block;";
                field5.name = "input_nod_" + id;

                <?php
                $i=1;
                while($i<=21) {
                ?>
                var subfield5=document.createElement("option");
                subfield5.value="<?php echo $i; ?>";
                subfield5.text="<?php echo $i; ?>";
                field5.appendChild(subfield5);
                <?php $i++; }
                ?>


                var label6=document.createElement("label");
                label6.innerHTML="Valid From";
                label6.className="form-control-label";
                var field6 = document.createElement("input");
                field6.className = "form-control";
                field6.style = "display:block;";
                field6.type="date";
                field6.name = "input_valid_" + id;  


                var label7=document.createElement("label");
                label7.innerHTML="Skipass Type";
                var field7 = document.createElement("select");
                field7.className = "form-control";
                field7.style = "display:block;";
                field7.name = "input_skipass_type_" + id;

                <?php
                $sql="SELECT * FROM tbl_skiing_pass_type";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result)) {
                ?>
                var subfield7=document.createElement("option");
                subfield7.value="<?php echo $row[0]; ?>";
                subfield7.text="<?php echo $row[1]; ?>";
                field7.appendChild(subfield7);
                <?php }
                } ?>



                var reapeatdiv=document.createElement("div");
                reapeatdiv.id="repeat_div_"+id;
                reapeatdiv.className="mt-4";
                reapeatdiv.style="border:1px solid #dee2e6;";
                parent.appendChild(reapeatdiv);

                reapeatdiv.appendChild(rowdiv1);

                rowdiv1.appendChild(coldiv1);
                rowdiv1.appendChild(coldiv2);
                rowdiv1.appendChild(coldiv3);
                rowdiv1.appendChild(coldiv4);
                rowdiv1.appendChild(coldiv5);
                rowdiv1.appendChild(coldiv6);
                rowdiv1.appendChild(coldiv7);
                rowdiv1.appendChild(coldiv8);

                coldiv1.appendChild(formdiv1);
                coldiv2.appendChild(formdiv2);
                coldiv3.appendChild(formdiv3);
                coldiv4.appendChild(formdiv4);
                coldiv5.appendChild(formdiv5);
                coldiv6.appendChild(formdiv6);
                coldiv7.appendChild(formdiv7);
                coldiv8.appendChild(formdiv8);


                formdiv1.appendChild(label1);
                formdiv1.appendChild(field1);
                formdiv2.appendChild(label2);
                formdiv2.appendChild(field2);
                formdiv3.appendChild(label8);
                formdiv3.appendChild(field8);
                formdiv4.appendChild(label3);
                formdiv4.appendChild(field3);
                formdiv5.appendChild(label4);
                formdiv5.appendChild(field4);
                formdiv6.appendChild(label5);
                formdiv6.appendChild(field5);
                formdiv7.appendChild(label6);
                formdiv7.appendChild(field6);
                formdiv8.appendChild(label7);
                formdiv8.appendChild(field7);

                id += 1;

                window.scrollTo({ left: 0, top: document.body.scrollHeight, behavior: "smooth" });
            }

            var newinput_remove = function(){
                var remove1=document.getElementById("repeat_div_"+(id-1));
                remove1.remove();
                id=id-1;
            }
        </script>
        <?php  include 'util-js-files.php' ?>
    </body>

</html>