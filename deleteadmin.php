<?php 
require_once "includes/db.php";
require_once "includes/function.php";
require_once "includes/session.php";
?>
<?php 
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    
    $conn;
    $sql = "DELETE FROM admintable WHERE id=:ID";
    $stmt = $conn->prepare($sql);
    $Execute = $stmt->execute([':ID' => $SearchQueryParameter]);
    if($Execute){
        $_SESSION['SuccessMessage'] = "Admin Deleted successfully";
        Redirect_to("admin.php");
    }else{
        $_SESSION['ErrorMessage'] = "Something techinical issue ";
        Redirect_to("admin.php");
    }
}