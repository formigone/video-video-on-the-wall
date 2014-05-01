<div class="text-left">
   <h3>Series
      <a href="/admin/addSeries" class="btn btn-primary pull-right">
         <span class="fa fa-plus"></span>
      </a>
   </h3>

   <?php foreach ($data['series'] as $_series): ?>
      <div class="row mt">
         <div class="col-md-3">
            <img src="<?= $_series['img']; ?>" class="img-responsive" style="width: 100%"/>
            <a href="/admin/editSeries/<?= $_series['id']; ?>" class="btn btn-primary">
               <span class="fa fa-edit"></span>
            </a>
         </div>
         <div class="col-md-9">
            <h3 class="bald"><?= $_series['title']; ?></h3>

            <div class="text-lead"><?= $this->typography->auto_typography($_series['description']); ?></div>
         </div>
      </div>
   <?php endforeach; ?>

</div>
