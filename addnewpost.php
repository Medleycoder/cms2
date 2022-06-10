<?php
   $title ='Addnewpost';
require_once "includes/header.php"; ?>
<?php require_once "includes/nav.php"; ?>
<?php  $_SESSION["TrackingURL"] = $_SERVER['PHP_SELF']; ?>
<?php Confirm_Login(); ?>
<?php 
   if(isset($_POST['submit'])){
       echo "HENLO";
       $TitlePost        = $_POST['title'];
       date_default_timezone_set('Asia/Kolkata');
       $DateTime         = date(DATE_RFC822); 
       $CatagoryName     = $_POST['catagory'];
       $Author           = $_SESSION['AName'];
       $Image            = $_FILES['image']['name'];
       $Target           ="uploads/".basename($_FILES['image']['name']);
       $Description      = $_POST['description'];

       if(empty($TitlePost) || empty($CatagoryName) || empty($Image) || empty($Description)){
           $_SESSION['ErrorMessage'] = 'Title can not be empty';
           Redirect_to('addnewpost.php');
       
        }elseif(strlen($TitlePost)<5){
        $_SESSION['ErrorMessage'] = 'Title should not be less than 5 character';
        Redirect_to('addnewpost.php');
    
    }elseif(strlen($Description)<100){
        $_SESSION['ErrorMessage'] = 'Description should not be less than 100 character';
        Redirect_to('addnewpost.php');
        
    }else{
          $sql = "INSERT INTO posttable (datetime,title,catagory,author,image,description) VALUES (:dateTime,:TitlE,:catagorY,:authoR,:imaGe,:descriptioN)";
          $stmt=$conn->prepare($sql);
          $Execute = $stmt->execute([
              ':dateTime'      => $DateTime,
              ':TitlE'         => $TitlePost,
              ':catagorY'      => $CatagoryName,
              ':authoR'        => $Author,
              ':imaGe'         => $Image,
              ':descriptioN'   => $Description
          ]);
           move_uploaded_file($_FILES['image']['tmp_name'],$Target);

          if($Execute){
              $_SESSION['SuccessMessage'] = 'Post with id: '.$conn->lastInsertId().' uploaded successfully';
              Redirect_to('posts.php');
          }else {
              $_SESSION['ErrorMessage'] = 'Something techinical issue occur';
              Redirect_to('addnewpost.php');
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
                <h1><i class="fa-solid fa-plus text-info"></i><?php echo $title; ?></h1>
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
                    <h2 >Add New Post</h2>
                </div>
                <div class="card-body">
                    <form action="addnewpost.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" class="form-label text-bold ">Title</label>
                            <input type="text" class="form-control" name="title" id="Title" placeholder="Enter title here">
                        </div>
                        <div class="form-group">
                            <label for="catagory" class="form-label text-bold ">Select Catagory</label>
                            <select class="form-select" aria-label="Default select example" name="catagory">
                                    <option selected>Select Catagory</option>
                                   <?php
                                   $conn;
                                   $sql = "SELECT * FROM catagorytable";
                                   $stmt = $conn->query($sql);
                                   
                                   while($DataRows = $stmt->fetch()){
                                      
                                      $Id             = $DataRows['id'];
                                      $CatagorySelect = $DataRows['title']; 
                                   
                                   ?>
                                   <option><?php echo htmlentities($CatagorySelect); ?></option>
                                   <?php } ?>
                            </select>                      
                        </div>
                        <div class="form-group">
                               <label for="formFileSm" class="form-label">Upload image</label>
                                <input class="form-control form-control-sm" name="image" id="formFileSm" type="File">
                        </div>
                        <div class="form-group">
                            <label for="floatingTextarea2">Post Description</label>
                           <textarea class="form-control" name="description" placeholder="Post Description"  id="floatingTextarea2" style="height: 100px"></textarea>
                        </div>
                       <div class="row py-2 my-2">
                             <div class="col-lg-6 col-md-12 col-sm-12 ">
                                 <button type="submit" name="submit" class="btn btn-primary btn-block w-100" ><i class="fa-solid fa-check"></i>Publish</button>
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
<!------------------------------------Main Area End-------------------------------------->




<?php require_once "includes/footer.php"; ?>