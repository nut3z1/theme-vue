    <!-- Vue AppFooter mounts here -->
    <?php if ( ! ( is_account_page() && ! is_user_logged_in() ) ) : ?>
        <div id="vue-footer"></div>
    <?php endif; ?>

</div><!-- #vue-app -->

<?php wp_footer(); ?>
</body>
</html>
