<?php $title ='Delete Posts';  ?>
<?php require_once "includes/header.php"; ?>

<?php Confirm_Login(); ?>
<?php
   
 
?>
<!------------------------------------HEADER-START-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-trash text-danger"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->
<!----------------------------------------MAIN-AREAS----------------------------------------->
<div class="container">
    <div class="row bg-info">
        <div class="offset-lg-1 col-md-10 bg-light" style="">
            <div class="card">
                <div class="card-header text-secondary">
                    <h2 ><?php echo $title; ?></h2>
                </div>
  <!----------------------------------FETCHING-DATA-------------------------------------->
                <?php 
                $SearchQueryParameter = $_GET['id'];
                $conn;
                $sql = "SELECT * FROM posttable WHERE id='$SearchQueryParameter'";
                $stmt = $conn->query($sql);
                while($DataRows = $stmt->fetch()){
                    $IdEdit           = $DataRows['id'];
                    $DateEdit         = $DataRows['datetime'];
                    $TitleEdit        = $DataRows['title'];
                    $CatagoryEdit     = $DataRows['catagory'];
                    $Author           = $DataRows['author'];
                    $ImageEdit        = $DataRows['image'];
                    $DescriptionEdit  = $DataRows['description'];

?>
<!----------------------------------------FETCHING-DATA-END------------------------------->
<!----------------------------------------DELETING STUFFS------------------------------->
<?php
            if(isset($_POST['submit'])){
               if(isset($_GET['id'])){
                   $SearchQueryParameter = $_GET['id'];
                   global $conn;
                   $sql = "DELETE FROM posttable WHERE id='$SearchQueryParameter'";
                   $Executes = $conn->query($sql);
                   
              
                   if($Executes){
                       $Target_image_delete = "uploads/$ImageEdit";
                       var_dump($Target_image_delete);
                       unlink($Target_image_delete);
                       $_SESSION['SuccessMessage'] = "Post deleted successfully";
                       Redirect_to("posts.php");
              
                   }else{
                       $_SESSION['ErrorMessage'] = "Something techinical glitch happened";
                       Redirect_to("post.php");
                   }
               }
             }
             ?>
<!----------------------------------------DELETING STUFFS-END--------------------------->
                <div class="card-body">
                <?php 
                   echo SuccessMessage();
                   echo ErrorMessage();
                ?>
                    <form action="deletepost.php?id=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" class="form-label text-bold ">Title</label>
                            <input type="text" disabled class="form-control" name="titleedit" id="Title" value="<?php echo htmlentities($TitleEdit); ?>">
                        </div>
                        <div class="form-group">
                            <label for="catagory" class="form-label text-bold ">Select Catagory</label>
                            <select class="form-select" disabled aria-label="Default select example" name="catagoryedit">
                                    <option selected><?php echo htmlentities($CatagoryEdit); ?></option>
                                   <?php 
                                   $conn;
                                   $sql = "SELECT title FROM catagorytable";
                                   $stmt = $conn->query($sql);
                                   while($DataRow = $stmt->fetch()){
                                       $CatagorySelect = $DataRow['title'];
                                   ?>
                                   <option><?php echo htmlentities($CatagorySelect); ?></option>
                                  <?php } ?>
                            </select>                      
                        </div>
                        <div class="form-group">
                        <div class="FieldInfo"> Image: </div>
                               <img src="Uploads/<?php echo htmlentities($ImageEdit); ?>" class="img-fluid" width="400px" alt="">

                              
                        <div class="form-group">
                            <label for="floatingTextarea2">Post Description</label>
                           <textarea class="form-control" disabled name="descriptionedit" placeholder="<?php echo htmlentities($DescriptionEdit); ?>"  id="floatingTextarea2" style="height: 100px"></textarea>
                        </div>
                       <div class="row py-2 my-2">
                             <div class="col-lg-6 col-md-12 col-sm-12 ">
                                 <button type="submit" name="submit" class="btn btn-danger btn-block w-100" ><i class="fa-solid fa-check"></i>Delete</button>
                             </div>
                             <div class="col-lg-6 col-md-12 col-sm-12">
                                 <button type="button" name="click" class="btn btn-secondary btn-block w-100" ><i class="fa-solid fa-arrow-left"></i>Back To Post</button>
                             </div>
                       </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!----------------------------------------MAIN-AREAS-ENDS------------------------------------->
<?php
 
 ?>
<?php require_once "includes/footer.php"; 