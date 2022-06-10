<?php
   $title ='Manage Catagory';
require_once "includes/header.php"; ?>
<?php require_once "includes/nav.php"; ?>
<?php  $_SESSION["TrackingURL"] = $_SERVER['PHP_SELF']; ?>
<?php Confirm_Login(); ?>
<!---------------------------------Inserting into database------------------------>
<?php 
   if(isset($_POST['submit'])){
       $Title = $_POST['title'];
       $Author = $_SESSION['AName'];
       date_default_timezone_set('Asia/Kolkata');
       $Time = date(DATE_RFC822); 

       if(empty($Title)){
           $_SESSION['ErrorMessage'] = 'Please fill title to continue';
           Redirect_to("catagory.php");
        
          
       }elseif ((strlen($Title))<3){
         $_SESSION['ErrorMessage'] = 'Title length should be greater than 2 character';
       
       
        }else{

       
       $conn;
       $sql       = "INSERT INTO catagorytable (title,author,time) VALUES (:titlE,:authoR,:datE)";
       $stmt            = $conn->prepare($sql);
       $Execute         = $stmt->execute([
           ':titlE'     => $Title,
           ':authoR'    => $Author,
           ':datE'      => $Time
       ]);
       if($Execute){
           $_SESSION['SuccessMessage'] = 'Title submitted successfully';
           Redirect_to('addnewpost.php');
       }else{
           $_SESSION['ErrorMessage']   = 'Something techinical issue';
           Redirect_to('catagory.php');
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
                <h1><i class="fa-solid fa-pen-to-square"></i><?php echo htmlentities($title); ?></h1>
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
                    <h2 >Add New Catagory</h2>
                </div>
                <div class="card-body">
                    <form action="catagory.php" method="POST">
                        <div class="form-group">
                            <label for="title" class="form-label text-bold ">Title</label>
                            <input type="text" class="form-control" name="title" id="Title" placeholder="Enter title here">
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

<!------------------------------------Main Area End-------------------------------------->
<!------------------------------------Catagory Table------------------------------------->
<table class="table table-striped my-4">
    <thead class=" text-light bg-dark">
      
    <tr>
        <td>#</td>
        <td>Catagory</td>
        <td>Author</td>
        <td>Time</td>
        <td>Action</td>
    </tr>
    </thead>
    <?php 
      $conn;
      $sql = "SELECT * FROM catagorytable LIMIT 10";
      $stmt = $conn->query($sql);
      $Sn=0;
      while($Datarows = $stmt->fetch(PDO::FETCH_ASSOC)){
          $CatagoryId = $Datarows['id'];
          $CatagoryTable = $Datarows['title'];
          $AuthorTable = $Datarows['author'];
          $Time   = $Datarows['time'];
          $Sn++;
           ?>

          <tbody>
              <tr>
                  <td><?php echo $Sn; ?></td>
                  <td><?php echo $CatagoryTable; ?></td>
                  <td><?php echo $AuthorTable; ?></td>
                  <td><?php if(strlen($Time)>16){$Time = substr($Time,0,15);} echo $Time; ?></td>
                  <td><a target="_blank" class="btn btn-danger" href="deletecatagory.php?id=<?php echo $CatagoryId; ?>">Delete</a></td>
              </tr>
          </tbody>
          <?php 
      }
    ?>
</table>
</div>


<?php require_once "includes/footer.php"; ?>