//para formulario
jQuery.fn.submitForm = function(settings){
    var config = {
        'url': '',
        'type':'POST',
        'dataType':'json',
        'sendInfo':'',
        'complete':'Sucesso',
        'completeAcao':null,
        'redirect':null,
        'resetform' : true,
        'reload' : false
    };

    var form = $(this);
    if (settings){$.extend(config, settings);}
        return form.each(function(){
        form.submit(function(event){
            if(config.url == '')
            	urlAction = form.attr('action');
            else
                urlAction = config.url;

            if(config.sendInfo == '')
                send = form.serialize();
            else
                send = config.sendInfo;    

            $.ajax({
                type: config.type,
                url: urlAction,
                dataType: config.dataType,
                data: send,
                success: function (data) {
                    $('input, select, textarea',form).popover('destroy')
                    $('input,textarea,select,button',form).css('box-shadow','none');
                    $('.form-control-feedback').remove();
                    if (data != true)
                    {
                        console.log(data)
	                    if(typeof data.generalerror !== "undefined" )
	                    {
                        	$("#dialogResult").html(data.generalerror);
							$("#dialogResult").dialog({
								autoOpen: true,
								buttons: [
									{
										text: "Ok",
										click: function() {
											$( this ).dialog( "close" );
										}
									}
								]
							});

                        }else{
                        	
	                        $.each(data.erro, function(index, val) {
	                            $.each(val, function(index, msg) {
	                                $('[name='+index+']').attr('data-content',msg)
	                                $('[name='+index+']').popover({
	                                    'placement': 'top',
	                                    'trigger':'focus'
	                                });
	                                $('[name='+index+']').popover('show')
                                    $('[name='+index+']').after('<span class="glyphicon glyphicon-warning-sign form-control-feedback" aria-hidden="true"></span>')
	                            });
	                        });
                     	}

                        return false;
                    }else
                    {
                    	if(config.reload == true)
                    		location.reload();
                        if(config.redirect != null)
                            location.href = config.redirect
                        if(config.resetform == true)
                            form.get(0).reset();
                   }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('ajax loading error...'+xhr+' - '+textStatus+' - '+ errorThrown);
                    console.log(xhr);
                    return false;
                }
            });
            return false;
        });
    });
};