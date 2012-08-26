<?
require("conf.php");
Header("content-type: image/png");

$path=explode("/", $_REQUEST['path']);
$zoom=$path[0];
$tile=array("x"=>$path[1], "y"=>$path[2]);

$orig_bounds=array(
  'x'=>array(-20037508.34, 20037508.34),
  'y'=>array(-20037508.34, 20037508.34),
);

$size=array(
  'x'=>($orig_bounds['x'][1]-$orig_bounds['x'][0])/pow(2, $zoom),
  'y'=>($orig_bounds['y'][1]-$orig_bounds['y'][0])/pow(2, $zoom),
);

$bounds=array(
  'x'=>array(
    $size['x']*$tile['x']+$orig_bounds['x'][0],
    $size['x']*($tile['x']+1)+$orig_bounds['x'][0],
  ),
  'y'=>array(
    -($size['y']*($tile['y']+1)+$orig_bounds['y'][0]),
    -($size['y']*$tile['y']+$orig_bounds['y'][0]),
  ),
);

unset($_REQUEST['path']);

if(!isset($_REQUEST['SERVICE']))
  $_REQUEST['SERVICE']="WMS";
if(!isset($_REQUEST['VERSION']))
  $_REQUEST['VERSION']="1.1.1";
if(!isset($_REQUEST['REQUEST']))
  $_REQUEST['REQUEST']="GetMap";
if(!isset($_REQUEST['SRS']))
  $_REQUEST['SRS']="EPSG:900913";

foreach($_REQUEST as $k=>$v) {
  if(is_array($v)) {
    $param[]=urlencode($k)."%5B%5D=".rawurlencode($v[0]);
  }
  else {
    $param[]=urlencode($k)."=".rawurlencode($v);
  }
}
$param="?".implode("&", $param);

print file_get_contents("{$wms_url}{$param}&BBOX={$bounds['x'][0]},{$bounds['y'][0]},{$bounds['x'][1]},{$bounds['y'][1]}&WIDTH=256&HEIGHT=256");
