$(document).ready(function() {

	var featuredPlayer = flowplayer("featured","videos/flowplayer-3.2.4.swf", {
		clip: {
			onFinish: function() {
				this.unload();
			},
			onUpdate: function() {
				this.unload();
			}
		}
	});

	// for all the "person" interviews
	$('.person .vid').each(function() {
		
		flowplayer(this, "videos/flowplayer-3.2.4.swf", {
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

	// swap featured people
	$('#features img.person1').click(function () {
		// store the old values
		var name = featured[0]['name'];
		var description = featured[0]['description'];
		var startimage = featured[0]['startimage'];
		var video = featured[0]['video'];
		var image = featured[0]['image'];

		if(featuredPlayer.isLoaded()) {
			featuredPlayer.getClip().update({url: featured[1]['video']});
		}
		else {
			featuredPlayer.getClip(0).update({url: featured[1]['video']});
		}

		// replace the values in the DOM
		$('#crowdMemberName').html(featured[1]['name'].toLowerCase());
		$('#crowdMemberDescription').html(featured[1]['description']);
		$('#mainFeature img.person').attr('src',featured[1]['image']).attr('title',featured[1]['name']).attr('alt',featured[1]['name']);
		$('#featured').attr('href',featured[1]['video']);
		$('#featured').css('background-image','url('+featured[1]['startimage']+')');

		// swap the featured person's image out, into the "small"
		$('#features img.person1').attr('src',image).attr('title',name).attr('alt',name);

		// swap the values in the array (1 -> 0, 0 -> 1)
		featured[0]['name'] = featured[1]['name'];
		featured[0]['description'] = featured[1]['description'];
		featured[0]['startimage'] = featured[1]['startimage'];
		featured[0]['video'] = featured[1]['video'];
		featured[0]['image'] = featured[1]['image'];

		featured[1]['name'] = name;
		featured[1]['description'] = description;
		featured[1]['startimage'] = startimage;
		featured[1]['video'] = video;
		featured[1]['image'] = image;

		// disable normal link behaviour
		return false;

	});

	// swap featured people
	$('#features img.person2').click(function () {
		// store the old values
		var name = featured[0]['name'];
		var description = featured[0]['description'];
		var startimage = featured[0]['startimage'];
		var video = featured[0]['video'];
		var image = featured[0]['image'];

		if(featuredPlayer.isLoaded()) {
			featuredPlayer.getClip().update({url: featured[2]['video']});
		}
		else {
			featuredPlayer.getClip(0).update({url: featured[2]['video']});
		}

		// replace the values in the DOM
		$('#crowdMemberName').html(featured[2]['name'].toLowerCase());
		$('#crowdMemberDescription').html(featured[2]['description']);
		$('#mainFeature img.person').attr('src',featured[2]['image']).attr('title',featured[2]['name']).attr('alt',featured[2]['name']);
		$('#featured').attr('href',featured[2]['video']);
		$('#featured').css('background-image','url('+featured[2]['startimage']+')');

		// swap the featured person's image out, into the "small"
		$('#features img.person2').attr('src',image).attr('title',name).attr('alt',name);

		// swap the values in the array (2 -> 0, 0 -> 2)
		featured[0]['name'] = featured[2]['name'];
		featured[0]['description'] = featured[2]['description'];
		featured[0]['startimage'] = featured[2]['startimage'];
		featured[0]['video'] = featured[2]['video'];
		featured[0]['image'] = featured[2]['image'];

		featured[2]['name'] = name;
		featured[2]['description'] = description;
		featured[2]['startimage'] = startimage;
		featured[2]['video'] = video;
		featured[2]['image'] = image;

		// disable normal link behaviour
		return false;
	});

	// select the black and white photos, make them ready for flipping
	$('div.person div.img').click(function () {
		var elem = $(this);

		// check if the element is already "flipped"
		if(elem.data('flipped'))
		{
			elem.revertFlip(); // call the built-in revertFlip function
			elem.data('flipped',false)
		}
		else
		{
			elem.flip({
				direction:'lr',
				speed: 100,
				color: '#9f9f9f',
				onBefore: function(){
					elem.html(elem.siblings('.currently').html());
				}
			});

			elem.data('flipped',true);
		}
	});

});
