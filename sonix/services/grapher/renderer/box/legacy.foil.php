<!-- Graph class type: "<?= $t->graph->classType() ?>" -->
<?php

$categoryMap = array();
$categoryMap['bits'] = 2;
$categoryMap['pkts'] = 5;
$categoryMap['errs'] = 3;
$categoryMap['discs'] = 6;
$categoryMap['bcasts'] = 4;

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
<iframe src="https://metric.sonix.network/grafana/d-solo/OYlR2m47z/overview?orgId=1&theme=light&from=now-<?=$gfp?>&to=now&panelId=5" width="100%" height="400" frameborder="0"></iframe>
<?php

} else if ($gfp != "" && $t->graph->classType() == "Infrastructure") {
	if ($t->graph->infrastructure()->id === 1) {
                ?> 
		<iframe src="https://metric.sonix.network/grafana/d-solo/OYlR2m47z/overview?orgId=1&theme=light&var-ixp=ixp-(kn7%7Ckg%7Cixn)-.*&from=now-<?=$gfp?>&to=now&panelId=5" width="100%" height="400" frameborder="0"></iframe>
                <?php
        }
	else if ($t->graph->infrastructure()->id === 2) {
                ?>
		<iframe src="https://metric.sonix.network/grafana/d-solo/OYlR2m47z/overview?orgId=1&theme=light&var-ixp=ixp-(shg5)-.*&from=now-<?=$gfp?>&to=now&panelId=5" width="100%" height="400" frameborder="0"></iframe>
                <?php
        }


// Smokeping or sFlow graphs
} else if ($t->graph->classType() === "Smokeping" || $t->graph->classType() == "VlanInterface") { ?>

    <img width="100%" border="0" src="data:image/png;base64,<?=base64_encode( $t->graph->png() )?>" />

<?php
} else {
	echo 'This graph is not implemented';
}
?>
