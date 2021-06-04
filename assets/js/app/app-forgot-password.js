define([
    "jQuery",
	"bootstrap",
    "jqvalidate",
    "datatables",
      "uiForm"
	], function (
    $,
	bootstrap,
    jqvalidate,
    datatables,
     uiForm
	) {
    return {  
        init: function () { 
        	App.initFunc();
            App.initEvent(); 
            console.log("loaded");
            $(".loading").hide();
		},
         
        initEvent : function(){  
           
            $("#form-forgot-password").validate({ 
                rules: {
                    email: {
                        required: true,
                    }
                },
                messages: {
                    email: {
                        required: "Identity is Required"
                    }
                }, 
                debug:true,
                
                errorPlacement: function(error, element) {
                    var name = element.attr('name');
                    var errorSelector = '.form-control-feedback[for="' + name + '"]';
                    var $element = $(errorSelector);
                    if ($element.length) { 
                        $(errorSelector).html(error.html());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler : function(form) { 
                    form.submit();
                }
            });

            $("#btn-reset").removeAttr("disabled");
             $("#form-reset-password").validate({ 
                rules: {
                    new: {
                        required: true
                    },
                    new_confirm: {
                        required: true,
                        equalTo: "#new",
                        minlength: 8
                    }
                },
                messages: {
                    new: {
                        required: "New Password is Required",
                    },
                    new_confirm: {
                        required: "New Password Confirm is Required",
                        equalTo: "New Password Confirm must same",
                        minlength: "New Password Confirm must 8 character"
                    }
                }, 
                debug:true,
                
                errorPlacement: function(error, element) {
                    var name = element.attr('name');
                    var errorSelector = '.form-control-feedback[for="' + name + '"]';
                    var $element = $(errorSelector);
                    if ($element.length) { 
                        $(errorSelector).html(error.html());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler : function(form) { 
                    form.submit();
                }
            });
        }
	}
});