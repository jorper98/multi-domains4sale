(function() {
  
	var app = {
		
		initialize : function () {	
			this.setUpListeners();
		},

		setUpListeners: function () {
			$('form').on('submit', app.submitForm);
			$('form').on('keydown', '.has-error', app.removeError);
		},

		submitForm: function (e) {
			e.preventDefault();

			var form = $(this),
				submitBtn = form.find('button[type="submit"]'); 

			// if the validation does not pass - it does not go beyond
			if ( app.validateForm(form) === false )	return false; 

			var str = form.serialize();   

			// against pressing the
	        submitBtn.attr({disabled: 'disabled'});

            $.ajax({
                type: "POST",
                url: "contact_process.php",
                data: str                
            }).done(function(msg) {
                if(msg == 'OK') {
                    result = '<div class="bg-success">Email Sent.</div>';
                    form.html(result);
                } else {
                    form.html(msg);
                }		
            }).always(function(){
            	submitBtn.removeAttr("disabled");
            })
		},

		validateForm: function (form){

			var inputs = form.find('input'),
				valid = true;
			
			inputs.tooltip('destroy');

			$.each(inputs, function(index, val) {
				var input = $(val),
					val = input.val(),
					formGrout = input.parents('.form-group'),
					label = formGrout.find('label').text().toLowerCase(),
					textError = 'Enter ' + label;

				if(val.length === 0){
					formGrout.addClass('has-error').removeClass('has-success');	
					input.tooltip({
						trigger: 'manual',
						placement: 'right',
						title: textError
					}).tooltip('show');		
					valid = false;		
				}else{
					formGrout.removeClass('has-error').addClass('has-success');
					input.tooltip('hide');
				}	
			});

			return valid;
			
		},

		removeError: function() {
			$(this).removeClass('has-error').find('input').tooltip('destroy');
		}
		
	}

	app.initialize();

}());