$(document).ready(function() {

	// select all div tags of class "vid"
	$('div.vid').each(function() {

		// Get the name of the person so we can use it
		// for the video and startImage parameters
		// ... kinda ugly I know.  But we know the name
		// will be the first of the ids so we only get [0]
		// from the array of ids
		var name =$(this).attr('id').split(/\s+/)[0];

		var video = name+'.flv';
		var startImage = 'images/people/'+name+'_play.png';
		
		flashembed(this, "videos/player_flv_maxi.swf", {
			flv: video, //relative to player!
			showplayer: 'never', // (hide maxi player "play" button)
			showloading: 'never', // (hide maxi player loading text)
			margin: '0', // (hide maxi player margin)
			startimage: startImage, // (show a "start" image before playing)
			wmmode: 'opaque'
		});
	});
});
