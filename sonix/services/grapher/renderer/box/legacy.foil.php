<!-- Graph class type: "<?= $t->graph->classType() ?>" -->
<?php
// SONIX skin: replace RRD/MRTG image graphs with Grafana panels
// from https://metric.sonix.network/grafana/

$categoryMap = [
    'bits'   => 2,
    'pkts'   => 5,
    'errs'   => 3,
    'discs'  => 6,
    'bcasts' => 4,
];

$categoryMapSflow = [
    'bits' => 2,
    'pkts' => 3,
];

// IXP Manager period -> Grafana relative time range ('custom' falls back to 24h)
$gfp = match( $t->graph->period() ) {
    'week'  => '7d',
    'month' => '30d',
    'year'  => '1y',
    default => '24h',
};

if( $t->graph->classType() === "Customer" ):
    foreach( $t->graph->customer()->virtualInterfaces as $vi ):
        if( !( $swp = $vi->switchPort() ) ) {
            continue;
        }
        ?>
        <iframe src="https://metric.sonix.network/grafana/d-solo/laG5Khxnk/interface-details?orgId=1&theme=light&var-switch=<?= $swp->switcher->name ?>.sonix.network&var-interface=<?= $swp->name ?>&from=now-<?= $gfp ?>&to=now&panelId=<?= $categoryMap[ $t->graph->category() ] ?>"
            width="100%" height="400" frameborder="0"></iframe>
    <?php endforeach; ?>

<?php elseif( $t->graph->classType() === "PhysicalInterface" ): ?>
    <?php $swp = $t->graph->physicalInterface()->switchPort; ?>
    <iframe src="https://metric.sonix.network/grafana/d-solo/laG5Khxnk/interface-details?orgId=1&theme=light&var-switch=<?= $swp->switcher->name ?>.sonix.network&var-interface=<?= $swp->name ?>&from=now-<?= $gfp ?>&to=now&panelId=<?= $categoryMap[ $t->graph->category() ] ?>"
        width="100%" height="400" frameborder="0"></iframe>

<?php elseif( $t->graph->classType() === "IXP" ): ?>
    <iframe src="https://metric.sonix.network/grafana/d-solo/jKdZekQ4z/overview?orgId=1&theme=light&from=now-<?= $gfp ?>&to=now&panelId=5"
        width="100%" height="400" frameborder="0"></iframe>

<?php elseif( $t->graph->classType() === "Infrastructure" ): ?>
    <?php
        // Filter the overview panel to this infrastructure's switches
        $ixpFilter = urlencode( '(' . $t->graph->infrastructure()->switchers->pluck( 'name' )->implode( '|' ) . ')' );
    ?>
    <iframe src="https://metric.sonix.network/grafana/d-solo/jKdZekQ4z/overview?orgId=1&theme=light&var-ixp=<?= $ixpFilter ?>&from=now-<?= $gfp ?>&to=now&panelId=5"
        width="100%" height="400" frameborder="0"></iframe>

<?php elseif( $t->graph->classType() === "VlanInterface" ): ?>
    <iframe src="https://metric.sonix.network/grafana/d-solo/YYcB1DwVz/sflow?orgId=1&theme=light&panelId=<?= $categoryMapSflow[ $t->graph->category() ] ?>&var-source_asn=<?= $t->graph->customer()->autsys ?>&var-destination_asn=All&from=now-<?= $gfp ?>&to=now"
        width="100%" height="400" frameborder="0"></iframe>

<?php else: ?>
    This graph is not implemented
<?php endif; ?>
