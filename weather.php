<?php 
	$weather = "";
	$error = "";
	

	if(array_key_exists('city', $_GET)) {
		$city = str_replace(' ', '', $_GET['city']);
		$file_headers = @get_headers("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
		if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
		    $error = "The city could not be found";
		} 
		else {
		$forecastPage = file_get_contents("https://www.weather-forecast.com/locations/".$city."/forecasts/latest");
		$pageArray = explode('Weather Today </h2>(1&ndash;3 days)</span><p class="b-forecast__table-description-content"><span class="phrase">', $forecastPage);
		if(sizeof($pageArray) > 1) {
			$secondPageArray = explode('</span></p></td><td class="b-forecast__table-description',$pageArray[1]);
			if(sizeof($secondPageArray) > 1) {
				$weather = $secondPageArray[0];
			}
			else {
				$error = "This city could not be found";
			}
		}
		else {
			$error = "This city could not be found";
		}
	}

	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Weather Forecast</title>
	<style type="text/css">
		
		body {
		    background: url(https://images.unsplash.com/photo-1429704658776-3d38c9990511?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=03d21f44b38c2690ca9e1dae7f76647a&auto=format&fit=crop&w=930&q=80) no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover; 
			
		}
		.container {
			text-align: center;
			margin-top: 200px;
			width: 450px!important;
			
		}

		input {
			margin: 20px 0px;
		}
		
	</style>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<h1>What's The Weather?</h1>
		<form>
		  <div class="form-group">
		    <label for="city">Enter City</label>
		    <input type="text" class="form-control" id="city" name="city" placeholder="eg. London, Raleigh, New Delhi" value="<?php  if(array_key_exists('city', $_GET)){echo $_GET['city'];}?>" >
		   
		  </div>
		  <fieldset class="form-group">
		  	<button type="submit" class="btn btn-primary" id="submit">Submit</button>
		  </fieldset>
		</form>
		<div id="weather"> 
			<?php 
			if($weather) {
			    echo '<div class="alert alert-success" role="alert">'.$weather.'</div>';
			}
			else if($error != "") {
				echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';

			}
			?>

		</div>

	</div>


	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

</body>
</html>