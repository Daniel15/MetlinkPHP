<?php 
require 'includes/core.php';
Page::header('Metlink Journey Planner API test');
?>
	<form action="search.php" method="post">
		<p>
			<label for="from">From:</label>
			<input type="text" name="from" id="from" tabindex="1" />
			(
				<input type="radio" name="from_type" value="address" id="from_type_address" checked="checked" />
				<label for="from_type_address">Address</label>
				<input type="radio" name="from_type" value="station" id="from_type_station" />
				<label for="from_type_station">Station / Stop</label>
				<input type="radio" name="from_type" value="landmark" id="from_type_landmark" />
				<label for="from_type_landmark">Landmark</label>
			)<br />
			
			<label for="to">To:</label>
			<input type="text" name="to" id="to" tabindex="2" />
			(
				<input type="radio" name="to_type" value="address" id="to_type_address" checked="checked" />
				<label for="to_type_address">Address</label>
				<input type="radio" name="to_type" value="station" id="to_type_station" />
				<label for="to_type_station">Station / Stop</label>
				<input type="radio" name="to_type" value="landmark" id="to_type_landmark" />
				<label for="to_type_landmark">Landmark</label>
			)
		</p>
		
		<p>
			<input type="radio" name="time_type" value="dep" id="departing" checked="checked" />
			<label for="departing">Departing</label>
			
			<input type="radio" name="time_type" value="arr" id="arriving" />
			<label for="arriving">Arriving</label>
			
			<input type="text" name="time" id="time" value="now" />
		</p>
		
		<p>
			<input type="submit" value="Search" />
		</p>
	</form>
<?php Page::footer() ?>