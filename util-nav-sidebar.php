<?php

if(session_id()==''){
    session_start();
}
?>
<!-- Sidenav -->
<nav class="sidenav navbar navbar-vertical  header-area fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner header-area">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand p-0" href="javascript:void(0)">
                <img src="<?php if($logo_url==""){echo 'HolidayFriendAdmin/images/hotel_images/default-logo.png'; }else{ echo 'HolidayFriendAdmin/'.$logo_url; } ?>"  class="navbar-brand-img" alt="...">
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index">
                            <i class="fa fa-home text-primary1"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <?php
                    $sql="SELECT a.*,b.* FROM tbl_user_module_map as a INNER JOIN tbl_util_modules as b ON a.umod_id=b.umod_id WHERE a.user_id=$user_id and a.isactive=1 order by position_order";
                    $result = $conn->query($sql);
                    if ($result && $result->num_rows > 0) {
                        while($row = mysqli_fetch_array($result)) {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $row['main_url']; ?>">
                            <?php
                            if($row['module_name']=="Important information"){
                            ?>
                            <i class="fas fa-hotel text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Weather"){
                            ?>
                            <i class="fas fa-cloud text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Weekly Program"){
                            ?>
                            <i class="fas fa-calendar-week text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Menu"){
                            ?>
                            <i class="fas fa-utensils text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Smart Experiences"){
                            ?>
                            <i class="fas fa-play text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Reading Corner"){
                            ?>
                            <i class="fas fa-book-open text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Events"){
                            ?>
                            <i class="fas fa-glass-cheers text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Shop"){
                            ?>
                            <i class="fas fa-store-alt text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Photogallery"){
                            ?>
                            <i class="fas fa-images text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Sport & Active"){
                            ?>
                            <i class="fas fa-swimmer text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="In the Surroundings"){
                            ?>
                            <i class="fas fa-tree text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Custom Box (New Module)"){
                            ?>
                            <i class="fas fa-toolbox text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Custom Box (New Box)"){
                            ?>
                            <i class="fas fa-box text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Skiing"){
                            ?>
                            <i class="fas fa-skiing text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Hotel Feedback"){
                            ?>
                            <i class="fas fa-comment-dots text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Gift Voucher"){
                            ?>
                            <i class="fas fa-gift text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Wine list"){
                            ?>
                            <i class="fas fa-wine-bottle text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Drinks Menu"){
                            ?>
                            <i class="fas fa-cocktail text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Room Service"){
                            ?>
                            <i class="fas fa-person-booth text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Team"){
                            ?>
                            <i class="fas fa-user-friends text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Wellness & Spa"){
                            ?>
                            <i class="fas fa-spa text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Webcams"){
                            ?>
                            <i class="fas fa-video text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Green Option"){
                            ?>
                            <i class="fas fa-leaf text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Pre-Checkin"){
                            ?>
                            <i class="fas fa-clipboard-check text-primary1"></i>
                            <?php
                            }elseif($row['module_name']=="Wishlist"){
                            ?>
                            <i class="fas fa-hand-holding-heart text-primary1"></i>
                            <?php
                            }
                            ?>

                            <span class="nav-link-text"><?php if($row['user_module_name']==""){echo $row['module_name']; }else{echo $row['user_module_name']; } ?></span>
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>



                </ul>

            </div>
        </div>
        <hr>

        <div class="row mt-3">
            <?php
            $url_facebook = "";
            $url_twitter = "";
            $url_instagram = "";
            $url_linkedin = "";
            $url_youtube = "";

            $sql="SELECT b.reception_phone,b.reception_email,b.url_facebook,b.url_twitter,
            b.url_instagram,b.url_linkedin,b.url_youtube from tbl_hotel as a LEFT OUTER JOIN tbl_hotel_more_detail as b on a.hotel_id=b.hotel_id where a.hotel_id=$hotel_id";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while($row = mysqli_fetch_array($result)) {
                    $url_facebook =  $row['url_facebook'];
                    $url_twitter =  $row['url_twitter'];
                    $url_instagram    =  $row['url_instagram'];
                    $url_linkedin    =  $row['url_linkedin'];
                    $url_youtube    =  $row['url_youtube'];

            ?>
            <p class="m-0"><?php if($row['reception_phone'] != ""){ echo 'Reception : '.$row['reception_phone']; } ?></p>
            <p class="m-0"><a href="mailto:<?php echo $row['reception_email']; ?>" target="_blank" style="color:#6F6F6E;" ><?php echo $row['reception_email']; ?></a></p>
            <?php } } ?>
            <p class="d-flex justify-content-between w-100"><a style="color:#6F6F6E;font-family: 'Roboto', sans-serif;"  href="privacy">Privacy</a>
                <a  style="color:#6F6F6E;font-family: 'Roboto', sans-serif;" href="impressum">Impressum</a></p>

        </div>
        <div class="row mb-2">
            <?php if($url_facebook != ""){ ?>    
            <div class="col-xl-3 col-md-3 col-sm-3 mt-2"  >
                <a target="_blank" href= "<?php echo $url_facebook;?>">
                    <img  width="40" height="40" src="assets/img/icons/c_facebook_icon.png" alt="" >
                </a>
            </div>
            <?php }if($url_instagram != ""){ ?>  
            <div class="col-xl-3 col-md-3 col-sm-3 mt-2" >
                <a target="_blank" href= "<?php echo $url_instagram;?>">
                    <img width="40" height="40" src="assets/img/icons/c_instagram_media_icon.png" alt="" >
                </a>
            </div>
            <?php }if($url_twitter != ""){ ?>  
            <div class="col-xl-3 col-md-3 col-sm-3 mt-2" >
                <a target="_blank" href= "<?php echo $url_twitter;?>">
                    <img  width="40" height="40" src="assets/img/icons/circle_twitter_icon.png" alt="" >
                </a>
            </div>
            <?php }if($url_linkedin != ""){ ?>  
            <div class="col-xl-3 col-md-3 col-sm-3 mt-2" >
                <a target="_blank" href= "<?php echo $url_linkedin;?>">
                    <img width="40" height="40" src="assets/img/icons/c_linkedin_media_people_icon.png" alt="" >
                </a>
            </div>
            <?php }if($url_youtube != ""){ ?>  
            <div class="col-xl-3 col-md-3 col-sm-3 mt-2" >
                <a target="_blank" href= "<?php echo $url_youtube;?>">
                    <img  width="40" height="40" src="assets/img/icons/c_youtube.png" alt="" >
                </a>
            </div>
            <?php } ?>
        </div>
    </div>


</nav>