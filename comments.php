<?php
   $title ='Comments Action';
require_once "includes/header.php"; ?>
<?php require_once "includes/nav.php"; ?>
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
<!------------------------------------Table START-------------------------------------------->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fa-solid fa-thumbs-up text-info"></i>Approve Comment</h2>
        </div>
    </div>
     <div class="row">
        <div class="col-lg-12 col">
          <table class="table table-striped">
          <thead class="bg-dark text-light">
              <tr>
                  <td>#</td>
                  <td>Date</td>
                  <td>Name</td>
                  <td>Comment</td>
                  <td>Approve</td>
                  <td>Delete</td>
                  <td>Detail</td>
              </tr>
          </thead>
          <?php 
             $sql = "SELECT * FROM commenttable WHERE status='OFF'";
             $stmt = $conn->query($sql);
             $Sn=0;
            //  $Execute = $stmt->execute();
            while($Datarows = $stmt->fetch()){
                $CommentID  = $Datarows['id'];
                $Date       = $Datarows['datetime'];
                $Author     = $Datarows['name'];
                $CommentCnt = $Datarows['comment']; 
                $CommentPostId = $Datarows['post_id'];
                $Sn++;
               
            ?>
             <tbody>
                 <tr>
                     <td><?php echo $Sn; ?></td>
                     <td><?php if(strlen($Date)>6){$Date = substr($Date,0,5);} echo $Date; ?></td>
                     <td><?php if(strlen($Author)>11){$Author = substr($Author,0,10);} echo $Author; ?></td>
                     <td><?php if(strlen($CommentCnt)>30){$CommentCnt = substr($CommentCnt,0,30);} echo $CommentCnt; ?></td>
                     <td><a target="_blank" href="approvecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-success">Approve</a></td>
                     <td><a target="_blank" href="deletecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-danger">Delete</a></td>
                     <td><a target="_blank" href="previewcomment.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary">Preview</a></td>
                 </tr>
             </tbody>
            <?php
            }
               ?>
          </table>
        </div>
     </div>
</div>
<!------------------------------------Table End -------------------------------------------->
<!---------------------------------Disapprove Comment-------------------------------------->
<div class="container">
    <div class="card">
        <div class="card-header">
            <h2><i class="fa-solid fa-thumbs-up text-info"></i>Dis-Approve Comment</h2>
        </div>
    </div>
     <div class="row">
        <div class="col-lg-12 col">
          <table class="table table-striped">
          <thead class="bg-dark text-light">
              <tr>
                  <td>#</td>
                  <td>Date</td>
                  <td>Name</td>
                  <td>Comment</td>
                  <td>Dis-Approve</td>
                  <td>Delete</td>
                  <td>Detail</td>
              </tr>
          </thead>
          <?php 
             $sql = "SELECT * FROM commenttable WHERE status='ON'";
             $stmt = $conn->query($sql);
             $Sn=0;
            //  $Execute = $stmt->execute();
            while($Datarows = $stmt->fetch()){
                $CommentID  = $Datarows['id'];
                $Date       = $Datarows['datetime'];
                $Author     = $Datarows['name'];
                $CommentCnt = $Datarows['comment']; 
                $CommentPostId = $Datarows['post_id'];
                $Sn++;
               
            ?>
             <tbody>
                 <tr>
                     <td><?php echo $Sn; ?></td>
                     <td><?php if(strlen($Date)>6){$Date = substr($Date,0,5);} echo $Date; ?></td>
                     <td><?php if(strlen($Author)>11){$Author = substr($Author,0,10);} echo $Author; ?></td>
                     <td><?php if(strlen($CommentCnt)>30){$CommentCnt = substr($CommentCnt,0,30);} echo $CommentCnt; ?></td>
                     <td><a href="dis-approvecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-warning">Dis-Approve</a></td>
                     <td><a href="deletecomment.php?id=<?php echo $CommentID; ?>" class="btn btn-danger">Delete</a></td>
                     <td><a href="fullpost.php?id=<?php echo $CommentPostId; ?>" class="btn btn-primary">Preview</a></td>
                 </tr>
             </tbody>
            <?php
            }
               ?>
          </table>
        </div>
     </div>
</div>
<!------------------------------------Table End -------------------------------------------->




<?php require_once "includes/footer.php"; ?>