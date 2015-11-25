/*
 * jQuery WV Validador 1.5
 * http://www.wviveiro.com.br/?p=269
 *
 * Author: Wellington Viveiro
 * Data: 2011-03-01
 *
 * Plugin para jQuery com validações de formulário que normalmente precisamos.
 */

/*Primeiro impedimos o conflito*/
jQuery(function($){
	
	//Função para chamar as validações
	$.fn.wvmask = function(param){
		if(param == "numero") this.wvnumero();
		else if(param == "telefone") this.wvtelefone();
		else if(param == "data") this.wvdata();
		else if(param == "cep") this.wvcep();
	}
	
	//Função para permitir apenas números no campo.
	$.fn.wvnumero = function(){
		this.keypress(function(event){
			if(event.charCode || event.charCode == "0"){
				var keyCode = event.charCode;	
			}else if(event.keyCode){
				var keyCode = event.keyCode;	
			}else{
				var keyCode = 0;	
			}
			
			if((keyCode>47 && keyCode<58) || (keyCode == 44) || (keyCode == 0)){
				return true;
			}else{
				return false;
			}
		});
	}
	
	/*Função de MÁSCARA para números de Telefone (xxxx-xxxx)*/
	$.fn.wvtelefone = function(){
		var $tamanho,$texto;
		this.wvnumero();
		function wv_tiraFinalNumeroTel(obj){
			obj.val(obj.val().replace(/-/gi,""));
			$tamanho = obj.val().length;
			$texto = obj.val().substr(0,4)+"-"+obj.val().substr(4);
			obj.val($texto);
			$tamanho = obj.val().length;
			if($tamanho>9){
				obj.val(obj.val().substr(0,9));
			}

		}
		
		function wv_mantemSoNumeroTel(obj){
			$texto = "";
			$tamanho = obj.val().length;
			for($i=0;$i<$tamanho;$i++){
				$val = obj.val().substr($i,1);
				if($val == "0" || $val == "1" || $val == "2" || $val == "3" || $val == "4" || $val == "5" || $val == "6" || $val == "7" || $val == "8" || $val == "9" || $val == "-"){
					$texto += $val;
				}
			}
			obj.val($texto);
		}
		this.keyup(function(){
			wv_tiraFinalNumeroTel($(this));
			wv_mantemSoNumeroTel($(this));
		});
		this.blur(function(){
			wv_tiraFinalNumeroTel($(this));
			wv_mantemSoNumeroTel($(this));
		});
	}
	
	$.fn.wvdata = function(){
		var $tamanho,$texto;
		this.wvnumero();
		function wv_tiraFinalNumeroData(obj){
			obj.val(obj.val().replace(/\//gi,""));
			$tamanho = obj.val().length;
			$texto = obj.val().substr(0,2)+"/"+obj.val().substr(2,2)+"/"+obj.val().substr(4);
			obj.val($texto);
			$tamanho = obj.val().length;
			if($tamanho>10){
				obj.val(obj.val().substr(0,10));	
			}
		}
		function wv_mantemSoNumeroData(obj){
			$texto = "";
			$tamanho = obj.val().length;
			for($i=0;$i<$tamanho;$i++){
				$val = obj.val().substr($i,1);
				if($val == "0" || $val == "1" || $val == "2" || $val == "3" || $val == "4" || $val == "5" || $val == "6" || $val == "7" || $val == "8" || $val == "9" || $val == "/"){
					$texto += $val;
				}
			}
			obj.val($texto);
		}
		this.keyup(function(){
			wv_tiraFinalNumeroData($(this));
			wv_mantemSoNumeroData($(this));
		});
		this.blur(function(){
			wv_tiraFinalNumeroData($(this));
			wv_mantemSoNumeroData($(this));
		});
	}

	/*Função de MÁSCARA para CEP (xxxxx-xxx)*/
	$.fn.wvcep = function(){
		var $tamanho,$texto;
		this.wvnumero();
		function wv_tiraFinalNumeroCep(obj){
			obj.val(obj.val().replace(/-/gi,""));
			$tamanho = obj.val().length;
			$texto = obj.val().substr(0,5)+"-"+obj.val().substr(5);
			obj.val($texto);
			$tamanho = obj.val().length;
			if($tamanho>9){
				obj.val(obj.val().substr(0,9));
			}

		}
		function wv_mantemSoNumeroCep(obj){
			$texto = "";
			$tamanho = obj.val().length;
			for($i=0;$i<$tamanho;$i++){
				$val = obj.val().substr($i,1);
				if($val == "0" || $val == "1" || $val == "2" || $val == "3" || $val == "4" || $val == "5" || $val == "6" || $val == "7" || $val == "8" || $val == "9" || $val == "-"){
					$texto += $val;
				}
			}
			obj.val($texto);
		}
		this.keyup(function(){
			wv_tiraFinalNumeroCep($(this));
			wv_mantemSoNumeroCep($(this));
		});
		this.blur(function(){
			wv_tiraFinalNumeroCep($(this));
			wv_mantemSoNumeroCep($(this));
		});
	}
	
	/*Função de validação de campo*/
	$.fn.valida = function(param){
		var padrao = {
			tipo : "vazio",
			minimo : 0,
			maximo : 0,
			cartao : '',
			sucesso :  function(){},
			erro : function(){}
		}
		var erro = false;
		var extErro = '';
		$.extend(padrao,param);
		if(padrao["tipo"] == "vazio"){
			if(padrao["minimo"]==0 && (this.val().length==0 || this.val() == "" || this.val() == " ")){
				erro = true;
				extErro = 'O campo está vazio.';
			}
			if(padrao["minimo"]>0 && this.val().length<padrao["minimo"]){
				erro = true;
				extErro = 'Não foi digitado número suficiente de caracteres no campo.';
			}
			if(padrao["maximo"]>0 && this.val().length>padrao["maximo"]){
				erro = true;
				extErro = 'O campo ultrapassou o número permitido de caracteres.';
			}
		}
		if(padrao["tipo"] == "email"){
			if(this.val().indexOf("@") == -1){
				erro = true;
				extErro = 'O campo não é um e-mail válido';
			}else if(this.val().substr((this.val().indexOf("@")+1)).indexOf(".") == -1){
				erro = true;
				extErro = 'O campo não é um e-mail válido';
			}
		}
		if(padrao["tipo"] == "check"){
			if(padrao["minimo"] == 0) padrao["minimo"] = 1;
			var $campos = this.selector;
			var $vetor = $campos.split(",");
			var $campo,$id,$tot,$totCampos,$encontrados;
			for($i=0;$i<$vetor.length;$i++){
				$campo = $vetor[$i];
				if($campo.indexOf("#") > -1){
					$id = $campo.replace(/#/gi,"");
					$tot = 0;
					while($("#"+$id).length>0){
						$tot++;
						$("#"+$id).attr("id",$id+$tot);
					}
					for($j=1;$j<=$tot;$j++){
						$("#"+$id+$j).addClass("wvCheck");
						$("#"+$id+$j).attr("id",$id);
					}
				}else{
					$($campo).addClass("wvCheck");
				}
			}
			$totCampos = $(".wvCheck").size();
			$encontrados = 0;
			for($i=0;$i<$totCampos;$i++){
				if($(".wvCheck:eq("+$i+")").attr('checked')){
					$encontrados++;
				}
			}
			$(".wvCheck").removeClass('wvCheck');
			if($encontrados<padrao["minimo"]){
				erro = true;
				extErro = 'Não foi selecionado número o suficiente de campos.';
			}else if($encontrados>padrao["maximo"] && padrao["maximo"]>0){
				erro = true;
				extErro = 'Foi selecionado mais campos do que o permitido.';
			}
		}
		if(padrao["tipo"] == "cpf"){
			var $f_texto,$f_primeiraParte,$i,$j,$f_total,$f_aux,$f_dig1,$f_dig2,$verdade;
			$verdade = false;
			$f_texto = this.val();
			if($f_texto.length == 11 && $f_texto != "00000000000" && $f_texto != "11111111111" && $f_texto != "22222222222" && $f_texto != "33333333333" && $f_texto != "44444444444" && $f_texto != "55555555555" && $f_texto != "66666666666" && $f_texto != "77777777777" && $f_texto != "88888888888" && $f_texto != "99999999999"){
				$f_primeiraParte = $f_texto.substr(0,9);
				$j = 11;
				$f_total = 0
				for($i=0;$i<9;$i++){
					$j--;
					$f_total += (parseInt($f_primeiraParte.substr($i,1))*$j);
				}
				$f_aux = $f_total/11;
				$f_aux = $f_aux + "";
				if($f_aux.indexOf(".")>=0){
					$f_aux = $f_aux.substr(0,$f_aux.indexOf("."));	
				}
				$f_aux = parseInt($f_aux);
				$f_aux = $f_aux*11;
				$f_aux = $f_total - $f_aux;
				$f_dig1 = "0";
				if($f_aux>=2){
					$f_aux = 11-$f_aux;
					$f_dig1 = $f_aux+"";
				}
				$j = 12;
				$f_total = 0;
				$f_primeiraParte = $f_primeiraParte + $f_dig1;
				for($i=0;$i<10;$i++){
					$j--;
					$f_total += (parseInt($f_primeiraParte.substr($i,1))*$j);
				}
				$f_aux = $f_total/11;
				$f_aux = $f_aux + "";
				if($f_aux.indexOf(".")>=0){
					$f_aux = $f_aux.substr(0,$f_aux.indexOf("."));	
				}
				$f_aux = parseInt($f_aux);
				$f_aux = $f_aux*11;
				$f_aux = $f_total - $f_aux;
				$f_dig2 = "0";
				if($f_aux>=2){
					$f_aux = 11-$f_aux;
					$f_dig2 = $f_aux+"";
				}
				if(($f_dig1+$f_dig2) == $f_texto.substr(9,2)){
					$verdade = true;
				}
			}
			if(!$verdade){
				erro = true;
				extErro = 'CPF inválido';
			}
		}
		if(padrao["tipo"] == 'cnpj'){
			var $f_texto,$f_primeiraParte,$i,$j,$f_total,$f_aux,$f_dig1,$f_dig2,$verdade;
			$verdade = false;
			$f_texto = this.val();
			if($f_texto.length == 14){
				$f_primeiraParte = $f_texto.substr(0,12);
				$j = 6;
				$f_total = 0
				for($i=0;$i<12;$i++){
					$j--;
					if($j==1){
						$j = 9;	
					}
					$f_total += (parseInt($f_primeiraParte.substr($i,1))*$j);
				}
				$f_aux = $f_total/11;
				$f_aux = $f_aux + "";
				if($f_aux.indexOf(".")>=0){
					$f_aux = $f_aux.substr(0,$f_aux.indexOf("."));	
				}
				$f_aux = parseInt($f_aux);
				$f_aux = $f_aux*11;
				$f_aux = $f_total - $f_aux;
				$f_dig1 = "0";
				if($f_aux>=2){
					$f_aux = 11-$f_aux;
					$f_dig1 = $f_aux+"";
				}
				$j = 7;
				$f_total = 0;
				$f_primeiraParte = $f_primeiraParte + $f_dig1;
				for($i=0;$i<13;$i++){
					$j--;
					if($j==1){
						$j = 9;	
					}
					$f_total += (parseInt($f_primeiraParte.substr($i,1))*$j);
				}
				$f_aux = $f_total/11;
				$f_aux = $f_aux + "";
				if($f_aux.indexOf(".")>=0){
					$f_aux = $f_aux.substr(0,$f_aux.indexOf("."));	
				}
				$f_aux = parseInt($f_aux);
				$f_aux = $f_aux*11;
				$f_aux = $f_total - $f_aux;
				$f_dig2 = "0";
				if($f_aux>=2){
					$f_aux = 11-$f_aux;
					$f_dig2 = $f_aux+"";
				}
				if(($f_dig1+$f_dig2) == $f_texto.substr(12,2)){
					$verdade = true;
				}
			}
			if(!$verdade){
				erro = true;
				extErro = 'CNPJ inválido';
			}
		}
		if(padrao["tipo"] == 'cartao'){
			var $e_tipo = padrao["cartao"];
			var $valido = true;
			var isValid = false;
			var ccCheckRegExp = /[^\d ]/;
			var cardNumber = this.val();
			var cardType = $e_tipo;
			isValid = !ccCheckRegExp.test(cardNumber);
			if (isValid){
				var cardNumbersOnly = cardNumber.replace(/ /g,"");
				var cardNumberLength = cardNumbersOnly.length;
				var lengthIsValid = false;
				var prefixIsValid = false;
				var prefixRegExp;
			switch(cardType){
				case "mastercard":
					lengthIsValid = (cardNumberLength == 16);
					prefixRegExp = /^5[1-5]/;
				break;
				case "visa":
					lengthIsValid = (cardNumberLength == 16 || cardNumberLength == 13);
					prefixRegExp = /^4/;
				break;
				case "amex":
					lengthIsValid = (cardNumberLength == 15);
					prefixRegExp = /^3(4|7)/;
				break;
				default:
					prefixRegExp = /^$/;
			}
		
			prefixIsValid = prefixRegExp.test(cardNumbersOnly);
			isValid = prefixIsValid && lengthIsValid;
			}
			if (isValid){
				var numberProduct;
				var numberProductDigitIndex;
				var checkSumTotal = 0;
				for (digitCounter = cardNumberLength - 1; digitCounter >= 0; digitCounter--){
					checkSumTotal += parseInt (cardNumbersOnly.charAt(digitCounter));
					digitCounter--;
					numberProduct = String((cardNumbersOnly.charAt(digitCounter) * 2));
					for (var productDigitCounter = 0; productDigitCounter < numberProduct.length; productDigitCounter++){
						checkSumTotal += parseInt(numberProduct.charAt(productDigitCounter));
					}
				}
				isValid = (checkSumTotal % 10 == 0);
			}
			$valido = isValid;
			if(!$valido){
				erro = true;
				extErro = 'Cartão Inválido.';
			}
		}
		if(erro){
			padrao["erro"](extErro);
		}else{
			padrao['sucesso']();
		}
	}

});