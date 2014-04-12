<div id="hello">
   <div class="container">
      <div class="row">
         <div class="col-lg-10 col-lg-offset-1 centered">
            <h1>Easy Learn Tutorial</h1>
            <h2>PROGRAMMING & SOFTWARE DEVELOPMENT TUTORIALS</h2>
         </div><!-- /col-lg-8 -->
      </div><!-- /row -->
   </div> <!-- /container -->
</div><!-- /hello -->

<div id="green">
   <div class="container">
      <div class="row">
         <div class="col-lg-5 centered">
            <img src="/public/img/iphone.png" alt="">
         </div>

         <div class="col-lg-7 centered">
            <h1>Series</h1>
            <?php foreach ($data['series'] as $_serie): ?>
               <p><?= $_serie; ?></p>
            <?php endforeach; ?>

         </div>
      </div>
   </div>
</div>

<div class="container">
   <div class="row centered mt grid">
      <h3>OUR LATEST WORK</h3>
      <div class="mt"></div>
      <div class="col-lg-4">
         <a href="#"><img src="/public/img/01.jpg" alt=""></a>
      </div>
      <div class="col-lg-4">
         <a href="#"><img src="/public/img/02.jpg" alt=""></a>
      </div>
      <div class="col-lg-4">
         <a href="#"><img src="/public/img/03.jpg" alt=""></a>
      </div>
   </div>

   <div class="row centered mt grid">
      <div class="mt"></div>
      <div class="col-lg-4">
         <a href="#"><img src="/public/img/04.jpg" alt=""></a>
      </div>
      <div class="col-lg-4">
         <a href="#"><img src="/public/img/05.jpg" alt=""></a>
      </div>
      <div class="col-lg-4">
         <a href="#"><img src="/public/img/06.jpg" alt=""></a>
      </div>
   </div>

   <div class="row mt centered">
      <div class="col-lg-7 col-lg-offset-1 mt">
         <p class="lead">Want to <strong>improve your programming skills</strong> about something not mentioned here?</p>
      </div>

      <div class="col-lg-3 mt">
         <p><button type="button" class="btn btn-theme btn-lg">Suggest tutorial series</button></p>
      </div>
   </div>
</div>


<div id="skills">
   <div class="container">
      <div class="row centered">
         <h3>OUR SKILLS</h3>
         <div class="col-lg-3 mt">
            <canvas id="javascript" height="130" width="130"></canvas>
            <p>JavaScript</p>
            <br>
            <script>
               var doughnutData = [
                  {
                     value: 70,
                     color:"#74cfae"
                  },
                  {
                     value : 30,
                     color : "#3c3c3c"
                  }
               ];
               var myDoughnut = new Chart(document.getElementById("javascript").getContext("2d")).Doughnut(doughnutData);
            </script>
         </div>
         <div class="col-lg-3 mt">
            <canvas id="bootstrap" height="130" width="130"></canvas>
            <p>C++</p>
            <br>
            <script>
               var doughnutData = [
                  {
                     value: 90,
                     color:"#74cfae"
                  },
                  {
                     value : 10,
                     color : "#3c3c3c"
                  }
               ];
               var myDoughnut = new Chart(document.getElementById("bootstrap").getContext("2d")).Doughnut(doughnutData);
            </script>
         </div>
         <div class="col-lg-3 mt">
            <canvas id="wordpress" height="130" width="130"></canvas>
            <p>PHP</p>
            <br>
            <script>
               var doughnutData = [
                  {
                     value: 95,
                     color:"#74cfae"
                  },
                  {
                     value : 5,
                     color : "#3c3c3c"
                  }
               ];
               var myDoughnut = new Chart(document.getElementById("wordpress").getContext("2d")).Doughnut(doughnutData);
            </script>
         </div>
         <div class="col-lg-3 mt">
            <canvas id="photoshop" height="130" width="130"></canvas>
            <p>Android</p>
            <br>
            <script>
               var doughnutData = [
                  {
                     value: 50,
                     color:"#74cfae"
                  },
                  {
                     value : 50,
                     color : "#3c3c3c"
                  }
               ];
               var myDoughnut = new Chart(document.getElementById("photoshop").getContext("2d")).Doughnut(doughnutData);
            </script>
         </div>
      </div><!-- /row -->
   </div><!-- /container -->
</div><!-- /skills -->

<section id="contact"></section>
<div id="social">
   <div class="container">
      <div class="row centered">
         <div class="col-lg-8 col-lg-offset-2">
            <div class="col-md-3">
               <a href="#"><i class="fa fa-gamepad"></i></a>
            </div>
            <div class="col-md-3">
               <a href="#"><i class="fa fa-youtube"></i></a>
            </div>
            <div class="col-md-3">
               <a href="#"><i class="fa fa-android"></i></a>
            </div>
            <div class="col-md-3">
               <a href="#"><i class="fa fa-code"></i></a>
            </div>
         </div>
      </div>
   </div><!-- /container -->
</div><!-- /social -->
