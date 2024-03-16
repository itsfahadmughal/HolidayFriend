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
$hotel_name="";
$address1="";
$phone="";
$email1="";
$web="";

if(session_id()==''){
    session_start();
}

include 'util-session.php';

$sql="SELECT logo_url,bg_img_url,hotel_name,address,web_url,phone,email from tbl_hotel where hotel_id=$hotel_id";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = mysqli_fetch_array($result)) {
        $logo_url=$row['logo_url'];
        $bg_url=$row['bg_img_url'];
        $hotel_name=$row['hotel_name'];
        $address1=$row['address'];
        $phone=$row['phone'];
        $email1=$row['email'];
        $web=$row['web_url'];
    }
}

if(isset($_POST['submit'])){
    $title[0]=$_POST['title_'];
    $firstname[0]=$_POST['first_name_'];
    $lastname[0]=$_POST['last_name_'];
    $email[0]=$_POST['email_'];
    $country[0]=$_POST['country_'];
    $zipcode[0]=$_POST['zipcode_'];
    $city[0]=$_POST['city_'];
    $address[0]=$_POST['address_'];
    $dob[0]=$_POST['dob_'];
    $country_of_birth[0]=$_POST['country_of_birth_'];
    $municipality_of_birth[0]=$_POST['municipality_of_birth_'];
    $nationality[0]=$_POST['nationality_'];
    $id_type[0]=$_POST['id_type_'];
    $id_number[0]=$_POST['id_number_'];
    $issuing_country[0]=$_POST['issuing_country_'];
    $issuing_office[0]=$_POST['issuing_office_'];
    $expiration_date[0]=$_POST['expiration_date_'];
    $type[0]="Adult";



    for($i=0;$i<30;$i++){
        if(isset($_POST['first_name_'.$i])){
            $title[$i+1]=$_POST['title_'.$i];
            $firstname[$i+1]=$_POST['first_name_'.$i];
            $lastname[$i+1]=$_POST['last_name_'.$i];
            $dob[$i+1]=$_POST['dob_'.$i];
            $country_of_birth[$i+1]=$_POST['country_of_birth_'.$i];
            $municipality_of_birth[$i+1]=$_POST['municipality_of_birth_'.$i];
            $nationality[$i+1]=$_POST['nationality_'.$i];
            $type[$i+1]=$_POST['type_'.$i];

        }else{
            break;
        }
    }
    $stmt1="";
    $sql1="INSERT INTO `tbl_guest_precheckin`(`hotel_id`, `title`, `first_name`, `last_name`, `email`, `conid`, `cityid`, `address`, `zip_code`, `dob`, `conid_birth`, `municipality`, `conid_nationality`, `id_type`, `id_num`, `id_issue_conid`, `issue_dept`, `id_expiry_date`) VALUES ($hotel_id,'$title[0]','$firstname[0]','$lastname[0]','$email[0]',$country[0],'$city[0]','$address[0]','$zipcode[0]','$dob[0]',$country_of_birth[0],'$municipality_of_birth[0]',$nationality[0],'$id_type[0]','$id_number[0]',$issuing_country[0],'$issuing_office[0]','$expiration_date[0]')";

    $stmt = $conn->query($sql1);

    if(!$stmt){
        echo '<script>alert("Something went wrong1!!!");</script>';
    }else{
        $last_id = $conn->insert_id;
        for($j=1;$j<sizeof($firstname);$j++){
            $sql2="INSERT INTO `tbl_guest_precheckin_det`( `prechk_id`, `title`, `first_name`, `last_name`, `email`, `dob`, `conid_birth`, `municipality`, `conid_nationality`, `pax_type`) VALUES ($last_id,'$title[$j]','$firstname[$j]','$lastname[$j]','$email[0]','$dob[$j]',$country_of_birth[$j],'$municipality_of_birth[$j]',$nationality[$j],'$type[$j]')";
            $stmt1 = $conn->query($sql2);
        }
        if(($stmt1 && sizeof($firstname)>1) || sizeof($firstname)==1){

            $subject=$title."Pre-Check-in Request";
            $headers = "From: " . strip_tags($email[0]) . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $message="Name : ".$firstname[0].' '.$lastname[0]."<br>"."Email : ".$email[0]."<br>"."Country : ".$country[0]."<br>"."Address : ".$address[0].', '.$city[0]." ID Type : ".$id_type[0]."<br>"."ID Number : ".$id_number[0];

            mail($email1,$subject,$message,$headers);

            echo '<script>alert("Pre-Check-In Request Sent."); window.location.href = "index";</script>';    
        }else{ 
            echo '<script>alert("Something Went Wrong2!!!");</script>';
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
        <title><?php echo $hotel_name; ?> - Pre-Check-in</title>
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
                <div class="row p-0">
                    <div class="col-xl-3 col-md-3 col-sm-3"></div>
                    <div class="col-xl-6 col-md-6 col-sm-6 button-background-color">
                        <div class="row pb-3">
                            <div class="col-xl-8 col-md-8 col-sm-8 pl-2" >
                                <h1  style="margin-top:8%;color:white;">Welcome at <br><?php echo $hotel_name; ?></h1>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-4 bg-white" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;">
                                <img src="<?php echo 'HolidayFriendAdmin/'.$logo_url; ?>" class="w-100 p-3" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-3 col-sm-3"></div>
                </div>


                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row bg-white p-0">
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                        <div class="col-xl-6 col-md-6 col-sm-6 p-4" style="border-right: 2px solid #dee2e6;border-left: 2px solid #dee2e6;">
                            <h2>Pre-Check-in</h2>
                            <span>Thank you for using our pre check-in service. You can check in from the comfort of your home, and save valuable holiday time upon arrival. </span><br><span>All you have to do is fill in the pre check-in form, and make sure that all information is correct.On your arrival, we will verify the information provided.</span><br><span>This is necessary due to the reporting duty set by the state police.Should you need any assistance please do not hesitate to contact us by telephone.</span>
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                    </div>



                    <div id="panel_body_id">
                        <div class="row bg-white p-0" id="repeat_div">
                            <div class="col-xl-3 col-md-3 col-sm-3"></div>
                            <div class="col-xl-6 col-md-6 col-sm-6 p-4" style="border-right: 2px solid #dee2e6;border-left: 2px solid #dee2e6;">


                                <h2 style="color:black;" class="pt-2">Adult 1:</h2>

                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4>Title</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <select name="title_">
                                            <option value="0">-</option>
                                            <option value="Mrs">Mrs.</option>
                                            <option value="Mr">Mr.</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">First name*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="first_name_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Last name*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="last_name_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">E-mail</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="email" name="email_" style="line-height: 0px;" >
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Country*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <select required name="country_">
                                            <option value="0">-</option>
                                            <?php 
                                            $sql="SELECT * FROM tbl_country";
                                            $result = $conn->query($sql);
                                            if ($result && $result->num_rows > 0) {
                                                while($row = mysqli_fetch_array($result)) {
                                                    echo '<option value='.$row[0].'>'.$row[4].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Zipcode*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="zipcode_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">City*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="city_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Address*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="address_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-2">D.O.B*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="date" name="dob_" required>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Country of birth*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <select name="country_of_birth_" required>
                                            <option value="0">-</option>
                                            <?php 
                                            $sql="SELECT * FROM tbl_country";
                                            $result = $conn->query($sql);
                                            if ($result && $result->num_rows > 0) {
                                                while($row = mysqli_fetch_array($result)) {
                                                    echo '<option value='.$row[0].'>'.$row[4].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Municipality of birth*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="municipality_of_birth_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Nationality*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <select name="nationality_" required>
                                            <option value="0">-</option>
                                            <?php 
                                            $sql="SELECT * FROM tbl_country";
                                            $result = $conn->query($sql);
                                            if ($result && $result->num_rows > 0) {
                                                while($row = mysqli_fetch_array($result)) {
                                                    echo '<option value='.$row[0].'>'.$row[4].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4>ID Type*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <select name="id_type_" required>
                                            <option value="0">-</option>
                                            <option value="Driving licence">Driving licence</option>
                                            <option value="Identity card">Identity card</option>
                                            <option value="Child identity card">Child identity card</option>
                                            <option value="Passport">Passport</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">ID Number*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="id_number_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Issuing country*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <select name="issuing_country_" required>
                                            <option value="0">-</option>
                                            <?php 
                                            $sql="SELECT * FROM tbl_country";
                                            $result = $conn->query($sql);
                                            if ($result && $result->num_rows > 0) {
                                                while($row = mysqli_fetch_array($result)) {
                                                    echo '<option value='.$row[0].'>'.$row[4].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-1">Issuing office*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="text" name="issuing_office_" style="line-height: 0px;" required>
                                    </div>
                                </div>
                                <div class="row m-0 p-0">
                                    <div class="col-xl-4 col-md-4 col-sm-4">
                                        <h4 class="pt-2">Expiration date*</h4>
                                    </div>
                                    <div class="col-xl-8 col-md-8 col-sm-8">
                                        <input type="date" name="expiration_date_"  required>
                                    </div>
                                </div>

                            </div>
                            <div class="col-xl-3 col-md-3 col-sm-3"></div>
                        </div>
                    </div>




                    <div class="row p-0">
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                        <div class="col-xl-6 col-md-6 col-sm-6 p-4" style="border-right: 2px solid #dee2e6;border-left: 2px solid #dee2e6;">
                            <div class="row mr-0 ml-0 mb-1 justify-content-between d-flex">
                                <a class="btn btn-sm text-white button-background-color btn-primary mt-2 add_remove_reg_participant_btn_wkp" href="javascript:void(0);" onclick="newinput()"><i class="ni ni-fat-add"></i>Add Person</a>
                                <a class="btn btn-sm text-white button-background-color btn-primary mt-2 add_remove_reg_participant_btn_wkp"  href="javascript:void(0);" onclick="newinput_remove()"><i class="ni ni-fat-delete"></i>Remove Person</a>
                            </div>

                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                    </div>

                    <div class="row p-0">
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                        <div class="col-xl-6 col-md-6 col-sm-6 pb-4 pr-4 pl-4" style="border-right: 2px solid #dee2e6;border-left: 2px solid #dee2e6;">

                            <div class="row mr-0 ml-0 mt-2 mb-2">
                                <input type="submit" name="submit" value="Send Pre-Check-In Data" class="btn btn-sm w-100 text-white button-background-color btn-primary add_remove_reg_participant_btn_wkp" />
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                    </div>

                    <div class="row p-0">
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
                        <div class="col-xl-6 col-md-6 col-sm-6 button-background-color">
                            <div class="row">
                                <div class="col-xl-12 col-md-12 col-sm-12 p-5" >
                                    <h4 style="text-align:center;color:white;"><?php echo $hotel_name; ?></h4>
                                    <h4 style="text-align:center;color:white;"><?php echo $address1; ?></h4>
                                    <h4 style="text-align:center;color:white;"><i class="fas fa-phone-alt"></i> <?php echo $phone; ?></h4>
                                    <h4 style="text-align:center;color:white;"><?php echo $email1.' '.$web; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3 col-sm-3"></div>
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

                var rowdiv=document.createElement("div");
                rowdiv.className="row bg-white p-0";
                rowdiv.id="repeat_div_"+id;


                var coldiv111=document.createElement("div");
                coldiv111.className="col-xl-3 col-md-3 col-sm-3";
                var coldiv222=document.createElement("div");
                coldiv222.className="col-xl-6 col-md-6 col-sm-6 p-4";
                coldiv222.style="border-right: 2px solid #dee2e6;border-left: 2px solid #dee2e6;";
                var coldiv333=document.createElement("div");
                coldiv333.className="col-xl-3 col-md-3 col-sm-3";

                rowdiv.appendChild(coldiv111);
                rowdiv.appendChild(coldiv222);
                rowdiv.appendChild(coldiv333);

                var label111=document.createElement("h4");
                label111.innerHTML="Person "+(id+1);
                label111.className="pt-2";
                label111.style="color:black";

                coldiv222.appendChild(label111);

                var rowdiv1=document.createElement("div");
                rowdiv1.className="row p-0 m-0";
                var rowdiv2=document.createElement("div");
                rowdiv2.className="row p-0 m-0";
                var rowdiv3=document.createElement("div");
                rowdiv3.className="row p-0 m-0";
                var rowdiv4=document.createElement("div");
                rowdiv4.className="row p-0 m-0";
                var rowdiv5=document.createElement("div");
                rowdiv5.className="row p-0 m-0";
                var rowdiv6=document.createElement("div");
                rowdiv6.className="row p-0 m-0";
                var rowdiv7=document.createElement("div");
                rowdiv7.className="row p-0 m-0";
                var rowdiv8=document.createElement("div");
                rowdiv8.className="row p-0 m-0";



                var coldiv1=document.createElement("div");
                coldiv1.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv2=document.createElement("div");
                coldiv2.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv3=document.createElement("div");
                coldiv3.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv4=document.createElement("div");
                coldiv4.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv5=document.createElement("div");
                coldiv5.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv6=document.createElement("div");
                coldiv6.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv7=document.createElement("div");
                coldiv7.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv8=document.createElement("div");
                coldiv8.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv9=document.createElement("div");
                coldiv9.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv10=document.createElement("div");
                coldiv10.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv11=document.createElement("div");
                coldiv11.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv12=document.createElement("div");
                coldiv12.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv13=document.createElement("div");
                coldiv13.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv14=document.createElement("div");
                coldiv14.className="col-xl-8 col-md-8 col-sm-8";   
                var coldiv15=document.createElement("div");
                coldiv15.className="col-xl-4 col-md-4 col-sm-4";
                var coldiv16=document.createElement("div");
                coldiv16.className="col-xl-8 col-md-8 col-sm-8";   



                var label0=document.createElement("h4");
                label0.innerHTML="Title";
                var field0 = document.createElement("select");
                field0.name = "title_" + id;

                var subfield01=document.createElement("option");
                subfield01.value="0";
                subfield01.text="-";
                field0.appendChild(subfield01);
                var subfield02=document.createElement("option");
                subfield02.value="Mrs";
                subfield02.text="Mrs.";
                field0.appendChild(subfield02);
                var subfield03=document.createElement("option");
                subfield03.value="Mr";
                subfield03.text="Mr.";
                field0.appendChild(subfield03);


                var label1=document.createElement("h4");
                label1.innerHTML="First Name*";
                var field1 = document.createElement("input");
                field1.style = "line-height: 0px;";
                field1.name = "first_name_" + id;
                field1.setAttribute("required","");

                var label2=document.createElement("h4");
                label2.innerHTML="Last Name*";
                var field2 = document.createElement("input");
                field2.style = "line-height: 0px;";
                field2.name = "last_name_" + id;
                field2.setAttribute("required","");

                var label3=document.createElement("h4");
                label3.innerHTML="E-mail*";
                var field3 = document.createElement("input");
                field3.style = "line-height: 0px;";
                field3.type = "email";
                field3.name = "email_" + id;
                field3.setAttribute("required","");

                var label3=document.createElement("h4");
                label3.innerHTML="D.O.B*";
                var field3 = document.createElement("input");
                field3.type = "date";
                field3.name = "dob_" + id;
                field3.setAttribute("required","");

                var label4=document.createElement("h4");
                label4.innerHTML="Country of birth*";
                var field4 = document.createElement("select");
                field4.name = "country_of_birth_" + id;

                var subfield11=document.createElement("option");
                subfield11.value="0";
                subfield11.text="-";
                field4.appendChild(subfield11);
                <?php
                $sql="SELECT * FROM tbl_country";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result)) {
                ?>
                var subfield12=document.createElement("option");
                subfield12.value="<?php echo $row[0]; ?>";
                subfield12.text="<?php echo $row[4]; ?>";
                field4.appendChild(subfield12);
                <?php }
                } ?>

                var label5=document.createElement("h4");
                label5.innerHTML="Municipality of birth*";
                var field5 = document.createElement("input");
                field5.style = "line-height: 0px;";
                field5.name = "municipality_of_birth_" + id;
                field5.setAttribute("required","");

                var label6=document.createElement("h4");
                label6.innerHTML="Nationality*";
                var field6 = document.createElement("select");
                field6.name = "nationality_" + id;

                var subfield21=document.createElement("option");
                subfield21.value="0";
                subfield21.text="-";
                field6.appendChild(subfield21);
                <?php
                $sql="SELECT * FROM tbl_country";
                $result = $conn->query($sql);
                if ($result && $result->num_rows > 0) {
                    while($row = mysqli_fetch_array($result)) {
                ?>
                var subfield22=document.createElement("option");
                subfield22.value="<?php echo $row[0]; ?>";
                subfield22.text="<?php echo $row[4]; ?>";
                field6.appendChild(subfield22);
                <?php }
                } ?>

                var label7=document.createElement("h4");
                label7.innerHTML="Type";
                var field7 = document.createElement("select");
                field7.name = "type_" + id;

                var subfield31=document.createElement("option");
                subfield31.value="0";
                subfield31.text="-";
                field7.appendChild(subfield31);
                var subfield32=document.createElement("option");
                subfield32.value="Adult";
                subfield32.text="Adult";
                field7.appendChild(subfield32);
                var subfield33=document.createElement("option");
                subfield33.value="Child";
                subfield33.text="Child";
                field7.appendChild(subfield33);
                var subfield34=document.createElement("option");
                subfield34.value="Infant";
                subfield34.text="Infant";
                field7.appendChild(subfield34);


                rowdiv1.appendChild(coldiv1);
                rowdiv1.appendChild(coldiv2);
                rowdiv2.appendChild(coldiv3);
                rowdiv2.appendChild(coldiv4);
                rowdiv3.appendChild(coldiv5);
                rowdiv3.appendChild(coldiv6);
                rowdiv4.appendChild(coldiv7);
                rowdiv4.appendChild(coldiv8);
                rowdiv5.appendChild(coldiv9);
                rowdiv5.appendChild(coldiv10);
                rowdiv6.appendChild(coldiv11);
                rowdiv6.appendChild(coldiv12);
                rowdiv7.appendChild(coldiv13);
                rowdiv7.appendChild(coldiv14);
                rowdiv8.appendChild(coldiv15);
                rowdiv8.appendChild(coldiv16);


                coldiv1.appendChild(label0);
                coldiv2.appendChild(field0);
                coldiv3.appendChild(label1);
                coldiv4.appendChild(field1);
                coldiv5.appendChild(label2);
                coldiv6.appendChild(field2);
                coldiv7.appendChild(label3);
                coldiv8.appendChild(field3);
                coldiv9.appendChild(label4);
                coldiv10.appendChild(field4);
                coldiv11.appendChild(label5);
                coldiv12.appendChild(field5);
                coldiv13.appendChild(label6);
                coldiv14.appendChild(field6);
                coldiv15.appendChild(label7);
                coldiv16.appendChild(field7);

                coldiv222.appendChild(rowdiv1);
                coldiv222.appendChild(rowdiv2);
                coldiv222.appendChild(rowdiv3);
                coldiv222.appendChild(rowdiv4);
                coldiv222.appendChild(rowdiv5);
                coldiv222.appendChild(rowdiv6);
                coldiv222.appendChild(rowdiv7);
                coldiv222.appendChild(rowdiv8);


                parent.appendChild(rowdiv);


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
