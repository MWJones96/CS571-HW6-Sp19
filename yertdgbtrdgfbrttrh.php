<!DOCTYPE html>
<html>
<head>
	<title>Homework 6</title>
	<style type="text/css">
		#main-frame
		{
			border: 3px solid #CACACA;
			background-color: #FAFAFA;
			width: 700px;
			margin: auto;
		}

		#main-frame h1
		{
			text-align: center;
			margin-bottom: 15px;
		}

		#main-frame hr
		{
			width: 98%;
		}

		#main-frame div
		{
			padding-left: 15px;
			display: flex;
			height: 22px;
			align-items: center;
			margin-bottom: 5px;
		}

		#main-frame div input, select
		{
			height: 18px;
			margin-left: 10px;
		}

		#main-frame div ul
		{
			list-style-type: none;
			padding: 0;
		}

		#main-frame div strong
		{
			margin-left: 5px;
			margin-right: 5px;
		}

		#main-frame .nearby-search
		{
			margin-left: 20px;
		}

		#main-frame .buttons
		{
			padding: 0;
			margin: 0;

			margin-bottom: 25px;
			justify-content: center;
		}

		#main-frame .buttons input
		{
			width: 65px;
			height: 25px;
		}
	</style>
</head>
<body>
	<form id="main-frame" method="post" onsubmit="return false;">
		<h1><i>Product Search</i></h1>
		<hr>
		<div>
			<h3>Keyword</h3>
			<input id="keyword" input type="textarea" name="keyword-entry" required></input>
		</div>
		<div>
			<h3>Category</h3>
			<select id="category">
				<option value="all">All Categories</option>
				<option value="550">Art</option>
				<option value="2984">Baby</option>
				<option value="267">Books</option>
				<option value="11450">Clothing, Shoes & Accessories</option>
				<option value="58058">Computers/Tablets & Networking</option>
				<option value="26395">Helath & Beauty</option>
				<option value="11233">Music</option>
				<option value="1249">Video Games & Consoles</option>
			</select>
		</div>
		<div>
			<h3>Condition</h3>
			<input id="new" type="checkbox" name="condition">New</input>
			<input id="used" type="checkbox" name="condition">Used</input>
			<input id="unspecified" type="checkbox" name="condition">Unspecified</input>
		</div>
		<div>
			<h3>Shipping Options</h3>
			<input id="local" type="checkbox" name="shipping">Local Pickup</input>
			<input id="free-shipping" type="checkbox" name="shipping">Free Shipping</input>
		</div>
		<table class="nearby-search">
			<tr>
				<td>
					<input id="enable-search" type="checkbox" name="nearby" onchange="enableNearbySearch()"></input>
					<strong>Enable Nearby Search</strong>
					<input class="cond-fields" type="number" name="miles" placeholder="10" disabled></input>
					<strong>miles from</strong>
				</td>
				<td>
					<input class="cond-fields" type="radio" name="location" onclick = "disableZipReq()" disabled checked>Here</input>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input class="cond-fields" type="radio" name="location" onclick = "enableZipReq()"disabled></input>
					<input id="zip" class="cond-fields" type="number" name="zip" placeholder="zip code" disabled></input>
				</td>
			</tr>
		</table>
		<br>
		<div class="buttons">
			<input type="submit" name="search" value="Search"></input>
			<input type="button" name="clear" value="Clear" onclick="clearForm()"></input>
		</div>
	</form>
	<div id="results-table">
	</div>
	<script type="text/javascript">
		function disableZipReq()
		{
			document.getElementById("zip").required = false;
		}

		function enableZipReq()
		{
			document.getElementById("zip").required = true;
		}

		function enableNearbySearch()
		{
			var checked = document.getElementById("enable-search").checked;

			if (checked)
			{
				var fields = document.getElementsByClassName("cond-fields");
				for (i = 0; i < fields.length; i++)
				{
					fields[i].disabled = false;
				}

			}
			else
			{
				var fields = document.getElementsByClassName("cond-fields");
				for (i = 0; i < fields.length; i++)
				{
					fields[i].disabled = true;
				}
			}
		}

		function clearForm()
		{
			var fields = document.getElementsByClassName("cond-fields");
			for (i = 0; i < fields.length; i++)
			{
				fields[i].disabled = true;
			}
			document.getElementById("main-frame").reset();
		}
	</script>
	<?php
		if (isset($_POST['main-frame']))
		{
			echo "Submit";
		}
	?>
</body>
</html>