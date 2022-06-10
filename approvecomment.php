<?php 
require_once "includes/db.php";
require_once "includes/function.php";
require_once "includes/session.php";

if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    $conn;
    $Admin = $_SESSION['UserEmail'];
    $sql = "UPDATE commenttable  SET status='ON', approvedby='$Admin' WHERE id='$SearchQueryParameter'";
    $Execute = $conn->query($sql);
    

    if($Execute){
        $_SESSION['SuccessMessage'] = "Comment approved successfully";
        Redirect_to("comments.php");

    }else{
        $_SESSION['ErrorMessage'] = "Some techinical issue while approving comment";
        Redirect_to("comments.php");
    }
}