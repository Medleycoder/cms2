<?php
   $title ='Login Page';
require_once "includes/header.php"; ?>

<?php 
  
   
  if(isset($_POST['submit'])){

    $UserMail = $_POST['useremail'];
    $UserPass = $_POST['userpassword'];
   

     if(empty($UserMail) || empty($UserPass)){
         $_SESSION['ErrorMessage'] = "Field cannt be empty";
         Redirect_to('login.php');
     }else{
         $conn;
         $sql = "SELECT * FROM admintable WHERE email=:emaiL";
         $stmt= $conn->prepare($sql);
         $Execute = $stmt->execute([
             ':emaiL' => $UserMail
         ]);
         $Result = $stmt->rowCount();

         if($Result==1 ){  
            $Found_Account = $stmt->fetch(PDO::FETCH_ASSOC);
                  $_SESSION['UserId']      = $Found_Account['id'];
                  $_SESSION['UserEmail']   = $Found_Account['email'];
                  $_SESSION['AName']       = $Found_Account['aname'];
                  
              if($Found_Account && password_verify($UserPass,$Found_Account['password'])){

                  $_SESSION['SuccessMessage'] = "Welcome back ". $_SESSION['AName'] ." userid = ".$_SESSION['UserId'];
     //TRACKING URL CONCEPT//
                      if(isset($_SESSION["TrackingURL"])){
                          Redirect_to($_SESSION["TrackingURL"]);
                      }else{
                          Redirect_to('blog.php');
                      }                
              }else{
                $_SESSION['ErrorMessage'] = "Your Password is incorrect";

                Redirect_to("login.php");
            }
         }  else{
            $_SESSION['ErrorMessage'] = "No User Found!!!!! with this email";
            Redirect_to("login.php");
     }
     }
   
  }


?>
<!------------------------------------HEADER-START-------------------------------------------->
<?php 
echo ErrorMessage();
echo SuccessMessage();
?>
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-house text-info"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->

<!------------------------------------LOGIN AREA-------------------------------------------->
<div class="container" style="width:600px;height:400px;">
    <div class="row bg-info">
        <div class="offset-lg-1 col-md-10 bg-light" style="">
            <div class="card">
                <div class="card-header text-secondary">
                    <h2 >WELCOME BACK!!</h2>
                </div>
                <div class="card-body my-3">
                    <form action="login.php" method="POST">
                      <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">@</span>
                            <input type="text" class="form-control" name="useremail" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                      <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" class="form-control" name="userpassword"  placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                      </div>
                       <div class="row py-2 my-2">
                             <div class="col-lg-6 col-md-12 col-sm-12 my-2">
                                 <button type="submit" name="submit" class="btn btn-primary btn-block w-100" ><i class="fa-solid fa-check"></i>Login</button>
                             </div>
                             <div class="col-lg-6 col-md-12 col-sm-12 my-2">
                                 <a href="register.php" type="button" name="click" class="btn btn-success btn-block w-100" ><i class="fa-solid fa-arrow-left"></i>Register</a>
                             </div>
                             <p><strong>forget password? <a href="contactadmin.php">click here!!</a></strong></p>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------------------------------LOGIN AREA ENDS--------------------------------------->




