<?php
   $title ='Comment';
require_once "includes/header.php"; ?>
<!----------------------------------------FETCHING COMMENT DATA------------------------------>
<?php 
   if(isset($_GET['id'])){
   $SearchQueryParameter = $_GET['id'];
   
    global $conn;
    $sql = "SELECT * FROM commenttable WHERE post_id='$SearchQueryParameter'";
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
