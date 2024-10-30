<div class="wrap">

<h2>Mailchimp for Shopified</h2>

<h3>Newsletter Hook Options</h3>

<form method="post" action="options.php">

<?php settings_fields( 'mcsf-settings-group' ); ?>

<?php do_settings_sections( 'mcsf-settings-group' ); ?>

<table class="form-table">

<tr valign="top">

<th scope="row">Mailchimp API Key</th>

<td><input type="text" name="mcsf_api_key" value="<?php echo get_option('mcsf_api_key'); ?>" /></td>

</tr>

<tr valign="top">

<th scope="row">Subscribe List ID</th>

<td><input type="text" name="mcsf_list_id" value="<?php echo get_option('mcsf_list_id'); ?>" /></td>

</tr>


</table>

<?php submit_button(); ?>

</form>

</div>