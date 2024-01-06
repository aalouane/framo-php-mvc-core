 <h1>Create an account</h1>

 <form action="register" method="post">
 
   <?php app\core\Form::text(attr: "firstname", label:"First Name", model: $model) ?>
   <?php app\core\Form::text($model, "lastname", label:"Last Name",) ?>
   <?php app\core\Form::email($model, "email") ?>
   <?php app\core\Form::password($model, "password") ?>
   <?php app\core\Form::password($model, "confirmPassword", label: "Confirm Password") ?>

   <button type="submit" class="btn btn-primary">Submit</button>
 </form>
