<?php
   $title ='Register';
require_once "includes/header.php"; ?>
<!------------------------------------HEADER-START-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-user text-dark"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->
<!---------------------------------Inserting into database------------------------>
<?php 
   if(isset($_POST['submit'])){
      $AName                   = $_POST['aname'];
      $Email                   = $_POST['useremail'];
      $Password                = $_POST['userpassword'];
      $PasswordHashed          = password_hash($Password,PASSWORD_DEFAULT);
      $ConfirmPassword         = $_POST['userconfirmpassword'];
      $UserImage               = $_FILES['userimage']['name'];
      $Target                  = "uploads/".basename($_FILES['userimage']['name']);
      date_default_timezone_set('Asia/Kolkata');
      $Time                    = date(DATE_RFC822); 
      $Author                  = 'Outer';
      

       if(empty($AName) || empty($Email) || empty($Password) || empty($ConfirmPassword) ){
           $_SESSION['ErrorMessage'] = 'Field must be filled';
           Redirect_to("login.php");
        
          
       }elseif ($Password !== $ConfirmPassword){
         $_SESSION['ErrorMessage'] = 'Confirm Password should match the password';
         Redirect_to("login.php");
       
        }elseif(strlen($Password)<5){
        
            $_SESSION['ErrorMessage'] = "Password cant be less than 5 character";
            Redirect_to("login.php");
        
        }elseif(CheckEmailExist($Email)){
         
            $_SESSION['ErrorMessage'] = "Email exists!! Please try different Email";
            Redirect_to("login.php");

        
        }else{

       
       $conn;
       $sql       = "INSERT INTO admintable (aname,email,password,aimage,date,approvedby) VALUES (:AName,:EMail,:PAssword,:AImage,:DAte,:APprovedby)";
       $stmt            = $conn->prepare($sql);
       $Execute         = $stmt->execute([
           ':AName'         => $AName,
           ':EMail'         => $Email,
           ':PAssword'      => $PasswordHashed,
           ':AImage'         => $UserImage,
           ':DAte'           => $Time,
           ':APprovedby'     => $Author
       ]);
       move_uploaded_file($_FILES['userimage']['tmp_name'],$Target);
       if($Execute){
           $_SESSION['SuccessMessage'] = 'Admin With name of  ' .$AName. ' registered successfully';
           Redirect_to('login.php');
       }else{
           $_SESSION['ErrorMessage']   = 'Something techinical issue happened on admin page';
           Redirect_to('login.php');
       }
    }
   }
?>
<?php 
echo ErrorMessage();
echo SuccessMessage();
?>


<!-----------------------------------Main Area---------------------------------------------->
<div class="container">
    <div class="row bg-info">
        <div class="offset-lg-1 col-md-10 bg-light" style="">
            <div class="card">
                <div class="card-header text-secondary">
                    <h2 >Admin Registration</h2>
                </div>
                <div class="card-body">
                    <form action="register.php" method="POST" enctype = "multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="form-label text-bold ">Name</label>
                            <input type="text" class="form-control" name="aname" id="Title" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="form-label text-bold ">Email</label>
                            <input type="text" class="form-control" name="useremail" id="Title" placeholder="Enter Your Email">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label text-bold ">Password</label>
                            <input type="password" class="form-control" name="userpassword" id="Title" placeholder="Enter Your Password">
                        </div>
                        <div class="form-group">
                            <label for="password" class="form-label text-bold ">Confirm Password</label>
                            <input type="password" class="form-control" name="userconfirmpassword" id="Title" placeholder="Confirm Your Password">
                        </div>
                        <div class="form-group">
                            <label for="image" class="form-label text-bold ">Upload Dp</label>
                            <input type="file" class="form-control" name="userimage" id="Title" placeholder="Confirm Your Password">
                        </div>

                       
                       <div class="row py-2 my-2">
                             <div class="col-lg-6 col-md-12 col-sm-12 ">
                                 <button type="submit" name="submit" class="btn btn-primary btn-block w-100" ><i class="fa-solid fa-user text-light"></i>Register</button>
                             </div>
                             <div class="col-lg-6 col-md-12 col-sm-12">
                                 <a href="login.php"  name="click" class="btn btn-dark btn-block w-100" ><i class="fa-solid fa-arrow-left "></i>Want to Login</a>
                             </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>