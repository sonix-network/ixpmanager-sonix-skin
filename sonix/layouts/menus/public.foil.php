<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?= $this->insert('layouts/ixp-logo-header'); ?>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-ellipsis-v"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <?php if( config( 'ixp_fe.customer.details_public') ): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= !request()->is( 'customer/details', 'customer/associates' ) ?: 'active' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= ucfirst( config( 'ixp_fe.lang.customer.one' ) ) ?> Information
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item <?= !request()->is( 'customer/details' ) ?: 'active' ?>" href="<?= route('customer@details') ?>">
                            <?= ucfirst( config( 'ixp_fe.lang.customer.one' ) ) ?> Details
                        </a>
                        <a class="dropdown-item <?= !request()->is( 'customer/associates' ) ?: 'active' ?>" href="<?= route( "customer@associates" ) ?>">
                            Associate <?= ucfirst( config( 'ixp_fe.lang.customer.many' ) ) ?>
                        </a>

                        <?php if( !config( 'ixp_fe.frontend.disabled.docstore' ) && \IXP\Models\DocstoreDirectory::getHierarchyForUserClass( \IXP\Models\User::AUTH_PUBLIC ) ): ?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item <?= !request()->is( 'docstore*' ) ?: 'active' ?>" href="<?= route('docstore-dir@list' ) ?>">
                                Document Store
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endif; ?>

            <?php if( !config('ixp_fe.frontend.disabled.lg' ) && ixp_min_auth( config( 'ixp.peering-matrix.min-auth' ) ) && !config( 'ixp_fe.frontend.disabled.peering-matrix', false ) ): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= !request()->is( 'lg', 'peering-matrix' ) ?: 'active' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Peering
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if( !config('ixp_fe.frontend.disabled.lg' ) ): ?>
                            <a class="dropdown-item <?= !request()->is( 'lg' ) ?: 'active' ?>" href="<?= url('lg') ?>">
                                Looking Glass
                            </a>
                        <?php endif; ?>
                        <?php if( ixp_min_auth( config( 'ixp.peering-matrix.min-auth' ) ) && !config( 'ixp_fe.frontend.disabled.peering-matrix', false ) ): ?>
                            <a class="dropdown-item <?= !request()->is( 'peering-matrix' ) ?: 'active' ?>" href="<?= route('peering-matrix@index') ?>">
                                Peering Matrix
                            </a>
                        <?php endif; ?>
                    </div>
                </li>
            <?php endif; ?>
        </ul>
        <ul class="navbar-nav mt-lg-0">
            <li class="nav-item">
                <?php if( Auth::check() ): ?>
                    <a class="nav-link" href="<?= route( 'login@logout' ) ?>">
                        Logout
                    </a>
                <?php else: ?>
                    <a class="nav-link <?= !request()->is( 'login' ) ?: 'active' ?>" href="<?= route( 'login@showForm' ) ?>">
                        Login
                    </a>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</nav>
