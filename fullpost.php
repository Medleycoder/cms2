<?php
   $title ='Live Preview';
require_once "includes/header.php"; ?>
 <!------------------------------COMMENT INSERTING-------------------------------------->
 <?php 
 if(isset($_GET['id'])){
     
    if(isset($_POST['commentorbutton'])){
    $SearchQueryParameter = $_GET['id'];
    date_default_timezone_set('Asia/Kolkata');
    $Time                = date(DATE_RFC822); 
    $Name                = $_POST['commentorname'];
    $Email               = $_POST['commentoremail'];
    $Image               = $_FILES['commentorimage']['name'];
    $Target              = "uploads/".basename($_FILES['commentorimage']['name']);
    $Comment             = $_POST['commentorthought'];
    $ApprovedBy          = 'Pending';
    $Status              = 'OFF';
        if(empty($Name) || empty($Email) || empty($Image) || empty($Comment)){
            $_SESSION['ErrorMessage'] = "Field cannot be empty";
            Redirect_to("fullpost.php?id=".$SearchQueryParameter);
        }else{

        
     $conn;
     $sql = "INSERT INTO commenttable(datetime,name,email,image,comment,approvedby,status,post_id) VALUES(:DateTIme,:namE,:emaiL,:imagE,:commenT,:approvedbY,:statuS,:postIdFromUrl)";
     $stmt = $conn->prepare($sql);
     $Execute = $stmt->execute([
         ':DateTIme'      => $Time,
         ':namE'          => $Name,
         ':emaiL'         => $Email,
         ':imagE'         => $Image,
         ':commenT'       => $Comment,
         ':approvedbY'    => $ApprovedBy,
         ':statuS'        => $Status,
         ':postIdFromUrl' => $SearchQueryParameter
     ]);
     move_uploaded_file($_FILES['commentorimage']['tmp_name'],$Target);
     if($Execute){
         $_SESSION['SuccessMessage'] = "Your comment submitted successfully";
         Redirect_to('posts.php');
     }else{
         $_SESSION['ErrorMessage']  = "Something techinical issue in comment submition";
         Redirect_to('posts.php');
     }
    }
 }
}
    ?>
    <!------------------------------COMMENT INSERTING END---------------------------------->

<!------------------------------------HEADER-START-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-eye text-success"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>
<?php echo ErrorMessage(); 
echo SuccessMessage();
?>
<!------------------------------------HEADER-END-------------------------------------------->


<!------------------------------------Main-Area--------------------------------------------->
<div class="container-sm">
    <div class="row">
        <div class="col">
            <div class="card">
 <!------------------------------------FETCHING DATA---------------------------------------->
    <?php
    if(isset($_GET['id'])){
        
        $SearchQueryParameter = $_GET['id'];
        $conn;
        $sql = "SELECT * FROM posttable WHERE id='$SearchQueryParameter'";
        $stmt = $conn->query($sql);
        // $Execute = $stmt->execute([
        //     ':ID' => $SearchQueryParameter
        // ]);
        while($Datarows = $stmt->fetch()){
            $Id            = $Datarows['id'];
            $Date          = $Datarows['datetime'];
            $Title         = $Datarows['title'];
            $Catagory      = $Datarows['catagory'];
            $Author        = $Datarows['author'];
            $Image         = $Datarows['image'];
            $Description   = $Datarows['description'];
            // move_uploaded_file($_FILES['image']['tmp_name'],$Target);
        
    ?>
 <!------------------------------------FETCHING DATA-END------------------------------------>
                <div class="card-header">
                    <h1 class="bold "><?php echo htmlentities($Catagory); ?></h1>
                </div>
               
                <img src="uploads/<?php echo htmlentities($Image); ?>" class="card-img-top img-fluid"   alt="<?php echo htmlentities($Image); ?>">
                   <div class="card-title my-3">
                       <div class="row mx-auto">
                           <div class="col-lg-6 col-md-6 col-sm-6 ">
                               <p><strong>By:  </strong><?php echo htmlentities($Author); ?></p>   
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 text-end">
                               <p><strong>On:  </strong><?php echo htmlentities($Date); ?></p>
                           </div>
                       </div>
                   </div>
                    <div class="card-body">
                      <p class="card-text"><?php echo htmlentities($Description); ?></p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
        </div>
    <?php }} ?>
    
<!-------------------------------DISPLAY EXISTING---------------------------------------->

<!----------------------------------------END FETCHING COMMENT DATA------------------------->
<div class="container-sm">
      <div class="card">
          <div class="card-header">
              <h2 class="text-center">Viewer Comments</h2>
          </div>
          <div class="card-body">
           <div class="row d-flex">
<!----------------------------------------FETCHING COMMENT DATA------------------------------>
<?php 
   if(isset($_GET['id'])){

   
    global $conn;
    $sql = "SELECT * FROM commenttable WHERE post_id='$SearchQueryParameter' AND status='ON'";
    $stmt = $conn->query($sql);
    while($Dataro=$stmt->fetch()){
        $CommentId            = $Dataro['id'];
        $CommentDate          = $Dataro['datetime'];
        $CommentName          = $Dataro['name'];
        $CommentImage         = $Dataro['image'];
        $CommentorComment     = $Dataro['comment'];
        $CommentApprovedBy    = $Dataro['approvedby'];
    
?>
            <div class="col text-center">
                 <img src="uploads/<?php echo $CommentImage; ?>" class="rounded-circle img-fluid" width="200px" alt="">
                       <div class="card-title">
                         <div class="row">
                             <div class="col-lg-6"><strong>On : </strong><?php echo $CommentDate; ?></div>
                             <div class="col-lg-6"><strong>By : </strong><?php echo $CommentName; ?></div>
                         </div>
                     <div class="card-body">
                        <p><?php echo $CommentorComment; ?></p>
                     </div>
                 </div>
            </div>
           </div>
          </div>
      </div>
   
</div>
<?php } } ?>
<!-------------------------------ENDS OFDISPLAY EXISTING--------------------------------->    
<!----------------------------------INPUT AREA------------------------------------->
    <div class="container-sm">
        <div class="row">
            <div class="col">
              <div class="card">
                <div class="card-header">
                 <h1>Your Comment</h1>
                </div>
                <div class="card-body">
                    <form action="fullpost.php?id=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" name="commentorname" class="form-input form-control" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                          <label for="email" class="form-label">Email</label>
                          <input type="text" name="commentoremail" class="form-input form-control" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                               <label for="formFileSm" class="form-label" >Upload Dp</label>
                                <input class="form-control form-control-sm" name="commentorimage" id="formFileSm" type="file">
                        </div>
                        
                        <div class="form-group">
                          <label for="comment" class="form-label">Your Thought</label>
                         <textarea name="commentorthought" id="" class="form-input form-control" cols="10" rows="5"></textarea>
                        </div>
                        <div class="form-group my-2">
                            <input type="submit" name="commentorbutton" class="btn btn-primary" value="Submit">
                        </div>
                        
                    </form>
                </div>
             </div>
           </div>  
       </div>
    </div>   


<!-------------------------------INPUT COMMENT-End--------------------------------------->





