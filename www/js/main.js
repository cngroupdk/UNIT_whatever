jQuery(function($) {
	$.nette.init();

	var $posts = $('.ut-posts');

	if ($posts.length) {
		var conn = new WebSocket('ws://localhost:3001/broadcast');

		conn.onmessage = function (e) {
			if (e.data === 'refresh') {
				$.nette.ajax({
					url: $posts.data('refresh-url')
				});
			}
		};
	}
});
