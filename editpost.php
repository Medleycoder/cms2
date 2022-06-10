<?php  
    $title ='Edit Posts';
 require_once "includes/header.php";?>
 <?phpConfirm_Login(); ?>
 <?php
    $SearchQueryParameter = $_GET['id'];
if(isset($_POST['submit'])){
    date_default_timezone_set('Asia/Kolkata');
    $DateTime             = date(DATE_RFC822); 
    $Title                = $_POST['titleedit'];
    $Catagory             = $_POST['catagoryedit'];
    $Author               = 'NIKITA';
    $Image                = $_FILES['image']['name'];
    $Target               = "uploads/".basename($_FILES["image"]["name"]);
    $Description          = $_POST['descriptionedit'];



    if(empty($Title) ||  empty($Author) || empty($Description)){
        $_SESSION['ErrorMessage'] = "Field can not be left empty";
        Redirect_to("posts.php");

    }elseif(strlen($Title)<5 || strlen($Description)<100){
          
        $_SESSION['Errormessage'] = "Lenght of title and description cannot be less than 6 and 100";
        Redirect_to("posts.php");
    }else{
        global $conn;
        if (!empty($_FILES['image']['name'])) {
            $sql = "UPDATE posttable
                    SET datetime=:dateTime, title=:titLe, catagory=:cataGorY, image=:imagE, description =:descripTion, author = authOr
                    WHERE id='$SearchQueryParameter'";
          }else {
            $sql = "UPDATE posttable
                    SET datetime=:dateTime, title=:titLe, catagory=:cataGorY, description =:descripTion
                    WHERE id='$SearchQueryParameter'";
          }
        // $sql = "UPDATE posttable SET title = :titLe, catagory = :catagoRy, author = :authoR, image = :imaGe, description = :descripTion WHERE id='$SearchQueryParameter'" ;
        $stmt =$conn->prepare($sql);
        $Execute = $stmt->execute([
            'dateTime'       => $DateTime,
            ':titLe'         => $Title,
            ':cataGorY'      => $Catagory,
            'imagE'          => $Image,
            ':descripTion'   => $Description
        ]);
        move_uploaded_file($_FILES["image"]["tmp_name"],$Target);
      
         
        if($Execute){
            $_SESSION['SuccessMessage'] = "Your Post updated successfully";
            Redirect_to('posts.php');
        }else{
            $_SESSION['ErrorMessage']  = "Something techinical glitch happened on editing post";
            Redirect_to("posts.php");

        }
        
    }   

    
}

?>
<!----------------------------------------HEADER-------------------------------------------->
<header>
    <div class="container py-3">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fa-solid fa-pen-to-square text-info"></i><?php echo $title; ?></h1>
            </div>
        </div>
    </div>
</header>

<!----------------------------------------HEADER-END----------------------------------------->
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
                <div class="card-body">
                <?php 
                   echo SuccessMessage();
                   echo ErrorMessage();
                ?>
                    <form action="editpost.php?id=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title" class="form-label text-bold ">Title</label>
                            <input type="text" class="form-control" name="titleedit" id="Title" value="<?php echo htmlentities($TitleEdit); ?>">
                        </div>
                        <div class="form-group">
                            <label for="catagory" class="form-label text-bold ">Select Catagory</label>
                            <select class="form-select" aria-label="Default select example" name="catagoryedit">
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
                        <div class="FieldInfo">Existing Image: </div>
                               <img src="Uploads/<?php echo $ImageEdit; ?>" class="img-fluid" width="400px" alt="">

                               <div class="custom-file">
                               <label for="formFileSm" class="form-label custom-file-label">Upload image</label>
                                <input class="form-control form-control-sm custom-file-input" name="image" id="formFileSm" type="File" ></div>
                                
                        </div>
                        <div class="form-group">
                            <label for="floatingTextarea2">Post Description</label>
                           <textarea class="form-control" name="descriptionedit" placeholder="<?php echo htmlentities($DescriptionEdit); ?>"  id="floatingTextarea2" style="height: 100px"></textarea>
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
<?php } ?>
<!----------------------------------------MAIN-AREAS-ENDS------------------------------------->
