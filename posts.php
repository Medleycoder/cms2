<?php
   $title ='Posts';
   
require_once "includes/header.php"; ?>
<?php require_once "includes/nav.php"; ?>
<?php  
    $_SESSION["TrackingURL"] = $_SERVER['PHP_SELF'];
?>
<?php Confirm_Login(); ?>
  <!------------------------------------HEADER-START-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-blog text-danger"></i><?php echo $title; ?></h1>
            </div>
            <div class="col-lg-3 my-2">
                <a href="addnewpost.php" class="btn btn-primary w-100">
                <i class="fa-solid fa-pen-to-square"></i>
                    Add New Post
                </a>
            </div>
            <div class="col-lg-3 my-2">
                <a href="catagory.php" class="btn btn-info w-100">
                <i class="fa-solid fa-folder-plus"></i>
                    Add New Catagory
                </a>
            </div>
            <div class="col-lg-3 my-2">
                <a href="admin.php" class="btn btn-success w-100">
                <i class="fa-solid fa-user-plus"></i>
                    Add New Admin   
                </a>
            </div>
            <div class="col-lg-3 my-2">
                <a href="comments.php" class="btn btn-secondary w-100">
                <i class="fa-solid fa-check"></i>
                    Approve Comments  
                </a>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->
<!-----------------------------------Table section----------------------------------------->
<div class="container my-2 py-2">
    <?php 
    echo SuccessMessage();
    echo ErrorMessage();
    ?>
    <div class="row">
      <div class="col-lg-12 col">
      <table class="table table-striped ">
          <thead class="bg-dark text-light">
              <tr>
                  <td>#</td>
                  <td>Date</td>
                  <td>Title</td>
                  <td>Catagory</td>
                  <td>Author</td>
                  <td>Image</td>
                  <td>Description</td>
                  <td>Action</td>
                  <td>Live</td>
              </tr>
          </thead>
          
          <?php 
             $sql = "SELECT * FROM posttable";
             $stmt = $conn->query($sql);
             $Sr = 0;
             while($DataRows = $stmt->fetch()){
                 $Id            = $DataRows['id'];
                 $Date          = $DataRows['datetime'];
                 $PostTitle     = $DataRows['title'];
                 $PostCatagory  = $DataRows['catagory'];
                 $Author        = $DataRows['author'];
                 $Image         = $DataRows['image'];
                 $Description   = $DataRows['description'];
                 $Sr++;
             ?>
             <tbody>
                 <tr>
                     <td><?php echo $Sr; ?></td>
                     <td><?php 
                     if(strlen($Date)> 6){$Date = substr($Date,0,5);}
                     echo htmlentities($Date); ?>
                     </td>
                     <td><?php 
                     if(strlen($PostTitle)>8){$PostTitle = substr($PostTitle,0,7);}
                     echo htmlentities($PostTitle); ?></td>
                     <td><?php
                     if(strlen($PostCatagory)>10){$PostCatagory = substr($PostCatagory,0,9);}
                     echo htmlentities($PostCatagory); ?></td>
                     <td><?php
                     if(strlen($Author)>10){$Author = substr($Author,0,9);}
                     echo htmlentities($Author); ?></td>
                     <td><img src="uploads/<?php echo htmlentities($Image); ?>" alt="" width="120px" height="80px"></td>
                     <td><?php
                     if(strlen($Description)>10){$Description = substr($Description,0,9).'..';}
                     echo htmlentities($Description); ?></td>
                     <td>
                         <a target='_blank' class="btn btn-success" name="edit" href="editpost.php?id=<?php echo htmlentities($Id); ?>">Edit</a>
                         <a target='_blank' class="btn btn-danger" href="deletepost.php?id=<?php echo htmlentities($Id); ?>">Delete</a>
                      </td>
                     
                     <td>
                         <a target='_blank' class="btn btn-primary" href="fullpost.php?id=<?php echo $Id; ?>">Preview</a>
                     </td>
                 </tr>
                 <?php } ?>
             </tbody>
      </table>
      </div>
    </div>
</div>



<?php require_once "includes/footer.php"; ?>