$(window).load(function() {

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

	function swapPeople(x) {
		// store the old values
		var name = featured[0]['name'];
		var description = featured[0]['description'];
		var startimage = featured[0]['startimage'];
		var video = featured[0]['video'];
		var image = featured[0]['image'];

		if(featuredPlayer.isLoaded()) {
			featuredPlayer.getClip().update({url: featured[x]['video']});
		}
		else {
			featuredPlayer.getClip(0).update({url: featured[x]['video']});
		}

		// replace the values in the DOM
		$('#crowdMemberName').html(featured[x]['name'].toLowerCase());
		$('#crowdMemberDescription').html(featured[x]['description']);
		$('#mainFeature img.person').attr('src',featured[x]['image']).attr('title',featured[x]['name']).attr('alt',featured[x]['name']);
		$('#featured').attr('href',featured[x]['video']);
		$('#featured').css('background-image','url('+featured[x]['startimage']+')');

		// swap the featured person's image out, into the "small"
		$('#features img.person'+x).attr('src',image).attr('title',name).attr('alt',name);

		// swap the values in the array (x -> 0, 0 -> x)
		featured[0]['name'] = featured[x]['name'];
		featured[0]['description'] = featured[x]['description'];
		featured[0]['startimage'] = featured[x]['startimage'];
		featured[0]['video'] = featured[x]['video'];
		featured[0]['image'] = featured[x]['image'];

		featured[x]['name'] = name;
		featured[x]['description'] = description;
		featured[x]['startimage'] = startimage;
		featured[x]['video'] = video;
		featured[x]['image'] = image;
	}

	// swap featured people
	$('#features img.person1').live('click', function () {
		swapPeople(1);

		// disable normal link behaviour
		return false;
	});

	// swap featured people
	$('#features img.person2').live('click', function () {
		swapPeople(2);

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

	// shika a few divs so we don't have to match them every time
	var $feature = $('#feature');
	var $jobs = $('#jobs');

	// a simple function to replace one div with another
	function replaceDiv($div1, $div2) {
		$div1.fadeOut(1, function () {
			$div1 = $div1.replaceWith($div2);
			$div2.fadeIn(200);
		});
	}

	$('#ilrijobs').live('click', function () {
		featuredPlayer.unload();
		replaceDiv($feature,$jobs);
	});

	$('a.close').live('click', function () {
		replaceDiv($(this).parent(),$feature);

		// disable normal link behavior
		return false;
	});

});
