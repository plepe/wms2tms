<?
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

print file_get_contents("http://vhost04.measurement.rtr.at:8080/geoserver/it.geosolutions/wms?LAYERS=it.geosolutions%3ABicycle%20Parking%20900913&STYLES=&FORMAT=image%2Fpng&TRANSPARENT=TRUE&TILED=true&TILESORIGIN=1805891.0815372%2C6126605.1261781&SERVICE=WMS&VERSION=1.1.1&REQUEST=GetMap&SRS=EPSG%3A900913&BBOX={$bounds['x'][0]},{$bounds['y'][0]},{$bounds['x'][1]},{$bounds['y'][1]}&WIDTH=256&HEIGHT=256");
