<?php
	function get_scheduler(
		$from_wordpress = FALSE,
		$schedule_type = '',
		$schedule_day = '',
		$schedule_date = '',
		$start_date = '',
		$stop_date = '',
		$start_ampm = '',
		$start_hour = '',
		$start_minute = '',
		$stop_ampm = '',
		$stop_hour = '',
		$stop_minute = '',
		$scheduler_index = ''
	) {
		$scheduler_index_string = '';
		$day_selected = '';
		$date_range_selected  = '';
		$date_selected = '';
		$day_class = 'show';
		$date_class = 'hide';
		$date_range_class = 'hide';
		$day_selected_array = array_fill(0, 7, '');
		$start_date_string = '';
		$stop_date_string = '';
		$schedule_date_string = '';
		$start_am = '';
		$start_pm = '';
		$stop_am = '';
		$stop_pm = '';
		if($from_wordpress) {
			$scheduler_index_string = ' data-id="' . $scheduler_index . '"';
			switch($schedule_type) {
				case 'day': {
					$day_selected = ' selected="selected"';
					$day_selected_array[$schedule_day] = ' selected="selected"';
					break;
				}
				case 'date': {
					$date_selected = ' selected="selected"';
					$schedule_date_string = ' data-date="' . $schedule_date . '"';
					$date_class = 'show';
					$day_class = 'hide';
					break;
				}
				case 'date-range': {
					$date_range_selected = ' selected="selected"';
					$start_date_string = ' data-date="' . $start_date . '"';
					$stop_date_string = ' data-date="' . $stop_date . '"';
					$date_range_class = 'show';
					$day_class = 'hide';
					break;
				}
			}
			if($start_ampm) {
				$start_pm = ' selected="selected"';
			}
			else {
				$start_am = ' selected="selected"';
			}
			if($stop_ampm) {
				$stop_pm = ' selected="selected"';
			}
			else {
				$stop_am = ' selected="selected"';
			}
		}
		?>
		<div class="post-type-scheduler"<?php echo $scheduler_index_string; ?>>
			<div class="schedule-type">
				<header>Select Schedule Type</header>
				<select>
					<option value="day"<?php echo $day_selected; ?>>Day of the Week</option>
					<option value="date-range"<?php echo $date_range_selected; ?>>Date Range</option>
					<option value="date"<?php echo $date_selected; ?>>Single Date</option>
				</select>
			</div>
			<div class="day <?php echo $day_class; ?>">
				<header>Day of the Week</header>
				<select>
					<option value="0"<?php echo $day_selected_array[0]; ?>>Sunday</option>
					<option value="1"<?php echo $day_selected_array[1]; ?>>Monday</option>
					<option value="2"<?php echo $day_selected_array[2]; ?>>Tuesday</option>
					<option value="3"<?php echo $day_selected_array[3]; ?>>Wednesday</option>
					<option value="4"<?php echo $day_selected_array[4]; ?>>Thursday</option>
					<option value="5"<?php echo $day_selected_array[5]; ?>>Friday</option>
					<option value="6"<?php echo $day_selected_array[6]; ?>>Saturday</option>
				</select>
			</div>
			<div class="date-range <?php echo $date_range_class; ?>">
				<div class="start-date">
					<header>Start Date</header>
					<div class="datepicker"<?php echo $start_date_string; ?>></div>
				</div>
				<div class="stop-date">
					<header>Stop Date</header>
					<div class="datepicker"<?php echo $stop_date_string; ?>></div>
				</div>
			</div>
			<div class="date <?php echo $date_class; ?>">
				<header>Date</header>
				<div class="datepicker"<?php echo $schedule_date_string; ?>></div>
			</div>
			<div class="time">
				<div class="start-time">
					<header>Start Time</header>
					<select class="hour">
						<?php
							for($i=1;$i<13;$i++) {
								$hour = str_pad($i, 2, "0", STR_PAD_LEFT);
								if(isset($start_hour) && $start_hour == $i) {
									echo '<option value="' . $i . '" selected="selected">' . $hour . '</option>';
								}
								else {
									echo '<option value="' . $i . '">' . $hour . '</option>';
								}
							}
						?>
					</select>
					<select class="minute">
						<?php
							for($i=0;$i<60;) {
								$minute = str_pad($i, 2, "0", STR_PAD_LEFT);
								if(isset($start_minute) && $start_minute == $i) {
									echo '<option value="' . $i . '" selected="selected">' . $minute . '</option>';
								}
								else {
									echo '<option value="' . $i . '">' . $minute . '</option>';
								}
								$i += 5;
							}
						?>
					</select>
					<select class="ampm">
						<option value="0"<?php echo $start_am; ?>>AM</option>
						<option value="1"<?php echo $start_pm; ?>>PM</option>
					</select>
				</div>
				<div class="stop-time">
					<header>Stop Time</header>
					<select class="hour">
						<?php
							for($i=1;$i<13;$i++) {
								$hour = str_pad($i, 2, "0", STR_PAD_LEFT);
								if(isset($stop_hour) && $stop_hour == $i) {
									echo '<option value="' . $i . '" selected="selected">' . $hour . '</option>';
								}
								else {
									echo '<option value="' . $i . '">' . $hour . '</option>';
								}
							}
						?>
					</select>
					<select class="minute">
						<?php
							for($i=0;$i<60;) {
								$minute = str_pad($i, 2, "0", STR_PAD_LEFT);
								if(isset($stop_minute) && $stop_minute == $i) {
									echo '<option value="' . $i . '" selected="selected">' . $minute . '</option>';
								}
								else {
									echo '<option value="' . $i . '">' . $minute . '</option>';
								}
								$i += 5;
							}
						?>
					</select>
					<select class="ampm">
						<option value="0"<?php echo $stop_am; ?>>AM</option>
						<option value="1"<?php echo $stop_pm; ?>>PM</option>
					</select>
				</div>
			</div>
			<div class="delete">
				<button>Delete schedule</button>
			</div>
		</div>
		<?php
	}
?>
