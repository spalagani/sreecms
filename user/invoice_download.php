<?php
ob_start();
// Include autoloader 
require_once 'dompdf/dompdf/autoload.inc.php';

/* Website custom code */
include("../valid.php");

$searchTerm = $_GET['id'];
$year = $_GET['year'];
$month = $_GET['month'];
$operator_id = $_GET['operator_id'];

$finalArr = array();
$paymentArr = array();
$operatorArr = array();

$invoiceId = $totalPaid = '';
if (!empty($searchTerm) && !empty($year) && !empty($month)) {
	$sql = "SELECT * FROM `customers` WHERE `id`=".$searchTerm;
	$result = mysqli_query($conn, $sql);
	$finalArr = array();
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	        $finalArr = $row;
	    }
	}
	
	$sql1 = "SELECT p.*, pm.payment_type, pc.package_name FROM `payments` AS p LEFT JOIN `payment_modes` AS pm ON pm.id = p.payment_mode  LEFT JOIN `packages` AS pc ON pc.package_id = p.package_id WHERE p.`user_id`=".$searchTerm." and p.`year`= ".$year." and p.`month` = '".$month."'";
    $result1 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result1) > 0) {
        while($row1 = mysqli_fetch_assoc($result1)) {
           $paymentArr = $row1;
        }
    }
	
	$payment_id = !empty($paymentArr['payment_id'])?$paymentArr['payment_id'] :
	    '';
	    
	$amount_paid = !empty($paymentArr['paid_amount'])?$paymentArr['paid_amount'] :
	    0;
	$extra_amount = !empty($paymentArr['extra_amount'])?$paymentArr['extra_amount'] :
	    0;
	$invoiceId = $year.'_'.$month.'_'.$payment_id;
	$totalPaid = $amount_paid+$extra_amount;
    
  $sql2 = "SELECT * FROM `operators` WHERE operator_id = ".$operator_id;
  $result2 = mysqli_query($conn, $sql2);
  if (mysqli_num_rows($result2) > 0) {
      while($row1 = mysqli_fetch_assoc($result2)) {
         $operatorArr = $row1;
      }
  }
}
/* End Website Custom Code */

?>

<?php ob_start(); ?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
.symbol {
	font-family: DejaVu Sans, sans-serif;
}
li {
	padding-bottom:2px;
	font-size: 12.8px;
}
p,thead,tbody {
font-family: Helvetica,sans-serif;
	font-size: 13.5px;
}
thead th {
	text-align:left;
}
a {
	text-decoration:none;
	color:#000;
}
.title {
	font-size: 20px;
}
ul {
	list-style: none;padding: 0;margin: 0;
}
table {
	width: 100%;font-family: Arial,sans-serif;padding:.65rem;padding-top: 0;padding-bottom: 0;
}
.invoiceTable .Border, .invoiceTable td, .invoiceTable th {
	border: 2px solid #a9a9a9;
}
.invoiceTable {
	border-collapse: collapse;
	padding: 0 !important;
}
.invoiceTable thead {
	background: #f6f6f6;
	padding: 0 !important;
}
.invoiceTable th, .invoiceTable td {
	text-align: center;
	padding: 10px;
}
.noBorder, .noBorder td {
	border:none;
}
</style>
</head>

<body>
<table>
	<tbody>
		<tr>
			<td>
				<h3 class="title">Sree Broadband</h3>
			</td>
			<td style="text-align: right;">
				<h3 style="text-transform: uppercase;" class="title">Invoice</h3>
			</td>
		</tr>
		<tr>
			<td>
				<ul>
					<li>#7-4, Main Road, Tadepalli</li>
					<li>Guntur, Andhra Pradesh 522501</li>
					<li>IN</li>
					<li>8099334455</li>
					<li><a href="mailto:care@sreebroadband.com">care@sreebroadband.com</a></li>
					<li><a href="http://www.sreebroadband.com/">http://www.sreebroadband.com</a></li>
					<li>GSTIN: 37BIOPT6316D1ZY</li>
				</ul>
			</td>
			<td style="text-align: right;vertical-align:top;">
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAALQAAABGCAYAAABll74gAAAACXBIWXMAAC4jAAAuIwF4pT92AAAYcmlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNi4wLWMwMDIgNzkuMTY0NDg4LCAyMDIwLzA3LzEwLTIyOjA2OjUzICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0RXZ0PSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VFdmVudCMiIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczpwaG90b3Nob3A9Imh0dHA6Ly9ucy5hZG9iZS5jb20vcGhvdG9zaG9wLzEuMC8iIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHhtcDpDcmVhdGVEYXRlPSIyMDE5LTAzLTA4VDE2OjA5OjA0KzA1OjMwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIxLTAzLTE0VDE1OjAyOjUxKzAyOjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMS0wMy0xNFQxNTowMjo1MSswMjowMCIgZGM6Zm9ybWF0PSJpbWFnZS9wbmciIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6YzU1Mzc4YjMtN2U2Zi1jOTQ4LWEyMGMtMWIwOGMxNGY4YWVlIiB4bXBNTTpEb2N1bWVudElEPSJhZG9iZTpkb2NpZDpwaG90b3Nob3A6YWJkNTJmZGUtODA4Ny0xOTQzLWFjNDUtODUyYjEyOGE0NDZhIiB4bXBNTTpPcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6MDA4NzhhNmMtYWIzOC00OTU4LTljNWItODQ1YzIzZmVmMzliIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIiBwaG90b3Nob3A6SUNDUHJvZmlsZT0ic1JHQiBJRUM2MTk2Ni0yLjEiPiA8eG1wTU06SGlzdG9yeT4gPHJkZjpTZXE+IDxyZGY6bGkgc3RFdnQ6YWN0aW9uPSJjcmVhdGVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjAwODc4YTZjLWFiMzgtNDk1OC05YzViLTg0NWMyM2ZlZjM5YiIgc3RFdnQ6d2hlbj0iMjAxOS0wMy0wOFQxNjowOTowNCswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjY5NTFjMDRhLTJjNjYtNDBhNi1hNmEwLTAxMzUxZWMwOGM5YiIgc3RFdnQ6d2hlbj0iMjAxOS0wMy0wOFQxNjowOToyMCswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNvbnZlcnRlZCIgc3RFdnQ6cGFyYW1ldGVycz0iZnJvbSBhcHBsaWNhdGlvbi9wZGYgdG8gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iZGVyaXZlZCIgc3RFdnQ6cGFyYW1ldGVycz0iY29udmVydGVkIGZyb20gYXBwbGljYXRpb24vcGRmIHRvIGFwcGxpY2F0aW9uL3ZuZC5hZG9iZS5waG90b3Nob3AiLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmRjNjY3MTliLTE2OTktNGMxMy05NDhkLTJmOTZhNmM4Mzg3NyIgc3RFdnQ6d2hlbj0iMjAxOS0wMy0wOFQxNjowOToyMCswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmI1MmI0MzU5LWE0ODYtNDgzOS04MDZiLTBlZjcxOGFmZmE3MCIgc3RFdnQ6d2hlbj0iMjAxOS0wMy0xMVQxNTo0Mjo1MyswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNvbnZlcnRlZCIgc3RFdnQ6cGFyYW1ldGVycz0iZnJvbSBhcHBsaWNhdGlvbi92bmQuYWRvYmUucGhvdG9zaG9wIHRvIGltYWdlL3BuZyIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iZGVyaXZlZCIgc3RFdnQ6cGFyYW1ldGVycz0iY29udmVydGVkIGZyb20gYXBwbGljYXRpb24vdm5kLmFkb2JlLnBob3Rvc2hvcCB0byBpbWFnZS9wbmciLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOjFmYjZmZjU4LTMzMzAtNDNiMC04ZDg1LTNmZTU5NTMwOWQ3MSIgc3RFdnQ6d2hlbj0iMjAxOS0wMy0xMVQxNTo0Mjo1MyswNTozMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTkgKE1hY2ludG9zaCkiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPHJkZjpsaSBzdEV2dDphY3Rpb249InNhdmVkIiBzdEV2dDppbnN0YW5jZUlEPSJ4bXAuaWlkOmM1NTM3OGIzLTdlNmYtYzk0OC1hMjBjLTFiMDhjMTRmOGFlZSIgc3RFdnQ6d2hlbj0iMjAyMS0wMy0xNFQxNTowMjo1MSswMjowMCIgc3RFdnQ6c29mdHdhcmVBZ2VudD0iQWRvYmUgUGhvdG9zaG9wIDIyLjAgKFdpbmRvd3MpIiBzdEV2dDpjaGFuZ2VkPSIvIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpiNTJiNDM1OS1hNDg2LTQ4MzktODA2Yi0wZWY3MThhZmZhNzAiIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6ZGM2NjcxOWItMTY5OS00YzEzLTk0OGQtMmY5NmE2YzgzODc3IiBzdFJlZjpvcmlnaW5hbERvY3VtZW50SUQ9InhtcC5kaWQ6MDA4NzhhNmMtYWIzOC00OTU4LTljNWItODQ1YzIzZmVmMzliIi8+IDxwaG90b3Nob3A6RG9jdW1lbnRBbmNlc3RvcnM+IDxyZGY6QmFnPiA8cmRmOmxpPjA3Qjg3QzE0QTdDQTM1NzZGNzFBMjJFQURDQjlGQTMxPC9yZGY6bGk+IDxyZGY6bGk+MTRCODQ3QTUyRTYwNTA3Rjk0RTYwNEZEQTQ0NDVCODI8L3JkZjpsaT4gPHJkZjpsaT4yNEYwRTYzNEM3ODJGOUVGNjk2RkY0MENCNDBDMDYyMzwvcmRmOmxpPiA8cmRmOmxpPjJGNTZGRkU5RDE3MjREOEIzMUE2NUYzRDgxMjEwRjY5PC9yZGY6bGk+IDxyZGY6bGk+Njg4M0JBRjZEREUwQjRCNDc0QTZDNEJERjdCRDQzNzU8L3JkZjpsaT4gPHJkZjpsaT43NDIwNzQyQjNDRUUwMTVDN0FEQjgxOTg3RDc2MjhCODwvcmRmOmxpPiA8cmRmOmxpPjc0N0JERjg4QUEwMzUyOEM3Q0FGOTEyMEUxRDFCOTI4PC9yZGY6bGk+IDxyZGY6bGk+NzlGM0E1OThDQkJDNUZBNDJGNDZCQzIzNzM3Qjk1Q0E8L3JkZjpsaT4gPHJkZjpsaT5COTg2QUY1QzI5MTU4ODI2NTlCQkY5NUEzRUI3QTNCMTwvcmRmOmxpPiA8cmRmOmxpPkQ4RDk1NEFGMkU0QUYwRDdBNEVFNkNDNTJGQTdDMkRGPC9yZGY6bGk+IDxyZGY6bGk+RkM2NTkzNEI4NEMyQUIzQzE4Q0MzQUE0QTc4NEUwRDM8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6MTU1MDhmZTYtNzRhNS0xMTdhLTlkNjEtZDFkMGY1NGY1YjEzPC9yZGY6bGk+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjFjY2VkNjlmLTcxOGYtMTE3YS05ZTYxLTgwOTkyZWE4MjVjNzwvcmRmOmxpPiA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDoyMzk5OGFjOS00NDkwLTExN2MtYmIxMS1kOGY0OWUyOWMwMTU8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6MzM3MGY4MDAtNmI1OC0xMTdiLWFkYTMtZTgyZDE3OTU2ZWU5PC9yZGY6bGk+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjQwMDQzOWFiLTA2ODctMTE3Yy05OWMzLWNkNDI2M2JhNTllMDwvcmRmOmxpPiA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDo2YWM1MGJhZi1jNzdiLTExN2ItYWFiYS1jNGM5Y2NjMTBhZDQ8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6NmJmZjI5NGUtMGM1Zi0xMTdjLTllYzgtYjI0MTc5MWI5MjRjPC9yZGY6bGk+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjgyNDFmM2I3LWZhMzItMTE3YS04MDdjLWUzYWU2ZDE5N2ZmOTwvcmRmOmxpPiA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDo4YTFkYTdjMS02NzEyLTExN2ItYmUxZC1hOThlZWJmMTExMDY8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6OTEyZDk4MjktNDJkZS0xMTdiLWE3ZmItYzU1OTUwM2JhZWMxPC9yZGY6bGk+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOjllOWRkY2ZiLTBjM2UtMTE3Yy05ZWM4LWIyNDE3OTFiOTI0YzwvcmRmOmxpPiA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDpiNTY5MzgwNi0wMTI5LTExN2ItYTE3Yi1lOWRjYTJjZjI1NDU8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6YzMwNzAyZTgtZjlkZS0xMTdhLTkyYjctY2U0ODVmNTAxZmQ1PC9yZGY6bGk+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmQwODAxNjdkLTA5ZTktMTE3Yy05ZWJjLWYwNGIzMTA1ZGY0ZDwvcmRmOmxpPiA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDpkMGY5ODlhMi0yODliLTExN2ItOGMxMi04YjYwODFhMjM3Y2Q8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6ZTQ1ZTE2ZDctNDJkMC0xMTdhLWEwNGQtYWFkYWU2YmViMjAwPC9yZGY6bGk+IDxyZGY6bGk+YWRvYmU6ZG9jaWQ6cGhvdG9zaG9wOmVjODA0YmMxLWZhYjYtMTFlNi05MzI0LWE2MTY5ZmNkOGIzNjwvcmRmOmxpPiA8cmRmOmxpPmFkb2JlOmRvY2lkOnBob3Rvc2hvcDpmMzA3YzZlYS1mYmRhLTExN2EtOGIzMS1mMmE0ZmE1YmM1YTM8L3JkZjpsaT4gPHJkZjpsaT5hZG9iZTpkb2NpZDpwaG90b3Nob3A6ZmNhYmU2ZjEtMjg0MS0xMTdiLWE0NDUtODBhMTQwMjBhYmVkPC9yZGY6bGk+IDxyZGY6bGk+dXVpZDpDQzlDNzlDNzQyMDVFNzExOTk4RkVGMkY4MjlBODQyRjwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6MTY4MWNhOGYtODcxOC00Y2FlLWIxZGMtOTRmMzRkNzVhMTc3PC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDoyZjY5MzI3MS0xN2M2LTQxZDItYTViMy01OGY1ZGZiMzkyM2Y8L3JkZjpsaT4gPHJkZjpsaT54bXAuZGlkOjQ1OGJkYjhjLTg1MWUtNDE1Ny1iZTg3LTBmYmEyYzJkMmM3ODwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6NmRjMjA2OWYtZWNmOS1iNDQ0LTg4MDgtYTUwNmU1NTA3OGUyPC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDo3NTE0NTYyRjJGNTYxMUU2QkEwMEY4RkU2NjIyODcwNDwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6NzVjODQzZmQtZmFhMi00MzQ2LWE4ODQtYTNkZGQ0ODY5Mzg2PC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDo3ODhBMkEyNkQwMjUxMUU3QTBBRUM4NzlCNjJCQUIxRDwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6Qjc2NUQyRUQwMENGMTFFNkJBNTlDOEE4ODcwQTE3REI8L3JkZjpsaT4gPHJkZjpsaT54bXAuZGlkOkI4QjgxRjZDNzZGNzExRTU4N0EyRkE1MjBBMEI1NjQ4PC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDpGQTVFOUU5QTkxNjMxMUU4ODBCQkNDOEFGRkQ1OTY4MDwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6RkUwRjRDRUVCRDg5RTQxMUIzQjBGNkEwMEE3NDlDMkM8L3JkZjpsaT4gPHJkZjpsaT54bXAuZGlkOmIzNjIwYWU0LWFjMWUtNDllYi05MGU5LTZmNmVjYzBmYWIzMzwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6YmE0MTJhNmQtY2ExZi00NDNmLTllNmMtNzZmODA1OGIyYjJmPC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDpiYTg1MGMxMy04OWE3LTQyMjUtYTkwZi1jMWM2Yjc1NDA0YzY8L3JkZjpsaT4gPHJkZjpsaT54bXAuZGlkOmM3NzAwMTI1LWNmNzgtNGU1My04YTI2LTNhZjhlM2U0NWU2ODwvcmRmOmxpPiA8cmRmOmxpPnhtcC5kaWQ6YzdiZTQ2OTYtMGVkZC00ZjFjLWI3NzEtNmQxNTFmZTYyOTE4PC9yZGY6bGk+IDxyZGY6bGk+eG1wLmRpZDpmOTg0YzYzZi1hYTUxLTQyYjQtODllZi1mMGZjY2I4NjkwOTc8L3JkZjpsaT4gPC9yZGY6QmFnPiA8L3Bob3Rvc2hvcDpEb2N1bWVudEFuY2VzdG9ycz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+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">
			</td>
		</tr>
	</tbody>
</table>

<table style="margin-top:85px;">
	<thead>
		<tr>
			<th>Bill To</th>
			<th>Ship To</th>
			<th style="text-align: right;">Invoice #</th>
			<th style="font-weight: normal;text-align: right;"><?php echo $invoiceId; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr style="line-height: 1.25;">
			<td style="width:35%;">
				<ul>
				  	<li><?php echo !empty($finalArr['Name']) ? $finalArr['Name'] : ''; ?></li>
				  	<li><?php echo !empty($finalArr['Billing_Address']) ? $finalArr['Billing_Address'] : ''; ?></li>
				  	<li>Phone: <?php echo !empty($finalArr['Mobile']) ? $finalArr['Mobile'] : ''; ?></li>
				  	<li>Email: <?php echo !empty($finalArr['Email']) ? $finalArr['Email'] : ''; ?></li>
				  </ul>
			</td>
			<td style="width:32%;">
				<ul>
				  	<li><?php echo !empty($finalArr['Name']) ? $finalArr['Name'] : ''; ?></li>
				  	<li><?php echo !empty($finalArr['Billing_Address']) ? $finalArr['Billing_Address'] : ''; ?></li>
				  	<li>Phone: <?php echo !empty($finalArr['Mobile']) ? $finalArr['Mobile'] : ''; ?></li>
				  	<li>Email: <?php echo !empty($finalArr['Email']) ? $finalArr['Email'] : ''; ?></li>
				  </ul>
			</td>
			<td style="vertical-align: top;text-align: right;font-weight: bold;width:16%;padding-top:10px;">
				Invoice Date
			</td>
			<td style="vertical-align: top;text-align: right;width:17%;padding-top:10px;">
				<?php echo !empty($paymentArr['payment_date']) ? date('d/m/Y', strtotime($paymentArr['payment_date'])) : ''; ?>
			</td>
		</tr>
	</tbody>
</table>

<table style="margin-top:25px;">
	<tbody>
		<tr>
			<td>
				A/C No <?php echo !empty($finalArr['Id']) ? $finalArr['Id'] : ''; ?>
			</td>
		</tr>
	</tbody>
</table>

<table style="margin-top:45px;" class="invoiceTable">
	<thead>
		<tr>
			<th>QTY</th>
			<th>DESCRIPTION</th>
			<th>UNIT PRICE</th>
			<th>AMOUNT</th>
		</tr>
	</thead>
	<tbody>
		<tr class="Border">
			<td style="width: 10%;">
				1
			</td>
			<td style="width: 50%;text-align:left;">
				<?php echo !empty($paymentArr['package_name']) ? $paymentArr['package_name'] : ''; ?>
			</td>
			<td style="width: 18%;text-align: right">
				<?php echo !empty($paymentArr['amount']) ? $paymentArr['amount'] : "0"; ?>
			</td>
			<td style="text-align: right">
				<?php echo !empty($paymentArr['amount']) ? $paymentArr['amount'] : "0"; ?>
			</td>
		</tr>
		<tr class="noBorder">
			<td>
				
			</td>
			<td>
				
			</td>
			<td style="text-align: right">
				Subtotal
			</td>
			<td style="text-align: right;border-bottom: none;" class="Border">
				<?php echo $totalPaid; ?>
			</td>
		</tr>
		<tr class="noBorder">
			<td>
				
			</td>
			<td>
				
			</td>
			<td style="text-align: right">
				GST Tax 18.0%
			</td>
			<td style="text-align: right;border-bottom: none;" class="Border">
				<?php
				$tax = $totalPaid * 18 / 100;
				echo $tax; ?>
			</td>
		</tr>
		<tr class="noBorder">
			<td>
				
			</td>
			<td>
				
			</td>
			<td style="text-align: right;font-weight: bold;font-size: 20px;">
				TOTAL
			</td>
			<td style="text-align: right;border-top: none;background:#f6f6f6;font-weight: bold;font-size: 20px;" class="Border">
				<span class="symbol">₹</span> <?php echo $totalPaid+$tax; ?>
			</td>
		</tr>
	</tbody>
</table>


<table style="margin-top:25px;">
  <tbody>
    <tr>
      <td style="font-weight:bold;">
        Terms & Conditions 
      </td>
    </tr>
    <tr>
      <td style="padding-bottom:10px;">
        Bill Period for 1 Month
      </td>
    </tr>
    <tr>
      <td style="padding-bottom:10px;">
        <ul>
        <?php
        if(!empty($paymentArr['payment_date'])) {
        	$dateTime = DateTime::createFromFormat('d/m/Y', date('d/m/Y', strtotime($paymentArr['payment_date'])));
        	$newDateString = $dateTime->format('M j Y');
        	
        	echo date("j F Y", strtotime($newDateString));
        	echo " - ";
        	
        	$timestm=strtotime($newDateString);
        	echo date("j F Y", strtotime("+1 month", $timestm));
        }
        ?>
        </ul> 
      </td>
    </tr>
    <tr>
      <td>
        <ul>
          <li>Sree Broadband Account Number</li>
          <li>Bank Name: ICICI Bank</li>
          <li>Account Name: SREE BROADBAND</li>
          <li>Account Type: CURRENT ACCOUNT</li>
          <li>Account Number: 426505500044</li>
          <li>IFSC: ICIC0004265</li>
          <li>Branch Name : UNDAVALLI</li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>

</body>
</html>

<?php $html = ob_get_clean();

// Reference the Dompdf namespace 
use Dompdf\Dompdf; 
 
// Instantiate and use the dompdf class 
$dompdf = new Dompdf();

// Load HTML content
$dompdf->loadHtml($html); 
 
// (Optional) Setup the paper size and orientation 
$dompdf->setPaper('A4'); 
 
// Render the HTML as PDF 
$dompdf->render();
 
// Output the generated PDF to Browser
// Attachment 0 = Preview, 1 = Download
$dompdf->stream("$invoiceId", array("Attachment" => 1));

// echo $html;