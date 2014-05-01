<div id="hello">
   <div class="container">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1 centered">
            <h1>Easy Learn Tutorial</h1>

            <h2>PROGRAMMING & SOFTWARE DEVELOPMENT TUTORIALS</h2>
         </div>
      </div>
   </div>
</div>

<div id="green">
   <div class="container">
      <div class="row">
         <div class="col-lg-5 centered">
            <img src="/public/img/iphone.png" alt="">
         </div>

         <div class="col-lg-7 centered">
            <h1>MOST POPULAR SERIES</h1>
            <?php foreach ($data['series'] as $_serie): ?>
               <p>
                  <?= $_serie['title']; ?> <a href="<?= $_serie['href']; ?>" class="fa fa-youtube-play"></a>
               </p>
            <?php endforeach; ?>

         </div>
      </div>
   </div>
</div>

<div class="container">
   <div class="row centered mt grid">
      <h3>LATEST TUTORIALS</h3>

      <div class="mt"></div>
      <?php foreach ($data['latest']['videos'] as $i => $_video): ?>
         <div class="col-lg-4">
            <a href="/tutorial/video/<?= $_video['id']; ?>/<?= $_video['clean-title']; ?>">
               <img src="<?= $_video['img']; ?>" class="img-responsive"/>
            </a>

            <h3>
               <a href="/tutorial/video/<?= $_video['id']; ?>/<?= $_video['clean-title']; ?>"
                  style="color: inherit;">
                  <?= $_video['title']; ?>
               </a>
            </h3>
         </div>

         <?php if ($i % 3 === 2): ?>
            <div class="clearfix"></div>
         <?php endif; ?>
      <?php endforeach; ?>
   </div>

   <div class="row mt centered">
      <div class="col-lg-7 col-lg-offset-1 mt">
         <p class="lead">Want to <strong>improve your programming skills</strong> about something not mentioned in the
            series?
         </p>
      </div>

      <div class="col-lg-3 mt">
         <p>
            <a href="https://plus.google.com/+easylearntutorial/posts" class="btn btn-theme btn-lg">Suggest tutorial series</a>
         </p>
      </div>
   </div>
</div>


<div id="skills">
   <div class="container">
      <div class="row centered">
         <?php
         $_topics = array(
            array('title' => 'AngularJS', 'id' => 'cv_ng', 'total' => 8),
            array('title' => 'Android', 'id' => 'cv_ng', 'total' => 3),
            array('title' => 'Advanced', 'id' => 'cv_adv', 'total' => 51),
            array('title' => 'Beginner', 'id' => 'cv_beg', 'total' => 49),
            array('title' => 'Demos', 'id' => 'cv_demo', 'total' => 12),
            array('title' => 'Game Development', 'id' => 'cv_gamedev', 'total' => 75),
            array('title' => 'GWT', 'id' => 'cv_gwt', 'total' => 63),
            array('title' => 'HTML5', 'id' => 'cv_html5', 'total' => 68),
            array('title' => 'JavaScript', 'id' => 'cv_js', 'total' => 40),
            array('title' => 'Live Coding', 'id' => 'cv_live', 'total' => 4),
            array('title' => 'Mobile', 'id' => 'cv_ng', 'total' => 3),
            array('title' => 'PHP', 'id' => 'cv_php', 'total' => 25),
            array('title' => 'Programming Challenges', 'id' => 'cv_power', 'total' => 14),
            array('title' => 'Programming Theory', 'id' => 'cv_theory', 'total' => 28),
            array('title' => 'Quick Tips', 'id' => 'cv_tips', 'total' => 16),
            array('title' => 'Awesomeness', 'id' => 'cv_awes', 'total' => 100),
         );
         ?>
         <h3>TUTORIALS BY TOPIC</h3>

         <?php foreach ($_topics as $_topic): ?>
            <div class="col-lg-3 mt">
               <canvas id="cv_<?= $_topic['title']; ?>" height="130" width="130"></canvas>
               <p><?= $_topic['title']; ?></p>
               <br>
               <script>
                  var doughnutData = [{ value: <?= $_topic['total']; ?>, color: "#74cfae" },{
                        value: <?= 100 - $_topic['total']; ?>, color: "#3c3c3c" }];
                  var myDoughnut = new Chart(document.getElementById("cv_<?= $_topic['title']; ?>").getContext("2d")).Doughnut(doughnutData);
               </script>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
</div>

<section id="contact"></section>
<div id="social">
   <div class="container">
      <div class="row centered">
         <?php
         $_topics = array(
            'gamepad',
            'android',
            'html5',
            'css3',
            'code',
            'windows',
            'linux',
            'apple',
            'trophy',
            'puzzle-piece',
            'code-fork',
            'flask',

         );
         ?>
         <h3>WHAT OUR VIDEO TUTORIALS CURRENTLY TALK ABOUT</h3>
         <br/>
         <?php foreach ($_topics as $_icon): ?>
            <div class="col-md-1">
               <i class="fa fa-<?= $_icon; ?>"></i>
            </div>
         <?php endforeach; ?>
      </div>
   </div>
</div>
