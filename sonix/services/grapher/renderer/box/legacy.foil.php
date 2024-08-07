<!-- Graph class type: "<?= $t->graph->classType() ?>" -->
<?php

$categoryMap = array();
$categoryMap['bits'] = 2;
$categoryMap['pkts'] = 5;
$categoryMap['errs'] = 3;
$categoryMap['discs'] = 6;
$categoryMap['bcasts'] = 4;

$categoryMapSflow = array();
$categoryMapSflow['bits'] = 2;
$categoryMapSflow['pkts'] = 3;

// Grafana period
$gfp = "24h";
switch($t->graph->period()) {
	case "day":
		$gfp = "24h";
		break;
	case "week":
		$gfp = "7d";
		break;
	case "month":
		$gfp = "30d";
		break;
	case "year":
		$gfp = "1y";
		break;
}
// IXP Manager v3 version of graph boxes to fit with the existing UI

// RRD graphs already have all the information embedded:

if ($gfp != "" && $t->graph->classType() == "Customer") {
foreach ($t->graph->customer()->virtualInterfaces as $vi) {
	$swp = $vi->switchPort();
	if($swp === false) {
		continue;
	}
?>
<iframe
src="https://metric.sonix.network/grafana/d-solo/laG5Khxnk/interface-details?orgId=1&theme=light&var-switch=<?=$swp->switcher->name?>.sonix.network&var-interface=<?=$swp->name?>&from=now-<?=$gfp?>&to=now&panelId=<?=$categoryMap[$t->graph->category()]?>"
  width="100%" height="400" frameborder="0"></iframe>
<?php
}

} else if ($gfp != "" && $t->graph->classType() == "PhysicalInterface") {
$swp = $t->graph->physicalInterface()->switchPort;
?>
<iframe
src="https://metric.sonix.network/grafana/d-solo/laG5Khxnk/interface-details?orgId=1&theme=light&var-switch=<?=$swp->switcher->name?>.sonix.network&var-interface=<?=$swp->name?>&from=now-<?=$gfp?>&to=now&panelId=<?=$categoryMap[$t->graph->category()]?>"
  width="100%" height="400" frameborder="0"></iframe>
<?php

} else if ($gfp != "" && $t->graph->classType() == "IXP") {
?>
<iframe src="https://metric.sonix.network/grafana/d-solo/jKdZekQ4z/overview?orgId=1&theme=light&from=now-<?=$gfp?>&to=now&panelId=5" width="100%" height="400" frameborder="0"></iframe>
<?php

} else if ($gfp != "" && $t->graph->classType() == "Infrastructure") {
	if ($t->graph->infrastructure()->id === 1) {
                ?> 
		<iframe src="https://metric.sonix.network/grafana/d-solo/jKdZekQ4z/overview?orgId=1&theme=light&var-ixp=ixp-(kn7%7Ckg%7Cixn)-.*&from=now-<?=$gfp?>&to=now&panelId=5" width="100%" height="400" frameborder="0"></iframe>
                <?php
        }
	else if ($t->graph->infrastructure()->id === 2) {
                ?>
		<iframe src="https://metric.sonix.network/grafana/d-solo/jKdZekQ4z/overview?orgId=1&theme=light&var-ixp=ixp-(shg5)-.*&from=now-<?=$gfp?>&to=now&panelId=5" width="100%" height="400" frameborder="0"></iframe>
                <?php
        }

} else if ($gfp != "" && $t->graph->classType() == "VlanInterface") {
$sasn = $t->graph->customer()->autsys;
$dasn = 'All'
?>
		<iframe src="https://metric.sonix.network/grafana/d-solo/YYcB1DwVz/sflow?orgId=1&theme=light&panelId=<?=$categoryMapSflow[$t->graph->category()]?>&var-source_asn=<?=$sasn?>&var-destination_asn=<?=$dasn?>&from=now-<?=$gfp?>&to=now" width="100%" height="400" frameborder="0"></iframe>
<?php       
} else {
	echo 'This graph is not implemented';
}
?>
