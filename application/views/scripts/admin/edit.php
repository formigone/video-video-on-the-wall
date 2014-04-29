<div class="text-left">
<pre><?php var_dump($data['videos']); ?></pre>
<pre><?php var_dump($data['videos']['items']); ?></pre>
<pre><?php var_dump($data['videos']['items'][0]); ?></pre>
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
         <?php foreach ($data['videos'] as $_video): ?>
            <tr>
               <td>
                  <a href="/admin/editSeries/?id=<?= $_video['id']; ?>&alias=<?= $_video['alias']; ?>"><?= $_video['title']; ?></a><br/>
                  <?= $_video['alias']; ?>
               </td>
               <td><?= $_video['description']; ?></td>
               <td>
                  <img src="<?= $_video['img']; ?>" class="img-responsive"/>
               </td>
            </tr>
         <?php endforeach; ?>
         </tbody>
      </table>
   </div>
</div>
