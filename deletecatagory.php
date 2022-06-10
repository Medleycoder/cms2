<?php 
require_once "includes/db.php";
require_once "includes/function.php";
require_once "includes/session.php";
?>
<?php 

if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    
    $conn;
    $sql = "DELETE FROM catagorytable WHERE id=:ID";
    $stmt = $conn->prepare($sql);
    $Execute = $stmt->execute([':ID' => $SearchQueryParameter]);
    if($Execute){
        $_SESSION['SuccessMessage'] = "Catagory Deleted successfully";
        Redirect_to("catagory.php");
    }else{
        $_SESSION['ErrorMessage'] = "Something techinical issue ";
        Redirect_to("catagory.php");
    }
}