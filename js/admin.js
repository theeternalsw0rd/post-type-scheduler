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
		$metabox.change('.schedule-type select', function(e){
			$this = $(e.target);
			$root = $this.closest('.post-type-scheduler');
			index = $root.data('id');
			console.log(index);
			select_value = '';
			$this.find('option:selected').each(function() {
				select_value += this.value;
			});
			$root.find('.date-range, .date, .day').hide().filter('.' + select_value).show();
		});
		$metabox.find('.datepicker').each(function() {
			$(this).datepicker();
		});
		$metabox.click('.insert', function(e) {
			e.preventDefault();
			$this = $(e.target);
			var index = $metabox.find('.post-type-scheduler').length;
			$(scheduler_html).attr('data-id', index).insertBefore($this).find('.datepicker').each(function() {
				$(this).datepicker();
			});
		});
	});
});
