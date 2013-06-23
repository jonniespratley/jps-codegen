<?php 
require_once "ContactsService.php";
require_once "vo/ContactsVO.php";


			$address = "";
			$city = "";
			$email = "";
			$id = "";
			$name = "";
			$phone = "";
			$state = "";
$record_id = '';
if ( isset($_GET[ 'id' ]) )
{
	$record_id = isset($_GET[ 'id' ]);
	$service = new ContactsService();
	$recordVO = new ContactsVO();
	$record = $service->getOneContacts( $record_id ); 
	$recordVO = $record[ 0 ];//First object in array
	
	
			$address = $recordVO->address;
			$city = $recordVO->city;
			$email = $recordVO->email;
			$id = $recordVO->id;
			$name = $recordVO->name;
			$phone = $recordVO->phone;
			$state = $recordVO->state;	
}
?>

<?php include '_header.php'; ?>
 
   <form id="formContacts" name="formContacts" method="post" action="ContactsList.php">

		
			<div>
		 		<label for="address">Address</label>
		 		<input type="text" name="address" value="<?php echo $address; ?>"/>
		 	</div>
			<div>
		 		<label for="city">City</label>
		 		<input type="text" name="city" value="<?php echo $city; ?>"/>
		 	</div>
			<div>
		 		<label for="email">Email</label>
		 		<input type="text" name="email" value="<?php echo $email; ?>"/>
		 	</div>
			<div>
		 		<label for="id">Id</label>
		 		<input type="text" name="id" value="<?php echo $id; ?>"/>
		 	</div>
			<div>
		 		<label for="name">Name</label>
		 		<input type="text" name="name" value="<?php echo $name; ?>"/>
		 	</div>
			<div>
		 		<label for="phone">Phone</label>
		 		<input type="text" name="phone" value="<?php echo $phone; ?>"/>
		 	</div>
			<div>
		 		<label for="state">State</label>
		 		<input type="text" name="state" value="<?php echo $state; ?>"/>
		 	</div>

	    <div>
	    	<input type="hidden" name="id" value="<?php echo $record_id; ?>"/>
		   <input name="save" type="submit" value="Save" />
			<input type="button" onclick="window.location='ContactsList.php'" value="Cancel"/>
	    </div>
	</form>
	
  
<?php include '_footer.php'; ?>