<footer class="footer p-3 mt-auto bg-dark" style="display:none">
    <div class="navbar-nav w-100 text-light text-center">
        <div>
            <small>
                <?php if( Auth::check() && Auth::getUser()->isSuperUser() ): ?>
                    Generated in
                    <?= sprintf( "%0.3f", microtime(true) - APPLICATION_STARTTIME ) ?>
                    seconds
                <?php else: ?>
                    Copyright &copy; 2009 - <?= now()->format('Y') ?> Internet Neutral Exchange Association CLG
                <?php endif; ?>
            </small>
        </div>
    </div>
</footer>
