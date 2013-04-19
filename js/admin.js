var scheduler_json = {schedule_array:[]};
function update_scheduler_json($root, update_type, index) {
	var update_type = typeof update_type !== 'undefined' ? update_type : 'insert';
	var $ = jQuery;
	if(update_type == 'delete') {
		if(scheduler_json.schedule_array.length == 1) {
			scheduler_json.schedule_array = [];
			$metabox.find('.post-scheduler-json').val('');
		}
		else {
			scheduler_json.schedule_array.splice(index, 1);
			$metabox.find('.post-scheduler-json').val(JSON.stringify(scheduler_json));
		}
	}
	var schedule_type = $root.find('.schedule-type select option:selected').val();
	var $schedule_type_data = $root.find('.' + schedule_type);
	var schedule_type_data = '';
	switch(schedule_type) {
		case 'day': {
			schedule_type_data = $schedule_type_data.find('select option:selected').val();
			break;
		}
		case 'date': {
			schedule_type_data = $.datepicker.formatDate('mm-dd-yy', $schedule_type_data.find('.datepicker').datepicker('getDate'));
			break;
		}
		case 'date-range': {
			schedule_type_data = $.datepicker.formatDate('mm-dd-yy', $schedule_type_data.find('.start-date .datepicker').datepicker('getDate'))
				+ ';' + $.datepicker.formatDate('mm-dd-yy', $schedule_type_data.find('.stop-date .datepicker').datepicker('getDate'));
			break;
		}
	}
	var start_hour = $root.find('.start-time .hour option:selected').val();
	var start_ampm = $root.find('.start-time .ampm option:selected').val();
	if(start_ampm == '1') {
		start_hour = Number(start_hour) + 12;
	}
	var start_time = start_hour + ':' + $root.find('.start-time .minute option:selected').val();
	var stop_hour = $root.find('.stop-time .hour option:selected').val();
	var stop_ampm = $root.find('.stop-time .ampm option:selected').val();
	if(stop_ampm == '1') {
		stop_hour = Number(stop_hour) + 12;
	}
	var stop_time = stop_hour + ':' + $root.find('.stop-time .minute option:selected').val();
	var time = start_time + ';' + stop_time;
	if(update_type == 'insert') {
		scheduler_json.schedule_array.push({
			"schedule_type": schedule_type,
			"schedule_type_data": schedule_type_data,
			"time": time
		});
	}
	if(update_type == 'update') {
		scheduler_json.schedule_array[index] = {
			"schedule_type": schedule_type,
			"schedule_type_data": schedule_type_data,
			"time": time
		};
	}
	$metabox.find('.post-scheduler-json').val(JSON.stringify(scheduler_json));
}
jQuery(document).ready(function($) {
	var script_url = $('script[src*="post-type-scheduler/js/admin.js"]').attr('src');
	var script_url_pieces = script_url.split('/');
	script_url_pieces.pop();
	script_url_pieces.pop();
	var plugin_base_url = script_url_pieces.shift() + '//';
	script_url_pieces.shift();
	for(var i=0;i<script_url_pieces.length;i++) {
		plugin_base_url += script_url_pieces[i] + '/';
	}
	$.get(plugin_base_url + 'views/post-schedule-construct-scheduler.php', function(data) {
		scheduler_html = data;
		$metabox = $(document.getElementById('post-schedule-metabox'));
		$metabox.find('.datepicker').each(function() {
			$(this).datepicker({
				minDate: 0,
				onSelect: function(dateText, inst) {
					var $this = $(document.getElementById(inst.id));
					var $scheduler = $this.closest('.post-type-scheduler');
					var index = $scheduler.data('id');
					update_scheduler_json($scheduler, 'update', index);
				}
			});
		});
		$metabox.on('click', '.insert > button', function(e) {
			e.preventDefault();
			var $this = $(e.target);
			var index = $metabox.find('.post-type-scheduler').length;
			var $scheduler = $(scheduler_html).attr('data-id', index).insertBefore($this.parent());
			$scheduler.find('.datepicker').each(function() {
				$(this).datepicker({
					minDate: 0,
					onSelect: function(dateText, inst) {
						var $this = $(document.getElementById(inst.id));
						var $scheduler = $this.closest('.post-type-scheduler');
						var index = $scheduler.data('id');
						update_scheduler_json($scheduler, 'update', index);
					}
				});
			});
			update_scheduler_json($scheduler);
		});
		$metabox.on('click', '.delete > button', function(e) {
			e.preventDefault();
			var $this = $(e.target);
			var $delete = $this.closest('.post-type-scheduler');
			var delete_id = $delete.data('id');
			update_scheduler_json($delete, 'delete', delete_id);	
			$delete.nextAll().each(function() {
				$this = $(this);
				$this.attr('data-id', $this.data('id') - 1);
			});
			$delete.remove();
		});
		$metabox.on('change', '.schedule-type select', function(e) {
			var $this = $(e.target);
			var $scheduler = $this.closest('.post-type-scheduler');
			var index = $scheduler.data('id');
			var select_value = '';
			$this.find('option:selected').each(function() {
				select_value += this.value;
			});
			$scheduler.find('.date-range, .date, .day').hide().filter('.' + select_value).show();
			update_scheduler_json($scheduler, 'update', index);
		});
		$metabox.on('change', '.day select, .time select', function(e) {
			var $this = $(e.target);
			var $scheduler = $this.closest('.post-type-scheduler');
			var index = $scheduler.data('id');
			update_scheduler_json($scheduler, 'update', index);
		});
	});
});
