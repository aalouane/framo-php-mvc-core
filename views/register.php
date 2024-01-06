 <h1>Create an account</h1>
 
<form action="" method="post">

  <?php app\core\Form::field($model, "firstname") ?>
  <?php app\core\Form::field($model, "lastname") ?>
  <?php app\core\Form::field($model, "email") ?>
  <?php app\core\Form::field($model, "password") ?>
  <?php app\core\Form::field($model, "confirmPassword") ?>
  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
