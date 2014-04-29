<div class="text-left">

   <div>
      <h3>Series
         <a href="/admin/addSeries" class="btn btn-primary pull-right">
            <span class="fa fa-plus"></span>
         </a>
      </h3>
      <table class="table-bordered" width="100%">
         <thead>
         <tr>
            <td>Title</td>
            <td>Description</td>
            <td>Thumbnail</td>
         </tr>
         </thead>
         <tbody>
         <?php foreach ($data['series'] as $_series): ?>
            <tr>
               <td>
                  <a href="/admin/editSeries/?id=<?= $_series['id']; ?>&alias=<?= $_series['alias']; ?>"><?= $_series['title']; ?></a><br/>
                  <?= $_series['alias']; ?>
               </td>
               <td><?= $_series['description']; ?></td>
               <td>
                  <img src="<?= $_series['img']; ?>" class="img-responsive"/>
               </td>
            </tr>
         <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</div>