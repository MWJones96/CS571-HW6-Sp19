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
		#results-table {padding: auto; width: 1000px; margin: auto;}
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
		.arrow-text { color: grey;  }
        iframe { border: none; overflow: hidden; margin: 0; height: 100%; }
        #similar-items-table table { border: 1px solid black; overflow-x: scroll; width: 600px; display: block; }
		#similar-items-table table tr, #similar-items-table table tr td { text-align: center; border: none; outline: none; border-collapse: collapse; }
		#similar-items-table table tr td { width: 10vw; }
		#similar-items-table table tr td img { width: auto; height: 150px; }
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
        
        function ResizeIframe(iframe)
        {
            if (iframe == null) { return; }

            iframe.style.width =  "1000px";
            
            var h = Math.max(iframe.contentWindow.document.body.scrollHeight, iframe.contentWindow.document.body.offsetHeight);
            
            iframe.style.height = (h+30) + "px";
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
                    
                    document.getElementById("seller-message-html").style.display = "none";
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
                    document.getElementById("seller-message-html").style.display = "block";

                    ResizeIframe(document.getElementById("seller-frame"));
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
                    
                    document.getElementById("seller-message-html").style.display = "none";
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
			document.getElementById("item-table").innerHTML = "";
			document.getElementById("error-bar").innerHTML = "";
			document.getElementById("error-bar").style.visibility = "hidden";

			document.getElementById("keyword").value = "";
			document.getElementById("category").selectedIndex = "all";

			document.getElementById("new").checked = false;
			document.getElementById("used").checked = false;
			document.getElementById("unspecified").checked = false;

			document.getElementById("local").checked = false;
			document.getElementById("free-shipping").checked = false;

			document.getElementById("enable-search").checked = false;
			document.getElementById("miles-from").value = "";
			document.getElementById("zip").value = "";
			document.getElementById("zip").value = "";

			document.getElementById("here-radio").checked = true;
		}
	</script>
</head>
<body>
	<?php
		function getJSON()
		{
			if (empty($_GET)){return '""';}

			if ($_GET["itemID"] != "0") { return getItemJSON(); }

            $index = 0;
			$kwd = rawurlencode($_GET["keyword"]);
			$category = ($_GET["category"] == "all") ? "" : "&categoryId={$_GET["category"]}";

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

            $shippingAndLocal = "";
            if (isset($_GET["free"])) { $shippingAndLocal .= "&itemFilter({$index}).name=FreeShippingOnly&itemFilter({$index}).value=true"; $index++; }
            if (isset($_GET["local"])) { $shippingAndLocal .= "&itemFilter({$index}).name=LocalPickupOnly&itemFilter({$index}).value=true"; $index++; }
            
			$duplicate = "&itemFilter({$index}).name=HideDuplicateItems&itemFilter({$index}).value=true";
			$index++;

			$condition = "";

			if (isset($_GET["new"]) || isset($_GET["used"]) || isset($_GET["unspec"]))
			{
                $condition .= "&itemFilter({$index}).name=Condition";
                
				$subIndex = 0;
				if (isset($_GET["new"])) { $condition .= "&itemFilter({$index}).value({$subIndex})=New"; $subIndex++; }
				if (isset($_GET["used"])) { $condition .= "&itemFilter({$index}).value({$subIndex})=Used"; $subIndex++; }
				if (isset($_GET["unspec"])) { $condition .= "&itemFilter({$index}).value({$subIndex})=Unspecified"; $subIndex++;}
				$index++;
			}

			//Builds URL for the API call with the data the user provides
			$_API_URL = "http://svcs.ebay.com/services/search/FindingService/v1?OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&SECURITY-APPNAME=MatthewJ-CS571-PRD-2f2cd4cf7-09303b6c&RESPONSE-DATA-FORMAT=JSON&REST-PAYLOAD&paginationInput.entriesPerPage=20&keywords={$kwd}{$category}{$nearby_search}{$shippingAndLocal}{$duplicate}{$condition}";

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
					<input id="miles-from" class="cond-fields" type="number" name="miles" placeholder="10" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> value="<?php if (!empty($_GET["miles"])) { echo $_GET["miles"]; } ?>"></input>
					<strong>miles from</strong>
				</td>
				<td>
					<input id="here-radio" class="cond-fields" type="radio" value="here" name="location" onclick = "disableZipReq()" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> <?php if (!isset($_GET["location"])) { echo "checked"; } else { if ($_GET["location"] == "here") { echo "checked"; } }?>>Here</input>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input id="zip-radio" class="cond-fields" type="radio" name="location" onclick = "enableZipReq()" value="zip" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> <?php if (isset($_GET["location"]) && $_GET["location"] == "zip") { echo "checked"; } ?>></input>
					<input id="zip" class="cond-fields" type="textarea" name="zip" placeholder="zip code" <?php if (!isset($_GET["nearby"])) { echo "disabled"; } ?> value="<?php if (!empty($_GET["zip"])) { echo $_GET["zip"]; } ?>"></input>
				</td>
			</tr>
		</table>
		<br>
		<div class="buttons">
			<input id="submit-form" type="submit" name="btnSubmit" value="Search" onclick="submitForm()" disabled></input>
			<input type="button" name="clear" value="Clear" onclick="clearForm()"></input>
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

				if (text == "Zipcode is invalid" || text == "No records have been found" || text == "Keyword is too short") 
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
			if (json.findItemsAdvancedResponse[0].ack[0] == "Failure" && json.findItemsAdvancedResponse[0].errorMessage[0].error[0].errorId[0] == "18")
			{
				return "Zipcode is invalid";
			}
            else if (json.findItemsAdvancedResponse[0].ack[0] == "Failure" && json.findItemsAdvancedResponse[0].errorMessage[0].error[0].errorId[0] == "36")
            {
                return "Keyword is too short";
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
				html_text += "<td>" + ((("galleryURL") in items[i]) ? "<img src=\"" + items[i].galleryURL[0] + "\"/>" : "N/A") + "</td>";
				html_text += "<td><a href=\"#\" onclick='OnItemClick(" + index + "); return true;'>" + ((("title") in items[i]) ? items[i].title[0] : "N/A") + "</a></td>";
				html_text += "<td>$" + ((("sellingStatus") in items[i]) ? items[i].sellingStatus[0].currentPrice[0].__value__ : "N/A") +"</td>";
				html_text += "<td>" + ((("postalCode") in items[i]) ? items[i].postalCode[0] : "N/A") +"</td>";
				html_text += "<td>" + ((("condition") in items[i]) ? items[i].condition[0].conditionDisplayName : "N/A") + "</td>";
				html_text += "<td>" + ((("shippingInfo") in items[i] && ("shippingServiceCost" in items[i].shippingInfo[0] && "__value__" in items[i].shippingInfo[0].shippingServiceCost[0])) ? ((Number(items[i].shippingInfo[0].shippingServiceCost[0].__value__) == 0) ? "Free Shipping" : ("$" + items[i].shippingInfo[0].shippingServiceCost[0].__value__)) : "N/A") +"</td>";
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
				return "<table><tr><td><h2 style=\"border: 1px solid black; width: 600px; margin: auto;\">No similar items found</h2></td></tr></table>";
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

            if ("PictureURL" in itemJSON.Item && itemJSON.Item.PictureURL != "") { html_text += "<tr><td><b>Photo</b></td><td><img src=\"" + itemJSON.Item.PictureURL[0] + "\"></td></tr>"; }
            
            if ("Title" in itemJSON.Item && itemJSON.Item.Title != "") { html_text += "<tr><td><b>Title</b></td><td>" + itemJSON.Item.Title + "</td></tr>"; }
            
            if ("Subtitle" in itemJSON.Item && itemJSON.Item.Subtitle != "") { html_text += "<tr><td><b>Subtitle</b></td><td>" + itemJSON.Item.Subtitle + "</td></tr>"; }
            
            if ("CurrentPrice" in itemJSON.Item && itemJSON.Item.CurrentPrice != "") { html_text += "<tr><td><b>Price</b></td><td>" + Number(itemJSON.Item.CurrentPrice.Value).toFixed(2) + " " + itemJSON.Item.CurrentPrice.CurrencyID + "</td></tr>"; }
            
            if ("Location" in itemJSON.Item && itemJSON.Item.Location != "") { html_text += "<tr><td><b>Location</b></td><td>" + itemJSON.Item.Location; if ("PostalCode" in itemJSON.Item && itemJSON.Item.PostalCode != "") { html_text += ", " + itemJSON.Item.PostalCode; } html_text += "</td></tr>"; }
            
            if ("Seller" in itemJSON.Item && "UserID" in itemJSON.Item.Seller && itemJSON.Item.UserID != "") { html_text += "<tr><td><b>Seller</b></td><td>" + itemJSON.Item.Seller.UserID + "</td></tr>"; }
            
            if ("ReturnPolicy" in itemJSON.Item && "ReturnsAccepted" in itemJSON.Item.ReturnPolicy && itemJSON.Item.ReturnsAccepted != "") 
            { 
                html_text += "<tr><td><b>Return Policy (US)</b></td><td>" +  ((itemJSON.Item.ReturnPolicy.ReturnsAccepted == "ReturnsNotAccepted") ? "Returns not accepted" : "Returns accepted" + ("ReturnsWithin" in itemJSON.Item.ReturnPolicy ? " within " + itemJSON.Item.ReturnPolicy.ReturnsWithin.toLowerCase() : ""));
                
                html_text += "</td></tr>";
            }

			if ("ItemSpecifics" in itemJSON.Item)
			{
				for(var i = 0; i < itemJSON.Item.ItemSpecifics.NameValueList.length; i++)
				{
					html_text += "<tr><td><b>" + itemJSON.Item.ItemSpecifics.NameValueList[i].Name + "</b></td><td>" + itemJSON.Item.ItemSpecifics.NameValueList[i].Value[0] + "</td></tr>";
				}
			}
            
            html_text += "</table>";

			var similarItemsHTML = getSimilarItemsHTML();

			html_text += "<div id=\"seller-msg\"><p id=\"seller-text\" class=\"arrow-text\">click to show seller message</p><img id=\"seller-message\" src=\"http://csci571.com/hw/hw6/images/arrow_down.png\" alt=\"down\" onclick=\"toggleDropdown(0)\"/>";
            
            html_text += "<div id=\"seller-message-html\" style=\"display: none;\">";
            if ("Description" in itemJSON.Item && itemJSON.Item.Description.length > 0)
            {
                html_text += "<iframe id='seller-frame' scrolling='no' srcdoc='" + json.Item.Description.replace(/'/g, "\"") + "'></iframe>";
            }
            else
            {
                html_text += "<iframe id='seller-frame' scrolling='no' srcdoc='<div style=\"margin: auto; text-align: center; width: 1000px; background-color: #DDDDDD;\" sandbox><h2>No seller message found</h2></div>'></iframe>";
            }
            
            html_text += "</div>";

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