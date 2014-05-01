<div class="container">
   <div class="row centered mt grid">
      <h3>SELECT TUTORIAL SERIES</h3>

      <div class="mt"></div>
      <?php foreach ($data['series'] as $i => $series): ?>
         <div class="col-lg-4 col-md-4 col-sm-6">
            <a href="/series/watch/<?= $series['id']; ?>/<?= $series['clean-title']; ?>">
               <img src="<?= $series['img']; ?>" class="img-responsive" alt="<?= $series['clean-title']; ?> Series"
                    style="width: 100%;">
            </a>

            <h3>
               <a href="/series/watch/<?= $series['id']; ?>/<?= $series['clean-title']; ?>"
                  style="color: inherit">
                  <?= $series['title']; ?>
               </a>
            </h3>
         </div>

         <?php if ($i % 3 === 2): ?>
            <div class="clearfix"></div>
         <?php endif; ?>
      <?php endforeach; ?>
   </div>
</div>

<div id="skills"></div>