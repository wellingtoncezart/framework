/*
@author wellington cezar
Plugin para upload de imagens, junto com cropper
Este plugin tem como dependência os plugin: 'ajaxForm', 'jquery ui' e 'cropper'.
*/
(function($){
	$.fn.uploadImage = function(options) {

        var defaults = {
			'width' : 50,
			'height' : 50,
			'cortar' : true,
			'original' : true,
			'sendInfo':'',
			'redirect':null,
			'resetform' : true,
			'reload' : false,
			'submitform' : false,
			'inputFile' : $('input[type=file]',this)
        };

        var settings = $.extend( {}, defaults, options );
        var formImg = $(this);
        var cortar = '';
        var original = '';
        var cancelar = false;

	    'use strict';
  		var console = window.console || { log: function () {} },
      	$alert = $('.docs-alert'),
      	$message = $alert.find('.message'),
      	showMessage = function (message, type) {
        	$message.text(message);
        	if (type) {
          		$message.addClass(type);
        	}
	        $alert.fadeIn();
	        setTimeout(function () {
    		    $alert.fadeOut();
        	}, 3000);
      	};

      	var panelCrop = '<div class="box_panel_cropper"> <div class="panel panel-default panel_cropper"> <div class="panel-heading"> <h4 class="modal-title" id="avatar-modal-label">Editar imagem</h4> <button class="close cancelCrop" data-dismiss="modal" type="button">×</button> </div> <div class="container panel-body"> <div class="row"> <div class="col-md-9"> <!-- <h3 class="page-header">Demo:</h3> --> <div class="img-container"> <img src="../assets/img/picture.jpg" alt="Picture"> </div> </div> <div class="col-md-3"> <!-- <h3 class="page-header">Preview:</h3> --> <div class="docs-preview clearfix"> <div class="img-preview preview-lg"></div> <div class="img-preview preview-md"></div> <div class="img-preview preview-sm"></div> <div class="img-preview preview-xs"></div> </div> <!-- <h3 class="page-header">Data:</h3> --> <div class="docs-data"> <div class="input-group"> <input class="form-control" id="dataX" type="text" placeholder="x" name="x1" style="display:none"> </div> <div class="input-group"> <input class="form-control" id="dataY" type="text" placeholder="y" name="y1" style="display:none"> </div> <div class="input-group"> <input class="form-control" id="dataWidth" type="text" placeholder="width" name="w" style="display:none"> </div> <div class="input-group"> <input class="form-control" id="dataHeight" type="text" placeholder="height" name="h" style="display:none"> </div> </div> </div> </div> <div class="row"> <div class="col-md-9 docs-buttons"> <!-- <h3 class="page-header">Toolbar:</h3> --> <div class="btn-group"> <button class="btn btn-primary" data-method="setDragMode" data-option="move" type="button" title="Move"> <span class="docs-tooltip" data-toggle="tooltip" title="Mover"> <span class="glyphicon glyphicon-move"></span> </span> </button> <button class="btn btn-primary" data-method="zoom" data-option="0.1" type="button" title="Zoom In"> <span class="docs-tooltip" data-toggle="tooltip" title="zoom in"> <span class="glyphicon glyphicon-zoom-in"></span> </span> </button> <button class="btn btn-primary" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out"> <span class="docs-tooltip" data-toggle="tooltip" title="zoom out"> <span class="glyphicon glyphicon-zoom-out"></span> </span> </button> </div> <!-- Show the cropped image in modal --> <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button> <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4> </div> <div class="modal-body"></div> <!-- <div class="modal-footer"> <button class="btn btn-primary" data-dismiss="modal" type="button">Close</button> </div> --> </div> </div> </div><!-- /.modal --> <!-- <button class="btn btn-primary" data-method="getCropBoxData" data-option="" data-target="#putData" type="button"> <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCropBoxData&quot;)"> Get Crop Box Data </span> </button> <button class="btn btn-primary" data-method="setCropBoxData" data-target="#putData" type="button"> <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCropBoxData&quot;, data)"> Set Crop Box Data </span> </button> --> <button class="btn btn-success saveCrop" type="button"> <span class="docs-tooltip" data-toggle="tooltip" title="Salvar"> Salvar </span> </button> <input class="form-control" id="putData" type="hidden" placeholder="Get data to here or set data with this value" name="putData"> </div><!-- /.docs-buttons --> </div> </div> <!-- Alert --> <div class="docs-alert"><span class="warning message"></span></div> </div> </div>';

      	formImg.append(panelCrop);





	  	// -------------------------------------------------------------------------
	  	(function () {
	    var $image = $('.img-container > img'),
	        $dataX = $('#dataX'),
	        $dataY = $('#dataY'),
	        $dataHeight = $('#dataHeight'),
	        $dataWidth = $('#dataWidth'),
	        $dataRotate = $('#dataRotate'),
	        options = {
				// strict: false,
				// responsive: false,
				// checkImageOrigin: false

				// modal: false,
				// guides: false,
				// highlight: false,
				// background: false,

				// autoCrop: false,
				// autoCropArea: 0.5,
				// dragCrop: false,
				// movable: false,
				// resizable: false,
				// rotatable: false,
				// zoomable: false,
				// touchDragZoom: false,
				// mouseWheelZoom: false,

				// minCanvasWidth: 320,
				// minCanvasHeight: 180,
				// minCropBoxWidth: 160,
				// minCropBoxHeight: 90,
				// minContainerWidth: 320,
				// minContainerHeight: 180,

				// build: null,
				// built: null,
				// dragstart: null,
				// dragmove: null,
				// dragend: null,
				// zoomin: null,
				// zoomout: null,

				aspectRatio: settings.width / settings.height,
				preview: '.img-preview',
				crop: function (data) {
					$dataX.val(Math.round(data.x));
					$dataY.val(Math.round(data.y));
					$dataHeight.val(Math.round(data.height));
					$dataWidth.val(Math.round(data.width));
					$dataRotate.val(Math.round(data.rotate));
				}
	        };

	    $image.on({
			'build.cropper': function (e) {
				console.log(e.type);
			},
			'built.cropper': function (e) {
				console.log(e.type);
			},
			'dragstart.cropper': function (e) {
				console.log(e.type, e.dragType);
			},
			'dragmove.cropper': function (e) {
				console.log(e.type, e.dragType);
			},
			'dragend.cropper': function (e) {
				console.log(e.type, e.dragType);
			},
			'zoomin.cropper': function (e) {
				console.log(e.type);
			},
			'zoomout.cropper': function (e) {
				console.log(e.type);
			}
	    }).cropper(options);

	    
	    // Methods
	    $(document.body).on('click', '[data-method]', function () {
		    var data = $(this).data(),
		        $target,
		        result;

		    if (data.method) {
		        data = $.extend({}, data); // Clone a new one

		        if (typeof data.target !== 'undefined'){
		    	    $target = $(data.target);

			        if (typeof data.option === 'undefined') {
			            try {
			              	data.option = JSON.parse($target.val());
			            } catch (e) {
			              	console.log(e.message);
			            }
			        }
		        }

		        result = $image.cropper(data.method, data.option);

		        if (data.method === 'getCroppedCanvas') {
		          	$('#getCroppedCanvasModal').modal().find('.modal-body').html(result);
		        }
		        if ($.isPlainObject(result) && $target) {
		          	try {
		            	$target.val(JSON.stringify(result));
		          	} catch (e) {
		            	console.log(e.message);
		          	}
		        }

		    }
		}).on('keydown', function (e) {
		    switch (e.which) {
		        case 37:
		    	    e.preventDefault();
		        	$image.cropper('move', -1, 0);
		        break;

		        case 38:
		          	e.preventDefault();
		          	$image.cropper('move', 0, -1);
		        break;

		        case 39:
		          	e.preventDefault();
		          	$image.cropper('move', 1, 0);
		        break;

		        case 40:
		          	e.preventDefault();
		          	$image.cropper('move', 0, 1);
		        break;
		    }

	    });


	    // Import image
	    var $inputImage = $(settings.inputFile),
	        URL = window.URL || window.webkitURL,
	        blobURL;

	    if (URL) {
	      	$inputImage.change(function () {
		        var files = this.files,
		            file;

		        if (files && files.length) {
		          	file = files[0];

		          	if (/^image\/\w+$/.test(file.type)) {
		            	blobURL = URL.createObjectURL(file);
		            	$image.one('built.cropper', function () {
		              		URL.revokeObjectURL(blobURL); // Revoke when load complete
		            	}).cropper('reset', true).cropper('replace', blobURL);
		            	//$('body').css('overflow','hidden');
		            	$('.box_panel_cropper').slideDown();

		            	//$inputImage.val('');
		          	} else {
		            	showMessage('Por favor, escolha um arquivo de imagem.');
		          	}
		        }
	     	});
	    } else {
	      	$inputImage.parent().remove();
	    }

	    $('.cancelCrop').on('click', function(event) {
	    	event.preventDefault();
	    	$('.box_panel_cropper').slideUp();
	    	$inputImage.val('');
	    	$('body').css('overflow','auto');
	    });

	    $('.saveCrop').on('click', function(event) {
	    	event.preventDefault();
	    	$('.box_panel_cropper').slideUp();
	    	$('body').css('overflow','auto');
	    });


	    /*
	    // Options
	    $('.docs-options :checkbox').on('change', function () {
	      var $this = $(this);

	      options[$this.val()] = $this.prop('checked');
	      $image.cropper('destroy').cropper(options);
	    });
	    */

	    // Tooltips
	    $('[data-toggle="tooltip"]').tooltip();

	  	}());
		
		if(settings.submitform == true)
		{
			$('[type=submit]').on('click', function(event) {
				event.preventDefault();
				formImg.submit();
			});


			formImg.ajaxForm(function(data) { 
				$('#carregando').fadeIn();
				if(data != true)
				{
					$("#result").html(data);
					$("#result").dialog({
						autoOpen: true,
						buttons: [
							{
								text: "Ok",
								click: function() {
									$( this ).dialog( "close" );
									$('#carregando').fadeOut();
									location.reload();
								}
							}
						]
					});
				}else
				{
					formImg.get(0).reset();
					location.reload();
				}
		    });
		}



    }
})(jQuery);


(function($){
    $.fn.uploadForm = function(options) {
        var configs = {
			'width' : 50,
			'height' : 50,
			'cortar' : true,
			'original' : true,
			'sendInfo':'',
			'redirect':null,
			'resetform' : true,
			'reload' : false,
			'parameters' : {}
        };

        var settings = $.extend( {}, configs, options );
        var form = $(this);
        var animate = null;


        $('.generalErrors').remove();
        form.before('<div class="panel generalErrors panel-danger" style="text-align:left; display:none;  background-color: #f2dede;"><h4 class="panel-heading">Ocorreu(ram) o(s) seguinte(s) erro(s):</h4><div class="alert" role="alert"></div></div>');

       	// pre-submit callback
		function showRequest(formData, jqForm, options)
		{ 

			/*console.log('INICIO REQUEST')
			console.log(formData)
			console.log(jqForm)
			console.log(options)
			*/
		    $('#carregando').remove();
	        $('body').append('<div id="carregando">'
								    //+'<div class="demo-wrapper html5-progress-bar">'
								        //+'<div class="progress-bar-wrapper">'
								        	+'<img src="'+url+'skin/img/imagens/loading.gif">'
								            //+'<progress id="progressbar" value="0" max="100"></progress>'
								            //+'<span class="progress-value">0%</span>'
								        //+'</div>'
								    //+'</div>'
								+'</div>');
		    $('#carregando').fadeIn();
		    return true;
		} 
 
		// post-submit callback 
		function showResponse(data, status, xhr, $form)  { 
			/*console.log('INICIO RESPONSE')
			console.log(status)
			console.log(xhr)
			console.log($form)
			
			console.log(data)
			*/

   			$('input, select, textarea',form).css('box-shadow','none');
		    $('.generalErrors .alert').html('');
		    $('.generalErrors').hide();
   			try
			{
				$('#carregando').fadeOut();
       			if(data != true)
       				{
		       			$('.generalErrors').show();
		       			//data = $.parseJSON(data);
		       			$.each(data, function(index, value) {
					        var value = ''+value;
							var values = value.split(',');
					        $.each(values, function(id, val) {
					        	$('.generalErrors .alert').append('<p>'+val+'</p>');
					        });
					        $('[name='+index+']',form).css('box-shadow','0 0 1px 1px #F00');
						});
		       			var erroTop = ($('.generalErrors').offset().top)
		       			$('body,html').animate({scrollTop : erroTop},600);
					}else
					{
						$("#img_previous",form).attr('src','');
						if(settings.reload == true)
                    		location.reload();
                        if(settings.redirect != null)
                            location.href = settings.redirect
                        if(settings.resetform == true)
                            form.get(0).reset();
						$('.generalErrors').removeClass('panel-danger').addClass('panel-success').html('<h4 class="panel-heading">Enviado com sucesso</h4>').css('background','#dff0d8').show();
						var erroTop = ($('.generalErrors').offset().top)
		       			$('body,html').animate({scrollTop : erroTop},600);
					}
			}
			catch(e)
			{
				$('#carregando').fadeOut();
	        	var erroTop = ($('.generalErrors').offset().top)
		       	$('body,html').animate({scrollTop : erroTop},600);
	        	$('.generalErrors .alert').html(data)
			}
			return true;

		} 
       	//ajaxSubmitOptions
	    var options = { 
	        //target:        '#output1',   // target element(s) to be updated with server response 
	        beforeSubmit:  showRequest,  // pre-submit callback 
	        success:       showResponse,  // post-submit callback 
	 
	        // other available options: 
	        url:       form.attr('action'),         // override for form's 'action' attribute 
	        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
	        dataType:  'json',        // 'xml', 'script', or 'json' (expected server response type) 
	        //clearForm: true        // clear all form fields after successful submit 
	        //resetForm: true        // reset the form after successful submit 
	 		data:  settings.parameters,
	        // $.ajax options can be used here too, for example: 
	        //timeout:   3000 
	        error : function(e){
	        	$('#carregando').fadeOut();
	        	var erroTop = ($('.generalErrors').offset().top)
		       	$('body,html').animate({scrollTop : erroTop},600);
	        	$('.generalErrors .alert').html(e.responseText)
	        }
	    }; 

	    
	    form.ajaxSubmit(options); 
    }; 
})(jQuery);