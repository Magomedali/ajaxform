jQuery(function($){

	function mform(){
		this.status = false;
		this.validate = function(field){
			field.next(".warning").remove();
			field.next(".succes").remove();
			if(field.attr("name") == "name"){
				if(/[^а-яА-ЯёЁ .]/.test(field.val()) || !field.val()){
					field.val("");
					$("<small/>").addClass("warning").text("Введите пожалуйста только русские буквы").insertAfter(field);
					this.status = false;
				}else{
					$("<small/>").addClass("succes").text("Верно").insertAfter(field);
					this.status = true;
				}
			}else if(field.attr("name") == "tel"){
				if(!/^[0-9]{10,11}$/.test(field.val()) || !field.val()){
					this.status = false;
					$("<small/>").addClass("warning").text("Введите корректный номер. Пример: 89887778899 или 9887778899").insertAfter(field);
				}else{
					$("<small/>").addClass("succes").text("Верно").insertAfter(field);
					this.status = true;
				}
			}else if(field.attr("name") == "email"){
				if(!/^.+@.+\.[a-zA-Z]{2,4}$/.test(field.val()) || !field.val()){
					this.status = false;
					$("<small/>").addClass("warning").text("Введите корректный email. Пример: web-ali@yandex.ru").insertAfter(field);
				}else{
					$("<small/>").addClass("succes").text("Верно").insertAfter(field);
					this.status = true;
				}
			}
		};

	}
	$("input").focus(function(event){
		$(this).next(".warning").remove();
		$(this).next(".succes").remove();
	})

	$("input[type=\'tel\']").keydown(function(event) {
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || 
            (event.keyCode == 65 && event.ctrlKey === true) || 
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 return;
        }
        else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault(); 
            }   
        }
    });
	
	var f = new mform;
	$("input:required").blur(function(){
		f.validate($(this));
	})


	$("form").submit(function(event){
		$(this).find("input:required").each(function(){
			f.validate($(this));
		});
		if(f.status || 1){
			$(".serverErrors").remove();
			$(".answer").remove();
			var thisForm = $(this);
			var form = $(this).serialize();
			$.ajax({
				url:"ajax.php",
				type:"POST",
				data:form,
				dataType:"json",
				beforeSend:function(){},
				success:function(json){
					if(!json.result && json.messages){
						var warnings = $("<ul/>").addClass("serverErrors");
						if(json.messages.length){
							$.each(json.messages,function(){
								warnings.html($("<li/>").text(this));
							})
							warnings.insertBefore($(".submit"));
						}
					}else{
						if(json.culr_output){
							thisForm.append($("<p/>").addClass("answer").text(json.culr_output));
						}
					}
				},
				error:function(msg){console.log(msg)},
				complete:function(){}
			})
		}
		event.preventDefault();
	})
})