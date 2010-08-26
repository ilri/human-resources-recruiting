$(document).ready(function() {

	// for the "featured" videos section
	$('a#featured').each(function() {

		flowplayer(this, "videos/flowplayer-3.2.3.swf", {
			clip: {
				autoPlay: true,
				onFinish: function() {
					this.unload();
				}
			}
		});
	});

	// for all the "person" interviews
	$('.person .vid').each(function() {
		
			flowplayer(this, "videos/flowplayer-3.2.3.swf", {
				plugins: {
					controls: null
				},

				clip: {
					autoPlay: true,
					onFinish: function() {
						this.unload();
					}
				}
			});
	});

	// show the Regional Representative's region
	$('span.rep').hover(
		function() {
			var region = $(this).parent().find('span.region');
			region.fadeIn(100);
		},

		function() {
			var region = $(this).parent().find('span.region');
			region.fadeOut(100);
		}
	);
});
