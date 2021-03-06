this.title_reg_field = function() {    
    this.xOffset = -5; // x distance from mouse
    this.yOffset = 10; // y distance from mouse     
    $(".title_reg_field").unbind().hover(    
        function(e) {
            this.t = this.title;
            this.title = ''; 
            this.top = (e.pageY + yOffset); this.left = (e.pageX + xOffset);
            
            $('body').append( '<p id="title_reg_field"><img id="vtipArrow" />' + this.t + '</p>' );
                        
            $('p#title_reg_field #vtipArrow').attr("src", '/public/img/global/icon/info_comment.png');
			//$('img.title_reg_field').attr("src", 'img/info_hover.png');
            $('p#title_reg_field').css("top", this.top+"px").css("left", this.left+"px").fadeIn("slow");
            
        },
        function() {
            this.title = this.t;
            $("p#title_reg_field").fadeOut("slow").remove();
				//$('img.title_reg_field').attr("src", 'img/info_norm.png');
        }
    ).mousemove(
        function(e) {
            this.top = (e.pageY + yOffset);
            this.left = (e.pageX + xOffset);
                         
            $("p#title_reg_field").css("top", this.top+"px").css("left", this.left+"px");
        }
    );            
    
};

/* Cмена языков в форме регистрации */
function translate(lang){
	var language = {
	  'ukr' : {
		"mu_last_name" : "Прізвище",
		"mu_name" : "Ім'я",
		"mu_middle_name" : "По батькові",
		"mu_sex" : "Стать",
		"mu_mob_phone" : "Телефон",
		"mu_skype" : "Skype",
		"mu_mail" : "e-mail",
		"mu_login" : "Логін",
		"mu_password" : "Пароль",
		"mu_password2" : "Пароль ще раз",
		"mu_organization" : "Назва організації",
		"mu_degree" : "Посада",
		"mu_uch_stepen" : "Науковий ступінь, звання",
		"mu_topic_conf" : "Тематичні напрямки",
		"mu_type_presentation" : "Форма доповіді",
		"mu_title_public" : "Назва доповіді",
		"mu_abstracts" : "Анотація (200 слів)",
		"mu_party" : "Участь у фуршеті – 23 травня",
		"mu_training_courses" : "Курси підвищення кваліфікації",
		"title_mob_phone" : 'Номер телефону може містити лише знак "+" <br> та цифри після нього.',
		"title_login" : 'Логін має містити не менше 5 латинських літер та цифр. <br> З інших знаків допускається лише знак "_".',
		"title_password" : 'Пароль має містити не менше 7 латинських літер та цифр.<br> З інших знаків допускається лише знак "_".',
		"title_captcha" : 'Перше правило математики.',	
		"option_degree_0" : 'Зробіть вибір...',
		"option_degree_1" : 'відсутня',
		"option_degree_2" : 'студент',	
		"option_degree_3" : 'аспірант',	
		"option_degree_4" : 'асистент',	
		"option_degree_5" : 'доцент',
		"option_degree_6" : 'професор',
		"option_uch_stepen_0" : 'Зробіть вибір...',	
		"option_uch_stepen_1" : 'відсутня',	
		"option_uch_stepen_2" : 'бакалавр',	
		"option_uch_stepen_3" : 'магістр',	
		"option_uch_stepen_4" : 'кандидат наук',	
		"option_uch_stepen_5" : 'доктор наук',
		"option_topic_conf_0" : 'Зробіть вибір...',	
		"option_topic_conf_1" : 'походження та геохімія вуглеводневих палив',	
		"option_topic_conf_2" : 'переробка твердих палив (теорія, практика, екологія)',	
		"option_topic_conf_3" : 'переробка нафти та газу (теорія, практика, екологія)',	
		"option_topic_conf_4" : 'хімотологія палива і мастильних матеріалів',	
		"option_topic_conf_5" : 'альтернативні види палива та технології переробки вуглеводневої сировини з відновлювальних та не відновлювальних джерел',	
		"option_type_presentation_0" : 'Зробіть вибір...',	
		"option_type_presentation_1" : 'усна',	
		"option_type_presentation_2" : 'стендова',	
		"option_type_presentation_3" : 'заочна участь',	
		
		
	  },
	  'rus' : {
		"mu_last_name" : "Фамилия",
		"mu_name" : "Имя",
		"mu_middle_name" : "Отчество",
		"mu_sex" : "Пол",
		"mu_mob_phone" : "Телефон",
		"mu_skype" : "Skype",
		"mu_mail" : "e-mail",
		"mu_login" : "Логин",
		"mu_password" : "Пароль",
		"mu_password2" : "Пароль еще раз",
		"mu_organization" : "Название организации",
		"mu_degree" : "Звание",
		"mu_uch_stepen" : "Учёная степень",
		"mu_topic_conf" : "Тематические направления",
		"mu_type_presentation" : "Форма доклада",
		"mu_title_public" : "Название доклада",
		"mu_abstracts" : "Аннотация (200 слов)",
		"mu_party" : "Участие в фуршете – 23 мая",
		"mu_training_courses" : 'Курсы повышения квалификации',
		"title_mob_phone" : 'Номер телефона может содержать только знак "+" <br> и цифры после него.',
		"title_login" : 'Логин должен содердать не менее 5 латинских букв и цифр.<br> Из остальных знаков допускается только знак "_".',
		"title_password" : 'Пароль должен содердать не менее 7 латинских букв и цифр.<br> Из остальных знаков допускается только знак "_".',
		"title_captcha" : 'Первое правило математики.',
		"option_degree_0" : 'Сделайте выбор...',
		"option_degree_1" : 'отсутствует',
		"option_degree_2" : 'студент',	
		"option_degree_3" : 'аспирант',	
		"option_degree_4" : 'ассистент',	
		"option_degree_5" : 'доцент',
		"option_degree_6" : 'профессор',
		"option_uch_stepen_0" : 'Сделайте выбор...',	
		"option_uch_stepen_1" : 'отсутствует',	
		"option_uch_stepen_2" : 'бакалавр',	
		"option_uch_stepen_3" : 'магистр',	
		"option_uch_stepen_4" : 'кандидат наук',	
		"option_uch_stepen_5" : 'доктор наук',
		"option_topic_conf_0" : 'Сделайте выбор...',	
		"option_topic_conf_1" : 'происхождение и геохимия углеводородных топлив',	
		"option_topic_conf_2" : 'переработка твердых топлив (теория, практика, экология)',	
		"option_topic_conf_3" : 'переработка нефти и газа (теория, практика, экология)',	
		"option_topic_conf_4" : 'хим мотология топливаи смазочных материалов',	
		"option_topic_conf_5" : 'альтернативные видытоплива и технология переработки углеводородного сырьяизвозобновляемых и не возобновляемых источников',	
		"option_type_presentation_0" : 'Сделайте выбор...',	
		"option_type_presentation_1" : 'устный',	
		"option_type_presentation_2" : 'стендовый',	
		"option_type_presentation_3" : 'заочный',

	  },
	  'eng' : {
		"mu_last_name" : "Surname",
		"mu_name" : "First Name",
		"mu_middle_name" : "Second Name",
		"mu_sex" : "Sex",
		"mu_mob_phone" : "Telephone",
		"mu_skype" : "Skype",
		"mu_mail" : "e-mail",
		"mu_login" : "Login",
		"mu_password" : "Password",
		"mu_password2" : "Password again",
		"mu_organization" : "Organization",
		"mu_degree" : "Degree",
		"mu_uch_stepen" : "Academic rank",
		"mu_topic_conf" : "Topics",
		"mu_type_presentation" : "Type of presentation",
		"mu_title_public" : "Title",
		"mu_abstracts" : "Аbstracts (up to 200 words)",
		"mu_party" : "Party – May, 23",
		"mu_training_courses" : "Advanced training courses",
		"title_mob_phone" : 'Telefone number may include sing "+" <br> only with digits after it.',
		"title_login" : 'Login must be at least 5 letters and numbers.<br> Only the sign "_" is allowed.',
		"title_password" : 'Password must be at least 7 letters and numbers.<br> Only the sign "_" is allowed.',
		"title_captcha" : 'The first mathematics rule.',
		"option_degree_0" : 'Select...',
		"option_degree_1" : 'absence',
		"option_degree_2" : 'student',	
		"option_degree_3" : 'postgraduate student',	
		"option_degree_4" : 'lecturer',	
		"option_degree_5" : 'assosiate professor',
		"option_degree_6" : 'professor',
		"option_uch_stepen_0" : 'Select...',	
		"option_uch_stepen_1" : 'absence',	
		"option_uch_stepen_2" : 'bachelor',	
		"option_uch_stepen_3" : 'master',	
		"option_uch_stepen_4" : 'PhD',	
		"option_uch_stepen_5" : 'Dr. Sci.',
		"option_topic_conf_0" : 'Select...',	
		"option_topic_conf_1" : 'origin and geochemistry of hydrocarbon fuels',	
		"option_topic_conf_2" : 'solid fuels processing (theory, practice, ecology)',	
		"option_topic_conf_3" : 'oil and gas processing(theory, practice, ecology)',	
		"option_topic_conf_4" : 'application of fuel and lubricants',	
		"option_topic_conf_5" : 'alternative fuels processing from renewable and non-renewable sources',	
		"option_type_presentation_0" : 'Select...',	
		"option_type_presentation_1" : 'oral',	
		"option_type_presentation_2" : 'poster',	
		"option_type_presentation_3" : 'сorrespondence participation',	
	  },
	};
	
	$('#mu_registred div').each(function (){	
		var attr = $(this).find(".title_reg_field").attr('data');			
		$(this).find("label").text(language[lang][this.id]);
		$(this).find(".title_reg_field").attr('title',language[lang][attr]);
	});
	
	 	 $("#mu_registred div .form_field_select").each(function (){				
			$(this).find("option").each(function (){
				var data_option = $(this).attr('data');
				var vall = $(this).attr('value');
				$(this).text(language[lang][data_option]);					
			});			
		});			
};

//Обработка данных прешедших из формы регистрации а также подсветка ошибок при регистрации
$().ready(function(){	
	title_reg_field();
	var er = 0;
	var color ;			
	$(".button_lang").click(function(){
		var	lang = $(this).find('img').attr('alt');
		//alert(lang);		
		if(lang == "ukr"){
			translate(lang);
			$('#title_conf3').text('Для реєстрації введіть дані');
			$('#title_conf3_1').text('"ПРОГРЕС В ТЕХНОЛОГІЇ ПЕРЕРОБКИ ГОРЮЧИХ КОПАЛИН ТА ХІМОТОЛОГІЇ ПАЛИВНО-МАСТИЛЬНИХ МАТЕРІАЛІВ"');			
			$('#button_reg_conf').text('Зареєструватися');				
		}		
		
		if(lang == "rus"){
			translate(lang);
			$('#title_conf3').text('Для регистрации введите данные');
			$('#title_conf3_1').text('"ПРОГРЕСС В ТЕХНОЛОГИИ ПЕРЕРАБОТКИ ГОРЮЧИХ ИСКОПАЕМЫХ И ХИММОТОЛОГИИ ТОПЛИВНО-СМАЗОЧНЫХ МАТЕРИАЛОВ"');			
			$('#button_reg_conf').text('Зарегистрироваться');				
		}
		
			if(lang == "eng"){
				translate(lang);
				$('#title_conf3').text('To register enter data');
				$('#title_conf3_1').text('"PROGRESS IN THE TECHNOLOGY OF FOSSIL FUELS PROCESSING AND APPLICATION OF COMBUSTIVE-LUBRICATING MATERIALS"');			
				$('#button_reg_conf').text('Sign up');			
			}				
	});
	


//Нажатие на кнопку "Зарегистрироваться" начнет функцию проверки
    $("#mu_sex input").click(function(){				
		var valll = $(this).attr('value');		
		if(valll == 'W'){
			$('div#mu_last_name_girl').remove();
			$('#mu_sex').after(' <div id="mu_last_name_girl"> <label>Дівоче прізвище</label> <input class="form_field" type="text" name="mu_last_name_girl" value=""></div>');					
		}

		if(valll == 'M'){
			$('div#mu_last_name_girl').remove();

		}

	});


//Нажатие на кнопку "Зарегистрироваться" начнет функцию проверки
	$('#button_reg_conf').click(function(){	
		
//Сеарилизация данных полученных метоом пост с формы регистрации для использование а асинхронке	
		var datas = $('#mu_conf_reg').serialize();
		//console.log(datas) ;
		$.ajax({
			type: "POST",
			dataType: 'json',
			//contentType: "application/json; charset=utf-8",
			url: document.location.href,
			data: datas,
			 //data: { get_member:"12" },
			success: function(data){
			//console.log(data) ;
//Если регистрация прошла без ошибок то с  пхп скрипта приходит мосив  с ключем redir и происходит редирект на страницу оповешения о регистрации
				if(data['redir'])
					$(location).attr('href','http://udhtu.edu.ua/activation/continue?step=2');
//Если есть ошибки Джеисон приносит нам с скрипта пхп в каикх это полях произошло и в тех полях мы меняем цвет ID полей соответствует ключам масива если добавлять к ниму MU_
				for (var i in data) {	
			//	console.log(data[i]) ;	
					if(i == 0)											
				$("#mu_capch").html(data[i])

					if("error_"+i == data[i]){						
						
						$("#mu_registred div#mu_"+i).css('color','red');
						$("#mu_registred div#mu_"+i+" .title_reg_field").attr("src", '/public/img/global/icon/info_err.png');						
						if(er == 0){
							$('<center><div style="color:red;font-size:22px;font-weight:bold">Десь є помилка!!!</div></center>').insertBefore('#mu_registred');
							er = 1;
						}						
					}else{
//Если ошибка была исправлено поле опять принимает стандартный цвет
						$("#mu_registred div#mu_"+i).css('color','');
						$("#mu_registred div#mu_"+i+" .title_reg_field").attr("src", '/public/img/global/icon/info_norm.png');
					
					}	
				}
						
			}
		})
	})	
		
		$("#mu_registred div .title_reg_field").hover(
			function () {	
				color =	$(this).attr("src");
				$(this).attr("src", '/public/img/global/icon/info_hover.png');
			},
			function () {			
				$(this).attr("src", color);	
			}); 




			
});



