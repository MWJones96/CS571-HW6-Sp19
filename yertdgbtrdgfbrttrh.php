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

		#main-frame hr
		{
			width: 98%;
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
			height: 20px;
		}

		#main-frame ul ul li
		{
			display: block;
			padding: 0;
		}

		#main-frame ul ul ul li
		{
			display: inline-block;
			padding: 0;
		}

		.vertical-list
		{
			margin: 0;
			padding: 0;
			float: left;
		}

		.vertical-list li
		{
			margin: 0;
		}

		.buttons
		{
			text-align: center;
			margin-bottom: 25px;
		}

		.buttons input
		{
			margin: 2px;
		}

		.nearby-search li
		{
			vertical-align: top;
			margin: 0px;
		}
	</style>
</head>
<body>
	<?php
	?>
	<form id="main-frame" onsubmit="submitForm()">
	<h1><i>Product Search</i></h1>
	<hr>
		<ul>
			<li><h3>Keyword</h3></li>
			<li><input id="keyword" input type="textarea" name="keyword-entry" required></input></li>
		</ul>
		<ul>
			<li><h3>Category</h3></li>
			<li>
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
			</li>
		</ul>
		<ul>
			<li><h3>Condition</h3></li>
			<li><input id="new" type="checkbox" name="condition">New</input></li>
			<li><input id="used" type="checkbox" name="condition">Used</input></li>
			<li><input id="unspecified" type="checkbox" name="condition">Unspecified</input></li>
		</ul>
		<ul>
			<li><h3>Shipping Options</h3></li>
			<li><input id="local" type="checkbox" name="shipping">Local Pickup</input></li>
			<li><input id="free-shipping" type="checkbox" name="shipping">Free Shipping</input></li>
		</ul>
		<br>
		<ul class="nearby-search">
			<li><input id="enable-search" type="checkbox" name="nearby" onchange="enableNearbySearch()"><strong>Enable Nearby Search</strong></input></li>
			<li><input class="cond-fields" type="number" name="miles" placeholder="10" disabled></input><li><strong>miles from</strong></li>
			<li><ul class="vertical-list">
				<input class="cond-fields" type="radio" name="location" onclick = "disableZipReq()" disabled checked>Here</input></li>
				<input class="cond-fields" type="radio" name="location" onclick = "enableZipReq()"disabled></input>
				<input id="zip" class="cond-fields" type="number" name="zip" placeholder="zip code" disabled></input>
			</ul></li>
		</ul>
	<br><br>
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

		function submitForm()
		{
			var keyword = document.getElementById("keyword").value;

			var category = document.getElementById("category").value;

			var newQ = document.getElementById("new").checked;

			var used = document.getElementById("used").checked;

			var unspecified = document.getElementById("unspecified").checked;

			var local = document.getElementById("local").checked;

			var freeShipping = document.getElementById("free-shipping").checked;

			alert(keyword + " " + category + " " + newQ + " " + used + " " + unspecified + " " + local + " " + freeShipping);
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
</body>
</html>