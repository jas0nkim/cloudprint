    <div id="footer">
        <ul id="footer_nav">
            <?php if ($this->auth->is_logged_in()): ?>
            <li><?php echo anchor('members/logout', 'Logout'); ?></li>
            <?php endif; ?>
            <li><?php echo anchor('#', 'Contact'); ?></li>
            <?php if (!$this->auth->is_logged_in()): ?>
            <li><?php echo anchor('members/forgot/password', 'Forgot Password'); ?></li>
            <li><?php echo anchor('members/forgot/username', 'Forgot Username'); ?></li>
            <li><?php echo anchor('members/forgot', 'Forgot'); ?></li>
            <li><?php echo anchor('members/register', 'Register'); ?></li>
            <li><?php echo anchor('members/login', 'Login'); ?></li>
            <?php endif; ?>
            <li><?php echo anchor('members', 'Members'); ?></li>
            <li><?php echo anchor('#', 'About'); ?></li>
            <li><?php echo anchor(base_url(), 'Home'); ?></li>
        </ul>
    </div>
</body>
</html>