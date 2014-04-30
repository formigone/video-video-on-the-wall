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
            <a href="/admin/editVideo/?vid=<?= $_video['id']; ?>&sid=<?= $data['series']['id']; ?>"
               class="btn btn-primary">
               <span class="fa fa-edit"></span>
            </a>
         </div>
         <div class="col-md-9">
            <h3 class="bald"><?= $_video['title']; ?></h3>

            <div class="text-lead"><?= $this->typography->auto_typography($_video['extra_description']); ?></div>
            <div class="subtle"><small><?= $this->typography->auto_typography($_video['description']); ?></small></div>
         </div>
      </div>
   <?php endforeach; ?>

</div>
