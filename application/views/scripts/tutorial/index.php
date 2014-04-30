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
         <div class="e-player">
            <iframe src="//www.youtube.com/embed/<?= $data['video']['resource_id']; ?>?rel=0"
                    frameborder="0" allowfullscreen></iframe>
         </div>

         <!-- AddThis Button BEGIN -->
         <div class="addthis_toolbox addthis_default_style addthis_32x32_style pull-right">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
         </div>
         <script type="text/javascript">var addthis_config = {"data_track_addressbar": true};</script>
         <script type="text/javascript"
                 src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53613b252d4cb93d"></script>
         <!-- AddThis Button END -->

         <div class="text-left">
            <small>By <a href="#?GP-AUTHOR-LINK">Rodrigo Silveira</a>, <?= date('M d, Y @ H:m a', strtotime($data['video']['created'])); ?></small>
         </div>
         <div class="clearfix"><br/>&nbsp;</div>

         <p class="text-left lead"><?= str_replace("\n", '<br/>', $data['video']['extra_description']); ?></p>

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
