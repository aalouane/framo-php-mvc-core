 <h1>Login</h1>

 <form action="login" method="post">
 
    <?php app\core\Form::email($model, "email") ?>
    <?php app\core\Form::password($model, "password") ?>
   
   <button type="submit" class="btn btn-primary">Submit</button>
 </form>
