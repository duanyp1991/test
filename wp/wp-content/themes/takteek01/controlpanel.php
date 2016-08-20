<?php
//Original Framework http://theundersigned.net/2006/06/wordpress-how-to-theme-options/ 
//Updated and added additional options by Jeremy Clark
//http://clarktech.no-ip.com/

//arrays
$themename = "TAKTEEK01";
$shortname = "takte";
$options = array (
	array(
		"name" => "Header Text",
		"id" => $shortname."_headertext",
		"std" => "\"TAKTEEK01 Theme\" -Eric Crooks",
		"type" => "textarea"
	),
	array(
		"name" => "Toggle Header Text",
		"id" => $shortname."_headertext_toggle",
		"type" => "radio",
		"std" => "Toggle On",
		"options" => array("Toggle On", "Toggle Off")
	),
	array(
		"name" => "Header Image",
		"description" => "URL",
		"id" => $shortname."_headerimage",
		"type" => "text"
	),
	array(
		"name" => "Header Image Width",
		"description" => "Width",
		"id" => $shortname."_headerimage_width",
		"type" => "text"
	),
	array(
		"name" => "Header Image Height",
		"description" => "Height",
		"id" => $shortname."_headerimage_height",
		"type" => "text"
	),
	array(
		"name" => "Header Image Alt",
		"description" => "Alternate Text (Description of Image)",
		"id" => $shortname."_headerimage_alt",
		"type" => "text",
	),
	array(
		"name" => "Toggle Header Image",
		"id" => $shortname."_headerimage_toggle",
		"type" => "radio",
		"std" => "Toggle Off",
		"options" => array("Toggle On", "Toggle Off")
	)
);

//functions
function mytheme_add_admin() {
	global $themename, $shortname, $options;
		if ( $_GET['page'] == basename(__FILE__) ) {
			if ( 'save' == $_REQUEST['action'] ) {
				foreach ($options as $value) {
					update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
				foreach ($options as $value) {
					if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
				header("Location: themes.php?page=controlpanel.php&saved=true");
				die;
		}
		else if( 'reset' == $_REQUEST['action'] ) {
			foreach ($options as $value) {
				delete_option( $value['id'] ); 
				update_option( $value['id'], $value['std'] );}
			header("Location: themes.php?page=controlpanel.php&reset=true");
			die;
        }
    }
	add_theme_page($themename." Options", "Theme Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
}
function mytheme_admin() {
	global $themename, $shortname, $options;
	if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
	if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
?>

<!--tables-->
<div class="wrap">
	<h2 class="main"><?php echo $themename; ?> Options</h2>
	<form method="post">
		<table class="optiontable">
			<?php foreach ($options as $value) { if ($value['name'] == "Header Text") { ?>
			<tr> 
				<td>
					<h2 class="optiontitle"><?php echo $value['name']; ?></h2>
					<textarea name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" cols="40" rows="5"/><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'] )); } else { echo $value['std']; } ?></textarea>
				</td>
			</tr>
			<?php } elseif ($value['name'] == "Toggle Header Text") { ?>
			<tr> 
				<td>
					<?php foreach ($value['options'] as $option) { ?>
					<small><?php echo $option; ?></small> <input name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $option; ?>" <?php if ( get_settings( $value['id'] ) == $option) { echo 'checked'; } ?>/>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			<?php } ?>
		</table>
		<table class="optiontable">
			<?php foreach ($options as $value) { if ($value['name'] == "Header Image") { ?>
			<tr> 
				<td>
					<h2 class="optiontitle"><?php echo $value['name']; ?></h2>
					<p><small>You should fill in all the fields for an SEO friendly banner image.</small></p>
					<strong><?php echo $value['description']; ?></strong>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" size="40" />
				</td>
			</tr>
			<?php } elseif ($value['name'] == "Header Image Width") { ?>
			<tr> 
				<td>
					<strong><?php echo $value['description']; ?></strong>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" size="40" />
				</td>
			</tr>
			<?php } elseif ($value['name'] == "Header Image Height") { ?>
			<tr> 
				<td>
					<strong><?php echo $value['description']; ?></strong>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" size="40" />
				</td>
			</tr>
			<?php } elseif ($value['name'] == "Header Image Alt") { ?>
			<tr> 
				<td>
					<strong><?php echo $value['description']; ?></strong>
					<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" size="40" />
				</td>
			</tr>
			<?php } elseif ($value['name'] == "Toggle Header Image") { ?>
			<tr> 
				<td>
					<?php foreach ($value['options'] as $option) { ?>
					<small><?php echo $option; ?></small> <input name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php echo $option; ?>" <?php if ( get_settings( $value['id'] ) == $option) { echo 'checked'; } ?>/>
					<?php } ?>
				</td>
			</tr>
			<?php } ?>
			<?php } ?>
		</table>
		<div class="button-submit">
			<input name="save" type="submit" value="Save Changes" />    
			<input type="hidden" name="action" value="save" />
		</div>
	</form>
	<form method="post">
		<div class="button-submit">
			<input name="reset" type="submit" value="Reset Changes" />
			<input type="hidden" name="action" value="reset" />
		</div>
	</form>
	<div class="button-donate">
			<a class="donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&amp;hosted_button_id=4684931" target="_blank">Donate</a>
	</div>
	<div class="previewframe">
		<h2 class="main">Preview (updated when options are saved)</h2>
		<iframe src="../?preview=true" width="100%" height="400" ></iframe>
	</div>
</div>
<style type="text/css">
/*.wrap div.button-submit {
	float: left;
	}*/
.wrap div.button-submit input {
	background: #ff7700;
	border: 1px solid #ff7700;
	color: #ffffff;
	font-weight: bold;
	margin-bottom: 1em;
	padding: 3px;
	text-align: center;
	width: 150px;
	}
.wrap div.button-donate {
	border-width: 1px;
	border-style: solid;
	-moz-border-radius: 4px;
	-khtml-border-radius: 4px;
	-webkit-border-radius: 4px;
	border-radius: 4px;
	float: left;
	margin-bottom: 1em;
	width: 150px;
}
a.donate {
	background: #000000;
	clear: both;
	color: #ffffff;
	display: block;
	font-weight: bold;
	padding: 3px;
	text-align: center;
	text-decoration: none;
}
.previewframe {
	clear: both;
	}
.optiontable {
	background: #efefef;
	border: 1px solid #dfdfdf;
	float: left;
	font-family: Arial, Helvetica, sans-serif;
	margin-right: 1em;
	padding: 1em 1em 0 1em;
	width: 350px;
	}
.optiontable td {
	padding-bottom: 1em;
	}
h2.optiontitle {
	background: #000000;
	color: #ffffff;
	display: block;
	font-family: Arial, Helvetica, sans-serif;
	font-size: .9em;
	font-style: normal;
	font-weight: bold;
	line-height: normal;
	margin-bottom: 1em;
	padding: 1em;
	text-transform: uppercase;
	}
.wrap h2.main {
	font-style: normal;
	}
.wrap small {
	text-transform: uppercase;
	}
.wrap input[type="checkbox"], .wrap input[type="radio"] {
	vertical-align: middle;
	}
.wrap textarea#takte_headertext {
	border: 1px solid #dfdfdf;
	margin: 0;
	width: 100%;
	}
.wrap input#takte_headerimage, .wrap input#takte_headerimage_width, .wrap input#takte_headerimage_height, .wrap input#takte_headerimage_alt, .wrap input#takte_headerimage_title {
	border: 1px solid #dfdfdf;
	margin: 0;
	width: 100%;
	}
.previewframe iframe {
	border: 4px solid #000000;
	margin-top: 20px;
	padding: 1px;
}
</style>
<?php
}
add_action('admin_menu', 'mytheme_add_admin'); ?>