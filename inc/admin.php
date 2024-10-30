<div class="wrap" id="cboc-admin">
	<form method="POST">
		<h1>Clearblue® <strong><?php echo CbOvulationCalculator_Data::__(CBOC_NAME); ?></strong></h1>

		<hr style="margin: 10px 0 30px 0;">
		<h2><?php CbOvulationCalculator_Data::_e("Shortcode"); ?></h2>
		<p>
			<input
				value="[<?php echo CBOC_BASENAME ?>]"
				class="text-regular"
				type="text"
				readonly
				style="min-width: 250px;"
			>
		</p>

		<hr style="margin: 30px 0;">
		<h2><?php CbOvulationCalculator_Data::_e("Settings"); ?></h2>
		<table class="form-table">

			<!--====== LANGUAGE =====-->
			<tr>
				<th scope="row"><label for="cboc-language"><?php CbOvulationCalculator_Data::_e("cboc-language"); ?></label></th>
				<td>
					<select id="cboc-language" name="cboc-language">
					<?php
						foreach (CbOvulationCalculator_Admin::$languages as $key => $value) :
							$selected = ($key === CbOvulationCalculator_Admin::$options['language']) ? 'selected="selected"' : '';
							echo '<option value="'. $key .'" '. $selected .'>'. $value .'</option>';
						endforeach;
					?>
					</select>
				</td>
			</tr>
	

			<!--====== FORMAT =====-->
			<tr>
				<th scope="row"><label for="cboc-format"><?php CbOvulationCalculator_Data::_e("cboc-format"); ?></label></th>
				<td>
					<fieldset>
						<?php foreach (CbOvulationCalculator_Admin::$formats as $key) : ?>
							<label>
								<input
									type="radio"
									name="cboc-format"
									value="<?php echo $key; ?>"
									<?php if (CbOvulationCalculator_Admin::$options['format'] === $key) echo 'checked' ?>
								>
								<span><?php CbOvulationCalculator_Data::_e("cboc-format-" . $key); ?></span>
							</label><br>
						<?php endforeach; ?>
					</fieldset>
				</td>
			</tr>

			<!--====== CREDITS =====-->
			<tr>
				<th scope="row"><label for="cboc-show-credits"><?php CbOvulationCalculator_Data::_e("Credits"); ?></label></th>
				<td>
					<fieldset>
						<label>
							<input
								type="checkbox"
								name="cboc-show-credits"
								<?php if (CbOvulationCalculator_Admin::$options['show-credits']) echo 'checked' ?>
							>
							<span><?php CbOvulationCalculator_Data::_e('Allow the plugin to display a "In partnership with Clearblue" link'); ?></span>
						</label>
					</fieldset>
				</td>
			</tr>
		</table>

		<hr style="margin: 10px 0 30px 0;">
		<h2><?php CbOvulationCalculator_Data::_e("Colors"); ?></h2>
		<table class="form-table">
			<?php foreach (CbOvulationCalculator_Admin::$options['colors'] as $key => $value) : ?>
				<tr>
					<th scope="row"><label for="cboc-color-<?php echo $key; ?>">
						<?php CbOvulationCalculator_Data::_e("cboc-color-" . $key); ?>
					</label></th>
					<td>
						<input
							id="cboc-color-<?php echo $key; ?>"
							name="cboc-color-<?php echo $key; ?>"
							value="<?php echo esc_attr(CbOvulationCalculator_Admin::$options['colors'][$key]); ?>"
							class="cb-color-picker"
							type="text"
						>
					</td>
				</tr>
        	<?php endforeach; ?>
		</table>

		<p class="submit">
			<input type="submit" name="cboc-submit" id="submit" class="button button-primary" value="<?php CbOvulationCalculator_Data::_e('Save'); ?>">
		</p>
	</form>

	<hr style="margin: 30px 0;">
	<form method="POST">
		<h2><?php CbOvulationCalculator_Data::_e("Reset settings"); ?></h2>

		<input type="hidden" name="cboc-reset" value="1">
		<p class="submit">
			<input type="submit" name="cb-submit-reset" id="cb-submit-reset" class="button" value="<?php CbOvulationCalculator_Data::_e('Reset settings'); ?>">
		</p>
	</form>
</div>
