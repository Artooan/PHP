$(document).ready(function() {

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

			},

			"Відміна" : function() {
				$(this).dialog("close");
			}
		}

	});

	$(".open").click(function() {
		$("#form_style").dialog("open");
	})

});