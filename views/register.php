 <h1>Create an account</h1>

 <form action="register" method="post">
   <div class="row">
     <div class="col">
       <div class="mb-3">
         <label>First Name</label>
         <input type="text" class="form-control" name="firtname">
       </div>
     </div>

     <div class="col">
       <div class="mb-3">
         <label>Last Name</label>
         <input type="text" class="form-control" name="lastname">
       </div>
     </div>
   </div>

   <div class="mb-3">
     <label>Email</label>
     <input type="email" class="form-control" name="email">
   </div>

   <div class="mb-3">
     <label>Password</label>
     <input type="password" class="form-control" name="password">
   </div>

   <div class="mb-3">
     <label>Confirm Password</label>
     <input type="password" class="form-control" name="confirmPassword">
   </div>

   <button type="submit" class="btn btn-primary">Submit</button>
 </form>