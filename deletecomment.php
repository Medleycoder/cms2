<?php 
require_once "includes/db.php";
require_once "includes/function.php";
require_once "includes/session.php";
?>

<?php 
if(isset($_GET['id'])){
    $SearchQueryParameter = $_GET['id'];
    $conn;
    $sql = "DELETE FROM commenttable WHERE id='$SearchQueryParameter'";
    $stmt = $conn->prepare($sql);
    $Execute = $stmt->execute();

    if($Execute){
        $_SESSION['SuccessMessage'] = "Comment deleted successfully by " .$_SESSION['AName'];
        Redirect_to('comments.php');

    }else{
        $_SESSION['ErrorMessage'] = "Error techinical glitch in comment delete page";
        Redirect_to('comments.php');
    }
}