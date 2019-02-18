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

		#results-table,
		{
			padding: 0;
			margin: auto;
			width: 1000px;
		}

	</style>
</head>
<body>
	<?php
		function getJSON()
		{
			$kwd = "";
			$category = "";
			$condition_new = "";
			$condition_used = "";
			$condition_unspec = "";

			$local_pickup= "";
			$free_shipping = "";

			if (!empty($_POST))
			{
				$kwd = $_POST["keyword"];
				$category = $_POST["category"];

				$condition_new = isset($_POST["new"]) ? 1 : 0;
				$condition_used = isset($_POST["used"]) ? 1 : 0;
				$condition_unspec = isset($_POST["unspec"]) ? 1 : 0;

				$local_pickup = isset($_POST["local"]) ? 1 : 0;
				$free_shipping = isset($_POST["free"]) ? 1 : 0;

				//The URL of the API call
				$_API_URL = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=MatthewJ-CS571-PRD-2f2cd4cf7-09303b6c&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&paginationInput.entriesPerPage=20&keywords=usc&itemFilter.name=FreeShippingOnly&itemFilter.value=true&itemFilter.name=LocalPickupOnly&itemFilter.value=true&itemFilter.name=Condition&itemFilter.value=New&itemFilter.value=Used&itemFilter.value=Unspecified&buyerPostalCode=90007&itemFilter.name=MaxDistance&itemFilter.value=10&itemFilter.name=HideDuplicateItems&itemFilter.value=true";

				//Call API
				$json = file_get_contents($_API_URL);
				return $json;
			}

			return NULL;
		}
	?>
	<form id="main-frame" method="post" onsubmit="return false;">
		<h1><i>Product Search</i></h1>
		<hr>
		<div>
			<h3>Keyword</h3>
			<input name="keyword" id="keyword" input type="textarea" name="keyword-entry" required></input>
		</div>
		<div>
			<h3>Category</h3>
			<select name="category" id="category">
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
			<input id="new" type="checkbox" name="new">New</input>
			<input id="used" type="checkbox" name="used">Used</input>
			<input id="unspecified" type="checkbox" name="unspec">Unspecified</input>
		</div>
		<div>
			<h3>Shipping Options</h3>
			<input id="local" type="checkbox" name="local">Local Pickup</input>
			<input id="free-shipping" type="checkbox" name="free">Free Shipping</input>
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
			<input type="submit" name="submit" value="Search" onclick="submitForm()"></input>
			<input type="button" name="clear" value="Clear" onclick="clearForm()"></input>
		</div>
	</form>
	<br>
	<table id="results-table">
	</table>

	<script type="text/javascript">
		function submitForm()
		{
			var json = <?php echo getJSON(); ?>;

			var html_text = "";
			html_text += "<th>";
			html_text += "<td><strong>Index</strong></td>";
			html_text += "<td><strong>Photo</strong></td>";
			html_text += "<td><strong>Name</strong></td>";
			html_text += "<td><strong>Price</strong></td>";
			html_text += "<td><strong>Zip code</strong></td>";
			html_text += "<td><strong>Condition</strong></td>";
			html_text += "<td><strong>Shipping option</strong></td>";
			html_text += "</th>";

			var items = json.findItemsAdvancedResponse[0].searchResult[0].item;

			for (i = 0; i < items.length; i++)
			{
				html_text += "<tr>";
				//html_text += "<td>" + (i+1) + "</td>";
				//html_text += "<td><a href=\"" + items[i].galleryURL[0] + "\"/></td>";
				//html_text += "<td>" + items[i].title[0] +"</td>";
				//html_text += "<td>$" + items[i].sellingStatus[0].currentPrice[0].__value__ +"</td>";
				//html_text += "<td>" + items[i].postalCode[0] +"</td>";
				html_text += "</tr>";
			}

			document.getElementById("results-table").innerHTML = html_text;
		}

		function disableZipReq()
		{
			document.getElementById("zip").required = 0;
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
					fields[i].disabled = 0;
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
			document.getElementById("results-table").innerHTML = "";
		}
	</script>
</body>
</html>