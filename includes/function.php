<?php 
require_once "db.php";

function Redirect_to($location){
    header("Location:".$location);
    exit;
}

function CheckEmailExist($Email){

    global $conn;
    $sql = "SELECT * FROM admintable WHERE email=:emaiL";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['emaiL' => $Email]);
    $Result = $stmt->rowcount();
    
    if($Result==1){
      return true;
    }else{
        return false;
    }
}

function Confirm_Login(){
    if(isset($_SESSION['UserId'])){
        return true;
    }else{
        $_SESSION['ErrorMessage'] = "Login required";
        Redirect_to("login.php");
    }
}

function CountPost(){
    
    global $conn;
    $sql = "SELECT COUNT(*) FROM posttable";
    $stmt = $conn->query($sql);
    $TotalRow = $stmt->fetch();
    $TotalPost = array_shift($TotalRow);
    echo  $TotalPost;
    
}
function CountCatagory(){
    global $conn;
    $sql = "SELECT COUNT(*) FROM catagorytable";
    $stmt = $conn->query($sql);
    $TotalRow = $stmt->fetch();
    $TotalCatagory = array_shift($TotalRow);
    echo $TotalCatagory; 
}

function CountAdmin(){
    global $conn;
    $sql = "SELECT COUNT(*) FROM admintable";
    $stmt = $conn->query($sql);
    $TotalRow = $stmt->fetch();
    $TotalAdmin = array_shift($TotalRow);
    echo $TotalAdmin; 
}

function CountComments(){
    global $conn;
    $sql = "SELECT COUNT(*) FROM commenttable";
    $stmt = $conn->query($sql);
    $TotalRow = $stmt->fetch();
    $TotalComment = array_shift($TotalRow);
    echo $TotalComment; 
}

function CountApproved($ID){
    global $conn;
    $sqlap = "SELECT COUNT(*) FROM commenttable WHERE post_id='$ID' AND status='ON'";
    $stmt1=$conn->query($sqlap);
    $TotalRow = $stmt1->fetch();
    $TotalApproved = array_shift($TotalRow);
    echo $TotalApproved;
    
}

function CountDisApproved($ID){
    global $conn;
    $sqldis = "SELECT COUNT(*) FROM commenttable WHERE post_id='$ID' AND status='OFF'";
    $stmt2=$conn->query($sqldis);
    $TotalRow = $stmt2->fetch();
    $TotalDisApproved = array_shift($TotalRow);
    echo $TotalDisApproved;
}