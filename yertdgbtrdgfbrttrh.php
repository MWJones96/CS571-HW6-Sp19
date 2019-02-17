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
			margin: 7px;
		}

		#main-frame ul
		{
			margin: 0;
			padding: 0;
		}

		#main-frame ul li
		{
			display: inline-block;
			margin-left: 10px;
			padding: 0;
		}

		#main-frame ul li h3
		{
			padding: 0;
		}
	</style>
</head>
<body>
	<?php
	?>
	<div id="main-frame">
	<h1><i>Product Search</i></h1>
	<hr>
		<ul>
			<li><h3>Keyword</h3></li>
			<li><input type="textarea" name="keyword-entry" required></input></li>
		</ul>
		<ul>
			<li><h3>Category</h3></li>
			<li>
				<select>
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
			</li>
		</ul>
		<ul>
			<li><h3>Condition</h3></li>
			<li><input type="checkbox" name="condition">New</input></li>
			<li><input type="checkbox" name="condition">Used</input></li>
			<li><input type="checkbox" name="condition">Unspecified</input></li>
		</ul>
		<ul>
			<li><h3>Shipping Options</h3></li>
			<li><input type="checkbox" name="shipping">Local Pickup</input></li>
			<li><input type="checkbox" name="shipping">Free Shipping</input></li>
		</ul>
	<input id="enable-search" type="checkbox" name="nearby"><strong>Enable Nearby Search</strong></input>
	<input class="cond-fields" type="number" name="miles" placeholder="10" disabled></input><strong>miles from</strong>
	<input class="cond-fields" type="radio" name="location" disabled checked>Here</input>
	<input class="cond-fields" type="radio" name="location" disabled>
		<input class="cond-fields" type="number" name="zip" placeholder="zip code" disabled></input>
	</input>
	<input type="button" name="search" value="Search"></input>
	<input type="button" name="clear" value="Clear" onclick="clearForm()"></input>
	</div>
	<script type="text/javascript">
		function clearForm()
		{
			
		}

		document.getElementById("enable-search").addEventListener("change", function() {
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
		});
	</script>
</body>
</html>