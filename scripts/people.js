$(document).ready(function() {
	// select all div tags of class "vid"
	$('div.vid').each(function() {
		//var personID = $(this).attr('id');
		//insertVideo(personID);
		//alert('omg it is: '+this.id);
		flashembed(this, "videos/player_flv_maxi.swf", {
			flv: 'andrew.flv', //relative to player!
			showplayer: 'never', // (hide maxi player "play" button)
			showloading: 'never', // (hide maxi player loading text)
			margin: '0', // (hide maxi player margin)
			startimage: 'images/people/andrew_play.png', // (show a "start" image before playing)
			wmmode: 'opaque'
		});
	});
});
