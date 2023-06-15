<h1>S7design Theme Options</h1>
<?php settings_errors(); ?>
<form method="post" action="options.php">
	<?php settings_fields( 's7design-settings-group' ); ?>
	<?php do_settings_sections( 's7design_option' ); ?>
	<?php submit_button(); ?>
</form>