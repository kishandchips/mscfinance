;(function($) {

	window.main = {
		init: function(){

			if($.fn.scroller){
				$('.scroller').each(function(){
					var scroller = $(this);
					var options = {};

					if(scroller.hasClass('gallery-scroller') || scroller.data('scroll-all') === true) options.scrollAll = true;
					if(scroller.data('auto-scroll') === true ) options.autoScroll = true;
					if(scroller.data('resize') === true ) options.resize = true;
					if(scroller.data('callback')) {
						scroller.bind('onChange', function(e, nextItem){
							var func = window[scroller.data('callback')];
							func($(this), nextItem);
						});					
					}
					
					scroller.scroller(options);
				});				
			}	

			$('.accordion-item').on('click', function() {
				var id = $(this).data('id');
				$('.content', this).slideToggle(300);
				$(this).toggleClass('open');
			});

			$(".mobile-category select").change(function() {
				console.log('change');
			  window.location = $(this).find("option:selected").val();
			});			

			$('#content h1:first, #content .row:first').addClass('first');	

			$('a[href^=#].scroll-to-btn').click(function(){
				var target = $($(this).attr('href'));
				var offsetTop = (target.length != 0) ? target.offset().top : 0;
				$('html,body').animate({scrollTop: offsetTop},'slow');
				return false;
			});

			$('.mobile-navigation-btn').on('click', function() {
				var navigation = $('.main-navigation');
				navigation.slideToggle(200);
			});

			$('#footer .mobile-navigation-btn').on('click', function() {
				var navigation = $('#footer #menu-primary-footer');
				navigation.slideToggle(200);
			});

			$(".gform_widget select").selecter();

	        if($.fn.prettyPhoto){
        		$('#lightbox').hide();

        		var prettyPhotoOptions = {
					social_tools: false,
					theme: 'light_square', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
					horizontal_padding: 0,
					opacity: 0.9,
					deeplinking: false,
					show_title: false,
					default_width: 850
					//callback: function() { $('body').removeClass('noscroll'); }
				}	

				$('a.zoom').prettyPhoto(prettyPhotoOptions);

				if( $('#lightbox').length > 0 && $(window).width() > 900 ){
					var delay = $('#lightbox').data('delay');
					setTimeout(function() {
						$.prettyPhoto.open('#lightbox');
						// $('body').addClass('noscroll');		
					}, delay);	
				}											
	        }

	        $('#content table').wrap( "<div class='scroll-table'></div>" );

			$.fn.simpleSlider = function(options) {
						
				var defaults = {
					navigation: true,
					prevText: "Prev",
					nextText: "Next",
					pagination: true,
					autoplay: false,
					delay: 8000,
					speed: 500,
					numItems: 1
				};
				var options = $.extend(defaults, options);

				var animateSlider = function(elem, compteur, opts) {
					elem.animate({
						marginLeft: -compteur + "%",
						marginTop: 0
					},  { 
						queue:false, 
						duration:opts.speed 
					});
				}
				
				return this.each(function() {
				
					var opts 		= options;
					var $this 		= $(this);              
					var elements 	= $this.children("div");
					var element		= elements.eq(0);
					var compteur 	= 0;
					var tmp_width = elements.width();
					var parentWidth = elements.parent().width();
					var percent = (100*tmp_width/parentWidth)/elements.length;
					var numItems = (opts.numItems > elements.length || opts.numItems < 1) ? parseInt(elements.length) : parseInt(opts.numItems);
					var largeur = ((100/numItems)*tmp_width/parentWidth);

					elements.addClass("slide").css({"width": percent + "%"});
					
					$this.css({"width": (100/numItems)*elements.length+"%"});
		
					if (opts.navigation) {
						if (elements.length > 1) {
							
							var prev_link = $("<a/>", {
								href: "#",
								html: opts.prevText
							}).addClass("prev nav icons-arrow-left");
							
							var next_link = $("<a/>", {
								href: "#",
								html: opts.nextText
							}).addClass("next nav icons-arrow-right");
							$this.parent().parent().prepend(prev_link);
							$this.parent().parent().append(next_link);
						
							prev_link.bind("click", function(e){
								if (compteur <= 0) compteur = largeur*(elements.length-numItems);
								else compteur -= largeur;
								animateSlider($this, compteur, opts);
								e.preventDefault();
							});
					
							next_link.bind("click", function(e){
								if (compteur >= largeur*(elements.length-numItems)) compteur = 0;
								else compteur += largeur;
								animateSlider($this, compteur, opts);
								e.preventDefault();
							});
						}
					}

					if (opts.pagination) {
						if (elements.length > 1) {
							var pagination_slider = $(document.createElement('div'));
							pagination_slider.attr("class", "carousel-index");
							
							elements.each(function(i) {
								var lien = $("<a/>", {
									href: "#",
									html: i+1
								}).addClass("slide-index slide-"+(i+1));
								pagination_slider.append(lien);
							});
							
							$this.parent().after(pagination_slider);

							pagination_slider.find("a").bind("click", function(e){
								var index_lien = $(this).index()+1;
								var parite_divs = elements.length % 2 == 0 ? 1 : 0;
								var parite_items = numItems % 2 == 0 ? 0 : 0.5;
								
								if (numItems > 1) {
									if (index_lien == 1 || index_lien <= (numItems/2)-parite_divs-parite_items) {
											compteur = 0;
									} else if (index_lien > (numItems/2)-parite_items && index_lien < (elements.length-((numItems/2)-1-parite_items)) ) {
										compteur = largeur*(index_lien-(numItems/2)-parite_items);
									} else if (index_lien >= elements.length) {
										compteur = largeur*(index_lien-numItems);
									} 
								} else {
									if (index_lien == 1) {	
										compteur = 0;
									} else {
										compteur = largeur*(index_lien-numItems);
									}
								}

								pagination_slider.find("a").not($(this)).removeClass("clic");
								$(this).addClass("clic");
								animateSlider($this, compteur, opts);
								e.preventDefault();
							});
						}
					}
			
					if (opts.autoplay) {
						if (elements.length > 1) {
							window.setInterval(function(){
								if (compteur >= largeur*(elements.length-numItems)) compteur = 0;
								else compteur += largeur;
								animateSlider($this, compteur, opts);
							}, opts.delay);
						}
					}
				});
			};
			$(window).resize(this.resize);
		},		

		loaded: function(){
			this.setBoxSizing();
			if($.fn.simpleSlider){
				$(".news-slider").simpleSlider({
					navigation: true,
					prevText: "",
					nextText: "",
					pagination: false,
					autoplay: false,
					speed: 500,
					numItems: 2
				});
			}					
		},

		setBoxSizing: function(){
			if( $('html').hasClass('no-boxsizing') ){
		        $('.span:visible').each(function(){
		        	console.log($(this).attr('class'));
		        	var span = $(this);
		            var fullW = span.outerWidth(),
		                actualW = span.width(),
		                wDiff = fullW - actualW,
		                newW = actualW - wDiff;			
		            span.css('width',newW);
		        });
		    }
		},

		slideUpBox: function(){
			var s = $(window).scrollTop(),
		        d = $(document).height(),
		        c = $(window).height();
		        scrollPercent = (s / (d-c)) * 100;

			var slideupbox = $("#slideupbox");

			if ( slideupbox.is( ".slideup" ) ) {
			    if (scrollPercent < 70) {
			        slideupbox.slideUp();
			    }
			    else {
					setTimeout(function() {
						if (scrollPercent > 70) {
				           	slideupbox.slideDown();
				    	}					
					}, 2000);			    			
				}
			}

			$('#slideupbox .close-link').click(function() {
				$('#slideupbox').slideUp().addClass('hide');
				return false;
			});			
		},

		equalHeight: function(){
			if($('.equal-height').length !== 0){
		
				var currTallest = 0,
				currRowStart = 0,
				rowDivs = new Array(),
				topPos = 0;

				$('.equal-height').each(function() {

					var element = $(this);
					topPos = element.offset().top;
					element.height('auto');
					if (currRowStart != topPos) {

						for (i = 0 ; i < rowDivs.length ; i++) {
							rowDivs[i].height(currTallest);
						}

						rowDivs.length = 0;
						currRowStart = topPos;
						currTallest = element.height();
						rowDivs.push(element);
					} else {
						rowDivs.push(element);
						currTallest = (currTallest < element.height()) ? (element.height()) : (currTallest);
					}

					for (i = 0 ; i < rowDivs.length ; i++) {
						rowDivs[i].height(currTallest);
					}
				});
			}
		},		
		
		resize: function(){
			main.equalHeight();	
		}
	}

	$(function(){
		main.init();
		
	});

	$(window).load(function(){
		main.loaded();
		main.equalHeight();	
		main.resize();	
	});
	
	$(window).scroll(function() {
		if ($(window).width() > 1000) {
		    main.slideUpBox();
		}	
	});
	
	$(window).resize(function() {
		if ($(window).width() < 800) {
			$("#slideupbox").hide();
		}
	});
	
})(jQuery);
