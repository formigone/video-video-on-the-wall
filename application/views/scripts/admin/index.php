<div class="container">
   <div class="row centered mt grid">
      <h3>ADMIN
         <?php if ($isLoggedIn): ?>
            <p>
               <small>
                  <a href="/admin/logout" class="btn btn-link">logout</a>
               </small>
            </p>
         <?php else: ?>
            <form class="form-inline" role="form" id="loginForm" method="post" action="/admin/login">
               <div class="form-group">
                  <input type="email" class="form-control" name="user">
               </div>
               <div class="form-group">
                  <input type="password" class="form-control" name="password">
               </div>
               <span class="fa fa-umbrella" onclick="document.getElementById('loginForm').submit();"></span>
            </form>
         <?php endif; ?>
      </h3>

      <div class="text-left">
<pre>
// TODO:
<?php var_dump($inj->getService('auth')); ?>
[X] Write Auth service
[ ] CRUD playlist entries
[ ] CRUD video entries
[ ] YouTube importer service
</pre>
      </div>

   </div>
</div>
