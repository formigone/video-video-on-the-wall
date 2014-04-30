<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <title><?= $page['title']; ?></title>

   <link href="/public/css/bootstrap.css" rel="stylesheet">
   <link href="/public/css/main.css" rel="stylesheet">
   <link href="/public/css/font-awesome.min.css" rel="stylesheet">

   <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
   <script src="/public/js/bootstrap.js"></script>
   <script src="/public/js/chart.js"></script>
   <link href='/favicon.ico' rel='icon' type='image/x-icon'/>

   <!--[if lt IE 9]>
   <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
   <script src="//oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
   <![endif]-->
</head>

<body>

<div class="navbar navbar-default navbar-fixed-top">
   <div class="container">
      <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="/"><i class="fa fa-bookmark-o"></i></a>
         <div class="pull-right yt-widget hor-spacer hidden visible-xs">
            <div class="g-ytsubscribe" data-channel="easylearntutorial" data-layout="default" data-count="default"></div>
         </div>
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
               <?php if (!$_page['auth'] || ($_page['auth'] && $isLoggedIn)): ?>
                  <li class="<?= $_page['type'] !== $page['active'] ? : 'active'; ?>">
                     <a href="<?= $_page['href']; ?>"><?= $_page['title']; ?></a>
                  </li>
               <?php endif; ?>
            <?php endforeach; ?>
            <li class="yt-widget">
               <script src="https://apis.google.com/js/platform.js"></script>
               <div class="g-ytsubscribe" data-channel="easylearntutorial" data-layout="default" data-count="default"></div>
            </li>
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

<script>
   (function(i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r;
      i[r] = i[r] || function() {
         (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date();
      a = s.createElement(o),
         m = s.getElementsByTagName(o)[0];
      a.async = 1;
      a.src = g;
      m.parentNode.insertBefore(a, m)
   })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

   ga('create', 'UA-36191661-1', 'easylearntutorial.com');
   ga('send', 'pageview');

</script>
</body>
</html>
