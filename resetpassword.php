<?php
   $title ='Reset Password';
require_once "includes/header.php"; 


Confirm_Login();
?>

<!---------------------------Changing Password------------------------------------------>
<?php 
if(isset($_SESSION['UserId'])){
       
    $SeachQueryParameter = $_GET['id'];

    if(isset($_POST['submit'])){
        $REPassword = $_POST['resetpassword'];
        $HashedPassword = password_hash($REPassword,PASSWORD_DEFAULT);
        $RECOPassword = $_POST['resetconfirmpassword'];

        if(empty($REPassword) || strlen($REPassword)<5){
            $_SESSION['ErrorMessage'] = "Password cant be empty or less than 5 characters";
            
            Redirect_to("resetpassword.php");
        }elseif($REPassword !== $RECOPassword){
            $_SESSION['ErrorMessage'] = "Both password should match";
            
            Redirect_to("resetpassword.php");
        }else{
            $conn;
            $sql = "UPDATE admintable SET password=:PassWord WHERE id='$SeachQueryParameter'";
            $stmt = $conn->prepare($sql);
            $Execute = $stmt->execute([':PassWord' => $HashedPassword]);
        }
        if($Execute){
            $_SESSION['SuccessMessage'] = "Your Password changed successfully";
            require_once "logout.php";
            Redirect_to("login.php");
            
        }else{
            $_SESSION['ErrorMessage'] = "Something techinical issue in reseting password";
            Redirect_to("login.php");
        }
    }

}
?>
 <!---------------------------Changing Password--END------------------------------------>
<!------------------------------------HEADER-START-------------------------------------------->
<?php 
echo ErrorMessage();
echo SuccessMessage();
?>
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-house text-success"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->
<div class="container">
    <div class="row bg-info">
        <div class="offset-lg-1 col-md-10 bg-light" style="">
 <!----------------------------------FETCHING EMAIL--------------------------------------->
     <?php
       
            $sql = "SELECT email FROM admintable WHERE id=:ID";
            $stmt = $conn->prepare($sql);
            $Execute = $stmt->execute([':ID' => $SeachQueryParameter]);
            while($Datarows = $stmt->fetch(PDO::FETCH_ASSOC)){
                $UserMail = $Datarows['email'];
?>

 <!----------------------------------FETCHING EMAIL-END---------------------------------->
            <div class="card">
                <div class="card-header text-secondary">
                    <h2 >Reset Password</h2>
                </div>
                <div class="card-body">
                    <form action="resetpassword.php?id=<?php echo $SeachQueryParameter; ?>" method="POST">
                        <div class="form-group">
                            <label for="title" class="form-label text-bold ">Email</label>
                            <h4><?php echo $UserMail; ?></h4>
                        </div>
                        <?php }  ?>
 
                        <div class="form-group">
                            <label for="password" class="form-label text-bold ">New Password</label>
                            <input type="password"  class="form-control" name="resetpassword"  >
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label text-bold ">Confirm Password</label>
                            <input type="password"  class="form-control" name="resetconfirmpassword" >
                        </div>
                         <div class="row py-2 my-2">
                             <div class="col-lg-6 col-md-12 col-sm-12 ">
                                 <button type="submit" name="submit" class="btn btn-danger btn-block w-100" ><i class="fa-solid fa-check"></i>Change password</button>
                         </div>
                         <div class="col-lg-6 col-md-12 col-sm-12">
                                 <button type="button" name="click" class="btn btn-secondary btn-block w-100" ><i class="fa-solid fa-arrow-left"></i>Direct To Dashboard</button>
                         </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


