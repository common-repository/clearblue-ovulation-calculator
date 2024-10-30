<?php
	$date_today = '11/02/2020';
	// TODO: nombre de colonnes

	CbOvulationCalculator_Data::display_js_data();
?>

<div class="cboc -<?php echo CbOvulationCalculator_Admin::$options['format'];?>" data-locale="<?php echo CbOvulationCalculator_Admin::$options['language']; ?>">
	<div class="cboc-wrapper -format-element">
		<div class="cboc-tool -active">
			<div class="cboc-tool-title">
				<?php CbOvulationCalculator_Data::_e(CBOC_NAME); ?>
			</div>

			<div class="cboc-input-line">
				<div class="cboc-question">
					<?php CbOvulationCalculator_Data::_e('When did your last period start?'); ?>
				</div>
				<label class="cboc-input-wrapper cboc-datepicker -format-element">
					<input class="cboc-input" name="cboc-last-period-start-date" readonly="readonly" type="text" required>
					<svg version="1.1" class="-calendar" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="48px" height="48px" viewBox="6 0 48 48" enable-background="new 6 0 48 48" xml:space="preserve"> <g> <path d="M50.244,48H9.756C7.686,48,6,46.315,6,44.244V6.757C6,4.686,7.686,3,9.757,3h40.485 C52.314,3,54,4.686,54,6.757v37.487C54,46.315,52.315,48,50.244,48z M9.757,6C9.34,6,9,6.34,9,6.757v37.487 C9,44.661,9.339,45,9.756,45h40.488C50.661,45,51,44.661,51,44.244V6.757C51,6.34,50.66,6,50.242,6H9.757z M52.5,15h-45 C6.672,15,6,14.328,6,13.5S6.672,12,7.5,12h45c0.83,0,1.5,0.672,1.5,1.5S53.33,15,52.5,15z M15,9c-0.828,0-1.5-0.672-1.5-1.5v-6 C13.5,0.672,14.172,0,15,0s1.5,0.672,1.5,1.5v6C16.5,8.328,15.828,9,15,9z M45,9c-0.83,0-1.5-0.672-1.5-1.5v-6 C43.5,0.672,44.17,0,45,0s1.5,0.672,1.5,1.5v6C46.5,8.328,45.83,9,45,9z"/> <circle cx="15" cy="27" r="1.5"/> <circle cx="15" cy="33" r="1.5"/> <circle cx="15" cy="39" r="1.5"/> <circle cx="39" cy="21" r="1.5"/> <circle cx="39" cy="27" r="1.5"/> <circle cx="39" cy="33" r="1.5"/> <circle cx="39" cy="39" r="1.5"/> <circle cx="45" cy="21" r="1.5"/> <circle cx="45" cy="27" r="1.5"/> <circle cx="45" cy="33" r="1.5"/> <circle cx="27" cy="21" r="1.5"/> <circle cx="27" cy="27" r="1.5"/> <circle cx="27" cy="33" r="1.5"/> <circle cx="27" cy="39" r="1.5"/> <circle cx="21" cy="21" r="1.5"/> <circle cx="21" cy="27" r="1.5"/> <circle cx="21" cy="33" r="1.5"/> <circle cx="21" cy="39" r="1.5"/> <circle cx="33" cy="21" r="1.5"/> <circle cx="33" cy="27" r="1.5"/> <circle cx="33" cy="33" r="1.5"/> <circle cx="33" cy="39" r="1.5"/> </g> </svg>
				</label>
				<div class="cboc-description">
					<?php CbOvulationCalculator_Data::_e('E.g. 18/01/2020'); ?>
				</div>
			</div>
			<div class="cboc-input-line">
				<div class="cboc-question">
					<?php CbOvulationCalculator_Data::_e('Usually, how long is your cycle?'); ?>
				</div>
				<label class="cboc-input-wrapper -format-element">
					<select class="cboc-input" name="cboc-cycle-length" required>
						<option value="" selected="selected"></option>
						<option value="23-"><?php CbOvulationCalculator_Data::_e('Less than'); ?> 23</option>
						<?php for ($i=23; $i<=35; $i++) : ?>
							<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
						<?php endfor; ?>
						<option value="35+"><?php CbOvulationCalculator_Data::_e('Over'); ?> 35</option>
					</select>
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="12" height="14" viewBox="0 0 12 14"> <g> <path d="M-0.011,8.065 C-0.011,8.065 -0.011,6.078 -0.011,6.078 C-0.011,6.078 5.244,11.312 5.244,11.312 C5.244,11.312 5.244,0.010 5.244,0.010 C5.244,0.010 6.730,0.010 6.730,0.010 C6.730,0.010 6.730,11.312 6.730,11.312 C6.730,11.312 11.985,6.078 11.985,6.078 C11.985,6.078 11.985,8.065 11.985,8.065 C11.985,8.065 5.979,14.012 5.979,14.012 C5.979,14.012 -0.011,8.065 -0.011,8.065 Z" fill-rule="evenodd"/> </svg>
				</label>
				<div class="cboc-description">
					<?php CbOvulationCalculator_Data::_e('Cycles typically vary from 23 to 35 days'); ?>
				</div>
			</div>
			<div class="cboc-button-wrapper">
				<div class="cboc-button cboc-button--arrow-right -format-element">
					<span><?php CbOvulationCalculator_Data::_e('Estimate your ovulation day'); ?></span>
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="14" height="12" viewBox="0 0 14 12"> <g> <path d="M8.065,12.011 C8.065,12.011 6.078,12.011 6.078,12.011 C6.078,12.011 11.312,6.756 11.312,6.756 C11.312,6.756 0.010,6.756 0.010,6.756 C0.010,6.756 0.010,5.270 0.010,5.270 C0.010,5.270 11.312,5.270 11.312,5.270 C11.312,5.270 6.078,0.015 6.078,0.015 C6.078,0.015 8.065,0.015 8.065,0.015 C8.065,0.015 14.012,6.021 14.012,6.021 C14.012,6.021 8.065,12.011 8.065,12.011 Z" fill-rule="evenodd"/> </g> </svg>
				</div>
			</div>
		</div>
		
		<div class="cboc-results">
			<div class="cboc-calendars-wrapper">
				<div class="cboc-calendars"></div>
				<div class="cboc-calendar-tooltip">
					<strong class="cboc-calendar-tooltip-prct"></strong>
					<?php CbOvulationCalculator_Data::_e('likelihood of ovulating today'); ?>
				</div>
			</div>
			<div class="cboc-empty-wrapper">
				<?php CbOvulationCalculator_Data::_e("Due to your cycle length, unfortunately we can't estimate an ovulation probability. We recommend that you use a Digital Ovulation Test to accurately detect your most fertile days."); ?>
			</div>
			<div class="cboc-legend-wrapper">
				<div class="cboc-legend-line">
					<div class="cboc-bubble -period">
						<span class="cboc-bubble-number">&nbsp;</span>
						<span class="cboc-bubble-bubble">*</span>
					</div>
					<span class="cboc-legend-text"><?php CbOvulationCalculator_Data::_e('Start of your last period'); ?></span>
				</div>
				<div class="cboc-legend-line">
					<div class="cboc-bubble -prct-20">
						<span class="cboc-bubble-number">&nbsp;</span>
						<span class="cboc-bubble-bubble">20%</span>
					</div>
					<span class="cboc-legend-text"><?php CbOvulationCalculator_Data::_e('Likelihood of ovulating on this date'); ?></span>
				</div>
			</div>
			<div class="cboc-button-wrapper">
				<div class="cboc-button cboc-button--arrow-left -format-element">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid" width="14" height="12" viewBox="0 0 14 12"> <g> <path d="M5.935,-0.011 C5.935,-0.011 7.922,-0.011 7.922,-0.011 C7.922,-0.011 2.688,5.244 2.688,5.244 C2.688,5.244 13.990,5.244 13.990,5.244 C13.990,5.244 13.990,6.730 13.990,6.730 C13.990,6.730 2.688,6.730 2.688,6.730 C2.688,6.730 7.922,11.985 7.922,11.985 C7.922,11.985 5.935,11.985 5.935,11.985 C5.935,11.985 -0.012,5.979 -0.012,5.979 C-0.012,5.979 5.935,-0.011 5.935,-0.011 Z" fill-rule="evenodd"/> </g> </svg>
					<span><?php CbOvulationCalculator_Data::_e('Change my informations'); ?></span>
				</div>
			</div>
		</div>

		<div class="cboc-description cboc-description-global">
			<?php if (CbOvulationCalculator_Admin::$options['show-credits']) : ?>
				<?php CbOvulationCalculator_Data::_e('In partnership with Clearblue.'); ?><br>
			<?php else: ?>
				<?php // Remove the <a> link ?>
				<?php echo strip_tags(CbOvulationCalculator_Data::__('In partnership with Clearblue.')); ?><br>
			<?php endif; ?>
			<?php CbOvulationCalculator_Data::_e('Results are based on the information you have provided and data from the publication below: Sarah Johnson, Lorrae Marriott & Michael Zinaman (2018): “Can apps and calendar methods predict ovulation with accuracy?”, Current Medical Research and Opinion, DOI:10.1080/03007995.2018.1475348'); ?>
		</div>
	</div>
</div>
