<div id="hello">
   <h2>Add Series</h2>

   <form class="form-inline" role="form" id="loginForm" method="post" action="/admin/addSeries">
      <div class="form-group">
         <input type="text" class="form-control" name="title" placeholder="Series title">
      </div>
      <div class="form-group">
         <input type="text" class="form-control" name="alias">
      </div>

      <div class="form-group">
         <input type="password" class="form-control" name="password">
      </div>
      <span class="fa fa-umbrella" onclick="document.getElementById('loginForm').submit();"></span>
   </form>
</div>
