<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <?php require 'include/css.php';?>
   </head>
   <body class="header-fix fix-sidebar">
      <div id="main-wrapper">
       <?php require 'include/header.php';?> 
      <?php require 'include/leftmenu.php';?> 

         <div class="page-wrapper">
            <div class="row page-titles">
               <div class="col-md-5 align-self-center">
                  <h3 class="text-primary">Dashboard</h3>
               </div>
               <div class="col-md-7 align-self-center">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                     <li class="breadcrumb-item active">Dashboard</li>
                  </ol>
               </div>
            </div>
            <div class="container-fluid">
               <div class="row">
                  <div class="col-12">
                  <div class="card">
<div class="card-title">
<h4>Manage Banner</h4>
</div>
<div class="card-body">
<div class="basic-elements">
<form  id="FormSubmit" novalidate="" method="post">
<input type="hidden" name="location" id="location" value="code/ManageBanner?flag=Add"/>
<div class="row">
<div class="col-lg-6">

<div class="form-group">
<label>Title</label>
<input id="example-email" class="form-control" type="text" placeholder="title" name="title" required>
</div>
<div class="form-group">
<label>Description</label>
<input class="form-control" type="text" name="description" required>
</div>


</div>
<div class="col-lg-6">

<div class="form-group">
<label>Image</label>
<input id="" class="form-control" type="file" placeholder="" name="image" required>
</div>

</div>
</div>

<button type="submit" class="btn btn-success btn-outline btn-rounded m-b-10 m-l-5">Add Banner</button>

</form>
</div>
</div>
</div>
                    </div>
               </div>
            </div>
           <?php require 'include/footer.php'; ?>
         </div>
      </div>
     <?php require 'include/js.php';?>
     <script src="ajax/SignUp.js"></script> 
   </body>
</html>