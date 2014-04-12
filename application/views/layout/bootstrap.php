<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title><?= $page['title']; ?></title>

   <!-- Bootstrap core CSS -->
   <link href="/public/css/bootstrap.css" rel="stylesheet">

   <!-- Custom styles for this template -->
   <link href="/public/css/main.css" rel="stylesheet">
   <link href="/public/css/font-awesome.min.css" rel="stylesheet">

   <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
   <script src="/public/js/chart.js"></script>

   <link href='/favicon.ico' rel='icon' type='image/x-icon'/>

   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
   <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
</head>

<body>

<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top">
   <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
<!--         <a class="navbar-brand" href="#"><i class="fa fa-puzzle-piece"></i></a>-->
         <a class="navbar-brand" href="/"><i class="fa fa-bookmark-o"></i></a>
      </div>
      <div class="navbar-collapse collapse">
         <ul class="nav navbar-nav navbar-right">
            <?php
            $_pages = array(
               array('type' => 'home', 'href' => '/', 'title' => 'Home', 'auth' => false),
               array('type' => 'series', 'href' => '/series', 'title' => 'Series', 'auth' => false),
               array('type' => 'about', 'href' => '/about', 'title' => 'About', 'auth' => false),
               array('type' => 'donate', 'href' => '/donate', 'title' => 'Donate', 'auth' => false),
               array('type' => 'admin', 'href' => '/admin', 'title' => 'Admin', 'auth' => true)
            )
            ?>

            <?php foreach ($_pages as $_page): ?>
               <li class="<?= $_page['type'] !== $page['active'] ? : 'active'; ?>">
                  <a href="<?= $_page['href']; ?>"><?= $_page['title']; ?></a>
               </li>
            <?php endforeach; ?>
         </ul>
      </div>
      <!--/.nav-collapse -->
   </div>
</div>

<?php if (!empty($view)) {
   $this->load->view($view, $data);
} ?>

<div id="f">
   <div class="container">
      <div class="row">
         <p>Copyright &copy; 2014 EasyLearnTutorial. All rights reserved.</p>
      </div>
   </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/public/js/bootstrap.js"></script>
</body>
</html>
