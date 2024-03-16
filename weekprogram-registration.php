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
$bg_url=$title="";
$wkp_id=0;
$email1="";
$title = "";
if(session_id()==''){
    session_start();
}

include 'util-session.php';
$sql="SELECT logo_url,bg_img_url,email from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $email1=$row['email'];
    }
}

if(isset($_GET['wkp_id'])){
    $wkp_id=$_GET['wkp_id'];
    $sql="SELECT title FROM `tbl_weekly_programs` WHERE `wkp_id` = $wkp_id";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while($row = mysqli_fetch_array($result)) {
            $title=$row['title'];
        }
    }    
}

if(isset($_POST['submit'])){
    $firstname[0]=$_POST['input_first_name_'];
    $lastname[0]=$_POST['input_last_name_'];
    $age[0]=$_POST['input_age_'];
    $room[0]=$_POST['input_room_number_'];
    $email=$_POST['input_email_'];
    $phone=$_POST['input_phone_number_'];
    $comment=$_POST['registeration_comment_'];
    $entryby_ip=getIPAddress();
    $entry_time=date("Y-m-d H:i:s");
    $last_editby_ip=getIPAddress();
    $last_edit_time=date("Y-m-d H:i:s");
    $wkp_id=$_POST['wkp_id'];

    for($i=0;$i<30;$i++){
        if(isset($_POST['input_first_name_'.$i])){
            $firstname[$i+1]=$_POST['input_first_name_'.$i];
            $lastname[$i+1]=$_POST['input_last_name_'.$i];
            $age[$i+1]=$_POST['input_age_'.$i];
            $room[$i+1]=$_POST['input_room_number_'.$i];
        }else{
            break;
        }
    }

    $sql1="INSERT INTO `tbl_weekly_prgm_registeration`(`wkp_id`, `email`, `phone`, `entry_time`, `entryby_id`, `entryby_ip`, `last_edit_time`, `last_editby_id`, `last_editby_ip`, `comments`, `comments_it`, `comments_de`, `is_confirmed`) VALUES ($wkp_id,'$email','$phone','$entry_time',0,'$entryby_ip','$last_edit_time',0,'$last_editby_ip','$comment','$comment','$comment',0)";

    $stmt = $conn->query($sql1);

    if(!$stmt){
        echo '<script>alert("Something went wrong!!!");</script>';
    }else{
        $last_id = $conn->insert_id;
        for($j=0;$j<sizeof($firstname);$j++){
            $sql2="INSERT INTO `tbl_weekly_prgm_registeration_detail`(`wpr_id`, `first_name`, `first_name_it`, `first_name_de`, `last_name`, `last_name_it`, `last_name_de`, `age`, `room_no`) VALUES ($last_id,'$firstname[$j]','$firstname[$j]','$firstname[$j]','$lastname[$j]','$lastname[$j]','$lastname[$j]',$age[$j],'$room[$j]')";
            $stmt1 = $conn->query($sql2);
        }
        if($stmt1){
             $from="";
        $from=$firstname[0];

        $subject=$title." Weekly Program Registered";
        $headers = "From: " . strip_tags($from) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message="Name : ".$firstname[0]."<br>"."Last Name : ".$lastname[0]."<br>"."Age : ".$age[0]."<br>"."Room No : ".$room[0]."<br>"." Email : ".$email."<br>"."Phone : ".$phone."<br>"."Comments : ".$comment;

        mail($email1,$subject,$message,$headers);
            
            echo '<script>alert("Weekly Program Registered."); window.location.href = "activity-calendar.php";</script>';    
        }else{
            echo '<script>alert("Something Went Wrong!!!");</script>';
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
        <title>Weekly Program - Register</title>
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

    </head>

    <body style="background: url(<?php echo 'HolidayFriendAdmin/'.$bg_url; ?>)no-repeat fixed center center; min-height:969px;" class="pb-6 bgimg">
        <?php  include 'util-nav-sidebar.php' ?>

        <!-- Main content -->
        <div class="main-content" id="panel" >

            <?php  include 'util-header.php' ?>

            <div class="mt-3">
                <div class="mobile_height_blank"></div>
                <div class="row pt-3">
                    <div class="col-xl-4 col-md-4 col-sm-4">
                        <h1 class="textstyle"><?php echo $title; ?></h1>
                    </div>
                </div>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row bg-white p-3 bgfull-affect-div">
                        <div class="col-xl-4 col-md-4 col-sm-4">
                            <h2>Registration</h2>
                        </div>

                        <div id="panel_body_id">
                            <div class="col-xl-12 col-md-12 col-sm-12" id="repeat_div" style="border: 1px solid #dee2e6;">

                                <div class="row mr-2 ml-2">
                                    <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-first-name">First name *</label>
                                            <input type="text" name="input_first_name_" id="input-first-name" class="form-control" placeholder="First name" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-last-name">Last name *</label>
                                            <input type="text" id="input-last-name" name="input_last_name_" class="form-control" placeholder="Last name" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-age">Age</label>
                                            <input type="number" min="0" id="input-age" name="input_age_" class="form-control" placeholder="Age">
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-room-number">Room number *</label>
                                            <input type="text" id="input-room-number" name="input_room_number_"  class="form-control" placeholder="Room Number" required>
                                        </div>
                                    </div>

                                    <div class="col-xl-12 col-md-12 col-sm-12 pt-2 pr-2 pl-2">
                                        <p>Please enter the contact details which will be used to send you the confirmation of the registration and for possible notifications regarding the activity (e.g. additional information, modification, cancellation).</p>
                                    </div>

                                    <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email *</label>
                                            <input type="email" id="input-email" name="input_email_" class="form-control" placeholder="Email" required>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-phone-number">Phone number *</label>
                                            <input type="text" id="input-phone-number" name="input_phone_number_" class="form-control" placeholder="Phone Number" required>
                                            <input type="hidden" name="wkp_id" value="<?php echo $wkp_id; ?>" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-xl-12 col-md-12 col-sm-12 mt-3">
                            <div class="row mr-0 ml-0 mb-2 justify-content-between d-flex">
                                <a class="btn  text-white button-background-color btn-primary mt-2 add_remove_reg_participant_btn_wkp" href="javascript:void(0);" onclick="newinput()"><i class="ni ni-fat-add"></i>Add more participant</a>
                                <a class="btn  text-white button-background-color btn-primary mt-2 add_remove_reg_participant_btn_wkp"  href="javascript:void(0);" onclick="newinput_remove()"><i class="ni ni-fat-delete"></i>Remove participant</a>
                            </div>

                            <div class="row mr-0 ml-0 mt-2 mb-2">
                                <div class="form-group" style="width: 100%;">
                                    <label class="form-control-label" for="registeration_comment">Comment</label>
                                    <textarea rows="4" class="p-2 form-control" id="registeration_comment" name="registeration_comment_"></textarea>
                                </div>
                            </div>
                            <div class="row mr-0 ml-0 mt-2 mb-2">
                                <div class="custom-control custom-control-alternative custom-checkbox">
                                    <input class="custom-control-input" id=" customCheckLogin" type="checkbox" required>
                                    <label class="custom-control-label" for=" customCheckLogin">
                                        <span class="text-muted">I have read and accept the <a href="privacy">privacy policy</a></span>
                                    </label>
                                </div>
                            </div>

                            <div class="row mr-0 ml-0 mt-3 mb-2">
                                <input type="submit" name="submit" value="Register" class="btn btn  text-white button-background-color btn-primary add_remove_reg_participant_btn_wkp" />
                            </div>
                        </div>

                    </div>
                </form>

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
                coldiv1.className="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2";
                var coldiv2=document.createElement("div");
                coldiv2.className="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2";
                var coldiv3=document.createElement("div");
                coldiv3.className="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2";
                var coldiv4=document.createElement("div");
                coldiv4.className="col-xl-6 col-md-6 col-sm-6 pt-2 pr-2 pl-2";

                var formdiv1=document.createElement("div");
                formdiv1.className="form-group";
                var formdiv2=document.createElement("div");
                formdiv2.className="form-group";
                var formdiv3=document.createElement("div");
                formdiv3.className="form-group";
                var formdiv4=document.createElement("div");
                formdiv4.className="form-group";


                var label1=document.createElement("label");
                label1.innerHTML="First Name";
                label1.className="form-control-label";
                var field1 = document.createElement("input");
                field1.className = "form-control";
                field1.style = "display:block;";
                field1.name = "input_first_name_" + id;

                var label2=document.createElement("label");
                label2.innerHTML="Last Name";
                label2.className="form-control-label";
                var field2 = document.createElement("input");
                field2.className = "form-control";
                field2.style = "display:block;";
                field2.name = "input_last_name_" + id;
                field2.setAttribute("required","");

                var label3=document.createElement("label");
                label3.innerHTML="Age";
                label3.className="form-control-label";
                var field3 = document.createElement("input");
                field3.className = "form-control";
                field3.style = "display:block;";
                field3.name = "input_age_" + id;
                field3.type="number";
                field3.min="0";

                var label4=document.createElement("label");
                label4.innerHTML="Room Number";
                label4.className="form-control-label";
                var field4 = document.createElement("input");
                field4.className = "form-control";
                field4.style = "display:block;";
                field4.name = "input_room_number_" + id;                



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

                coldiv1.appendChild(formdiv1);
                coldiv2.appendChild(formdiv2);
                coldiv3.appendChild(formdiv3);
                coldiv4.appendChild(formdiv4);


                formdiv1.appendChild(label1);
                formdiv1.appendChild(field1);
                formdiv2.appendChild(label2);
                formdiv2.appendChild(field2);
                formdiv3.appendChild(label3);
                formdiv3.appendChild(field3);
                formdiv4.appendChild(label4);
                formdiv4.appendChild(field4);

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
