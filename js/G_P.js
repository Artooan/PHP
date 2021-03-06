$(document).ready(function() {

	$("#add_Msg").hide(); //скриваємо повідомлення

	$("#form_style").dialog({

		autoOpen: false, //виключаємо автовідкриття нашого об'кта
		height: 550, //його висота
		width: 600, //його ширина
		show: "blind", //ефект відкриття!
		hide: "blind", //ефект закриття форми!
		modal: true,
	//описуємо кнопки!!!
		buttons: {
			"Відправити" : function() {
			//отримуємо дані з полів введення
				var name = $("#name").val();
				var email = $("#email").val();
				var msg = $("#msg").val();

				if (msg == '') {
					alert("Заповність текстове поле!") //повідомлення в разі незаповненого поля тексту
				} else {
					$("#msg").val(''); //якщо користувач хоче додати ще 1 пов., тому ми після відпра 1-го, очищаємо текст-поле
					$(this).dialog('close');

					$("#add_Msg").html('Надсилання повідомлення');//додаємо текст між тегами елемента
				//дадаємо ефект вспливання повідомлення про відправку. можна передавати два параметра
					$("#add_Msg").fadeIn(2000, function() {
						//AJAX
						$.ajax({
							type:"POST", //метод передачі!
							url: "index.php", //до якого файлу будемо передавати!
							data: "name="+name+"&email="+email+"&msg="+msg, //дані які передаємо!!!
						//вразі удачної передачі даних!!!	
							success: function(html) {
								//виводимо повідомлення
								$("#add_Msg").html(html); //виводимо текст про успішне додавання коментаря
								$("#add_Msg").fadeOut(2000, function() {
									if (html != 'Помилка!' || html != 'Заповність текстове поле!') {
										show_msg(); //виводимо повідомлення на екран
									}
								}); //скриваємо це повідомлення!
							}
						});
					});
				}
			},
		//кнопка відміни відправки повідомлення!
			"Відміна" : function() {
				$(this).dialog("close");
			}
		}

	});

//відкриваємо діалогового вікна (показ. форми)
	$(".open").click(function() {
		$("#form_style").dialog("open");
	});

//Робимо видалення записів за допомогою AJAX
	
//each вибір усіх ссилок 
	$("strong a").each(function() {
		$(this).click(function(event) {
			//відміняємо перехід по ссилках
			event.preventDefault();
			var g = $(this); //зберігаємо в змінну ссилку по якій клікнули!!!
			//отримуэмо атрибув ссилки
			var href = g.attr('href'); 
			//якщо передати другий агрумент в attr, то ти не отримаємо,
			//а встановимо значення!
			var id = href.substring(4, href.legth); //значення отримується починаючи з 4 елемента
			//виводимо повідомленння про видалення!
			$("#add_Msg").html('Видалення повідомлення');
			$("#add_Msg").fadeIn(1000, function() {
				$.ajax({
					type: "GET",//тип передачі
					url: "index.php", 
					data: "id="+id, //виводимо
					success: function(msg) {
						//виводимо повідомлення
						$("#add_Msg").html('Повідомлення видалено');
						//скриваємо повідомлення
						$("#add_Msg").fadeOut(1000);
						//скриваємо видалене повідомлення
						g.parents('div').eq(1).hide(500);
						//parents - отримуємо батьківський елемент div, eq - індекс батків. елемента
					}
				});
			});
		});
	});

//функція виводу добавленого повідомлення на екран
	function show_msg() {
		$.ajax({
			url: "addMsg.php",
			success: function(msg) {
				$("#new_Msg").prepend(msg);
				$("#new_Msg div:first-child").hide();
				$("#new_Msg div:first-child").fadeIn(1000);
			}
		});
	}

});