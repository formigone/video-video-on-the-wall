<div class="text-left">
   <div>
      <h3><?= $data['video']['title']; ?></h3>

      <form method="post" action="/admin/updateVideo">
         <input type="hidden" name="vid" value="<?= $data['video']['id']; ?>"/>
         <input type="hidden" name="sid" value="<?= $data['sid']; ?>"/>

         <p>
            <input type="text" class="form-control" name="meta_title" value="<?= $data['video']['meta_title'] ?: $data['video']['title'].' | '.$data['video']['series']['title']; ?>"/>
         </p>
         <textarea name="extra_description" class="input-word"><?= $data['video']['extra_description']; ?></textarea>

         <div>
            <p></p>
            <a href="/admin/editSeries/?id=<?= $data['sid']; ?>" class="btn btn-danger"><span class="fa fa-reply"></span></a>
            <button class="btn btn-primary"><span class="fa fa-save"></span></button>
            <p></p>
         </div>
      </form>
   </div>
</div>
