<?php /* underscore at beginning of name hides it from custom fields */ ?>
<div id="post-schedule-metabox">
	<?php
		global $post;
		$post_scheduler_json_string = get_post_meta($post->ID, '_post_schedule', TRUE);
		if(!empty($post_scheduler_json_string)) {
			include_once('post-schedule-construct-scheduler.php');
			$post_scheduler_json = json_decode($post_scheduler_json_string);
			$schedule_array = $post_scheduler_json->schedule_array;
			$schedule_count = count($schedule_array);
			for($i=0;$i<$schedule_count;$i++) {
				$schedule_day = '';
				$schedule_date = '';
				$start_date = '';
				$stop_date = '';
				$current_item = $schedule_array[$i];
				$schedule_type = $current_item->schedule_type;
				switch($schedule_type) {
					case 'day': {
						$schedule_day = $current_item->schedule_type_data;
						break;
					}
					case 'date': {
						$schedule_date = $current_item->schedule_type_data;
						break;
					}
					case 'date-range': {
						$schedule_type_data = $current_item->schedule_type_data;
						$schedule_dates = explode(';', $schedule_type_data);
						$start_date = $schedule_dates[0];
						$stop_date = $schedule_dates[1];
						break;
					}
				}
				$schedule_times = explode(';', $current_item->time);
				$start_ampm = 0;
				$start_time = explode(':', $schedule_times[0]);
				$start_hour = $start_time[0];
				$start_hour += 0; // this strips leading zeroes easily
				if($start_hour > 12) {
					$start_ampm = 1;
					$start_hour -= 12;
				}
				$start_minute = $start_time[1];
				$start_minute += 0; // this strips leading zeroes easily
				$stop_ampm = 0;
				$stop_time = explode(':', $schedule_times[1]);
				$stop_hour = $stop_time[0];
				$stop_hour += 0; // this strips leading zeroes easily
				if($stop_hour > 12) {
					$stop_ampm = 1;
					$stop_hour -= 12;
				}
				$stop_minute = $stop_time[1];
				$stop_minute += 0; // this strips leading zeroes easily
				$scheduler_index = $i;
				get_scheduler(
					TRUE, 
					$schedule_type,
					$schedule_day,
					$schedule_date,
					$start_date,
					$stop_date,
					$start_ampm,
					$start_hour,
					$start_minute,
					$stop_ampm,
					$stop_hour,
					$stop_minute,
					$scheduler_index
				);
			}
		}
	?>
	<div class="insert">
		<button>Insert schedule</button>
	</div>
	<input type="hidden" name="post_schedule_noncename" value="<?php echo wp_create_nonce('post-schedule-metabox'); ?>" />
	<input class="post-scheduler-json" type="hidden" name="_post_schedule" value='<?php echo $post_scheduler_json_string; ?>' />
</div>
