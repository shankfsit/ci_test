<!DOCTYPE html>
<html lang="en">
<head>
  <title>User</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>User form</h2>
  <div align="right">
  <button align="right"><a href="<?php echo base_url().'user/view_all_users'?>">View All Users</a></button>	
  </div>
  
  <?php echo form_open_multipart('user/user_fields');?>
    <div class="form-group">
      <label>Name:</label>
      <input type="text" class="form-control" placeholder="Enter Name" name="name" required>
    </div>
    <div class="form-group">
      <label>Eamil:</label>
      <input type="email" class="form-control" placeholder="Enter email" name="email" required>
    </div>
    <div class="form-group">
      <label>Phone:</label>
      <input type="text" class="form-control" placeholder="Enter Phone" name="phone" required>
    </div>
    <div class="form-group">
      <label>WatsApp No:</label>
      <input type="text" class="form-control" placeholder="Enter WatsApp No" name="watsapp_no" required>
    </div>
    <div class="form-group">
      <label>Domain Name:</label>
      <input type="text" class="form-control" placeholder="Enter Domain Name" name="domain_name" required>
    </div>
    <div class="form-group">
      <label>Domain Date:</label>
      <input type="date" class="form-control" placeholder="Enter Domain Date" name="domain_date" required>
    </div>
    <div class="form-group">
      <label>Hosting Package:</label>
      <div class="form-group">
		  <select class="form-control" required name="hosting_package">
		  	<option>--Select Hosting Package--</option>
		    <option value="basic">Basic</option>
		    <option value="bronze">Bronze</option>
		    <option value="gold">Gold</option>
		  </select>
		</div>
      
    </div>
    <div class="form-group">
      <label>Hosting Date:</label>
      <input type="date" class="form-control" placeholder="Enter date" name="hosting_date" required>
    </div>
    <!-- <div class="form-group">
      <label>Upload:</label>
      <input type="file" class="form-control" placeholder="Enter WatsApp No" name="userfile" required>
    </div> -->
    
    <button type="submit" class="btn btn-default">Submit</button>
  <?php echo form_close();?>
</div>

</body>
</html>
