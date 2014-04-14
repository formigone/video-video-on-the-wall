<div class="container">
   <div class="row centered mt grid">
      <?php if (!empty($user)): ?>
         <h3>ADMIN
            <small>
               <a href="/admin/logout" class="btn btn-link">
                  <span class="fa fa-dribbble"></span>
               </a>
            </small>
         </h3>
      <?php endif; ?>

      <?= $subviews['admin']; ?>
   </div>
</div>
