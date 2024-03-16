<?php
 if(isset($_SESSION['user_id'])){
     $hotel_id=$_SESSION['hotel_id'];
     $user_id=$_SESSION['user_id'];
 }else{
     $url=$_SERVER['SERVER_NAME'];
     $urlArray=explode(".",$url);
     $sql="SELECT hotel_id,user_id from tbl_hotel where subdomain_name='$urlArray[0]' and isactive=1";
     $result=$conn->query($sql);
     if ($result && $result->num_rows > 0) {
         while($row = mysqli_fetch_array($result)) {
             $hotel_id=$row['hotel_id'];
             $user_id=$row['user_id'];
             $_SESSION['hotel_id']=$hotel_id;
             $_SESSION['user_id']=$user_id;
         }
     }else{
         echo "<script>alert('Hotel Not Found.')</script>";
         exit;
     }
 }

//$hotel_id=1;
//$user_id=7;
//$_SESSION['hotel_id']=1;
//$_SESSION['user_id']=7;
?>