<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<br><br>
	<div class="container">
		<?php echo form_open('user/user_fields_search');?>
		<input type="text" name="uname" placeholder="search By Name">
		<input type="text" name="phone" placeholder="search By Phone">
		<input type="text" name="domain_name" placeholder="search By Domain Name">
		
		Start Date : <input type="date" name="start_date" placeholder="search By Domain Date">
		End Date : <input type="date" name="end_date" placeholder="search By Domain Date">
		<input type="submit">
		<br>
	<?php echo form_close();?>
	<br>
	<button><a href="<?php echo base_url().'user/view_all_users'?>">View All Users</a></button>
	<button><a href="<?php echo base_url().'user/'?>">Add New User</a></button>
	<?php echo form_open_multipart('members/import');?>
	<br>
       <input type="file" name="file" /><br>
       <input type="submit" name="importSubmit" value="IMPORT">
	<?php echo form_close();?>
	<br>
  <h2>User List</h2>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>WatsApp No</th>
			<th>Domain Name</th>
			<th>Domain Date</th>
			<th>Hosting Package</th>
			<th>Hosting Date</th>
			<th>Actions</th>
      </tr>
    </thead>
    <tbody>
    	<?php
			if(isset($user_info_search)){
				//echo "Search Users";
				foreach ($user_info_search as $info) {
			?>
      <tr>
				
				<td><?php echo $info['name'];?></td>
				<td><?php echo $info['email'];?></td>
				<td><?php echo $info['phone'];?></td>
				<td><?php echo $info['watsapp_no'];?></td>
				<td><?php echo $info['domain_name'];?></td>
				<td><?php echo $info['domain_date'];?></td>
				<td><?php echo $info['hosting_package'];?></td>
				<td><?php echo $info['hosting_date'];?></td>
				<td><a href="<?php echo base_url()."user/edit_user/". $info['id']?>">Edit</a> <a href="<?php echo base_url()."user/user_delete/". $info['id']?>">Delete</a></td>
			</tr>
			<?php	
		}
			}
			else{
        	foreach ($user_info as $info) {
    ?> 
			<tr>
				
				<td><?php echo $info['name'];?></td>
				<td><?php echo $info['email'];?></td>
				<td><?php echo $info['phone'];?></td>
				<td><?php echo $info['watsapp_no'];?></td>
				<td><?php echo $info['domain_name'];?></td>
				<td><?php echo $info['domain_date'];?></td>
				<td><?php echo $info['hosting_package'];?></td>
				<td><?php echo $info['hosting_date'];?></td>
				<td><a href="<?php echo base_url()."user/edit_user/". $info['id']?>">Edit</a> <a href="<?php echo base_url()."user/user_delete/". $info['id']?>">Delete</a></td>
			</tr>
<?php } } ?>
    </tbody>
  </table>
</div>
</body>
</html>