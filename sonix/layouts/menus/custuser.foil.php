<?php

use PragmaRX\Google2FALaravel\Support\Authenticator as GoogleAuthenticator;

?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <?= $this->insert('layouts/ixp-logo-header'); ?>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-ellipsis-v"></i>
    </button>

    <?php
        // hide most things until 2fa complete:
        $authenticator = new GoogleAuthenticator( request() );

        if( !Auth::getUser()->user2FA || !Auth::getUser()->user2FA->enabled || $authenticator->isAuthenticated() ):
    ?>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item <?= !request()->is( 'dashboard' ) ?: 'active' ?>">
                <a class="nav-link" href="<?= url('') ?>">
                   Home
                </a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= !request()->is( 'customer/*' , 'switch/configuration', 'docstore/*' ) ?: 'active' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?= ucfirst( config( 'ixp_fe.lang.customer.one' ) ) ?> Information
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item <?= !request()->is( 'customer/details' ) ?: 'active' ?>" href="<?= route('customer@details') ?>">
                        <?= ucfirst( config( 'ixp_fe.lang.customer.one' ) ) ?> Details
                    </a>
                    <a class="dropdown-item <?= !request()->is( 'customer/associates' ) ?: 'active' ?>" href="<?= route( "customer@associates" ) ?>">
                        Associate <?= ucfirst( config( 'ixp_fe.lang.customer.many' ) ) ?>
                    </a>
                    <a class="dropdown-item <?= !request()->is( 'switch/configuration' ) ?: 'active' ?>" href="<?= route('switch@configuration') ?>">
                        Switch Configuration
                    </a>

                    <?php if( !config( 'ixp_fe.frontend.disabled.docstore' ) && \IXP\Models\DocstoreDirectory::getHierarchyForUserClass( \IXP\Models\User::AUTH_CUSTUSER ) ): ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?= request()->is( 'docstore*' ) && !request()->is( 'docstorec*' ) ? 'active' : '' ?>" href="<?= route('docstore-dir@list' ) ?>">
                            Document Store
                        </a>
                    <?php endif; ?>

                    <?php if( !config( 'ixp_fe.frontend.disabled.docstore_customer' ) && \IXP\Models\DocstoreCustomerFile::getListingForAllDirectories( Auth::getUser()->custid,\IXP\Models\User::AUTH_CUSTUSER )  ): ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item <?= !request()->is( 'docstore-c*' ) ?: 'active' ?>" href="<?= route('docstore-c-dir@list', [ 'cust' => Auth::getUser()->custid ] ) ?>">
                            My Documents
                        </a>
                    <?php endif; ?>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= !request()->is( 'peering-manager' , 'lg', 'peering-matrix', 'rs-prefixes/list' ) ?: 'active' ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Peering
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php if( !config( 'ixp_fe.frontend.disabled.peering-manager', false ) ): ?>
                        <a class="dropdown-item <?= !request()->is( 'peering-manager' ) ?: 'active' ?>" href="<?= route('peering-manager@index') ?>">
                            Peering Manager
                        </a>
                    <?php endif; ?>
                    <?php if( !config( 'ixp_fe.frontend.disabled.rs-prefixes', false ) ): ?>
                        <?php if( Auth::getUser()->customer->routeServerClient() ): ?>
                            <a class="dropdown-item <?= !request()->is( 'rs-prefixes/list' ) ?: 'active' ?>" href="<?= route('rs-prefixes@list') ?>">
                                Route Server Prefixes
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if( !config('ixp_fe.frontend.disabled.lg' ) ): ?>
                        <a class="dropdown-item <?= !request()->is( 'lg'  ) ?: 'active' ?>" href="<?= url('lg') ?>">
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
        </ul>

        <ul class="navbar-nav mt-lg-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?= !request()->is( 'profile' , 'api-key/list' ) ?: 'active' ?>" href="#" id="my-account" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    My Account
                </a>
                <ul class="dropdown-menu dropdown-menu-right" id="my-account-dd">
                    <a id="profile" class="dropdown-item <?= !request()->is( 'profile' ) ?: 'active' ?>" href="<?= route( 'profile@edit' ) ?>">
                        Profile
                    </a>

                    <a class="dropdown-item <?= !request()->is( 'api-key/list' ) ?: 'active' ?>" href="<?= route('api-key@list' )?>">
                        API Keys
                    </a>

                    <a id="active-sessions" class="dropdown-item <?= !request()->is( 'active-sessions/list' ) ?: 'active' ?>" href="<?= route('active-sessions@list' )?>">
                        Active Sessions
                    </a>

                    <?php $customers = Auth::getUser()->customers()->active()->notDeleted()->get(); ?>
                    <?php if( $customers->count() > 1 ): ?>
                        <div class="dropdown-divider"></div>

                        <h6 class="dropdown-header">
                            Switch to:
                        </h6>

                        <?php foreach( $customers as $cust ): ?>
                            <a id="switch-cust-<?= $cust->id ?>" class="dropdown-item <?= Auth::getUser()->custid !== $cust->id ?: 'active cursor-default' ?>"
                                <?= Auth::getUser()->custid !== $cust->id ?: "onclick='return false;'" ?>
                               href="<?= Auth::getUser()->custid === $cust->id ? '#' : route( 'switch-customer@switch' , [ "cust" => $cust->id ]  ) ?>">
                                <?= $cust->name ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <div class="dropdown-divider"></div>

                    <a id="logout" class="dropdown-item" href="<?= route( 'login@logout' ) ?>">
                        Logout
                    </a>
                </ul>
            </li>

            <li class="nav-item">
                <?php if( session()->exists( "switched_user_from" ) ): ?>
                    <a class="nav-link" href="<?= route( 'switch-user@switchBack' ) ?>">
                        Switch Back
                    </a>
                <?php else: ?>
                    <a class="nav-link" href="<?= route( 'login@logout' ) ?>">
                        Logout
                    </a>
                <?php endif; ?>
            <li>
        </ul>
    </div>

    <?php endif; // 2fa test at very top ?>

</nav>
