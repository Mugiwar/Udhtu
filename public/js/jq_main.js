$().ready(function(){	




//Функция перехода по язікам

	$('#lang p > img').click(function(){

		var lang = $(this).attr('title');
		//alert(document.location.href);
		location.href =document.location.href+'?l='+lang;

	})







	
	$('div.sort_conf').click(function(){

		$('div.sort_type').toggle();

	})

	//$('div.box_conf h2').click(function(){
		$('body').on('click', 'div.box_conf h2', function(){


		$(this).next().toggle();

	})	




	$("contentTitle").addClass('hide');			
	$('div.content_sm').on('click', 'contentSub', function(){			
		$(this)
			.next()
				.slideDown(300)
					.siblings('contentTitle')
						.slideUp(300);			
	})

		$("ddd").addClass('hide');	

			$('div.slide_menu').on('click', 'dtt', function(){			
		$(this)
			.next()
				.slideDown(300)
					.siblings('ddd')
						.slideUp(300);			
	})

	$('.content_sm contentSub').click(function(){		
		var data = $(this).attr('data');
		var thiss = $(this);
		 $("contentTitle").remove();				
			 $.ajax({
			   type: "POST",
			   dataType: 'json',
			   url: document.location.href,
			   data: "id_sub="+data,
			   success: function(datas){			   	
			   		for (var i in datas) {			   			
			   			thiss.after('<contentTitle><p><a href="'+document.location.href+'/edit/'+datas[i].id+'">'+datas[i].title+'</a></p></contentTitle>'); 			
			   	

			   		}
			 	}

	
	})

			 	})









});		