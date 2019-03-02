<!DOCTYPE html>
<html>
<head>
	<title>Homework 6</title>
	<style type="text/css">
		#product-search { border: 3px solid #CACACA; background-color: #FAFAFA; width: 700px; margin: 0 auto; }
		#product-search h1 {text-align: center; margin-bottom: 15px; }
		#product-search hr { width: 98%; }
		#product-search div { padding-left: 15px; display: flex; height: 22px; align-items: center; margin-bottom: 5px; }
		#product-search div input, select { height: 18px; margin-left: 10px; }
		#product-search div ul { list-style-type: none; padding: 0; }
		#product-search div strong { margin-left: 5px; margin-right: 5px; }
		#product-search .nearby-search { margin-left: 20px; }
		#product-search .buttons { padding: 0; margin: 0; margin-bottom: 25px; justify-content: center; }
		#product-search .buttons input {width: 65px; height: 25px; }
		#results-table {padding: 0; margin: 0 auto; width: 1000px; }
		#results-table table, #results-table table td, #results-table table th {border: 1px solid grey; border-collapse: collapse; }
		#results-table table tr td img { width: 65px; }
		#results-table table tr td a { text-decoration: none; color: black; }
		#results-table table tr td a:hover { color: grey; }
		#item-table div { text-align: center; }
		#item-table div img { width: 50px; }
		#item-table h1 { text-align: center; }
		#item-table table { margin: auto; }
		#item-table table, #item-table table td { border: 1px solid grey; border-collapse: collapse; }
		#item-table table tr td img { height: 250px; }
		.error-bar { text-align: center; margin: auto; width: 1000px; background-color: #F0F0F0; border: 2px solid #E7E7E7; visibility: hidden; }
		#seller-message-html { width: 1000px;}
		.arrow-text { color: grey;  }
		#seller-message-html { display: block; margin: auto; height: 100%; border: none; }
		#similar-items-table table, #similar-items-table table tr, #similar-items-table table tr td { text-align: center; border: none; outline: none; border-collapse: collapse; }
		#similar-items-table table tr td { width: 10vw; }
		#similar-items-table table tr td img { height: auto; width: 10vw; }
		#similar-items-table table tr td a { text-decoration: none; color: black; }
		#similar-items-table table tr td a:hover { color: grey; }
	</style>
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

		function OnItemClick(itemIndex)
		{
			document.getElementById("itemID").value = json.findItemsAdvancedResponse[0].searchResult[0].item[itemIndex].itemId;
			document.getElementById("userZip").value = geoLocationJSON.zip;
			document.getElementById("product-search").submit();
		}

		function OnSimilarItemClick(itemID)
		{
			document.getElementById("itemID").value = itemID;
			document.getElementById("userZip").value = geoLocationJSON.zip;
			document.getElementById("product-search").submit();
		}

		function toggleDropdown(index)
		{
			if (index == 0)
			{
				if (document.getElementById("seller-message").alt == "up")
				{
					document.getElementById("seller-message").alt = "down";
					document.getElementById("seller-message").src = "http://csci571.com/hw/hw6/images/arrow_down.png";
					document.getElementById("seller-text").innerHTML = "click to show seller message";
				}
				else
				{
					document.getElementById("seller-message").alt = "up";
					document.getElementById("seller-message").src = "http://csci571.com/hw/hw6/images/arrow_up.png";
					document.getElementById("seller-text").innerHTML = "click to hide seller message";

					document.getElementById("similar-items").alt = "down";
					document.getElementById("similar-items").src = "http://csci571.com/hw/hw6/images/arrow_down.png";
					document.getElementById("similar-text").innerHTML = "click to show similar items";
                    
                    document.getElementById("similar-items-table").style.display = "none";
				}
			}
			else
			{
				if (document.getElementById("similar-items").alt == "up")
				{
					document.getElementById("similar-items").alt = "down";
					document.getElementById("similar-items").src = "http://csci571.com/hw/hw6/images/arrow_down.png";
					document.getElementById("similar-text").innerHTML = "click to show similar items";
                    
                    document.getElementById("similar-items-table").style.display = "none";
				}
				else
				{
					document.getElementById("similar-items").alt = "up";
					document.getElementById("similar-items").src = "http://csci571.com/hw/hw6/images/arrow_up.png";
					document.getElementById("similar-text").innerHTML = "click to hide similar items";

					document.getElementById("seller-message").alt = "down";
					document.getElementById("seller-message").src = "http://csci571.com/hw/hw6/images/arrow_down.png";
					document.getElementById("seller-text").innerHTML = "click to show seller message";
                    
                    document.getElementById("similar-items-table").style.display = "block";
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

			document.getElementById("results-table").innerHTML = "";
			document.getElementById("error-bar").innerHTML = "";
			document.getElementById("error-bar").style.visibility = "hidden";

			window.history.pushState({}, document.title, "/HW6/yertdgbtrdgfbrttrh.php");
			window.location.reload();
		}
	</script>
</head>
<body>
	<?php
		function getJSON()
		{
			if (empty($_GET)){return '""';}

			if ($_GET["itemID"] != "0") { return getItemJSON(); }

			$kwd = rawurlencode($_GET["keyword"]);
			$category = ($_GET["category"] == "all") ? "" : "&categoryId={$_GET["category"]}";

			$freeShipping = "false";
			$localPickup = "false";

			if (!isset($_GET["local"]) && !isset($_GET["free"])) { $freeShipping = "true"; $localPickup = "true" ;}
			else { if (isset($_GET["local"])) { $localPickup = "true"; } if (isset($_GET["free"])) { $freeShipping = "true"; }}

			$index = 0;
			$nearby_search = "";

			//Nearby search enabled
			if (isset($_GET["nearby"]))
			{
				$distance = "0";
				$zip = $_GET["userZip"];

				//10 miles by default
				if (empty($_GET["miles"])) { $distance = "10"; }
				else { $distance = $_GET["miles"]; }

				//If user specifies ZIP code, override default
				if ($_GET["location"] == "zip") { $zip = $_GET["zip"]; }

				$nearby_search .= "&buyerPostalCode={$zip}&itemFilter({$index}).name=MaxDistance&itemFilter({$index}).value={$distance}";
				$index++;
			}

			$shipping_options = "&itemFilter({$index}).name=FreeShippingOnly&itemFilter({$index}).value={$freeShipping}";
			$index++;
			$pickup_options = "&itemFilter({$index}).name=LocalPickupOnly&itemFilter({$index}).value={$localPickup}";
			$index++;
			$duplicate = "&itemFilter({$index}).name=HideDuplicateItems&itemFilter({$index}).value=true";
			$index++;

			$condition = "&itemFilter({$index}).name=Condition";

			if (!isset($_GET["new"]) && !isset($_GET["used"]) && !isset($_GET["unspec"]))
			{
				$condition .= "&itemFilter({$index}).value(0)=New&itemFilter({$index}).value(1)=Used&itemFilter({$index}).value(2)=Unspecified";
				$index++;
			}
			else
			{
				$subIndex = 0;
				if (isset($_GET["new"])) { $condition .= "&itemFilter({$index}).value({$subIndex})=New"; $subIndex++; }
				if (isset($_GET["used"])) { $condition .= "&itemFilter({$index}).value({$subIndex})=Used"; $subIndex++; }
				if (isset($_GET["unspec"])) { $condition .= "&itemFilter({$index}).value({$subIndex})=Unspecified"; $subIndex++;}
				$index++;
			}

			//Builds URL for the API call with the data the user provides
			$_API_URL = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=MatthewJ-CS571-PRD-2f2cd4cf7-09303b6c&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&paginationInput.entriesPerPage=20&keywords={$kwd}{$category}{$nearby_search}{$shipping_options}{$pickup_options}{$duplicate}{$condition}";

			//Call API
			$json = file_get_contents($_API_URL);

			return $json;
		}

		function getItemJSON()
		{
			if (!isset($_GET["itemID"])) { return '""'; }
			$itemID = $_GET["itemID"];

			$_API_URL = "http://open.api.ebay.com/shopping?callname=GetSingleItem&responseencoding=JSON&appid=MatthewJ-CS571-PRD-2f2cd4cf7-09303b6c&siteid=0&version=967&ItemID={$itemID}&IncludeSelector=Description,Details,ItemSpecifics";

			$json = file_get_contents($_API_URL);
			return $json;
		}

		function getSimilarItems()
		{
			if (!isset($_GET["itemID"])) { return '""'; }
			$itemID = $_GET["itemID"];

			$_API_URL = "http://svcs.ebay.com/MerchandisingService?OPERATION-NAME=getSimilarItems&SERVICE-NAME=MerchandisingService&SERVICE-VERSION=1.1.0&CONSUMER-ID=MatthewJ-CS571-PRD-2f2cd4cf7-09303b6c&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&itemId={$itemID}&maxResults=8";

			$json = file_get_contents($_API_URL);
			return $json;
		}
	?>
	<form id="product-search" method="get" onsubmit="return true">
		<h1><i>Product Search</i></h1>
		<hr>
		<div>
			<h3>Keyword</h3>
			<input name="keyword" id="keyword" input type="textarea" name="keyword-entry" value="<?php if (isset($_GET["keyword"])) echo $_GET["keyword"] ?>" required></input>
		</div>
		<div>
			<h3>Category</h3>
			<select name="category" id="category">
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "all") { echo "selected"; } ?> value="all">All Categories</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "550") { echo "selected"; } ?> value="550">Art</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "2984") { echo "selected"; } ?> value="2984">Baby</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "267") { echo "selected"; } ?> value="267">Books</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "11450") { echo "selected"; } ?> value="11450">Clothing, Shoes & Accessories</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "58058") { echo "selected"; } ?> value="58058">Computers/Tablets & Networking</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "26395") { echo "selected"; } ?> value="26395">Health & Beauty</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "11233") { echo "selected"; } ?> value="11233">Music</option>
				<option <?php if (isset($_GET["category"]) && $_GET["category"] == "1249") { echo "selected"; } ?> value="1249">Video Games & Consoles</option>
			</select>
		</div>
		<div>
			<h3>Condition</h3>
			<input name="new" id="new" type="checkbox"<?php if (isset($_GET["new"])) echo "checked" ?>>New</input>
			<input name="used" id="used" type="checkbox" <?php if (isset($_GET["used"])) echo "checked" ?>>Used</input>
			<input name="unspec" id="unspecified" type="checkbox" <?php if (isset($_GET["unspec"])) echo "checked" ?>>Unspecified</input>
		</div>
		<div>
			<h3>Shipping Options</h3>
			<input name="local" id="local" type="checkbox" <?php if (isset($_GET["local"])) echo "checked" ?>>Local Pickup</input>
			<input name="free" id="free-shipping" type="checkbox" <?php if (isset($_GET["free"])) echo "checked" ?>>Free Shipping</input>
		</div>
		<table class="nearby-search">
			<tr>
				<td>
					<input id="enable-search" type="checkbox" name="nearby" <?php if (isset($_GET["nearby"])) { echo "checked"; } ?> onchange="enableNearbySearch()"></input>
					<strong>Enable Nearby Search</strong>
					<input class="cond-fields" type="number" name="miles" placeholder="10" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> value="<?php if (!empty($_GET["miles"])) { echo $_GET["miles"]; } ?>"></input>
					<strong>miles from</strong>
				</td>
				<td>
					<input class="cond-fields" type="radio" value="here" name="location" onclick = "disableZipReq()" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> <?php if (!isset($_GET["location"])) { echo "checked"; } else { if ($_GET["location"] == "here") { echo "checked"; } }?>>Here</input>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input class="cond-fields" type="radio" name="location" onclick = "enableZipReq()" value="zip" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> <?php if (isset($_GET["location"]) && $_GET["location"] == "zip") { echo "checked"; } ?>></input>
					<input id="zip" class="cond-fields" type="textarea" name="zip" placeholder="zip code" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> value="<?php if (!empty($_GET["zip"])) { echo $_GET["zip"]; } ?>"></input>
				</td>
			</tr>
		</table>
		<br>
		<div class="buttons">
			<input id="submit-form" type="submit" name="btnSubmit" value="Search" onclick="submitForm()" disabled></input>
			<input type="reset" name="clear" value="Clear" onclick="clearForm()"></input>
		</div>
		<input id="itemID" type="hidden" name="itemID" value=0>
		<input id="userZip" type="hidden" name="userZip">
	</form>
	<br>
	<div id="results-table">
	</div>
	<div id="item-table">
	</div>
	<div id="error-bar" class="error-bar">
	</div>
	<script type="text/javascript">
		var json = null;
		var geoLocationJSON = null;

		function submitForm()
		{
			document.getElementById("userZip").value = geoLocationJSON.zip;
		}

		function buildPage()
		{
			json = <?php echo getJSON(); ?>;
			if (json == "") { return; }

			var text = "";
			if ("findItemsAdvancedResponse" in json)
			{
				text = buildResultsPage(json);

				if (text == "Zipcode is invalid" || text == "No records have been found") 
				{
					document.getElementById("error-bar").innerHTML = text;
					document.getElementById("error-bar").style.visibility = "visible";

					return;
				}

				document.getElementById("results-table").innerHTML = text;
			}
			else
			{
				text = buildItemPage(json);
				if (text == "Item has expired")
				{
					document.getElementById("error-bar").innerHTML = text;
					document.getElementById("error-bar").style.visibility = "visible";

					return;
				}

				document.getElementById("item-table").innerHTML = text;
			}
		}

		function buildResultsPage(json)
		{
			if (json.findItemsAdvancedResponse[0].ack[0] == "Failure")
			{
				return "Zipcode is invalid";
			}
			else if (!("item" in json.findItemsAdvancedResponse[0].searchResult[0]))
			{
				return "No records have been found";
			}

			var html_text = "<table>";
			html_text += "<tr>";
			html_text += "<th><strong>Index</strong></th>";
			html_text += "<th><strong>Photo</strong></th>";
			html_text += "<th><strong>Name</strong></th>";
			html_text += "<th><strong>Price</strong></th>";
			html_text += "<th><strong>Zip code</strong></th>";
			html_text += "<th><strong>Condition</strong></th>";
			html_text += "<th><strong>Shipping option</strong></th>";
			html_text += "</tr>";

			var items = json.findItemsAdvancedResponse[0].searchResult[0].item;

			for (var i = 0; i < items.length; i++)
			{
				var index = i;
				html_text += "<tr>";
				html_text += "<td>" + (i+1) + "</td>";
				html_text += "<td><img src=\"" + ((("galleryURL") in items[i]) ? items[i].galleryURL[0] : "N/A") + "\"/></td>";
				html_text += "<td><a href=\"#\" onclick='OnItemClick(" + index + "); return true;'>" + ((("title") in items[i]) ? items[i].title[0] : "N/A") + "</a></td>";
				html_text += "<td>$" + ((("sellingStatus") in items[i]) ? Number(items[i].sellingStatus[0].currentPrice[0].__value__).toFixed(2) : "N/A") +"</td>";
				html_text += "<td>" + ((("postalCode") in items[i]) ? items[i].postalCode[0] : "N/A") +"</td>";
				html_text += "<td>" + ((("condition") in items[i]) ? items[i].condition[0].conditionDisplayName : "N/A") + "</td>";
				html_text += "<td>" + ((("shippingInfo") in items[i]) ? ((Number(items[i].shippingInfo[0].shippingServiceCost[0].__value__) == 0) ? "Free Shipping" : ("$" + Number(items[i].shippingInfo[0].shippingServiceCost[0].__value__).toFixed(2))) : "N/A") +"</td>";
				html_text += "</tr>";
			}

			html_text += "</table>";

			return html_text;
		}

		function getSimilarItemsHTML()
		{
			var similarItemsJSON = <?php echo getSimilarItems(); ?>;
			var similarItems = similarItemsJSON.getSimilarItemsResponse.itemRecommendations.item;

			if (similarItems.length == 0)
			{
				return "<h1>No similar items found</h1>";
			}

			var html_text = "<table><tr>";
			for (var i=0; i < similarItems.length; i++)
			{
				html_text += "<td><img src=\"" + similarItems[i].imageURL + "\"/></td>";
			}
			html_text += "</tr>";

			html_text += "<tr>";
			for (var i=0; i < similarItems.length; i++)
			{
				html_text += "<td><a href=\"#\" onclick=\"OnSimilarItemClick(" + similarItems[i].itemId + ")\">" + similarItems[i].title + "</a></td>";
			}
			html_text += "</tr>";

			html_text += "<tr>";
			for (var i=0; i < similarItems.length; i++)
			{
				html_text += "<td><b>$" + similarItems[i].buyItNowPrice.__value__ + "<b></td>";
			}
			html_text += "</tr></table>";

			return html_text;
		}

		function buildItemPage(itemJSON)
		{
			//Item has expired
			if (!("Item" in itemJSON))
			{
				return "Item has expired";
			}

			var html_text = "<h1><i>Item Details</i></h1><table>";

			html_text += "<tr><td><b>Photo</b></td><td>" + (("PictureURL" in itemJSON.Item) ? "<img src=\"" + itemJSON.Item.PictureURL[0] + "\">" : "") +"</td></tr>";
			html_text += "<tr><td><b>Title</b></td><td>" + (("Title" in itemJSON.Item) ? itemJSON.Item.Title : "N/A") + "</td></tr>";
			html_text += "<tr><td><b>Subtitle</b></td><td>" + (("Subtitle" in itemJSON.Item) ? itemJSON.Item.Subtitle : "N/A") + "</td></tr>";
			html_text += "<tr><td><b>Price</b></td><td>" + (("CurrentPrice" in itemJSON.Item) ? Number(itemJSON.Item.CurrentPrice.Value).toFixed(2) + " " + itemJSON.Item.CurrentPrice.CurrencyID : "N/A") + "</td></tr>";
			html_text += "<tr><td><b>Location</b></td><td>" + (("Location" in itemJSON.Item) && ("PostalCode" in itemJSON.Item) ? itemJSON.Item.Location + ", " + itemJSON.Item.PostalCode : "N/A") + "</td></tr>";
			html_text += "<tr><td><b>Seller</b></td><td>" + (("Seller" in itemJSON.Item) ? itemJSON.Item.Seller.UserID : "N/A") + "</td></tr>";
			html_text += "<tr><td><b>Return Policy (US)</b></td><td>" + (("ReturnPolicy" in itemJSON.Item) ? ((itemJSON.Item.ReturnPolicy.ReturnsAccepted == "Returns Accepted") ? "Returns accepted within " + itemJSON.Item.ReturnPolicy.ReturnsWithin.toLowerCase() : "Returns not accepted") : "N/A") + "</td></tr>";

			if ("ItemSpecifics" in itemJSON.Item)
			{
				for(var i = 0; i < itemJSON.Item.ItemSpecifics.NameValueList.length; i++)
				{
					html_text += "<tr><td><b>" + itemJSON.Item.ItemSpecifics.NameValueList[i].Name + "</b></td><td>" + itemJSON.Item.ItemSpecifics.NameValueList[i].Value[0] + "</td></tr>";
				}
			}

			var similarItemsHTML = getSimilarItemsHTML();

			html_text += "</table>";

			html_text += "<div id=\"seller-msg\"><p id=\"seller-text\" class=\"arrow-text\">click to show seller message</p><img id=\"seller-message\" src=\"http://csci571.com/hw/hw6/images/arrow_down.png\" alt=\"down\" onclick=\"toggleDropdown(0)\"/>";

			//html_text += (("Description" in json.Item && json.Item.Description.length > 0) ? "<iframe id=\"seller-message-html\" align=\"middle\" style=\"visibility: hidden; height: 0px;\" srcdoc=\"" + json.Item.Description + "\"/></iframe></div>" : "<div id=\"seller-message-error\" class=\"error-bar\">No seller message found</div>");

			html_text += "<div><p id=\"similar-text\" class=\"arrow-text\">click to show similar items</p><img id=\"similar-items\" src=\"http://csci571.com/hw/hw6/images/arrow_down.png\" alt=\"down\" onclick=\"toggleDropdown(1)\"></div>";

			html_text += "<div id=\"similar-items-table\" style=\"display: none;\">" + similarItemsHTML + "</div>";

			return html_text;
		}

		window.onload = function() {
			var xml = new XMLHttpRequest();

			xml.open("GET", "http://ip-api.com/json", false);
			xml.send();

			geoLocationJSON = JSON.parse(xml.responseText);

			document.getElementById("submit-form").disabled = false;

			buildPage();
		}
	</script>
</body>
</html>