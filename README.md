# CS571 Homework 6: eBay Product Search (PHP)

A server-side PHP page for searching eBay listings, viewing item details and browsing similar items.

## Overview

Coursework for USC CSCI 571, Web Technologies, Spring 2019. The whole application is a single `index.php` file. The form submits to itself with `GET`; PHP builds the eBay API request, fetches the JSON with `file_get_contents`, and embeds it in the page, where client-side JavaScript turns it into HTML tables.

## Features

- **Search form**
  - Keyword (required) and category (All, Art, Baby, Books, Clothing, Shoes & Accessories, Computers/Tablets & Networking, Health & Beauty, Music, Video Games & Consoles).
  - Condition filters: New, Used, Unspecified.
  - Shipping filters: Local Pickup, Free Shipping.
  - Optional nearby search: a distance in miles (10 by default) from either the user's current location or an entered ZIP code. The current ZIP code is looked up from the visitor's IP address via ip-api.com when the page loads.
  - Form values persist across submissions; **Clear** resets the form and results.
- **Results table** of up to 20 items (eBay Finding API, `findItemsAdvanced`, with duplicates hidden), showing index, photo, name, price, ZIP code, condition and shipping cost ("Free Shipping" when zero).
- **Item details** (eBay Shopping API, `GetSingleItem`) when a result is clicked: photo, title, subtitle, price, location, seller, US return policy and all item specifics.
- **Seller message**: the item description, shown in a collapsible, auto-resized `iframe`.
- **Similar items** (eBay Merchandising API, `getSimilarItems`, up to 8) in a collapsible, horizontally scrolling table; clicking one opens its details.
- Error messages for an invalid ZIP code, a keyword that is too short, no results, and expired items.

## Tech stack

- PHP (no framework or Composer dependencies)
- HTML, CSS and vanilla JavaScript
- eBay Finding, Shopping and Merchandising APIs
- ip-api.com for IP-based geolocation

## Getting started

### Prerequisites

- PHP with `allow_url_fopen` enabled (it is on by default), since the API calls use `file_get_contents`.
- An eBay developer application ID.

### Configuration

The eBay application ID is hard-coded in three API URLs inside `index.php` (the `SECURITY-APPNAME`, `appid` and `CONSUMER-ID` parameters). Replace it with your own ID before running the page.

### Run

```sh
php -S localhost:8000
```

Then open `http://localhost:8000/index.php`.

## Project structure

```
index.php   Form, PHP API calls, styles and client-side rendering in one file
```

## Status and limitations

- eBay has since retired its legacy Finding, Shopping and Merchandising APIs, so searches are unlikely to return results without porting the requests to eBay's current REST APIs.
- The geolocation request to `http://ip-api.com/json` is made synchronously over plain HTTP, so it will be blocked if the page is served over HTTPS.
- Arrow images are hot-linked from `http://csci571.com/hw/hw6/images/`, the course website.
- User input is echoed back into the page without escaping, so the page is not suitable for public hosting as written.

## Acknowledgements

- USC CSCI 571, Web Technologies, for the assignment specification and image assets.
- eBay developer APIs and ip-api.com.
