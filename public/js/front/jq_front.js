$().ready(function(){ 


//$('.page_slider').accordion({  collapsible: true });

//$( "#accordion" ).accordion( "refresh" );
 
//$("#accordion").accordion({collapsible : true, active : false});




//$(".example-image-link a").addClass('example-4'); 
//$(".example-image-link a").attr('data-lightbox', 'example-4'); 
//<div class="image-row">
	//      <a class="example-image-link" href="/public/usefiles/Goleus.jpg"  data-lightbox="example-4" data-title="Goleus"><img class="example-image" src="/public/usefiles/Goleus.jpg" alt="images"   /></a>
		
		//  </div>

		//ТЕст акардиона 
$(".acc_content").hide();
$("body").on('click','.acc_title',function(event){

//$(".acc_content").stop( true, true ).slideUp();


$(this).next().stop( true, true ).slideToggle();

});

$("body").on('click','.w_close',function(event){

$(this).closest('.urss_form').fadeOut();

});


//Рассылка запись мыла в файл

 $("body").on('click','.urss',function(e){
 	e.preventDefault();
 	if($(this).next('.urss_form').is(':visible')){
 		$('.urss_form').stop( true, true ).slideToggle("slow");

 	}else{
 		$('.urss_form').remove();
 	$(this).after('<div class="urss_form" style=" display:none;    text-align: center;   position: absolute;   height: 180px;    width: 300px;   border: 1px solid rebeccapurple; background: wheat; top: 30px; z-index: 9999;"><div class="w_close" style="    position: absolute;  margin: 5px;  right: 0; cursor: pointer;font-weight:bold">X</div><form id="fm_fsm" name="fm_fsm"><p style="margin-bottom:5px;font-weight:bold;"><label for="mu_name">Name</label></p><input id="mu_name" name="mu_name" size="30" type="text"><p style="margin-bottom:5px;font-weight:bold;"><label for="mu_mail">e-mail</label></p><input id="mu_mail" name="mu_mail" size="30" type="text"><div><p><input name="fsm_type" type="hidden" value="urss"></p></div><p style="margin-bottom: 0;"><input name="btn_fsm" type="button" value="Підписатись"></p></form></div>');
 	$('.urss_form').stop( true, true ).slideToggle("slow");
 		//$('.urss_form').remove();
}
});





		$.fn.extend({

		//pass the options variable to the function
		accordion: function(options) {
				
		var defaults = {
			accordion: 'true',
			speed: 300,
			closedSign: '[+]',
			openedSign: '[-]'
		};

		// Extend our default options with those provided.
		var opts = $.extend(defaults, options);
		//Assign current element to variable, in this case is UL element
		var $this = $(this);
		
		//add a mark [+] to a multilevel menu
		$this.find("li").each(function() {
			if($(this).find("ul").size() != 0){
				//add the multilevel sign next to the link
				//$(this).find("a:first").append("<span>"+ opts.closedSign +"</span>");
				
				//avoid jumping to the top of the page when the href is an #
				if($(this).find("a:first").attr('href') == "#"){
						$(this).find("a:first").click(function(){return false;});
					}
			}
		});

		//open active level
		$this.find("li.active").each(function() {
			$(this).parents("ul").slideDown(opts.speed);
			$(this).parents("ul").parent("li").find("span:first").html(opts.openedSign);
		});

			$this.find("li a").click(function() {
				if($(this).parent().find("ul").size() != 0){
					if(opts.accordion){
						//Do nothing when the list is open
						if(!$(this).parent().find("ul").is(':visible')){
							parents = $(this).parent().parents("ul");
							visible = $this.find("ul:visible");
							visible.each(function(visibleIndex){
								var close = true;
								parents.each(function(parentIndex){
									if(parents[parentIndex] == visible[visibleIndex]){
										close = false;
										return false;
									}
								});
								if(close){
									if($(this).parent().find("ul") != visible[visibleIndex]){
										$(visible[visibleIndex]).slideUp(opts.speed, function(){
											$(this).parent("li").find("span:first").html(opts.closedSign);
										});
										
									}
								}
							});
						}
					}
					if($(this).parent().find("ul:first").is(":visible")){
						$(this).parent().find("ul:first").slideUp(opts.speed, function(){
							$(this).parent("li").find("span:first").delay(opts.speed).html(opts.closedSign);
						});
						
						
					}else{
						$(this).parent().find("ul:first").slideDown(opts.speed, function(){
							$(this).parent("li").find("span:first").delay(opts.speed).html(opts.openedSign);
						});
					}
				}
			});
		}
});
				//alert(document.domain);

			if(document.location.href == document.domain  ){  
				var cookieOptions = {expires: 7, path: '/'};      
				$.cookie('active', null, {path:'/'});


			}

			
	if($(".logos").attr('data')!=null){
		var cookieOptions = {expires: 7, path: '/'};
		var logo = $(".logos").attr('data');

		$.cookie('logos', logo, cookieOptions);

	}



 $(".dropdown ul li").click(function () {
      $("#left-menu .dropdown ul li").each(function(){
        $(this).removeClass("active_l");
      });
     $("#left-menu ul li.menu").each(function(){

      });
        $(this).closest("#left-menu .dropdown ul li").toggleClass("active_l");
        $(this).closest("#left-menu ul li.menu").toggleClass("active_l");
        
});
$("#left-menu > ul > li").click(function () {
      $(this).each(function(){
        $(this).siblings().removeClass("active_l");        
        $(this).toggleClass("active_l");
      });
      
});



 $(".subblock_c").click(function(){
//$('div#center-punct').css("display","none");


/* setTimeout(function () {

}, 3000);  */
var rr = $('div#center-punct').css("display");
//alert($('div#center-punct').css("display"));
if( rr != 'none'){
	$('div#center-punct').slideUp("normal");
}

//$('div#center-punct').addClass("aaa");
	//$('.subblock_c').removeClass("active");
 //$(this).toggleClass("active");
	if($(this).attr('path')){

	var path = $(this).attr('path');
var parent_url_title =$(this).find("a").attr('href');
//$('div#center-punct').slideDown(4000);
//alert($(this).attr('path'));
 $.ajax({
	url: document.location.href,
	type: 'POST',
	dataType: 'json',  
	data: {subblock_path : path},
	success: function(datas){
//console.log(datas.subBlockMenu['name']);

		 //$('div#center-punct').remove();
		 	$("#content").empty();
		 $('div#content').prepend('<div id="center-punct" class="pullDown" > </div>');
		 $('div#content').append('<div id="page_text" > </div>');
						for (var i in datas['subBlockMenu'])  {												
							if(i == 0)
								var active_c = 'class = "active_c"';							
								$('div#center-punct').append(' <div  class="punct_menu_lvl_1 slideUp"><a  '+active_c+' style="width:'+((950 - ((datas['subBlockMenu'].length)*10)) / datas['subBlockMenu'].length )+'px" href="/'+parent_url_title+'/'+datas['subBlockMenu'][i].url_title+'">'+datas['subBlockMenu'][i].name+'</a></div>');
								active_c = '';
					
						 }
						//console.log(datas['content'][0].content);
						$("#page_text").append(datas['content'][0].content);						



						$(".accordion2 div").hide();
						//$("#accordion").accordion({collapsible : true, active : false});
						//$("#accordion").accordion({collapsible : true, active : false});
				}
});

$('div#center-punct').slideDown("normal");
$('div#center-punct').css("min-height","0");
//$('div#center-punct').slideDown("normal").delay("normal");
// $('div#center-punct').addClass("aaa");
 //$('div#center-punct').show();
//setTimeout(function () {
//$('div#center-punct').show();
//}, 300); // время в мс


}






		});






//Функция изменения урл без перегрузки из Hurl.js


		$(function(){
				var $categoryProducts = $('#content');
				var $subblock = $('.dropdown');
				var path;
				$categoryProducts.on('click', '.punct_menu_lvl_1 a', function(e){


					 $(".punct_menu_lvl_1 a").each(function(){
				        $(this).removeClass("active_c");
				     // alert(current.href);
				      });



					  $(this).closest(".punct_menu_lvl_1 a").toggleClass('active_c');
						e.preventDefault();
						path =  $(this).attr('href');
						History.pushState(null, document.title, $(this).attr('href'));
					
				});





				$subblock.on('click', '.subblock_c a', function(e){	
						e.preventDefault();

						path =  $(this).attr('href');
						History.pushState(null, document.title, $(this).attr('href'));
					
				});
 
				function loadPage(url) {            
					//  $categoryProducts.load(url + " .center-punct > *");
					//alert(path);

					 $.ajax({
						url: document.location.href,
						type: 'POST',
						dataType: 'json',  
						data: {page_path : url},
						success: function(datas){
							if (datas['cpd'])
							if (datas['cpd']['url'] != '#' && datas['cpd']['porydok'] == '1') {
								$('.fkns').css('display','block');
								}else{
									$('.fkns').css('display','none');
								}
							$("#page_text").empty();				
						 		//$('div#content').append('<div id="page_text"> </div>');

						//$("#content").prepend(datas['menu_center']);
						$("#page_text").append(datas['content'][0].content);


						}
			
					});

					
				}
 
				History.Adapter.bind(window, 'statechange',function(e){
						var State = History.getState();
						loadPage(State.url);
				});
		});

//Функция  (конец)








/*  js lightbox открывание картинок        */



var LightboxOptions = (function() {
		function LightboxOptions() {
			this.fadeDuration                = 500;
			this.fitImagesInViewport         = true;
			this.resizeDuration              = 700;
			this.positionFromTop             = 50;
			this.showImageNumberLabel        = true;
			this.alwaysShowNavOnTouchDevices = false;
			this.wrapAround                  = false;
		}
		
		// Change to localize to non-english language
		LightboxOptions.prototype.albumLabel = function(curImageNum, albumSize) {
			return "Image " + curImageNum + " of " + albumSize;
		};

		return LightboxOptions;
	})();


	var Lightbox = (function() {
		function Lightbox(options) {
			this.options           = options;
			this.album             = [];
			this.currentImageIndex = void 0;
			this.init();
		}

		Lightbox.prototype.init = function() {
			this.enable();
			this.build();
		};

		// Loop through anchors and areamaps looking for either data-lightbox attributes or rel attributes
		// that contain 'lightbox'. When these are clicked, start lightbox.
		Lightbox.prototype.enable = function() {
			var self = this;
			$('body').on('click', 'a[rel^=lightbox], area[rel^=lightbox], a[data-lightbox], area[data-lightbox]', function(event) {
				self.start($(event.currentTarget));
				return false;
			});
		};

		// Build html for the lightbox and the overlay.
		// Attach event handlers to the new DOM elements. click click click
		Lightbox.prototype.build = function() {
			var self = this;
			$("<div id='lightboxOverlay' class='lightboxOverlay'></div><div id='lightbox' class='lightbox'><div class='lb-outerContainer'><div class='lb-container'><img class='lb-image' src='' /><div class='lb-nav'><a class='lb-prev' href='' ></a><a class='lb-next' href='' ></a></div><div class='lb-loader'><a class='lb-cancel'></a></div></div></div><div class='lb-dataContainer'><div class='lb-data'><div class='lb-details'><span class='lb-caption'></span><span class='lb-number'></span></div><div class='lb-closeContainer'><a class='lb-close'></a></div></div></div></div>").appendTo($('html'));
			
			// Cache jQuery objects
			this.$lightbox       = $('#lightbox');
			this.$overlay        = $('#lightboxOverlay');
			this.$outerContainer = this.$lightbox.find('.lb-outerContainer');
			this.$container      = this.$lightbox.find('.lb-container');

			// Store css values for future lookup
			this.containerTopPadding = parseInt(this.$container.css('padding-top'), 10);
			this.containerRightPadding = parseInt(this.$container.css('padding-right'), 10);
			this.containerBottomPadding = parseInt(this.$container.css('padding-bottom'), 10);
			this.containerLeftPadding = parseInt(this.$container.css('padding-left'), 10);
			
			// Attach event handlers to the newly minted DOM elements
			this.$overlay.hide().on('click', function() {
				self.end();
				return false;
			});

			this.$lightbox.hide().on('click', function(event) {
				if ($(event.target).attr('id') === 'lightbox') {
					self.end();
				}
				return false;
			});

			this.$outerContainer.on('click', function(event) {
				if ($(event.target).attr('id') === 'lightbox') {
					self.end();
				}
				return false;
			});

			this.$lightbox.find('.lb-prev').on('click', function() {
				if (self.currentImageIndex === 0) {
					self.changeImage(self.album.length - 1);
				} else {
					self.changeImage(self.currentImageIndex - 1);
				}
				return false;
			});

			this.$lightbox.find('.lb-next').on('click', function() {
				if (self.currentImageIndex === self.album.length - 1) {
					self.changeImage(0);
				} else {
					self.changeImage(self.currentImageIndex + 1);
				}
				return false;
			});

			this.$lightbox.find('.lb-loader, .lb-close').on('click', function() {
				self.end();
				return false;
			});
		};

		// Show overlay and lightbox. If the image is part of a set, add siblings to album array.
		Lightbox.prototype.start = function($link) {
			var self    = this;
			var $window = $(window);

			$window.on('resize', $.proxy(this.sizeOverlay, this));

			$('select, object, embed').css({
				visibility: "hidden"
			});

			this.sizeOverlay();

			this.album = [];
			var imageNumber = 0;

			function addToAlbum($link) {
				self.album.push({
					link: $link.attr('href'),
					title: $link.attr('data-title') || $link.attr('title')
				});
			}

			// Support both data-lightbox attribute and rel attribute implementations
			var dataLightboxValue = $link.attr('data-lightbox');
			var $links;

			if (dataLightboxValue) {
				$links = $($link.prop("tagName") + '[data-lightbox="' + dataLightboxValue + '"]');
				for (var i = 0; i < $links.length; i = ++i) {
					addToAlbum($($links[i]));
					if ($links[i] === $link[0]) {
						imageNumber = i;
					}
				}
			} else {
				if ($link.attr('rel') === 'lightbox') {
					// If image is not part of a set
					addToAlbum($link);
				} else {
					// If image is part of a set
					$links = $($link.prop("tagName") + '[rel="' + $link.attr('rel') + '"]');
					for (var j = 0; j < $links.length; j = ++j) {
						addToAlbum($($links[j]));
						if ($links[j] === $link[0]) {
							imageNumber = j;
						}
					}
				}
			}
			
			// Position Lightbox
			var top  = $window.scrollTop() + this.options.positionFromTop;
			var left = $window.scrollLeft();
			this.$lightbox.css({
				top: top + 'px',
				left: left + 'px'
			}).fadeIn(this.options.fadeDuration);

			this.changeImage(imageNumber);
		};

		// Hide most UI elements in preparation for the animated resizing of the lightbox.
		Lightbox.prototype.changeImage = function(imageNumber) {
			var self = this;

			this.disableKeyboardNav();
			var $image = this.$lightbox.find('.lb-image');

			this.$overlay.fadeIn(this.options.fadeDuration);

			$('.lb-loader').fadeIn('slow');
			this.$lightbox.find('.lb-image, .lb-nav, .lb-prev, .lb-next, .lb-dataContainer, .lb-numbers, .lb-caption').hide();

			this.$outerContainer.addClass('animating');

			// When image to show is preloaded, we send the width and height to sizeContainer()
			var preloader = new Image();
			preloader.onload = function() {
				var $preloader, imageHeight, imageWidth, maxImageHeight, maxImageWidth, windowHeight, windowWidth;
				$image.attr('src', self.album[imageNumber].link);

				$preloader = $(preloader);

				$image.width(preloader.width);
				$image.height(preloader.height);
				
				if (self.options.fitImagesInViewport) {
					// Fit image inside the viewport.
					// Take into account the border around the image and an additional 10px gutter on each side.

					windowWidth    = $(window).width();
					windowHeight   = $(window).height();
					maxImageWidth  = windowWidth - self.containerLeftPadding - self.containerRightPadding - 20;
					maxImageHeight = windowHeight - self.containerTopPadding - self.containerBottomPadding - 120;

					// Is there a fitting issue?
					if ((preloader.width > maxImageWidth) || (preloader.height > maxImageHeight)) {
						if ((preloader.width / maxImageWidth) > (preloader.height / maxImageHeight)) {
							imageWidth  = maxImageWidth;
							imageHeight = parseInt(preloader.height / (preloader.width / imageWidth), 10);
							$image.width(imageWidth);
							$image.height(imageHeight);
						} else {
							imageHeight = maxImageHeight;
							imageWidth = parseInt(preloader.width / (preloader.height / imageHeight), 10);
							$image.width(imageWidth);
							$image.height(imageHeight);
						}
					}
				}
				self.sizeContainer($image.width(), $image.height());
			};

			preloader.src          = this.album[imageNumber].link;
			this.currentImageIndex = imageNumber;
		};

		// Stretch overlay to fit the viewport
		Lightbox.prototype.sizeOverlay = function() {
			this.$overlay
				.width($(window).width())
				.height($(document).height());
		};

		// Animate the size of the lightbox to fit the image we are showing
		Lightbox.prototype.sizeContainer = function(imageWidth, imageHeight) {
			var self = this;
			
			var oldWidth  = this.$outerContainer.outerWidth();
			var oldHeight = this.$outerContainer.outerHeight();
			var newWidth  = imageWidth + this.containerLeftPadding + this.containerRightPadding;
			var newHeight = imageHeight + this.containerTopPadding + this.containerBottomPadding;
			
			function postResize() {
				self.$lightbox.find('.lb-dataContainer').width(newWidth);
				self.$lightbox.find('.lb-prevLink').height(newHeight);
				self.$lightbox.find('.lb-nextLink').height(newHeight);
				self.showImage();
			}

			if (oldWidth !== newWidth || oldHeight !== newHeight) {
				this.$outerContainer.animate({
					width: newWidth,
					height: newHeight
				}, this.options.resizeDuration, 'swing', function() {
					postResize();
				});
			} else {
				postResize();
			}
		};

		// Display the image and it's details and begin preload neighboring images.
		Lightbox.prototype.showImage = function() {
			this.$lightbox.find('.lb-loader').hide();
			this.$lightbox.find('.lb-image').fadeIn('slow');
		
			this.updateNav();
			this.updateDetails();
			this.preloadNeighboringImages();
			this.enableKeyboardNav();
		};

		// Display previous and next navigation if appropriate.
		Lightbox.prototype.updateNav = function() {
			// Check to see if the browser supports touch events. If so, we take the conservative approach
			// and assume that mouse hover events are not supported and always show prev/next navigation
			// arrows in image sets.
			var alwaysShowNav = false;
			try {
				document.createEvent("TouchEvent");
				alwaysShowNav = (this.options.alwaysShowNavOnTouchDevices)? true: false;
			} catch (e) {}

			this.$lightbox.find('.lb-nav').show();

			if (this.album.length > 1) {
				if (this.options.wrapAround) {
					if (alwaysShowNav) {
						this.$lightbox.find('.lb-prev, .lb-next').css('opacity', '1');
					}
					this.$lightbox.find('.lb-prev, .lb-next').show();
				} else {
					if (this.currentImageIndex > 0) {
						this.$lightbox.find('.lb-prev').show();
						if (alwaysShowNav) {
							this.$lightbox.find('.lb-prev').css('opacity', '1');
						}
					}
					if (this.currentImageIndex < this.album.length - 1) {
						this.$lightbox.find('.lb-next').show();
						if (alwaysShowNav) {
							this.$lightbox.find('.lb-next').css('opacity', '1');
						}
					}
				}
			}
		};

		// Display caption, image number, and closing button.
		Lightbox.prototype.updateDetails = function() {
			var self = this;

			// Enable anchor clicks in the injected caption html.
			// Thanks Nate Wright for the fix. @https://github.com/NateWr
			if (typeof this.album[this.currentImageIndex].title !== 'undefined' && this.album[this.currentImageIndex].title !== "") {
				this.$lightbox.find('.lb-caption')
					.html(this.album[this.currentImageIndex].title)
					.fadeIn('fast')
					.find('a').on('click', function(event){
						location.href = $(this).attr('href');
					});
			}
		
			if (this.album.length > 1 && this.options.showImageNumberLabel) {
				this.$lightbox.find('.lb-number').text(this.options.albumLabel(this.currentImageIndex + 1, this.album.length)).fadeIn('fast');
			} else {
				this.$lightbox.find('.lb-number').hide();
			}
		
			this.$outerContainer.removeClass('animating');
		
			this.$lightbox.find('.lb-dataContainer').fadeIn(this.options.resizeDuration, function() {
				return self.sizeOverlay();
			});
		};

		// Preload previous and next images in set.
		Lightbox.prototype.preloadNeighboringImages = function() {
			if (this.album.length > this.currentImageIndex + 1) {
				var preloadNext = new Image();
				preloadNext.src = this.album[this.currentImageIndex + 1].link;
			}
			if (this.currentImageIndex > 0) {
				var preloadPrev = new Image();
				preloadPrev.src = this.album[this.currentImageIndex - 1].link;
			}
		};

		Lightbox.prototype.enableKeyboardNav = function() {
			$(document).on('keyup.keyboard', $.proxy(this.keyboardAction, this));
		};

		Lightbox.prototype.disableKeyboardNav = function() {
			$(document).off('.keyboard');
		};

		Lightbox.prototype.keyboardAction = function(event) {
			var KEYCODE_ESC        = 27;
			var KEYCODE_LEFTARROW  = 37;
			var KEYCODE_RIGHTARROW = 39;

			var keycode = event.keyCode;
			var key     = String.fromCharCode(keycode).toLowerCase();
			if (keycode === KEYCODE_ESC || key.match(/x|o|c/)) {
				this.end();
			} else if (key === 'p' || keycode === KEYCODE_LEFTARROW) {
				if (this.currentImageIndex !== 0) {
					this.changeImage(this.currentImageIndex - 1);
				} else if (this.options.wrapAround && this.album.length > 1) {
					this.changeImage(this.album.length - 1);
				}
			} else if (key === 'n' || keycode === KEYCODE_RIGHTARROW) {
				if (this.currentImageIndex !== this.album.length - 1) {
					this.changeImage(this.currentImageIndex + 1);
				} else if (this.options.wrapAround && this.album.length > 1) {
					this.changeImage(0);
				}
			}
		};

		// Closing time. :-(
		Lightbox.prototype.end = function() {
			this.disableKeyboardNav();
			$(window).off("resize", this.sizeOverlay);
			this.$lightbox.fadeOut(this.options.fadeDuration);
			this.$overlay.fadeOut(this.options.fadeDuration);
			$('select, object, embed').css({
				visibility: "visible"
			});
		};

		return Lightbox;

	})();

	$(function() {
		var options  = new LightboxOptions();
		var lightbox = new Lightbox(options);
	});



//Функция сладирование левого меню фронта сайта

$(document).ready(function(){
	$.easing.def = "easeInOutQuad";
	$('li.button a').click(function(e){
		var dropDown = $(this).parent().next();
		$('#left-menu .dropdown').stop( true, true ).not(dropDown).slideUp('slow');
		dropDown.slideToggle('slow');
		e.preventDefault();
	})  
});

//Функция сладирование левого меню фронта сайта (конец)




// Демонстрация liteAccordion
			$('#fakultet').liteAccordion({
containerWidth : 920,           // ширина аккордеона (px)

containerHeight : 200,          // высота аккордеона (px)

headerWidth : 40, 
			
				
					theme : 'gray',
					rounded : true
								
			}).find('figcaption:first').show();
			//$('#fakultet').liteAccordion();
			//$('#three').liteAccordion({ theme : 'dark', containerWidth : 600, containerHeight : 200, slideSpeed : 600, firstSlide : 2 });



//Поиск по сайту

	$("#site-search").click(function() {
		$(this).val('');
	});









		//    При клике на кнопку btn_fsm(button form send mail) обрабатует данніе для отправки их на ємаил из формі form_mail
		$('body').on('click',' input[name="btn_fsm"]', function(){
			var data_form;
			//fm_sm(forma send mail)
			data_form   = $('#fm_fsm').serialize();
			// var data_form = {'Name': 'Michael', 'Age': '22', 'Country': 'Russia'}; // Создаём ассоциативный массив
		
			//alert(document.location.href);


			//$('#fm_fsm').trigger('reset');
			//console.log( data_form);
			$.ajax({
				url: document.location.href,
				type: 'POST',
				dataType: 'json',  
				data: data_form,
				success: function(datas){		
				//	console.log( datas);
					$(".note").remove();
						$("#fm_fsm").after("<div class='note' style='color:"+datas.color+";font-size:"+datas.fontSize+"px'><b>"+datas.textNote+"</b></div>");
						if(datas.sendStat == 1){
							$('#fm_fsm').trigger('reset');
						}

						//location.href =document.location.href;

					//	console.log( datas);
						/*
					switch (datas['id']){
						case 1:
								drop_this.append("<div    class='cssmenu cart l_menu portlet stretchLeft object'><li class='block_menu has-sub block_sub '  style='background: url(/public/img/front/menu_img/block1.gif) no-repeat'><a class='portlet-header' href='#'><span >"+datas['name']+"</span></a><ul class='portlet-content' ></ul></li></div>");
							break;
						case 2:
								//drop_this.append('<div class="punct_menu_lvl_0 slideUp punct_sub "><a href="">'+datas['name']+'</a></div>');
							break;
						case 3:
								//drop_this.append('<div class="punct_menu_lvl_1 slideUp "><a href="/mychem/adminka-site-udhtu/edit/46">'+datas['name']+'<img class="pulse" src="/public/img/global/icon/info_err.png"></a></div>');
							break;
						case 4:
								
							break;		
						default:
							//alert("4 switch 372  stroka layouta");
							break;
					}*/
				}
			});
		});




		//    форма отправки Опроса


$(".op_select").change(function() {
		var data_select = $( this ).val();
	//alert($( this ).val());
	
			$.ajax({
				url: document.location.href,
				type: 'POST',
				dataType: 'json',  
				data: "mu_ints="+data_select,
				success: function(datas){					
					var opt = '';
						for(var i in datas)
							for(var ii in  datas[i]){
								//console.log( datas[i][ii]);
								opt += '<option value="'+datas[i][ii].id_mrd+'">'+datas[i][ii].name+'</option>' ;

						}
						console.log( opt);
						$('.op_select').prop('name','') ;
						$(".op_select2").remove();
						$('.op_select').after('<select style="margin-left:20px; display:block;"class ="op_select2" name="select_59_60_1">'+opt+'</select>');

				}
			});

  });






 $('#fm_opros').keydown(function(event){
        if(event.keyCode == 13) {
          event.preventDefault();
          return false;
      }
   });



		$('body').on('click','#op_btn_save', function(){
			var data_form,data_form_arr,passed = true;		
data_form_arr   = $('#fm_opros').serializeArray();


$('label').each(function () {	
	if ($(this).prop('id') != '')  		
  		$(this).addClass("allError");
  
});


for(var i in data_form_arr){
console.log( data_form_arr[i]);	
if($.trim(data_form_arr[i].value) != ''){
	$('#'+data_form_arr[i].name).removeClass("allError");
}

}

$('label').each(function () {
	if ($(this).hasClass("allError"))  		
  		passed = false;
});





				
			data_form   = $('#fm_opros').serialize();
			// var data_form = {'Name': 'Michael', 'Age': '22', 'Country': 'Russia'}; // Создаём ассоциативный массив		
			//$('#fm_fsm').trigger('reset');
		//console.log( data_form1);
		if (passed) 
			$.ajax({
				url: document.location.href,
				type: 'POST',
				dataType: 'json',  
				data: data_form,
				success: function(datas){		
						 $('#content').empty();
						 $('#content').append('<center><div style="font-size:18px;font-weight:bold;color:green;">Дякуємо!<br> <br><a href="'+document.location.href+'">Повернутися до тестування.</a></div></center>');

					//alert(datas);
					//$(".note").remove();
				//		$("#fm_fsm").after("<div class='note' style='color:"+datas.color+";font-size:"+datas.fontSize+"px'><b>"+datas.textNote+"</b></div>");
				//		if(datas.sendStat == 1){
				//			$('#fm_fsm').trigger('reset');
				//		}

						//location.href =document.location.href;

					//	console.log( datas);
						/*
					switch (datas['id']){
						case 1:
								drop_this.append("<div    class='cssmenu cart l_menu portlet stretchLeft object'><li class='block_menu has-sub block_sub '  style='background: url(/public/img/front/menu_img/block1.gif) no-repeat'><a class='portlet-header' href='#'><span >"+datas['name']+"</span></a><ul class='portlet-content' ></ul></li></div>");
							break;
						case 2:
								//drop_this.append('<div class="punct_menu_lvl_0 slideUp punct_sub "><a href="">'+datas['name']+'</a></div>');
							break;
						case 3:
								//drop_this.append('<div class="punct_menu_lvl_1 slideUp "><a href="/mychem/adminka-site-udhtu/edit/46">'+datas['name']+'<img class="pulse" src="/public/img/global/icon/info_err.png"></a></div>');
							break;
						case 4:
								
							break;		
						default:
							//alert("4 switch 372  stroka layouta");
							break;
					}*/
				}
			});
		});


















});