<?php
    /** @var Foil\Template\Template $t */
    $this->layout( 'layouts/ixpv4' )
?>

<?php $this->section( 'page-header-preamble' ) ?>
    VLAN Graphs - <?= $t->vlan->name ?> (<?= IXP\Services\Grapher\Graph::resolveProtocol( $t->protocol ) ?>)
<?php $this->append() ?>

<?php $this->section( 'content' ) ?>
    <div class="row">
        <div class="col-md-12">
            <?= $t->alerts() ?>
            <div class="alert alert-info" role="alert">
                <div class="d-flex align-items-center">
                    <div class="text-center">
                        <i class="fa fa-info-circle fa-2x"></i>
                    </div>
                        Redirecting you to <a href="<?= route( 'statistics@infrastructure' ) ?>">infrastructure graphs</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->append() ?>

<?php $this->section( 'scripts' ) ?>
    <script>
    	window.location = "<?= route( 'statistics@infrastructure' ) ?>";
    </script>
<?php $this->append() ?>
