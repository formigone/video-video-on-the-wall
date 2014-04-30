<div class="container">
   <div class="row centered mt grid">
      <h3><?= $data['video']['title']; ?></h3>

      <p>
         <small>from
            <a href="/series/watch/?st=<?= $data['video']['series']['clean-title']; ?>&sid=<?= $data['video']['series']['id']; ?>">
               <?= $data['video']['series']['title']; ?>
            </a>
            series
         </small>
      </p>

      <div class="mt"></div>
      <div class="col-md-push-2 col-md-8 col-sm-push-1 col-sm-10 text-center">
         <h1>[video player here]</h1>

         <p class="text-left pull-right">
            [SOCIAL SHARES]
         </p>

         <p class="text-left">
            <small>By <a href="#?GP-AUTHOR-LINK">Rodrigo
                  Silveira</a>, <?= date('M d, Y @ H:m a', strtotime($data['video']['created'])); ?></small>
         </p>
         <div class="clearfix"></div>
         <p class="text-left lead"><?= $data['video']['extra_description']; ?></p>

         <div class="clearfix"></div>

         <?php if (!empty($data['video']['playback']['prev'])): ?>
            <a href="/tutorial/?vt=<?= $data['video']['playback']['prev']['clean-title']; ?>&vid=<?= $data['video']['playback']['prev']['id']; ?>"
               class="btn btn-success pull-left" alt="<?= $data['video']['playback']['prev']['title']; ?>"
               title="<?= $data['video']['playback']['prev']['title']; ?>">
               <span class="fa fa-arrow-left"></span> Previous tutorial
            </a>
         <?php endif; ?>

         <?php if (!empty($data['video']['playback']['next'])): ?>
            <a href="/tutorial/?vt=<?= $data['video']['playback']['next']['clean-title']; ?>&vid=<?= $data['video']['playback']['next']['id']; ?>"
               class="btn btn-success pull-right" alt="<?= $data['video']['playback']['next']['title']; ?>"
               title="<?= $data['video']['playback']['next']['title']; ?>">
               Next tutorial<span class="fa fa-arrow-right"></span>
            </a>
         <?php endif; ?>
         <div class="clearfix"></div>
      </div>

   </div>
</div>

<div id="skills"></div>
