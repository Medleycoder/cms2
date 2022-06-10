<?php
   $title ='Add New Admin';
require_once "includes/header.php"; ?>
<?php require_once "includes/nav.php"; ?>
<?php $_SESSION["TrackingURL"] = $_SERVER['PHP_SELF']; ?>
<?php Confirm_Login(); ?>

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
      $Author                  = $_SESSION['AName'];
      

       if(empty($AName) || empty($Email) || empty($Password) || empty($ConfirmPassword) ){
           $_SESSION['ErrorMessage'] = 'Field must be filled';
           Redirect_to("admin.php");
        
          
       }elseif ($Password !== $ConfirmPassword){
         $_SESSION['ErrorMessage'] = 'Confirm Password should match the password';
         Redirect_to("admin.php");
       
        }elseif(strlen($Password)<5){
        
            $_SESSION['ErrorMessage'] = "Password cant be less than 5 character";
            Redirect_to("admin.php");
        
        }elseif(CheckEmailExist($Email)){
         
            $_SESSION['ErrorMessage'] = "Email exists!! Please try different Email";
            Redirect_to("admin.php");

        
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
           Redirect_to('admin.php');
       }else{
           $_SESSION['ErrorMessage']   = 'Something techinical issue happened on admin page';
           Redirect_to('admin.php');
       }
    }
   }
?>
<?php 
echo ErrorMessage();
echo SuccessMessage();
?>
<!------------------------------------HEADER-START-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-user text-success" ></i><?php echo htmlentities($title); ?></h1>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->

<!-----------------------------------Main Area---------------------------------------------->
<div class="container">
    <div class="row bg-info">
        <div class="offset-lg-1 col-md-10 bg-light" style="">
            <div class="card">
                <div class="card-header text-secondary">
                    <h2 >Admin Registration</h2>
                </div>
                <div class="card-body">
                    <form action="admin.php" method="POST" enctype = "multipart/form-data">
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
<!------------------------------------Main Area End-------------------------------------->
<!------------------------------------ADMIN TABLE-------------------------------------->
<div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead class="bg-dark text-light">
                        <tr>
                            <td>#</td>
                            <td>Name</td>
                            <td>Email</td>
                            <td>Dp</td>
                            <td>Date</td>
                            <td>Approved By</td>
                            <td>Details</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                      <?php 
                        $conn;
                        $sql = "SELECT * FROM admintable";
                        $stmt = $conn->query($sql);
                        $Sn=0;
                        while($Dataresult=$stmt->fetch(PDO::FETCH_ASSOC)){
                            $AdmintableId        = $Dataresult['id'];
                            $AdmintableName      = $Dataresult['aname'];
                            $AdmintableEmail     = $Dataresult['email'];
                            $AdmintableImage     = $Dataresult['aimage'];
                            $AdmintableDate      = $Dataresult['date'];
                            $AdmintableApproved  = $Dataresult['approvedby'];
                            $Sn++;
                        
                      ?>
                    <tbody>
                        <tr>
                            <td><?php echo $Sn; ?></td>
                            <td><?php echo $AdmintableName; ?></td>
                            <td><?php echo $AdmintableEmail; ?></td>
                            <td><img src="uploads/<?php echo $AdmintableImage; ?>" width="80px" height="100px"></td>
                            <td><?php echo $AdmintableDate; ?></td>
                            <td><?php echo $AdmintableApproved; ?></td>
                            <td><a target="_blank" class="btn btn-info" href="myprofile.php?id=<?php echo $AdmintableId; ?>">Detail</a></td>
                            <td><a href="deleteadmin.php?id=<?php echo $AdmintableId; ?>" class="btn btn-danger">Deactivate</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
</div>    
<!------------------------------------ADMIN TABLE END---------------------------------->



<?php require_once "includes/footer.php"; ?>