<?php
	$options = get_option('ViperFeed_options');
?>
<style>
	.ViperFeed_swatch {
		float: left;
		width: 17px;
		height: 10px;
	}
	
	.ViperFeed_swatch_lg {
		border: 1px solid #000000;
		width: 60px;
		height: 60px;
		margin: 10px;
	}
	
	#ViperFeed_color_picker {
		width: 654px;
		border: 1px solid #000000;
	}
	
	#ViperFeed_editor {
		width: 100%;
	}
	
	.ViperFeed_table tr td {
		padding: 3px;
	}
	
	#ViperFeed_breaker_options {
		height: 270px;
		border: 1px solid #DCDCDC;
		background: #FEFEFE;
		margin: 20px 0px 0px 0px;
		overflow: auto;
	}
	
	/*Common Viper Products */
	
		#ViperFeed_main_container {
			width: 700px;
			border: 1px solid #DCDCDC;
			margin: 10px;
			padding: 10px;
		}
		
		#ViperFeed_preview {
			border: 1px solid #555;
			background: #FFFFFF;
			padding: 5px;
		}
		
		.ViperFeed_input,.ViperFeed_label {
			margin: 3px;
			display: block;
			width: 95%;
		}
		
		.ViperFeed_form_element {
			float: left;
			width: 50%;
		}
		
		.ViperFeed_label {
			font-weight: bold;
			margin-top: 20px;
		}
		
		.ViperFeed_input {
			margin-left: 20px;
		}
	
	/* End Common Viper Products */
</style>
<div id="ViperFeed_main_container">
	<?php
		$plugin_dir = str_replace("/".basename(__FILE__),"",plugin_basename(__FILE__));
		echo file_get_contents("http://www.viperchill.com/rss/plugin_header.php?plugin=".$plugin_dir);
	?>
	<form method="post" action="" enctype="multipart/form-data">
		<div class="ViperFeed_form_element">
			<div class="ViperFeed_label">Enable ViperFeed?</div>
			<div class="ViperFeed_input">
				<input type="radio" name="enabled" value="true" <?php echo ($options['enabled'] == "true") ? 'checked="checked"' : ''; ?>>Yes
				<input type="radio" name="enabled" value="false" <?php echo ($options['enabled'] == "false") ? 'checked="checked"' : ''; ?>>No
			</div>
		</div>
		<div class="ViperFeed_form_element">
			<div class="ViperFeed_label">Give ViperChill credit?</div>
			<div class="ViperFeed_input">
				<input type="radio" name="attribution" value="true" <?php echo ($options['attribution'] == "true") ? 'checked="checked"' : ''; ?>>Yes
				<input type="radio" name="attribution" value="false" <?php echo ($options['attribution'] == "false") ? 'checked="checked"' : ''; ?>>No
			</div>
		</div>
		<div class="ViperFeed_form_element">
			<div class="ViperFeed_label">Link back to post comments?</div>
			<div class="ViperFeed_input">
				<input type="radio" name="comments_link" value="true" <?php echo ($options['comments_link'] == "true") ? 'checked="checked"' : ''; ?>>Yes
				<input type="radio" name="comments_link" value="false" <?php echo ($options['comments_link'] == "false") ? 'checked="checked"' : ''; ?>>No
			</div>
		</div>
		<div class="ViperFeed_form_element">
			<div class="ViperFeed_label">Comment Link Text:</div>
			<div class="ViperFeed_input">
				<input type="text" name="comments_link_text" value="<?php echo $options['comments_link_text']; ?>" style="width: 80%;">
			</div>
		</div>
		<div class="ViperFeed_form_element">
			<div class="ViperFeed_label">Breaker Link (Empty for No Link):</div>
			<div class="ViperFeed_input">
				<input type="text" name="breaker_link" value="<?php echo $options['breaker_link']; ?>" style="width: 80%;">
			</div>
		</div>
		<div class="ViperFeed_form_element">
			<div class="ViperFeed_label">Choose your breaker image style:</div>
			<div class="ViperFeed_input">
				<input
					type="radio"
					name="breaker_image_style"
					value="image"
					id="input_breaker_image_style_image"
					onClick="toggle_breaker_type()"
					<?php echo ($options['breaker_image_style'] == "image") ? 'checked="checked"' : ''; ?>
				> Custom Image
				<input
					type="radio"
					name="breaker_image_style"
					value="color"
					id="input_breaker_image_style_color"
					onClick="toggle_breaker_type()"
					<?php echo ($options['breaker_image_style'] == "color") ? 'checked="checked"' : ''; ?>
				> Color Bar
			</div>
		</div>
		<br style="clear: both;">
		<div id="ViperFeed_breaker_options">
			<div id="panel_breaker_image_style_color">
				<div class="ViperFeed_label">Choose a breaker image color:</div>
				<div class="ViperFeed_input">
					<p>
						Hover to see it, click to commit.
					</p>
					<div id="ViperFeed_color_picker" style="border: 1px solid #000000;">
						<?php
							$resolution = array(
								"00","33","66","99","CC","FF"
							);
							
							echo "";
						
							for($r = 0; $r < sizeof($resolution); $r++) {
								echo "<div style=\"float: left; width: 102px;\">";
								
								for($g = 0; $g < sizeof($resolution); $g++) {
								
									for($b = 0; $b < sizeof($resolution); $b++) {
										$hex = $resolution[$r].$resolution[$g].$resolution[$b];
									
										echo
											"<div class=\"ViperFeed_swatch\" style=\"background:#".$hex."\" onMouseOver=\"see_new_color('".$hex."')\" onClick=\"set_new_color('".$hex."')\"></div>";
									}
									
								}
								
								echo "</div>";
							}
						?>
						<div
							class="ViperFeed_swatch_lg"
							id="preview_color"
							style="background: #<?php echo $options['breaker_color']; ?>; float: left; margin: 0px; border: 0px; width: 42px;"></div>
						<br style="clear: both;">
					</div>
					<div style="margin: 10px;">
						<table class="ViperFeed_table">
							<tr>
								<td style="text-align: right;"><b>Current Color:</b></td>
								<td><img id="current_color" src="<?php echo WP_PLUGIN_URL."/".$plugin_dir; ?>/breaker.php?width=530&color=<?php echo $options['breaker_color']; ?>"></td>
							</tr>
							<tr>
								<td style="text-align: right;"><b>New Color:</b></td>
								<td><img id="new_color" src="<?php echo WP_PLUGIN_URL."/".$plugin_dir; ?>/breaker.php?width=530&color=<?php echo $options['breaker_color']; ?>"></td>
							</tr>
						</table>
						<input type="hidden" id="breaker_color_input" name="breaker_color" value="<?php echo $options['breaker_color']; ?>">
						<br style="clear: both;">
					</div>
					<script type="text/javascript">
						function see_new_color(hex) {
							document.getElementById('preview_color').style.background = '#' + hex;
						}
						
						function set_new_color(hex) {
							document.getElementById('new_color').src = '<?php echo WP_PLUGIN_URL."/".$plugin_dir; ?>/breaker.php?width=530&color=' + hex;
							document.getElementById('breaker_color_input').value = hex;
						}
					</script>
				</div>
			</div>
			<div id="panel_breaker_image_style_image" style="text-align: center;">
				<div class="ViperFeed_label">Upload your own image (jpg only):</div>
				<div class="ViperFeed_input">
					<input type="file" name="file" id="file" />
					<?php
						$upload_dir = wp_upload_dir();
						
						if(file_exists($upload_dir['basedir']."/ViperFeed_custom.jpg")) {
							
							echo
								"<p><b>Current Image:</b></p>
								<p style=\"padding: 5px;\"><img src=\"".$upload_dir['baseurl']."/ViperFeed_custom.jpg\" style=\"border: 1px solid #AAAAAA;\"></p>";
						}
					?>
				</div>
			</div>
			<script type="text/javascript">
				function toggle_breaker_type() {
					if(document.getElementById('input_breaker_image_style_color').checked) {
						document.getElementById('panel_breaker_image_style_color').style.display = 'block';
						document.getElementById('panel_breaker_image_style_image').style.display = 'none';
					} else {
						document.getElementById('panel_breaker_image_style_color').style.display = 'none';
						document.getElementById('panel_breaker_image_style_image').style.display = 'block';
					}
				}
				
				toggle_breaker_type();
			</script>
		</div>
		<div class="ViperFeed_label">Add your footer text:</div>
		<div class="ViperFeed_input">
			<?php
				wp_tiny_mce( true , // true makes the editor "teeny"
					array(
						"editor_selector" => "ViperFeed_editor"
					)
				);
			?>
			<textarea name="footer_text" id="ViperFeed_editor" class="ViperFeed_editor"><?php echo stripslashes($options['footer_text']); ?></textarea>
		</div>
		<input type="submit" name="submit" value="Save">
	</form>
	<h2>Preview</h2>
	<p>Please hit "Save" to update the preview.</p>
	<div id="ViperFeed_preview">
		<?php 
			if (class_exists("ViperFeed")) {
				$ViperFeed = new ViperFeed();
				echo $ViperFeed->footer();
			}
		?>
	</div>
</div>