<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<html>

  <head>
    <title>Blog Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/public.css">
  </head>

  <body>
    <div style="height:10px; background:#27AAE1;"></div>
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="container" >
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
            <span class="sr-only">Toggle Navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <h2 class="navbar-brand" style="margin-top:-5px;">BlogS</h2>
        </div>
        <div class="collapse navbar-collapse" id="collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li class="active"><a href="Blog.php">Blog</a></li>
            <li><a href="">About us</a></li>
            <li><a href="">Contact us</a></li>
            <li><a href="login.php">Admins here</a></li>
          </ul>
          <form action="blog.php" class="navbar-form navbar-right">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search" name="search">
            </div>
              <button class="btn btn-default" name="searchbutton">GO</button>
          </form>
        </div>
      </div>
    </nav>
    <div class="line" style="height:10px; background:#27AAE1;"></div>
    <div class="container">
        <div class="blog-header">
            <h1>The complete responsive CMS blog</h1>
            <p class="lead">The complete blog using <kbd>PHP</kbd> by Abhishek Shree</p>
        </div>
        <div class="row">
          <div class="col-sm-8">
             <?php
             global $connecting_db;
             global $connection;
             if (isset($_GET["searchbutton"])) {
               $search = $_GET['search']; //search button 
               $view="SELECT * FROM admin_panel
               WHERE datetime LIKE '%$search%'
               OR title LIKE '%$search%'
               OR category LIKE '%$search%'
               OR post LIKE '%$search%'
               ";
             }elseif(isset($_GET['Category'])){
              //catergory selection ?Category=--
              $Category = $_GET['Category'];
              $view = "SELECT * FROM admin_panel WHERE category='$Category' ORDER BY datetime DESC";
             }
             elseif(isset($_GET["Page"])){
              //for pagination when page is given...
              $page =$_GET["Page"];
              if ($page == 0 || $page < 1) {
                $show_post_from = 0;
              }else{
              $show_post_from = ($page*5)-5;
              }
              $view = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT $show_post_from,5";
            
             }else{
              $view = "SELECT * FROM admin_panel ORDER BY datetime desc LIMIT 0,5"; //default
              }
             $execute = mysqli_query($connection,$view)or die(mysqli_error($connection));
             while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
                $postid=$Datarow['id'];
                $date=$Datarow['datetime'];
                $title=$Datarow['title'];
                $category=$Datarow['category'];
                $author=$Datarow['author'];
                $image=$Datarow['image'];
                $post=$Datarow['post'];
              ?>
              <div class="blogpost thumbnail">
                <img class="img-responsive img-rounded" src="upload/<?php echo $image; ?>">
                <div class="caption">
                  <h1 style="font-weight: bold;//color: #005e90; color: #0090db;"><?php echo htmlentities($title); ?></h1>
                  <p style="color: #868686;font-weight: bold;margin-top: -2px;">Category:<?php echo $category; ?> published on:<?php echo $date; ?></p>
                  <p style="font-size:1.1em; text-align:justify;"><?php
                  if (strlen($post)>150) {
                    $post=substr($post,0,150).'...';
                  }
                  echo $post; ?></p>
                </div>
                <a href="fullpost.php?id=<?php echo $postid; ?>"><span class="btn btn-info">Read More &rsaquo;</span></a>
              </div>
              <?php } ?>
          <nav>
          <ul class="pagination pull-left pagination-lg">
          <?php
          if (isset($page)) {
          if ($page>1) {
            ?>
            <li > <a href="blog.php?Page=<?php echo $page-1; ?>">&laquo;</a></li>
          <?php } } ?>
          
          <?php 
          global $connecting_db;
          global $connection;
          $querypagination = "SELECT COUNT(*) FROM admin_panel";
          $executepagination = mysqli_query($connection,$querypagination)or die(mysqli_error($connection));
          $rowpagination = mysqli_fetch_array($executepagination, MYSQLI_ASSOC);
          $totalposts = array_shift($rowpagination);
          // echo $totalposts;
          $postperpage = $totalposts/5;
          $postperpage = ceil($postperpage);
          for ($i=1; $i <= $postperpage ; $i++) { 
            if (isset($page)) {
            if ($i == $page) {
          ?>
          
          <li class="active"><a href = "blog.php?Page=<?php echo $i; ?>"> <?php echo $i; ?> </a></li>
          <?php 
          }
          else{ ?>
            <li><a href = "blog.php?Page=<?php echo $i; ?>"> <?php echo $i; ?> </a></li>
          
          
          <?php 
          } 
          }
          } 
          ?>
          <?php
          if (isset($page)) {
          if ($page+1<= $postperpage) {
          ?>
            <li > <a href="blog.php?Page=<?php echo $page+1; ?>">&raquo;</a></li>
          <?php } } ?>
          
          </ul>
          </nav>
          </div>

          <div class="col-sm-offset-1 col-sm-3">
            <h2>About me</h2>
            <img class="img-responsive img-circle" style="max-width: 150px;margin: 0 auto; display: block;" src="images/pic.jpg">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus egestas nisl sed massa consequat, in vulputate nulla imperdiet. Cras in volutpat lacus. Nulla tempus tortor vitae diam tempor egestas. Aliquam eu imperdiet nisi. Ut a mi eu magna dapibus lobortis. Curabitur semper volutpat lectus, vel pellentesque elit pulvinar at. Cras pretium lectus at tellus consequat rutrum. Etiam volutpat ornare quam, nec egestas nibh suscipit et. Aliquam venenatis pretium bibendum. Nulla commodo non libero ut porttitor. Sed ac lacus vel libero elementum consectetur. Phasellus euismod odio ut urna fringilla, id tristique felis suscipit. Vivamus ut ipsum placerat nisi bibendum suscipit vel et neque. Vivamus suscipit sapien sed enim mollis hendrerit.</p>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h2 class="panel-title">Categories</h2>
              </div>
              <div class="panel-body">
                <?php 
                global $connecting_db;
                global $connection;
                $view = "SELECT * FROM category ORDER BY dateandtime DESC";
                $executeview = mysqli_query($connection,$view)or die(mysqli_error($connection));
                while ($Datarow=mysqli_fetch_array($executeview, MYSQLI_ASSOC)) {
                  $id = $Datarow['id'];
                  $category = $Datarow['name'];
                
                ?>
                <a href="blog.php?Category=<?php echo $category; ?>">
                <span class=""><?php echo $category."<br>"; ?></span></a>
                <?php } ?>
              </div>
              <div class="panel-footer">
                
              </div>
            </div>
            <div class="panel panel-info">
              <div class="panel-heading">
                <h2 class="panel-title">Recent posts</h2>
              </div>
              <div class="panel-body">
               <?php 
                global $connecting_db;
                global $connection;
                $view = "SELECT * FROM admin_panel ORDER BY datetime DESC LIMIT 0,5 ";
                $executeview = mysqli_query($connection,$view)or die(mysqli_error($connection));
                while ($Datarows=mysqli_fetch_array($executeview, MYSQLI_ASSOC)) {
                  $id = $Datarows['id'];
                  $title = $Datarows['title'];
                  $date = $Datarows['datetime'];
                  $image = $Datarows['image'];
                  if (strlen($date)>13) {
                    $date=substr($date, 0, 13);
                  }
               ?>
               <div>
                 <img style=" margin-left: 10px" class="pull-left" width="70" height="70" src="upload/<?php echo $image; ?>">
                 <a href="fullpost.php?id=<?php echo $id; ?>">
                 <p style="margin-left: 90px;"><?php echo htmlentities($title); ?></p></a>
                 <p style="margin-left: 90px;"><?php echo $date; ?></p>
                 <hr>
               </div>
               <?php } ?>
              </div>
              <div class="panel-footer">
                
              </div>
            </div>
          </div>
        </div>
    </div>
   </div>
    <footer class="footer">
      <div class="container">
        <p class="text-muted">Project made by Abhishek Shree.</p>
      </div>
    </footer>
  </body>

</html>
