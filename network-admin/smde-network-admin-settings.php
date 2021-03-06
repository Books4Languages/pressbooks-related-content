<?php

/**
 * Network settings functionality
 *
 * Description. (use period)
 *
 * @link URL
 *
 * @package simple-metadata-education
 * @subpackage network-admin/settings
 * @since x.x.x (when the file was introduced)
 */



use \vocabularies\SMDE_Metadata_Educational as edu_meta;
use \vocabularies\SMDE_Metadata_Classification as class_meta;

defined ("ABSPATH") or die ("No script assholes!");

/**
* Function for adding network settings page.
*
* @since
*
*/

function smde_add_network_settings() {

  //adding settings metaboxes and settigns sections
  add_meta_box('smde-network-metadata-for-lang', __('Languages education', 'simple-metadata-education'), 'smde_network_render_metabox_for_lang', 'smd_net_set_page', 'normal', 'core');
  add_meta_box('smde-metadata-network-location', __('Educational Metadata', 'simple-metadata-education'), 'smde_network_render_metabox_schema_locations', 'smd_net_set_page', 'normal', 'core');
  add_meta_box('smde-network-metadata-edu-properties', __('Educational Properties Management', 'simple-metadata-education'), 'smde_network_render_metabox_edu_properties', 'smd_net_set_page', 'normal', 'core');



  add_settings_section( 'smde_network_meta_locations', '', '', 'smde_network_meta_locations' );

  add_settings_section( 'smde_network_meta_edu_properties', __('Educational Properties', 'simple-metadata-education'), '', 'smde_network_meta_edu_properties' );
  add_settings_section( 'smde_network_meta_class_properties', __('Classification Properties', 'simple-metadata-education'), '', 'smde_network_meta_edu_properties' );

  add_settings_section( 'smde_network_meta_for_lang', '', '', 'smde_network_meta_for_lang' );

  //registering settings
  add_site_option ( 'smde_net_locations', '');
  add_site_option ( 'smde_net_for_lang', '');
  add_site_option ( 'smde_net_edu_', '');
  add_site_option ( 'smde_net_class_', '');

	// getting options values from DB
	$post_types = smd_get_all_post_types();
	$locations = get_site_option('smde_net_locations');

  $is_for_lang =  get_site_option('smde_net_for_lang');
  $props_edu = (array) get_site_option('smde_net_edu_');
  $props_class = (array) get_site_option('smde_net_class_');

	//adding settings for locations
	foreach ($post_types as $post_type) {

		//creating labels for settings
		if ('metadata' == $post_type){
			$label = 'Book Info';
		} else {
			$label = ucfirst($post_type);
		}

		add_settings_field ('smde_net_locations['.$post_type.']', $label, function () use ($post_type, $locations){
			$checked = isset($locations[$post_type]) ? true : false;
			?>
				<input type="checkbox" name="smde_net_locations[<?=$post_type?>]" id="smde_net_locations[<?=$post_type?>]" value="1" <?php checked(1, $checked);?>>
			<?php
		}, 'smde_network_meta_locations', 'smde_network_meta_locations');
	}

	//adding settings for educational properties management
	foreach (edu_meta::$edu_properties as $key => $data) {

		add_settings_field ('smde_net_edu_'.$key, ucfirst($data[0]), function () use ($key, $data, $props_edu){

      $props_edu[$key] = !empty($props_edu[$key]) ? $props_edu[$key] : '0';

			?>
      <?php if ($props_edu[$key]=='1') {
        if (isset($_GET['hello'])) {

        function runMyFunction8() {
          if (isset($_GET['field_name'])) {
            $key = $_GET['field_name'];

              global $wpdb;
                 //If we have more than one or 0 ids in the array then return and stop operation
                 //If we have no chapters or posts to distribute data also stop operation
                 $prefixx = $wpdb->prefix;
                 $post_meta_texte = "_postmeta";
                 $prefixx_blog =$prefixx.'blogs';

                 //getting metadata of site-meta/books info post
                 $select_all_id_blogs = $wpdb->get_results("
                     SELECT blog_id FROM $prefixx_blog",ARRAY_N);
                  foreach ($select_all_id_blogs as $key1 => $valuee) {
                    $postMetaTable = $prefixx . $valuee[0] . $post_meta_texte;
                    $metadata_meta_key_site = 'smde_'.strtolower($key).'_edu_vocabs_';
                $recuperation_de_la_table = $wpdb->get_results("
                    DELETE FROM $postMetaTable  WHERE meta_key like '%{$metadata_meta_key_site}%' ");


                  }
          }
}

runMyFunction8();
//refresh the page
?> <meta http-equiv="refresh" content="0;URL=admin.php?page=smd_net_set_page"><?php
}
if ($props_edu[$key]=='1') {
echo "<a onClick=\"javascript: return confirm('Are you sure to delete all meta-data of this field in the all sites?');\" style='color:red; text-decoration: none; font-size: 14px;'href = 'admin.php?page=smd_net_set_page&hello=true&field_name=$key'>X</a>";}

?>
      &nbsp;&nbsp;
    <?php } ?>

      <label for="smde_net_edu_disable[<?=$key?>]"><?php esc_html_e('Disable', 'simple-metadata-education');?> <input type="radio"  name="smde_net_edu_[<?=$key?>]" value="1" id="smde_net_edu_disable[<?=$key?>]" <?php if ($props_edu[$key]=='1') { echo "checked='checked'"; }
      ?>  ></label>
      <label for="smde_net_edu_local_value[<?=$key?>]"><?php esc_html_e('Local value', 'simple-metadata-education');?> <input type="radio"  name="smde_net_edu_[<?=$key?>]" value="0" id="smde_net_edu_local_value[<?=$key?>]" <?php if ($props_edu[$key]=='0') { echo "checked='checked'"; }
      ?>   ></label>
      <label  for="smde_net_edu_share[<?=$key?>]"><?php esc_html_e('Share', 'simple-metadata-education');?> <input type="radio"  name="smde_net_edu_[<?=$key?>]" value="2" id="smde_net_edu_share[<?=$key?>]" <?php if ($props_edu[$key]=='2') { echo "checked='checked'"; }
      ?>></label>
      <label for="smde_net_edu_freeze[<?=$key?>]"><?php esc_html_e('Freeze', 'simple-metadata-education');?> <input type="radio"  name="smde_net_edu_[<?=$key?>]" value="3" id="smde_net_edu_freeze[<?=$key?>]"  <?php if ($props_edu[$key]=='3') { echo "checked='checked'"; }
      ?> ></label>
        <br><span class="description"><?=$data[1]?></span>
      <?php
      //if checkboxes are disabled, we add hidden field to store value of option
    }, 'smde_network_meta_edu_properties', 'smde_network_meta_edu_properties');
	}

  //adding settings for classification properties management
  foreach (class_meta::$classification_properties_main as $key => $data) {

    //we do not add option for 'specificClass' property (no need to control it)
    if ('specificClass' == $key ){
    		continue;
    }

    // Skip eduLang because is only for language Content
    if('eduLang' ==	$key && !get_site_option('smde_net_for_lang')){
      continue;
    }


    if('prerequisite' == $key){
      add_settings_field ('smde_net_class_'.$key, '', function (){
          ?>
            <tr><th scope="row" style="font-size:16px">Prerequisite </th></tr>
          <?php
      }, 'smde_network_meta_edu_properties', 'smde_network_meta_class_properties');
      continue;
    }

  	if (get_site_option('smde_net_for_lang') && ('eduFrame' == $key || 'iscedField' == $key)){
  			continue;
  	}

  	add_settings_field ('smde_net_class_'.$key, ucfirst($data[0]), function () use ($key, $data, $props_class){

      $props_class[$key] = !empty($props_class[$key]) ? $props_class[$key] : '0';

  ?>
  <?php if ($props_class[$key]=='1') {
    if (isset($_GET['hello25'])) {

    function runMyFunction88() {
      if (isset($_GET['field_name'])) {
        $key = $_GET['field_name'];

          global $wpdb;
             //If we have more than one or 0 ids in the array then return and stop operation
             //If we have no chapters or posts to distribute data also stop operation
             $prefixx = $wpdb->prefix;
             $post_meta_texte = "_postmeta";
             $prefixx_blog =$prefixx.'blogs';


             //getting metadata of site-meta/books info post
             $select_all_id_blogs = $wpdb->get_results("
                 SELECT blog_id FROM $prefixx_blog",ARRAY_N);
              foreach ($select_all_id_blogs as $key1 => $valuee) {
                $postMetaTable = $prefixx . $valuee[0] . $post_meta_texte;
                $metadata_meta_key_site = 'smde_'.strtolower($key).'_class_vocab_';
            $recuperation_de_la_table = $wpdb->get_results("
                DELETE FROM $postMetaTable  WHERE meta_key like '%{$metadata_meta_key_site}%' ");


              }
      }
  }

  runMyFunction88();
  //refresh the page
  ?> <meta http-equiv="refresh" content="0;URL=admin.php?page=smd_net_set_page"><?php
  }
  if ($props_class[$key]=='1') {
  echo "<a onClick=\"javascript: return confirm('Are you sure to delete all meta-data of this field in the all sites?');\" style='color:red; text-decoration: none; font-size: 14px;'href = 'admin.php?page=smd_net_set_page&hello25=true&field_name=$key'>X</a>";}

  ?>
  &nbsp;&nbsp;
  <?php } ?>
      <label for="smde_net_class_disable[<?=$key?>]"><?php esc_html_e('Disable', 'simple-metadata-education'); ?> <input type="radio"  name="smde_net_class_[<?=$key?>]" value="1" id="smde_net_class_disable[<?=$key?>]" <?php if ($props_class[$key]=='1') { echo "checked='checked'"; }
      ?>></label>
      <label for="smde_net_class_local_value[<?=$key?>]"><?php esc_html_e('Local value', 'simple-metadata-education'); ?> <input type="radio"  name="smde_net_class_[<?=$key?>]" value="0" id="smde_net_class_local_value[<?=$key?>]" <?php if ($props_class[$key]=='0') { echo "checked='checked'"; }
      ?>   ></label>
      <label  for="smde_net_class_share[<?=$key?>]"><?php esc_html_e('Share', 'simple-metadata-education'); ?> <input type="radio"  name="smde_net_class_[<?=$key?>]" value="2" id="smde_net_class_share[<?=$key?>]" <?php if ($props_class[$key]=='2') { echo "checked='checked'"; }
      ?> ></label>
      <label for="smde_net_class_freeze[<?=$key?>]"><?php esc_html_e('Freeze', 'simple-metadata-education'); ?> <input type="radio"  name="smde_net_class_[<?=$key?>]" value="3" id="smde_net_class_freeze[<?=$key?>]"  <?php if ($props_class[$key]=='3') { echo "checked='checked'"; }
      ?> ></label>
        <br><span class="description"><?=$data[1]?></span>
      <?php
  	}, 'smde_network_meta_edu_properties', 'smde_network_meta_class_properties');
  }

  /*
  if (get_site_option('smde_net_for_lang')){
    add_settings_field ('smde_net_class_shares[eduLang]', __('Studying content', 'simple-metadata-annotation'), function () use ($key, $props_class){

      $key = 'eduLang';
      $props_class[$key] = !empty($props_class[$key]) ? $props_class[$key] : '0';

      ?>
      <label for="smde_net_class_disable[<?=$key?>]">
        <?php esc_html_e('Disable', 'simple-metadata-education'); ?>
        <input type="radio"  name="smde_net_class_[<?=$key?>]" value="1" id="smde_net_class_disable[<?=$key?>]" <?php if ($props_class[$key]=='1') { echo "checked='checked'"; } ?> >
      </label>
      <label for="smde_net_class_local_value[<?=$key?>]">
        <?php esc_html_e('Local value', 'simple-metadata-education'); ?>
        <input type="radio"  name="smde_net_class_[<?=$key?>]" value="0" id="smde_net_class_local_value[<?=$key?>]" <?php if ($props_class[$key]=='0') { echo "checked='checked'"; } ?>  >
      </label>
      <label  for="smde_net_class_share[<?=$key?>]">
        <?php esc_html_e('Share', 'simple-metadata-education'); ?>
        <input type="radio"  name="smde_net_class_[<?=$key?>]" value="2" id="smde_net_class_share[<?=$key?>]" <?php if ($props_class[$key]=='2') { echo "checked='checked'"; }?> >
      </label>
      <label for="smde_net_class_freeze[<?=$key?>]">
        <?php esc_html_e('Freeze', 'simple-metadata-education'); ?>
        <input type="radio"  name="smde_net_class_[<?=$key?>]" value="3" id="smde_net_class_freeze[<?=$key?>]"  <?php if ($props_class[$key]=='3') { echo "checked='checked'"; }?>>
      </label>
        <br>
        <span class="description"><?php esc_html_e('Language which content is about', 'simple-metadata-education'); ?></span>
      <?php
    }, 'smde_network_meta_edu_properties', 'smde_network_meta_class_properties');
  }
  */

	//adding setting for languages education
	add_settings_field ('smde_net_for_lang', __('Content is for languages education', 'simple-metdata-education'), function () use ($is_for_lang){
			$checked = $is_for_lang ? true : false;
			?>
				<input type="checkbox" name="smde_net_for_lang" id="smde_net_for_lang" value="1" <?php checked(1, $checked);?>>
			<?php
		}, 'smde_network_meta_for_lang', 'smde_network_meta_for_lang');
}

/**
* Function for rendering network settings page.
*
* @since
*
*/

function smde_render_network_settings(){
	wp_enqueue_script('common');
		wp_enqueue_script('wp-lists');
		wp_enqueue_script('postbox');
	    ?>
	    <div class="wrap">
	    	<?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) { //in case settings were saved, we show notice?>
        	<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e('Settings saved.', 'simple-metadata-education'); ?></strong></p>
			</div>
			<?php } ?>
		    <div class="metabox-holder">
			    <?php
			    	do_meta_boxes('smde_net_set_page', 'normal','');
			    ?>
		    </div>
	    </div>
	    <script type="text/javascript">
            //<![CDATA[
            jQuery(document).ready( function($) {
                // close postboxes that should be closed
                $('.if-js-closed').removeClass('if-js-closed').addClass('closed');
                // postboxes setup
                postboxes.add_postbox_toggles('<?php echo 'smde_net_set_page'; ?>');
            });
            //]]>
		</script>
		<?php
}

/**
* Function for rendering metabox of locations.
*
* @since
*
*/

function smde_network_render_metabox_schema_locations(){
	?>
	<div id="smde_network_meta_locations" class="smde_network_meta_locations">
		<span class="description">
      <?php esc_html_e('Activate the public post types where metadata will be available.', 'simple-metadata-education'); ?>
      <br>
      <?php esc_html_e('If selected, site administrators can not modify.', 'simple-metadata-education'); ?>

    </span>
		<form method="post" action="edit.php?action=smde_update_network_locations">
			<?php
			settings_fields( 'smde_network_meta_locations' );
			do_settings_sections( 'smde_network_meta_locations' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>
	<?php
}

/**
* Function for rendering metabox for properties management.
*
* @since
*
*/

function smde_network_render_metabox_edu_properties(){
	?>
	<div id="smde_network_meta_edu_properties" class="smde_network_meta_edu_properties">
		<span class="description">
      <?php esc_html_e('Control of the properties over the subsites.', 'simple-metadata-education'); ?>
    </span>
		<form method="post" action="edit.php?action=smde_update_network_options">
			<?php
			settings_fields( 'smde_network_meta_edu_properties' );
			do_settings_sections( 'smde_network_meta_edu_properties' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>
	<?php
}

/**
* Function for rendering metabox for properties management.
*
* @since
*
*/

function smde_network_render_metabox_for_lang(){
	?>
	<div id="smde_network_meta_for_lang" class="smde_network_meta_for_lang">
		<span class="description">
      <?php esc_html_e('If activate, some of the educational descriptions would be related to languages. Like levels (A1, A2..) or fields of education.', 'simple-metadata-education'); ?>
    </span>
		<form method="post" action="edit.php?action=smde_update_network_for_lang">
			<?php
			settings_fields( 'smde_network_meta_for_lang' );
			do_settings_sections( 'smde_network_meta_for_lang' );
			submit_button();
			?>
		</form>
		<p></p>
	</div>
	<?php
}

/**
* Handler for locations settings update.
*
* @since
*
*/

function smde_update_network_locations() {

	//checking admin reffer to prevent direct access to this function
	check_admin_referer('smde_network_meta_locations-options');

	//Wordpress Database variable for database operations
    global $wpdb;

    //collecting locations accumulative option from POST request
	$locations = isset($_POST['smde_net_locations']) ? $_POST['smde_net_locations'] : array();

	 //collecting locations of general meta accumulative option from POST request
	$locations_general = get_site_option('smd_net_locations') ?: array();

	$locations_general = array_merge($locations_general, $locations);

	if (isset($locations_general['metadata'])){
		unset($locations_general['metadata']);
	}
	if (isset($locations_general['site-meta'])){
		unset($locations_general['site-meta']);
	}

	//updating network locations option
	update_site_option('smde_net_locations', $locations);
	update_site_option('smd_net_locations', $locations_general);

	//Grabbing all the site IDs
    $siteids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

    //Going through the sites and updating active locations site-by-site
    foreach ($siteids as $site_id) {
    	if (1 == $site_id){
    		continue;
    	}

    	switch_to_blog($site_id);

    	//getting blog active lcoations
    	$locations_local = get_option('smde_locations') ?: array();
    	$locations_local_general = get_option('smd_locations') ?: array();

    	//we merge active locations of blog with active locations from network settings
    	$locations_local = array_merge($locations_local, $locations);
    	$locations_local_general = array_merge($locations_local_general, $locations_general);

    	update_option('smde_locations', $locations_local);
    	update_option('smd_locations', $locations_local_general);

    }

    restore_current_blog();

	// At the end we redirect back to our options page.
    wp_redirect(add_query_arg(array('page' => 'smd_net_set_page',
    'settings-updated' => 'true'), network_admin_url('settings.php')));

    exit;
}

/**
* Handler for properties settings update.
*
* @since
*
*/

function smde_update_network_options() {
exit;
	//checking admin reffer to prevent direct access to this function (TEMPORALY DEACTIVATED) #issue #18  v1.2.1
  //check_admin_referer('smde_network_meta_edu_properties-options');

	//Wordpress Database variable for database operations
    global $wpdb;

    //collecting sharing and freezeing options for educational propertis and classification form POST request
    $props_edu = isset($_POST['smde_net_edu_']) ? $_POST['smde_net_edu_'] : array();
    //if property is frozen, it's automatically shared
    $props_class = isset($_POST['smde_net_class_']) ? $_POST['smde_net_class_'] : array();

    //updating network options
	update_site_option('smde_net_edu_', $props_edu);
	update_site_option('smde_net_class_', $props_class);

	//Grabbing all the site IDs
    $siteids = $wpdb->get_col("SELECT blog_id FROM $wpdb->blogs");

    //Going through the sites
    foreach ($siteids as $site_id) {

    	if (1 == $site_id){
    		continue;
    	}

    	switch_to_blog($site_id);

    	//collecting local blog options values and merge them with ones from network settings

    	$props_local = get_option('smde_edu_') ?: array();
    	$props_local = array_merge($props_local, $props_edu);

    	$props_local_class = get_option('smde_class_') ?: array();
    	$props_local_class = array_merge($props_local_class, $props_class);

    	//updating local options
    	update_option('smde_edu_', $props_local);
    	update_option('smde_class_', $props_local_class);

    	smde_update_overwrites();
    }

    restore_current_blog();

	// At the end we redirect back to our options page.
    wp_redirect(add_query_arg(array('page' => 'smd_net_set_page',
    'settings-updated' => 'true'), network_admin_url('settings.php')));

    exit;
}

/**
* Handler for type of education update.
*
* @since
*
*/

function smde_update_network_for_lang() {
	//checking admin reffer to prevent direct access to this function
	check_admin_referer('smde_network_meta_for_lang-options');

	$is_for_languages = isset($_POST['smde_net_for_lang']) ? $_POST['smde_net_for_lang'] : '';
	update_site_option('smde_net_for_lang', $is_for_languages);

	// At the end we redirect back to our options page.
    wp_redirect(add_query_arg(array('page' => 'smd_net_set_page',
    'settings-updated' => 'true'), network_admin_url('settings.php')));

    //exit;  (DISABLED)  so following 'smde_update_network_options' function is executable #issue #18  v1.2.1
}


add_action( 'network_admin_menu', 'smde_add_network_settings', 1000);
add_action( 'network_admin_edit_smde_update_network_locations', 'smde_update_network_locations');
add_action( 'network_admin_edit_smde_update_network_options', 'smde_update_network_options');

add_action( 'network_admin_edit_smde_update_network_for_lang', 'smde_update_network_for_lang');
add_action( 'network_admin_edit_smde_update_network_for_lang', 'smde_update_network_options', 11); // runs right after 'language education' metabox is saved #issue #18  v1.2.1
