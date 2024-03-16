<?php 
require_once "util-config.php";


if(isset($_POST['wkp_id'])){
    $wkp_id_=$_POST['wkp_id'];
    $rating_=$_POST['rating'];
    $comment_=$_POST['comment'];

    $query="INSERT INTO `tbl_weekly_programs_feedback`(`star_rating`, `comments`, `comments_it`, `comments_de`, `wkp_id`) VALUES ($rating_,'$comment_','$comment_','$comment_',$wkp_id_)";

    $stmt=mysqli_query($conn,$query);
    if($stmt){
        echo "Your Feedback Submitted.";
    }else{
        echo "Error Occure in Server";
    }

}else{
    echo "Some Error Occure in Remarks Submitting";
}


?>