<div id="post-schedule-metabox">
	<div class="post-type-scheduler">
		<div class="schedule-type">
			<header>Select Schedule Type</header>
			<select>
				<option value="day">Day of the Week</option>
				<option value="date-range">Date Range</option>
				<option value="date">Single Date</option>
			</select>
		</div>
		<div class="day">
			<header>Day of the Week</header>
			<select>
				<option value="0">Sunday</option>
				<option value="1">Monday</option>
				<option value="2">Tuesday</option>
				<option value="3">Wednesday</option>
				<option value="4">Thursday</option>
				<option value="5">Friday</option>
				<option value="6">Saturday</option>
			</select>
		</div>
		<div class="date-range">
			<div class="start-date">
				<header>Start Date</header>
				Insert jQuery UI datepicker here
			</div>
			<div class="end-date">
				<header>End Date</header>
				Insert jQuery UI datepicker here
			</div>
		</div>
		<div class="date">
			<header>Date</header>
			Insert jQuery UI datepicker here
		</div>
		<div class="time">
			<div class="start-time">
				<header>Start Time</header>
				<select class="hour">
					<?php
						for($i=1;$i<13;$i++) {
							$hour = str_pad($i, 2, "0", STR_PAD_LEFT);
							echo "<option value='${hour}'>${hour}</option>";
						}
					?>
				</select>
				<select class="minute">
					<?php
						for($i=0;$i<60;) {
							$minute = str_pad($i, 2, "0", STR_PAD_LEFT);
							echo "<option value='${minute}'>${minute}</option>";
							$i += 5;
						}
					?>
				</select>
				<select class="ampm">
					<option value="0">AM</option>
					<option value="1">PM</option>
				</select>
			</div>
			<div class="stop-time">
				<header>Stop Time</header>
				<select class="hour">
					<?php
						for($i=1;$i<13;$i++) {
							$hour = str_pad($i, 2, "0", STR_PAD_LEFT);
							echo "<option value='${hour}'>${hour}</option>";
						}
					?>
				</select>
				<select class="minute">
					<?php
						for($i=0;$i<60;) {
							$minute = str_pad($i, 2, "0", STR_PAD_LEFT);
							echo "<option value='${minute}'>${minute}</option>";
							$i += 5;
						}
					?>
				</select>
				<select class="ampm">
					<option value="0">AM</option>
					<option value="1">PM</option>
				</select>
			</div>
		</div>
	</div>
	<button>Add another schedule</button>
</div>
