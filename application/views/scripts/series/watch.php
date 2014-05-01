<div class="container">
   <div class="row centered mt grid">
      <h1><?= $data['series']['title']; ?></h1>

      <div class="mt"></div>
      <?php foreach ($data['series']['videos'] as $i => $video): ?>
         <div class="container">
            <div class="col-sm-6 col-md-4">
               <a href="/tutorial/video/<?= $video['id']; ?>/<?= $video['clean-title']; ?>">
                  <img src="<?= $video['img']; ?>" class="img-responsive" alt="<?= $video['clean-title']; ?> Series"
                       style="width: 100%;">
               </a>

               <p><br/>&nbsp;</p>
            </div>

            <div class="col-sm-6 col-md-8 text-left">
               <h2><?= $video['title']; ?></h2>

               <p><?= str_replace("\n", "<br/>", $video['description']); ?></p>
               <a href="/tutorial/video/<?= $video['id']; ?>/<?= $video['clean-title']; ?>"
                  class="btn btn-theme btn-lg" data-intent="watch" data-id="<?= $video['alias']; ?>">Watch Tutorial</a>

               <p><br/>&nbsp;</p>
            </div>
         </div>
      <?php endforeach; ?>
   </div>
</div>

<div id="skills"></div>