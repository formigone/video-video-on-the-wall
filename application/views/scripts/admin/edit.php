<div class="text-left">
   <h3><?= $data['series']['title']; ?>
      <a href="/admin/addSeries" class="btn btn-primary pull-right">
         <span class="fa fa-plus"></span>
      </a>
   </h3>

   <?php foreach ($data['series']['videos'] as $_video): ?>
      <div class="row mt">
         <div class="col-md-3">
            <img src="<?= $_video['img']; ?>" class="img-responsive" style="width: 100%"/>
            <a href="/admin/editVideo/<?= $_video['id']; ?>/<?= $data['series']['id']; ?>"
               class="btn btn-primary">
               <span class="fa fa-edit"></span>
            </a>
         </div>
         <div class="col-md-9">
            <h3 class="bald"><?= $_video['title']; ?></h3>
            <p class="lead"><?= $_video['meta_title'] ?: '<em class="text-muted">no meta title</em>'; ?></p>

            <div class="raw_extra"><?= $this->typography->auto_typography($_video['raw_extra_description']); ?></div>
            <hr/>
            <div class="raw_desc"><?= $this->typography->auto_typography($_video['raw_description']); ?></div>
         </div>
      </div>
   <?php endforeach; ?>

</div>
