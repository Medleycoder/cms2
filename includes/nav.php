<!----------------------------------------NAVBAR-------------------------------------------->

<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
  <div class="container-fluid">
    <a class="navbar-brand mx-3" href="dashboard.php"><h3><strong>MedleyTm</strong></h3></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav mx-auto" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="myprofile.php?id=<?php echo $_SESSION['UserId']; ?>"><i class="fa-solid fa-user-tie"></i>My Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php"><i class="fa-solid fa-address-card"></i>Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="admin.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-bars-progress"></i>Manage Admins</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="posts.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-signs-post"></i>Posts</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="comments.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-comment"></i>Comments</a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="blog.php?page=1" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-blog"></i>Live Blog</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="catagory.php" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Catagory
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
      <li class="nav-item ">
          <a class="nav-link text-danger" href="logout.php" tabindex="-1" aria-disabled="true"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!------------------------------------NAVBAR-END-------------------------------------------->
