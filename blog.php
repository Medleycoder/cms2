<?php
   $title ='Blog';
require_once "includes/header.php"; ?>

<!----------------------------------------NavBar-------------------------------------------->
<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
  <div class="container-fluid">
    <a class="navbar-brand mx-3" href="#"><h3><strong>MedleyTm</strong></h3></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav mx-auto" style="--bs-scroll-height: 100px;">
      <?php 
      if(isset($_SESSION['UserId'])){ ?>
           <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="myprofile.php?id=<?php echo $_SESSION['UserId']; ?>"><i class="fa-solid fa-user-tie"></i>My Profile</a>
        </li>

      <?php 
      }
      if(isset($_SESSION['UserId'])){?>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php"><i class="fa-solid fa-address-card"></i>Dashboard</a>
        </li>

     <?php
      }else{?>

      <li class="nav-items">
        <a href="login.php" class="nav-link" ><i class="fa-solid fa-lock"></i>Login</a>
      </li>
        <?php
      }
        if(isset($_SESSION['UserId'])){?>
         <li class="nav-item">
             <a class="nav-link " href="admin.php"><i class="fa-solid fa-bars-progress"></i>Manage Admins</a>
        </li>
        <?php
        }else{ ?>
           <li class="nav-item">
          <a class="nav-link " href="register.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-pen"></i>Register</a>
        </li>
        <?php
        }

        if(isset($_SESSION['UserId'])){

        
        ?>
       
        <li class="nav-item">
          <a class="nav-link " href="posts.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-signs-post"></i>Posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="comments.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-comment"></i>Comments</a>
        </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link " href="blog.php?page=1" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-blog"></i>Live Blog</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="catagory.php" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Catagory
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <?php 
            $conn;
            $sql = "SELECT title FROM catagorytable";
            $stmt = $conn->query($sql);
            while($Catagoryrow = $stmt->fetch(PDO::FETCH_ASSOC)){
              $Title = $Catagoryrow['title'];
            ?>
            <li><a class="dropdown-item" href="blog.php"><?php echo $Title; ?></a></li>
           <?php } ?>
          </ul>
        </li>
      </ul>
      <form action="blog.php?"  class="d-flex">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" name="SearchButton" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<!----------------------------------------NavBar---ENd------------------------------------->
<!------------------------------------HEADER-START-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-blog text-danger"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<!------------------------------------HEADER-END-------------------------------------------->
<!------------------------------------SEARCH QUERY-------------------------------------------->
<?php global $conn; ?>
<?php if(isset($_GET['SearchButton'])){
    $Search = $_GET['search'];
    $conn;
    $sql = "SELECT * FROM posttable WHERE datetime LIKE :search
    OR title LIKE :search  OR catagory LIKE :search OR author LIKE :search OR description LIKE :search";
    $stmt = $conn->prepare($sql);
    $Execute = $stmt->execute([':search' => '%'.$Search.'%']);

    ?>
<!------------------------------------SEARCH QUERY END-------------------------------------->

<!-------------------------------------FETCHING DATA--------------------------------------->
<?php 
//PAGINATION//
}elseif(isset($_GET['page'])){
     $Page = $_GET['page'];
     if($Page<0){
      $ShowPostFrom = 0;
     }else{
      $ShowPostFrom = $Page*4-4;
     }
     $sql = "SELECT * FROM posttable ORDER BY id desc LIMIT $ShowPostFrom,4";
     $stmt = $conn->query($sql);
}
else{

    $sql = "SELECT * FROM posttable";
    $stmt = $conn->query($sql);
}
    while($Datarows = $stmt->fetch()){ 
     $Id             = $Datarows['id'];
     $Date           = $Datarows['datetime'];
     $Title          = $Datarows['title'];
     $Catagory       = $Datarows['catagory'];
     $Author         = $Datarows['author'];
     $Image          = $Datarows['image'];
     $Description    = $Datarows['description'];
    
 ?>
<!-------------------------------------FETCHING DATA--END---------------------------------->
<!-------------------------------------MAIN-AREA-------------------------------------------->
<div class="container-sm">
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h1><?php echo $Catagory; ?></h1>
                </div>
                <img src="uploads/<?php echo $Image; ?>" class=" card-img-top" width="auto" height="600px" alt="">
                <div class="card-body">
                  <div class="row">
                    <div class="col-lg-6">
                    <div class="card-title">
                      <h3><?php echo $Title; ?></h3>
                     </div>
                    </div>
                    <div class="col-lg-6 text-end  ">
                      <p><strong>Comments: <?php CountApproved($Id); ?> </strong></p>
                    </div>
                  </div>
                  <!---------------------------------->
                  <div class="row">
                      <div class="col-lg-6">
                         <p><strong>By:  </strong><?php echo $Author; ?></p>  </div>
                      <div class="col-lg-6 text-end">
                          <p><strong>On:  </strong><?php echo $Date; ?></p>
                      </div>
                  </div>
                  <div class="card-text"><?php
                  if(strlen($Description)>20){$Description = substr($Description,0,19)."...";}
                  echo $Description; ?></div>
                </div>
                <a href="fullpost.php?id=<?php echo $Id; ?>" class="btn btn-dark btn-bold">Read More</a>
            </div>
        </div>
    </div>
</div>
<?php  } ?>
<!-------------------------------------MAIN--END-------------------------------------------->
<!-------------------------------Pagination start-------------------------------------------->
<div class="container-sm d-flex align-items-center justify-content-center my-2 py-3">
<div class="row">
<nav aria-label="...">
     <ul class="pagination">
     <li class="page-item ">
      <a class="page-link" href="blog.php?page= 
      <?php 
      if(isset($_GET['page'])){

       if($Page==1){
           echo $Page;
         }else{
           echo htmlentities($Page-1);
         }
      ;?>" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
  <?php 
   $conn;
   $sql = "SELECT COUNT(*) FROM posttable";
   $stmt = $conn->query($sql);
   $RowPagination = $stmt->fetch(PDO::FETCH_ASSOC);
   $TotalPOsts = array_shift($RowPagination);
   $SHowPagination = $TotalPOsts/4;
   $SHowPagination = ceil($SHowPagination);
   for ($i=1; $i<=$SHowPagination; $i++){
          
     
     if($i==$Page){  
  ?>
    <li class="page-item active"><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
    <?php
     }else{
       ?>
      <li class="page-item "><a class="page-link" href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
   <?php
     }
    
      } ?>
    <li class="page-item">
      <a class="page-link" href="blog.php?page=<?php 
      if(isset($Page) && empty($Page)){

      
        if($Page+1 <= $ShowPostFrom){
          echo $Page;
        }else{
          echo $Page-1;
        }
      }?>">Next</a>
    </li>
  </ul>
</nav>
<?php } ?>
  </div>
</div>
<!-------------------------------Pagination ends-------------------------------------------->


<?php require_once "includes/footer.php"; ?>