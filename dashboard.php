<?php
   $title ='Dashboard';
require_once "includes/header.php"; ?>
<?php require_once "includes/nav.php"; ?>
<?php  $_SESSION["TrackingURL"] = $_SERVER['PHP_SELF']; ?>
<?php Confirm_Login(); ?>
<!------------------------------------HEADER-START-------------------------------------------->
<?php echo ErrorMessage();
 echo SuccessMessage();
  ?>
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-house text-success"></i><?php echo $title; ?></h1>
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
</div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->
<div class="container">
    <div class="row">
        <!-------LEFT AREA----------------->
      <div class="col-lg-2 col-md-12 col-sm-12">
          <div class=" text-center card bg-dark text-light my-2">
              <h3 class="leads">Posts</h3>
              <i class="fa-brands fa-2x fa-readme"></i>
              <p class="display-6">
                  <?php
                     CountPost();
                  ?>
              </p>
          </div>
          <div class=" text-center card bg-dark text-light my-2">
              <h3 class="leads">Catagories</h3>
              <i class="fa-solid fa-2x fa-folder"></i>
              <p class="display-6">
              <?php
                 CountCatagory();
                  ?>
              </p>
          </div>
          <div class=" text-center card bg-dark text-light my-2">
              <h3 class="leads">Admins</h3>
              <i class="fa-solid fa-2x fa-user"></i>
              <p class="display-6">
              <?php
                 CountAdmin();
                  ?>
              </p>
          </div>
          <div class=" text-center card bg-dark text-light my-2">
              <h3 class="leads">Comments</h3>
              <i class="fa-solid fa-2x fa-comment"></i>
              <p class="display-6">
              <?php
                 CountComments();
                  ?>
              </p>
          </div>
      </div>
  <!----------LEFT END---------------------->    
  <!----------RIGHT START---------------------->
  <div class="col-lg-10">
      <div class="card">
          <div class="card-header">
              <h1><strong>Top Posts</strong> </h1>
          </div>
          <table class="table-striped">
              <thead class="bg-dark text-light">
                  <tr>
                      <td>#</td>
                      <td>Title</td>
                      <td>Date</td>
                      <td>Author</td>
                      <td>Comments</td>
                      <td>Previe2</td>
                  </tr>
              </thead>
              <?php 
                $conn;
                $sql ="SELECT * FROM posttable  LIMIT 12";
                $stmt= $conn->query($sql);
                $Sr=0;
                while($DataRows = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $ID = $DataRows['id'];
                    $Title = $DataRows['title'];
                    $Date = $DataRows['datetime'];
                    $Author = $DataRows['author'];
                    $Sr++;
                
              ?>
              <tbody>
                 <tr>
                     <td><?php echo $Sr; ?></td>
                     <td><?php echo $Title; ?></td>
                     <td><?php echo $Date; ?></td>
                     <td><?php echo $Author; ?></td>
                     <td>
                         <span class="btn btn-success">
                             <?php
                             CountApproved($ID);
                             ?>
                         </span>
                         <span class="btn btn-danger">
                             <?php 
                              CountDisApproved($ID);
                             ?>
                         </span>
                     </td>
                     <td><a href="fullpost.php?id=<?php echo $ID; ?>" class="btn btn-primary" >Details</a></td>
                 </tr>
                 <?php } ?>
              </tbody>
          </table>
      </div>
  </div>    
  <!----------RIGHT END---------------------->    
    </div>
</div>



<?php require_once "includes/footer.php"; ?>