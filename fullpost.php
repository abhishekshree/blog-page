<?php require_once("include/db.php"); ?>
<?php require_once("include/sessions.php"); ?>
<?php require_once("include/functions.php"); ?>
<?php
if (isset($_POST['Submit'])) {
  $Name = $_POST['Name'];
  $Email = $_POST['Email'];
  $Comment = $_POST['Comment'];
  date_default_timezone_set("Asia/Kolkata");
  $currenttime=time();
  //$datetime = strftime("%Y-%m-%d %H:%M:%S",$currenttime);
  $datetime = strftime("%B-%d-%Y %H:%M:%S %a",$currenttime);
  $datetime;
  $Postid = $_GET['id'];
  if (empty($Name) || empty($Email) || empty($Comment)) {
    $_SESSION['ErrorMessage']="All fields are required !";
}

elseif (strlen($Comment)>500) {
  $_SESSION['ErrorMessage']="Only 500 characters allowed for comments";
}

else {
  global $connecting_db;
  global $connection;
  $idoftable = $_GET['id'];
  $query = "INSERT INTO comments(datetime, name ,email, comment, approvedby,status,admin_panel_id) VALUES('$datetime','$Name','$Email','$Comment','pending','OFF','$idoftable')";
  $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
  if($execute){
    $_SESSION['SuccessMessage']="Comment added successfully";
    redirect("fullpost.php?id={$Postid}");
}

else {
  $_SESSION['ErrorMessage']="Something went wrong";
    redirect("fullpost.php?id={$Postid}");
}
}
}

 ?>

<html>

  <head>
    <title>Full Blog Page</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/public.css">
  </head>

  <body>
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
            <li><a href="">Features</a></li>
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
    <div class="container">
        <div class="blog-header">
            <h1>The complete responsive CMS blog</h1>
            <p class="lead">The complete blog using <kbd>PHP</kbd> by Abhishek Shree</p>
            <div><?php echo Message(); echo SMessage(); ?></div>
        </div>
        <div class="row">
          <div class="col-sm-8">
             <?php
             global $connecting_db;
             global $connection;
             if (isset($_GET["searchbutton"])) {
               $search = $_GET['search'];
               $view="SELECT * FROM admin_panel
               WHERE datetime LIKE '%$search%'
               OR title LIKE '%$search%'
               OR category LIKE '%$search%'
               OR post LIKE '%$search%'
               ";
             }else{
             $postidfromURL = $_GET['id'];
             $view = "SELECT * FROM admin_panel WHERE id ='$postidfromURL'";}
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
                  <p style="font-size:1.1em; text-align:justify;"><?php echo nl2br($post); ?></p>
                </div>
                </div>
              <?php } ?>
              <hr>
              <h2><u>Your comments:</u></h2>
              <?php global $connecting_db;
              global $connection;
              $post = $_GET['id'];
              $query = "SELECT * FROM comments WHERE admin_panel_id='$post' AND status='ON'";
              $execute = mysqli_query($connection,$query)or die(mysqli_error($connection));
              while ($Datarow = mysqli_fetch_array($execute, MYSQLI_ASSOC)) {
                $commentdate = $Datarow["datetime"];
                $name = $Datarow["name"];
                $comment = $Datarow["comment"];

              ?>
              <div style="background-color : #F6F7F9;">
              <img style="margin-left: 10px; margin-top: 10px;" class="pull-left" src="images/comment.png" width=70px; height=70px;>
                <p style="color:#365899; font-family:sans-serif; font-size:1.1em; font-weight:bold; padding-top:10px;"><?php echo $name; ?></p>
                <p style="color:#b6b406; font-weight:bold; margin-top:-2px;"><?php echo $commentdate; ?></p>
                <p style="margin-top:-2px;font-size: 1.1em;"><?php echo nl2br($comment); ?></p><hr>
              </div>
              <?php } ?>
              <div><h3 class="display-4">Comments area</h3></div>
              <div>
                <form action="fullpost.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data">
                  <fieldset>
                    <div class="form-group">
                  <label for="Name"><h4>Name:</h4></label>
                  <input class="form-control" type="text" name="Name" id="Name" placeholder="Name">
                    </div>
                    <div class="form-group">
                  <label for="E-mail"><h4>E-mail:</h4></label>
                  <input class="form-control" type="email" name="Email" id="Email" placeholder="Email">
                    </div>
                  <div class="form-group">
                <label for="Commentarea"><h4>Comment:</h4></label>
                <textarea class="form-control" name="Comment" id="Commentarea" rows="6"></textarea>
                </div>
                <input class="btn btn-primary" type="submit" name="Submit" value="Submit!" >
              </fieldset>
            </form>
          </div>

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
