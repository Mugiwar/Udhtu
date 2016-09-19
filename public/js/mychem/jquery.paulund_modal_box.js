/**
 * JQuery Plugin for a modal box
 * Will create a simple modal box with all HTML and styling
 * 
 * Author: Paul Underwood
 * URL: http://www.paulund.co.uk
 * 
 * Available for free download from http://www.paulund.co.uk
 */

(function($){

	// Defining our jQuery plugin
var id_conf;
var status;
	$.fn.paulund_modal_box = function(prop){

		// Default parameters

		var options = $.extend({
			height : "250",
			width : "500",
			//title:"Отправить тезисы по ФУЕЛ",
			//description: '<form class="send_mail_form" action="" method="post" enctype="multipart/form-data"><input type="file" name="file_tezis" size="30"> <input type="submit" value="Отправить тезисы" name="submit"></form>',
			top: "20%",
			left: "30%",
		},prop);
				
		//Click event on element
		return this.click(function(e){
				 id_conf = $(this).attr('id_conf');
				 status = $(this).attr('status');
				
			add_block_page();
			add_popup_box();
			add_styles();		

			switch(status){
				case '1':
					$('.paulund_inner_modal_box').empty();
					$('.paulund_inner_modal_box').append('<h2>Файл вже було відправлено. Чекайте на рішення організаційного комітету.</h2>');
				 break;
				 case '3':
					$('.paulund_inner_modal_box').empty();
					$('.paulund_inner_modal_box').append('<h2>Файл вже було відправлено. Чекайте на рішення організаційного комітету.</h2>');
				 break;
				 case '5':
					$('.paulund_inner_modal_box').empty();
					$('.paulund_inner_modal_box').append('<h2>Файл вже було відправлено. Чекайте на рішення організаційного комітету.</h2>');
				 break;



			}


			
			$('.paulund_modal_box').fadeIn();
			
			//alert(status);
			 $('.send_mail_form').append('<input type="hidden" name="id_conf" value="'+id_conf+'">');
		});
		
		/**
		 * Add styles to the html markup
		 */
		 function add_styles(){			
			$('.paulund_modal_box').css({ 
				'position':'absolute', 
				'left':options.left,
				'top':options.top,
				'display':'none',
				'height': options.height + 'px',
				'width': options.width + 'px',
				'border':'1px solid #fff',
				'box-shadow': '0px 2px 7px #292929',
				'-moz-box-shadow': '0px 2px 7px #292929',
				'-webkit-box-shadow': '0px 2px 7px #292929',
				'border-radius':'10px',
				'-moz-border-radius':'10px',
				'-webkit-border-radius':'10px',
				'background': '#f2f2f2', 
				'z-index':'50',
			});
			$('.paulund_modal_close').css({
				'position':'relative',
				'top':'-25px',
				'left':'20px',
				'float':'right',
				'display':'block',
				'height':'50px',
				'width':'50px',
				'background': 'url(/public/img/mychem/conference/form/close_add_autor.png) no-repeat',
			});
			$('.paulund_block_page').css({
				'position':'fixed',
				'top':'0',
				'left':'0',				
				'background-color':'rgba(0,0,0,0.6)',
				'height':'100%',
				'width':'100%',
				'z-index':'10'
			});
			$('.paulund_inner_modal_box').css({
				'background-color':'#fff',
				'height':(options.height - 50) + 'px',
				'width':(options.width - 50) + 'px',
				'padding':'10px',
				'margin':'15px',
				'border-radius':'10px',
				'-moz-border-radius':'10px',
				'-webkit-border-radius':'10px'
			});
		}
		
		 /**
		  * Create the block page div
		  */
		 function add_block_page(){
			var block_page = $('<div class="paulund_block_page"></div>');
						
			$(block_page).appendTo('body');
		}
		 	
		 /**
		  * Creates the modal box
		  */
		 function add_popup_box(){
			 var pop_up = $('<div class="paulund_modal_box"><a href="#" class="paulund_modal_close"></a><div class="paulund_inner_modal_box"><h2>' + options.title + '</h2><p>' + options.description + '</p></div></div>');
			 $(pop_up).appendTo('.paulund_block_page');
			 			 
			 $('.paulund_modal_close').click(function(){
				$(this).parent().fadeOut().remove();
				$('.paulund_block_page').fadeOut().remove();				 
			 });
		}

		return this;
	};
	
})(jQuery);
