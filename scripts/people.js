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
	$('div.rep').each( function() {
		$(this).hover(
			function() {
				var region = $(this).find('span.region');
				region.css('display','block');
			},

			function() {
				var region = $(this).find('span.region');
				region.hide();
			}
		);
	});
});
