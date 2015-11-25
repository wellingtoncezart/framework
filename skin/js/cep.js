(function($){
    $.fn.validaCep = function(options) {
        var defaults = {
          'rua' : true,
          'bairro' : true,
          'cidade' : true,
          'uf' : true
        };

        var settings = $.extend( {}, defaults, options );
        var form = $(this);
        function limpa_formulário_cep(form) {
            // Limpa valores do formulário de cep.
            if(settings.rua == true)
                $("#rua",form).val("");

            if(settings.bairro == true)
                $("#bairro",form).val("");

            if(settings.cidade == true)
                $("#cidade",form).val("");

            if(settings.uf == true)
                $("#uf",form).val("");
        }

        //Quando o campo cep perde o foco.
        $("input[name=cep]",form).on('blur',function(){
            $("#cep",form).css({
                "border": "1px solid #999"
            });
            //console.log($('input[name=cep]',form).val());
            //Nova variável com valor do campo "cep".
            var cep = $(this).val();

            //Verifica se campo cep possui valor informado.
            if (cep != "") {

                //Expressão regular para validar o CEP.
                var validacep = /^[0-9]{5}-?[0-9]{3}$/;

                //Valida o formato do CEP.
                if(validacep.test(cep)) {

                    //Preenche os campos com "..." enquanto consulta webservice.
                    if(settings.rua == true)
                        $("#rua",form).val("...");

                    if(settings.bairro == true)
                        $("#bairro",form).val("...");

                    if(settings.cidade == true)
                        $("#cidade",form).val("...");

                    if(settings.uf == true)
                        $("#uf",form).val("...");

                    //Consulta o webservice http://viacep.com.br/
                    $.getJSON("http://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            //Atualiza os campos com os valores da consulta.
                            if(settings.rua == true)
                                $("#rua",form).val(dados.logradouro).addClass('input_content');
                            if(settings.bairro == true)
                                $("#bairro",form).val(dados.bairro).addClass('input_content');   
                            if(settings.cidade == true)
                                $("#cidade",form).val(dados.localidade).addClass('input_content');   
                            if(settings.uf == true)
                                $("#uf",form).val(dados.uf).addClass('input_content');
                            
                            //$("#ibge").val(dados.ibge);

                        } //end if.
                        else {
                            //CEP pesquisado não foi encontrado.
                            limpa_formulário_cep();
                            $("#cep",form).css({
                                "border": "2px solid red"
                            });
                            $("#cep",form).val('00000-000');
                        }
                    });
                } //end if.
                else {
                    //cep é inválido.
                    limpa_formulário_cep(form);
                    $("#cep",form).css({"border": "2px solid red"});
                    $("#cep",form).val('00000-000');
                }
            } //end if.
            else {
                //cep sem valor, limpa formulário.
                limpa_formulário_cep();
            }
        });


 
    }; 
})(jQuery);

