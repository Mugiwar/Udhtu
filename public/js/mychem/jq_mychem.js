$().ready(function(){	



		 $('#gen_type_conf').change(function(){
	  var gen_type_conf = $(this).val();
	 
	   //var	id_conf = $(this).attr("id");


				$.ajax({
						type: "POST",
						dataType: 'json',
						//url: $("#regg").attr("action"),
						url:'/mychem/conf',
						data: "gen_type_conf="+gen_type_conf,
						success: function(data){
							 $("#gen_topic").remove();
						$('#gen_type_conf').after('<p><select id="gen_topic" name="gen_topic"><option selected disabled>Все сексы</option></select></p>');
							
								for (var i in data){
						  $('#gen_topic').append('<option value="'+data[i].id+'">'+data[i].value+'</option>');			   		  	  
								//alert(data[i].value); 
								}   

						   }
						 });



	})







	 $('.mu_status').change(function(){
	  var conf_status_public = $(this).val();

	   var	id_conf = $(this).attr("id");


						$.ajax({
						type: "POST",
						//dataType: 'json',
						//url: $("#regg").attr("action"),
						url:'/mychem/conf',
						data: "conf_status_public="+conf_status_public+"&id_conf="+id_conf,
						success: function(data){
								//for (var i in data)     
						   }
						 });



	})
	




	$('.chb').click(function(){
var view_oplata_value = '';
			
		   //$(this).slideUp();
		   var	id_conf = $(this).attr("id");
		   //alert($(this).attr("name"));
		   switch($(this).attr("name")){

			case 'mu_status_oplata':
				if($(this).attr("value") == 2){
					view_oplata_value = 1;
				 }else{
					view_oplata_value = 2;
				}
			break;

			case 'mu_status_view':
				if($(this).attr("value") == 2){
					view_oplata_value = 1;
				}else{
					view_oplata_value = 2;		   			
				}

			break;

		   }		 
		
//var datas = $('#regg').serialize(); 	
console.log($(this).attr("name"));  	
		$.ajax({
			type: "POST",
		  dataType: 'json',

			//url: $("#regg").attr("action"),
			url: window.location.href,
			data: $(this).attr("name")+"="+view_oplata_value+"&id_conf="+id_conf,
			success: function(data){
					//for (var i in data)
	 //alert(data);
   }
 });

				})

//Отправка почті из админки конфі


	$( "#dmw_email" ).draggable({
	  //appendTo: "body",
	  revert: true,
	  //helper: "clone",
		//cursor: "move"
	});


	$('.send_email').click(function(){
		$('#to_email').attr('value',$('#conf_email').text());
		$('#from_email').attr('value',$(this).text());		
		$( "#dmw_email").show();
   });


$('#dmw_send_email').on('click', function(){ 

	var from_email,to_email,dmw_email_message;
	from_email = $('#from_email').val();
	dmw_email_message = $('#dmw_email_message').val();
	to_email = $('#to_email').val();
	

 $.ajax({
	url: document.location.href,
	type: 'POST',
	dataType: 'json',  
	data: {from_email : from_email,to_email : to_email,dmw_email_message : dmw_email_message},
	success: function(datas){

		alert(window.location.href);

}

})

  
  });





//Конец отправки формі из админки конфі



	 $('.sort_type div').click(function(){	 	
	  var sort_type = $(this).text();
	   var id_section = $(this).attr("idtopic");

	   //var	id_conf = $(this).attr("id");
	   $('.sort_conf #type_section').text(sort_type);

	   //alert(id_section);
	   //alert(window.location.href);

		$.ajax({
			type: "POST",
			dataType: 'json',
			//url: $("#regg").attr("action"),
			url: window.location.href,
			data: "id_section="+id_section,
			success: function(data){
					var summm= 0;
				var status_public;
				var status_oplata;		
						$(".full_sort").remove();		
					 $(".sort_tabl").remove();
				  $('.sort_conf').after(' <table class="sort_tabl" border=1 style="margin: 0 15px 35px ;width:950px"><tr><th>№</th><th>П.І.Б.</th><th>Назва роботи</th><th>Статус роботи</th><th>Оплата участі</th></tr></table>');
					for (var i in data){
					console.log(data);	
				//$('.sort_conf').after('<div>'+data[i].last_name+'</div>');
	//$('#lastt').text(data[i].last_name );
									switch(data[i].mu_status){
			case '1': status_public = '<center><img class="paulund_modal" status="'+data[i].mu_status+'" id_conf="'+data[i].id+'" style="height:40px;" src="/public/img/mychem/conference/prinyto.png"></center>';
				break;
			case '2': status_public = '<center><img class="paulund_modal" status="'+data[i].mu_status+'" id_conf="'+data[i].id+'" style="height:40px;" src="/public/img/mychem/conference/ne_polucheno.png"></center>';
				break;
			case '3': status_public = '<center><img class="paulund_modal" status="'+data[i].mu_status+'" id_conf="'+data[i].id+'" style="height:40px;" src="/public/img/mychem/conference/na_proverke.png"></center>';
				break;
			case '4': status_public = '<center><img class="paulund_modal" status="'+data[i].mu_status+'" id_conf="'+data[i].id+'" style="height:40px;" src="/public/img/mychem/conference/provereno.png"></center>';
				break;
			case '5': status_public = '<center><img class="paulund_modal" status="'+data[i].mu_status+'" id_conf="'+data[i].id+'" style="height:40px;" src="/public/img/mychem/conference/ne_prinyto.png"></center>';
				break;

			}

												switch(data[i].mu_status_oplata){
			case '1': status_oplata = '<center><img style="height:40px;" src="/public/img/mychem/conference/plus.png"></center>';
				break;
			case '2': status_oplata = '<center><img style="height:40px;" src="/public/img/mychem/conference/minus.png"></center>';
				break;

			}			

	/*

					if ( $("#"+data[i].mu_user).hasClass(data[i].mu_user) ) {
					  $('.clearr'+data[i].mu_user).before('<tr><td>'+data[i].id+'</td><td style="width:600px;">'+data[i].title_public+'</td><td>'+status_public+'</td><td>'+status_oplata+'</td></tr>');
					  
					}else{



	$('.box_conf').prepend('<h2 class="punct_conf '+data[i].mu_user+'" id="'+data[i].mu_user+'"> '+data[i].last_name+' '+data[i].name+' '+data[i].middle_name+' (' +data[i].mail+
		')</h2><div class="about_conf_tabl"><table><tr><th>№</th><th>Назва роботи</th><th>Статус роботи</th><th>Оплата участі</th></tr><tr class="clearr'+data[i].mu_user+'"><td>'+data[i].id+'</td><td style="width:600px;">'+data[i].title_public+'</td><td>'+status_public+'</td><td>'+status_oplata+'</td></tr></table><div class="clear"></div></div>');

}*/

 summm=1+summm;

if ( $("#"+data[i].mu_user).hasClass(data[i].mu_user) ) {
					  $('.clearr'+data[i].mu_user).before('<tr><td>'+summm+'</td><td style="width:220px">'+data[i].last_name+' <br>'+data[i].name+' '+data[i].middle_name+'</td><td style="width:600px;">'+data[i].title_public+'</td><td>'+status_public+'</td><td>'+status_oplata+'</td></tr>');
					  
					}else{



	$('.sort_tabl').append('<tr class="clearr'+data[i].mu_user+'"><td>'+summm+'</td><td style="width:220px">'+data[i].last_name+'<br> '+data[i].name+' '+data[i].middle_name+'</td><td style="width:600px;">'+data[i].title_public+'</td><td>'+status_public+'</td><td>'+status_oplata+'</td></tr>');

}


}



  $('.paulund_modal').paulund_modal_box({
	   title:" Перед відправленням тексту статті – ретельно перевірте її.",
		description: '<form class="send_mail_form" action="" method="post" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000" /><input type="file" name="file_tezis" size="30"> <input type="submit" value="Відправити" name="submit"></form>',
			});
	$('.paulund_modal_2').paulund_modal_box({
		title:'Second Title Box',
		description:'Custom description for box <br/><br/>Quisque sodales odio nec dolor porta sed laoreet mauris pretium. Aenean id mauris ligula, semper pulvinar dolor. Suspendisse rutrum, libero eu condimentum porta, mauris mauris semper augue, ut tempor nunc arcu vel ligula. Quisque orci eros, consequat vel iaculis eget, blandit bibendum est. Morbi ac tellus dui. Nullam eget eros et lectus dignissim placerat. Nulla facilisi. Ut congue posuere vulputate.'
	});
	$('.paulund_modal_3').paulund_modal_box({
		title: 'Change Title with height',
		height: '500'
	});
	$('.paulund_modal_4').paulund_modal_box({
		title: 'Change Title with Width',
		width: '800'
	});
	$('.paulund_modal_5').paulund_modal_box({
		title:'Second Title Box',
		description:'Custom description for box <br/><br/>Quisque sodales odio nec dolor porta sed laoreet mauris pretium. Aenean id mauris ligula, semper pulvinar dolor. Suspendisse rutrum, libero eu condimentum porta, mauris mauris semper augue, ut tempor nunc arcu vel ligula. Quisque orci eros, consequat vel iaculis eget, blandit bibendum est. Morbi ac tellus dui. Nullam eget eros et lectus dignissim placerat. Nulla facilisi. Ut congue posuere vulputate.',
		height: '500',
		width: '800'
	});



	
   }




 });


	})



/* Вспліваюшие модальное окно добовления авторов + плагин к нему отдельнім фаилом


	$('.paulund_modal').paulund_modal_box({
	   title:" Перед відправленням тексту статті – ретельно перевірте її.",
		description: '<form class="send_mail_form" action="" method="post" enctype="multipart/form-data"><input type="hidden" name="MAX_FILE_SIZE" value="10000000" /><input type="file" name="file_tezis" size="30"> <input type="submit" value="Відправити" name="submit"></form>',
			});
	$('.paulund_modal_2').paulund_modal_box({
		title:'Second Title Box',
		description:'Custom description for box <br/><br/>Quisque sodales odio nec dolor porta sed laoreet mauris pretium. Aenean id mauris ligula, semper pulvinar dolor. Suspendisse rutrum, libero eu condimentum porta, mauris mauris semper augue, ut tempor nunc arcu vel ligula. Quisque orci eros, consequat vel iaculis eget, blandit bibendum est. Morbi ac tellus dui. Nullam eget eros et lectus dignissim placerat. Nulla facilisi. Ut congue posuere vulputate.'
	});
	$('.paulund_modal_3').paulund_modal_box({
		title: 'Change Title with height',
		height: '500'
	});
	$('.paulund_modal_4').paulund_modal_box({
		title: 'Change Title with Width',
		width: '800'
	});
	$('.paulund_modal_5').paulund_modal_box({
		title:'Second Title Box',
		description:'Custom description for box <br/><br/>Quisque sodales odio nec dolor porta sed laoreet mauris pretium. Aenean id mauris ligula, semper pulvinar dolor. Suspendisse rutrum, libero eu condimentum porta, mauris mauris semper augue, ut tempor nunc arcu vel ligula. Quisque orci eros, consequat vel iaculis eget, blandit bibendum est. Morbi ac tellus dui. Nullam eget eros et lectus dignissim placerat. Nulla facilisi. Ut congue posuere vulputate.',
		height: '500',
		width: '800'
	});



*/








//  levoe menu  otkritie zakritie


$('.cssmenu li.has-sub>a').on('click', function(){ 

	$(this).removeAttr('href');
	var element = $(this).parent('li');
	if (element.hasClass('open')) {
	  element.removeClass('open');
	  element.find('li').removeClass('open');
	  element.find('ul').slideUp();
	}
	else {
	  element.addClass('open');
	  element.children('ul').slideDown();
	  element.siblings('li').children('ul').slideUp();
	  element.siblings('li').removeClass('open');
	  element.siblings('li').find('li').removeClass('open');
	  element.siblings('li').find('ul').slideUp();
	}
  });

  $('.cssmenu>ul>li.has-sub>a').append('<span class="holder"></span>');









// так можно установить новые кукисы или переписать значения у уже существующих:
//$.cookie('cookie_name', 'cookie_value');

// получить значение существующих кукисов можно так:
//$.cookie('cookie_name');
// если запрашиваемых кукисов не существует, то эта функция вернет null

// а так можно удалить кукисы
//$.cookie('cookie_name', null);
//$("p").parent(".block_menu").css("background", "yellow");




function tests(punct_0){





var rr = $('div#center-punct').css("display");
//alert($('div#center-punct').css("display"));
if( rr != 'none'){
	$('div#center-punct').slideUp("normal");
}

//$('div#center-punct').addClass("aaa");
	$('.punct_sub').removeClass("active");
 $(this).toggleClass("active");
	if($.isNumeric(punct_0)){
	
//$('div#center-punct').slideDown(4000);
//alert(document.location.href);
 $.ajax({
	url: document.location.href,
	type: 'POST',
	dataType: 'json',  
	data: {block_ints : punct_0},
	success: function(datas){
	   // console.log( datas);
	 if(!datas.lenght) {
			 $('div#center-punct').empty();
			 // alert(document.location.href);
			for (var i in datas) {
			  var url_value  = '';
				if (datas[i].call_url_value){
				  //url_value = "/"+datas[i].call_url_value;
				  url_value = "/all";
				 }else{
				  url_value = "/all";  
				}  

			  $('div#center-punct').append('<div type="center_punct" data_id="'+datas[i].sub_punct_url_title+'" parents="'+datas[i].parents_punct+'" block="'+datas[i].block_id+'" class="punct_menu_lvl_1 slideUp  "><a href="/mychem/adminka-site-udhtu/'+datas[i].sub_punct_url_title+url_value+'">'+datas[i].punct+'<img class="pulse" src="/public/img/global/icon/info_err.png"></a></div>');
			  //alert(datas[i]['punct']);
		  

			}
	   
	 }else{
		  ('div#center-punct').css('height','50px');

	 };



				$( "#center-punct > div" ).draggable({
	  //appendTo: "body",
	  revert: true,
	  //helper: "clone",
		//cursor: "move"
	});


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




}























/*



if ($.cookie('punct_active')) {

	//$('.punct').removeClass("active");
	var activ_menu = $.cookie('punct_active');
	$('.punct_menu_lvl_0').eq(activ_menu).addClass("active");
	$('.punct_menu_lvl_0').eq(activ_menu).parent('ul').slideDown("normal");
	$('.punct_menu_lvl_0').eq(activ_menu).parents(".block_menu").addClass("open");
	

	if ($.cookie('punct_0')) {       
		tests($.cookie('punct_0'));

	};

	$.cookie('punct_active', null);
	
			$.cookie('punct_0',null, {
		expires: 5,
		path: '/',
	});
	  
};





 $(".punct_menu_lvl_0").click(function(){    
	$(".punct_menu_lvl_0").removeClass("active");
	
	 var active= $('.punct_menu_lvl_0').index(this);
	$.cookie('punct_active',active, {
		expires: 5,
		path: '/',
	});
		if ($(this).hasClass("punct_sub")) {
	   var  punct_0 = $(this).attr('data_id');
	$.cookie('punct_0',punct_0, {
		expires: 5,
		path: '/',
	});


	 


	};
console.log( active);

});






*/











 $(".punct_sub").click(function(){


var rr = $('div#center-punct').css("display");
//alert($('div#center-punct').css("display"));
if( rr != 'none'){
	$('div#center-punct').slideUp("normal");
}

//$('div#center-punct').addClass("aaa");
	$('.punct_sub').removeClass("active");
 $(this).toggleClass("active");
	if($.isNumeric($(this).attr('data_id'))){
	var block = $(this).attr('data_id');
//$('div#center-punct').slideDown(4000);
//alert(document.location.href);
 $.ajax({
	url: document.location.href,
	type: 'POST',
	dataType: 'json',  
	data: {block_ints : block},
	success: function(datas){
	 if(!datas.lenght) {
			 $('div#center-punct').empty();
			 // alert(document.location.href);
			for (var i in datas) {
			  var url_value  = '';
				if (datas[i].call_url_value){
				  //url_value = "/"+datas[i].call_url_value;
				  url_value = "/all";
				 }else{
				  url_value = "/all";  
				}  

			  $('div#center-punct').append('<div type="center_punct" data_id="'+datas[i].sub_punct_url_title+'" parents="'+datas[i].parents_punct+'" block="'+datas[i].block_id+'" class="punct_menu_lvl_1 slideUp  "><a href="/mychem/adminka-site-udhtu/'+datas[i].sub_punct_url_title+url_value+'">'+datas[i].punct+'<img class="pulse" src="/public/img/global/icon/info_err.png"></a></div>');
			  //alert(datas[i]['punct']);
		  

			}
	   
	 }else{
		  ('div#center-punct').css('height','50px');

	 };



				$( "#center-punct > div" ).draggable({
	  //appendTo: "body",
	  revert: true,
	  //helper: "clone",
		//cursor: "move"
	});


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



//Функция сладирование левого меню фронта сайта

$(document).ready(function(){
  $.easing.def = "easeInOutQuad";
  $('li.button a').click(function(e){
    var dropDown = $(this).parent().next();
    $('.dropdown').not(dropDown).slideUp('slow');
    dropDown.slideToggle('slow');
    e.preventDefault();
  })  
});

//Функция сладирование левого меню фронта сайта (конец)

//Создание меню по правому клику мышки


//Начало контекстного меню

// При выборе и клике на пункт контекстного меню
$("body").on('click','.rc-catm li',function(){    
    // This is the triggered action name
    switch($(this).attr("data-action")) {        
        // A case for each action. Your actions here
        case "cm_cat_cr":         					
        break;
        case "cm_cat_cr_f":         					
        		//console.log($(this).attr('type'));
        		var dmw = $( '<div><form action="POST" id="fm_create_razdelov"><p><b>Форма добавления раздела </b></p><p><label for="name">Название раздела</label><Br><input type="text" name="mu_name" class="name_url"><Br><label for="url_title">как будет отображаться ссылка на транслите(можете поправить)</label><Br><input type="text" name="mu_url_title" class="url_title"><Br><input type="hidden" name="mrd" value="'+$(this).attr('mrd')+'"><input type="hidden" name="insert" value="punct"><input type="hidden" name="type_content" value="'+$(this).attr('type')+'"><input type="hidden" name="position" value="'+$(this).attr('position')+'"><input type="hidden" name="mu_ints" value="'+$(this).attr('id_mtt')+'"/><input type="hidden" name="type_face" value="'+$(this).attr('type_face')+'"/></p></form><button action="add" id="save_razdel">Сохранить</button></div>' ).appendTo( "body" );	
        			//<input type="checkbox" name="mu_status_chb_rb" id="status" value="1"><label for="status">Показывать данный блок или скрыть</label>
					        setTimeout(function() {
					          dmw.dialog({
					          	beforeClose: function( event, ui ) {					          	
        							$('.ui-dialog').remove();
        							 $('#fm_create_razdelov').closest('div').remove(); 

					          	},
					            title: 'title',					           
								width: 500,
					            modal: true
					          });
					        }, 1 ); 
        break;
        case "cm_cat_cr_p":
        					var dmw = $( '<div"><form method="POST" id="fm_create_razdelov"><textarea name="editor2" id="editor2"></textarea><p>Заголовок</p><input  type="text" name="mu_title" class="name_url" /><input type="text" name="mu_url_title" class="url_title"><p>preview</p><textarea rows="5" cols="45"  name="mu_preview"></textarea>		<input type="hidden" name="insert" value="page"/><input type="hidden" name="mu_ints" value="'+$(this).attr('id_mtt')+'"/><input type="hidden" name="type_content" value="'+$(this).attr('type')+'"><input type="hidden" name="mrd" value="'+$(this).attr('mrd')+'"><input type="hidden" name="type_face" value="'+$(this).attr('type_face')+'"/><input type="hidden" name="position" value="'+$(this).attr('position')+'"></form>		<button action="add" type="page" id="save_razdel">Сохранить</button></div>' ).appendTo( "body" );	
					        setTimeout(function() {
					          dmw.dialog({
					          	beforeClose: function( event, ui ) {					          	
        							$('.ui-dialog').remove();
        							$('#fm_create_razdelov').closest('div').remove(); 
					          	},
					            title: 'title',
					            width: 950,					           
					            modal: true
					          });
					        }, 1 );
					      
		                    setTimeout(function() {
		                    	CKEDITOR.replace( 'editor2',{height: '350px' });
													
					        }, 5 );
        break;
        case "cm_cat_edit_f":							
	       		//console.log($(this).attr('type'));
        		var dmw = $( '<div><form action="POST" id="fm_upd_folder"><p><b>Редактирование папки</b></p><p><label for="name">Название раздела</label><Br><input type="text" name="fname" style="width:400px" value="'+$(this).attr('fname')+'" class="name_url"><Br><label for="short_name">абривиатура(которкое имя)</label><Br><input type="text" name="short_name" value="'+$(this).attr('short_name')+'"  class="short_name"><Br><input type="hidden" name="edit" value="punct"><input type="hidden" name="mu_ints" value="'+$(this).attr('id_mtt')+'"/></p></form><button action="update" id="save_razdel">Сохранить</button></div>' ).appendTo( "body" );	
        			       setTimeout(function() {
					          dmw.dialog({
					          	beforeClose: function( event, ui ) {					          	
        							$('.ui-dialog').remove();
        							$('#fm_upd_folder').closest('div').remove(); 

					          	},
					            title: 'title',					           
								width: 500,
					            modal: true
					          });
					        }, 1 ); 
        break;
        case "cm_cat_del_f":
        		//console.log(del_f.attr('path'));
				DMW_delet(del_f);
				delete del_f;
        break;
    }
});

$(document).bind("click", function(){
$(".rc-catm").hide(100).remove();


});

	
	var del_f;
	//Вызов контекстного меню в админке для создания папок\файлов
  	$(document).on('mousedown contextmenu','.udhtu-file', function(event){
    event.preventDefault();
    if(event.button == 0){
       // alert('Вы кликнули левой клавишей');
    } else if(event.button == 1){
       // alert('Вы кликнули левой колесиком');
    } else if(event.button == 2 ){
      //  alert('Вы кликнули правой клавишей');
       //purl = $(this).closest(".udhtu-file").attr('data_id');
		var id_cat,type_content;
       	$.ajax({
		url: document.location.href,
		type: 'POST',
		dataType: 'json',  
		data: {user_click : 'user_click'},
			success: function(datas){       
				if (datas[0])
					switch(event.target.className){
					case 'icon-folder':							
										id_cat_edit = $(event.target).closest(".udhtu-folder").attr('path');
										 del_f = $(event.target).closest(".udhtu-folder");
										//type_content = $(event.target).closest(".udhtu-folder").attr('type');
										fname = $(event.target).closest(".udhtu-folder").find('a').attr('fname');
										short_name = $(event.target).closest(".udhtu-folder").find('a').text();
										id_cat_edit = id_cat_edit.split('/');	
										$(".rc-catm").remove();
										$('body').append("<ul class='rc-catm'> <li id_mtt='"+id_cat_edit.pop()+"' fname='"+fname+"' short_name='"+short_name+"' data-action='cm_cat_edit_f'>редактировать</li>  <li data-action='cm_cat_del_f'>удалить</li></ul>");
										$(".rc-catm").css({"top": event.pageY +  "px", "left": event.pageX +  "px"}).show();
					break;
					case 'udhtu-file':
										id_cat_cr = $(event.target).attr('id_mtt');
										id_mrd_cr = $(event.target).attr('id_mrd');
										//console.log( id_mrd_cr);
										//type_content = $(event.target).children().attr('type');
										//id_cat_edit =  id_cat_cr.split('/');
										//id_cat_edit =  id_cat_edit[id_cat_edit.length - 2];
										//console.log( id_cat_edit);								
										$(".rc-catm").remove();
										$('body').append("<ul class='rc-catm'>  <li data-action='cm_cat_cr'>создать </li><ul class='cm_subp' style='display:none'><li id_mtt='"+id_cat_cr+"' type_face='back' mrd='"+id_mrd_cr+"' position='left-menu' type='subfolder' data-action='cm_cat_cr_f'>папку</li> <li  id_mtt='"+id_cat_cr+"' type_face='front' position='center-menu' mrd='"+id_mrd_cr+"' type='page' data-action='cm_cat_cr_p'>страницу</li></ul>  <li data-action='cm_cat_edit1'>редактировать</li>  <li data-action='cm_cat_del'>удалить</li></ul>");
										$(".rc-catm").css({"top": event.pageY +  "px", "left": event.pageX +  "px"}).show();
					break;

					}
			}
		}) 
    }
	});


//Контекстное меню с выплыванием подменю создать страница папка



$(document).on('mouseover', '.rc-catm li', function(e) { 
    if ($(this).next('ul').length > 0) {     
    $(this).next('ul').show(100);
};
});

$(document).on('mouseover', '.rc-catm li', function(e) {
     // code from mouseout hover function goes here
       if ($(this).next('ul').length == 0 && !$(this).closest('ul').hasClass('cm_subp') ) {
   	 $('.cm_subp').hide(100);
    };
});


//Конец контекстного меню

//Переход по урлм папок
$('body').on('click','.path_url > a', function(event){
	event.preventDefault();
	var name_folder = $(this).attr('fname');
	var path_folder = $(this).attr('path');
	var uls = $(this).closest('.path_url').next().next();
	var purl = $(this).prev();
	var	pathUrl_class	=$(this).parent();	
	
	uls.attr('id_mtt',path_folder);
	var navUrl;


navUrl = $(this).attr('path').split("/");
$(this).parent().children().each(function(i,val) { // val равняется this ткушему в цикле дом єлементу
	if (!navUrl[i] ) {
		//$(pathUrl_class).append("<a path="+navUrl[i]+" fname="+$(val).attr('fname')+">"+$(val).text()+"/</a>");
		$(val).remove();
	} 
});

//console.log(navUrl.length)
	 $.ajax({
		url: document.location.href,
		type: 'POST',
		dataType: 'json',  
		data: {path_folder : path_folder},
		success: function(datas){
			// $(e.target).closest("ul").slideToggle();
			uls.prev().text(name_folder);
			uls.empty();
			
			//alert(window.location.href);
			for (var i in datas) {
				console.log(datas);
				//alert(datas[i].short_name);
				if(datas[i].type_content == 'subfolder'){
					$(uls).append('<li type="subfolder" class="udhtu-folder"  path='+datas[i].path+'/'+datas[i].id_mtt+'><span class="icon-folder"></span><br/><a href="'+datas[i].url_title+'" fname="'+datas[i].name+'">'+datas[i].short_name+'</a></li> ');
				}

				if(datas[i].type_content == 'subblock'){
					$(uls).append('<li type="subblock" class="udhtu-folder"  path='+datas[i].path+'/'+datas[i].id_mtt+'><span class="icon-folder"></span><br/><a href="'+datas[i].url_title+'" fname="'+datas[i].name+'">'+datas[i].short_name+'</a></li> ');
				}
				if(datas[i].type_content == 'page'){
					$(uls).append('<li type="page"  path='+datas[i].path+'/'+datas[i].id_mtt+' data_id="'+datas[i].url+'" class="udhtu-page ui-widget-content ui-corner-tr"><h5 class="ui-widget-header">'+datas[i].short_name+'</h5><div>Priview</div><a  title="Подробнее" class="ui-icon ui-icon-zoomin">Подробнее</a><a  title="Редактироват" class="ui-icon ui-icon-pencil">Редактироват</a><a href="link/to/trash/script/when/we/have/js/off" title="Удалить" class="ui-icon ui-icon-trash">Удалить</a><a data="info" title="status_page" class="icon"></a></li>');
				}

			}			
			//$(purl).append("<a path="+datas[i].id_mtt+" fname="+datas[i].id_mtt+">/files_privacy</a>");
		}
	})  
  });


//Работа с папками 

$('body').on('click','.udhtu-folder', function(event){
	event.preventDefault();
	var name_folder = $(this).find("a").attr('fname');
	var path_folder = $(this).attr('path');
	var uls = $(this).closest("ul");	
	var purl = $(this).closest("ul").prev().prev();	
	$(purl).append("<a path="+path_folder+" fname="+$(this).find('a').attr('fname')+">/"+$(this).find("a").attr('href')+"</a>");
	$(this).closest(".udhtu-file").attr('id_mtt',path_folder);
	
	

	 $.ajax({
		url: document.location.href,
		type: 'POST',
		dataType: 'json',  
		data: {path_folder : path_folder},
		success: function(datas){
			// $(e.target).closest("ul").slideToggle();
			uls.prev().text(name_folder);			
			uls.empty();
			//$("ul.udhtu-folder").remove();
			//console.log('s2222ds');
			//alert(window.location.href);
			for (var i in datas) {
				//alert(datas[i].short_name);
				if(datas[i].type_content == 'subfolder'){
				 $(uls).append('<li type="subfolder" class="udhtu-folder"  path='+datas[i].path+'/'+datas[i].id_mtt+'><span class="icon-folder"></span><br/><a href="'+datas[i].url_title+'" fname="'+datas[i].name+'">'+datas[i].short_name+'</a></li> ');
				}
				if(datas[i].type_content == 'page'){
				 $(uls).append('<li type="page"  path='+datas[i].path+'/'+datas[i].id_mtt+' data_id="'+datas[i].url+'" class="udhtu-page ui-widget-content ui-corner-tr"><h5 class="ui-widget-header">'+datas[i].short_name+'</h5><div>Priview</div><a  title="Подробнее" class="ui-icon ui-icon-zoomin">Подробнее</a><a  title="Редактироват" class="ui-icon ui-icon-pencil">Редактироват</a><a href="link/to/trash/script/when/we/have/js/off" title="Удалить" class="ui-icon ui-icon-trash">Удалить</a><a data="info" title="status_page" class="icon"></a></li>');
				}

			}
		}
	})  
  });




	


$("body").on('click','#upd_title',function(){

    $("#upd_title").focus();   
});	


$("body").on('click','#reso500x375',function(){

   $('#cropContainer').animate({width:500,height:375}, 200);
   $('.cropImgWrapper').animate({width:500,height:375}, 200);

});	

$("body").on('click','#reso300x400',function(){

  $('#cropContainer').animate({width:300,height:400}, 200);
    $('.cropImgWrapper').animate({width:300,height:400}, 200);


});	


});		