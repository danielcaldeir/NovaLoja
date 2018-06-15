$( function() {
    
    $('.pagamentoArea').find('#efetuarCompra').click(function(e){
        var id = PagSeguroDirectPayment.getSenderHash();
        
        var nome = $('.pagamentoArea').find('#nome').val();
        var cpf = $('.pagamentoArea').find('#cpf').val();
        var telefone = $('.pagamentoArea').find('#telefone').val();
        var email = $('.pagamentoArea').find('#email').val();
        var pass = $('.pagamentoArea').find('#password').val();
        
        var cep = $('.informacoesEND').find('#cep').val();
        var rua = $('.informacoesEND').find('#rua').val();
        var numero = $('.informacoesEND').find('#numero').val();
        var complemento = $('.informacoesEND').find('#complemento').val();
        var bairro = $('.informacoesEND').find('#bairro').val();
        var cidade = $('.informacoesEND').find('#cidade').val();
        var estado = $('.informacoesEND').find('#estado').val();
        
        var cartaoTitular = $('.informacoesPAG').find('#cartao_titular').val();
        var cartaoCpf = $('.informacoesPAG').find('#cartao_cpf').val();
        var cartaoNumero = parseInt($('.informacoesPAG').find('#cartao_numero').val());
        var numeroCVV = parseInt($('.informacoesPAG').find('#cartao_cvv').val());
        var cart_mes = parseInt($('.informacoesPAG').find('#cartao_mes').val());
        var cart_ano = parseInt($('.informacoesPAG').find('#cartao_ano').val());
        
        var parc = $('.informacoesPAG').find('#parc').val();
        
        if (!isNaN(cartaoNumero) && !isNaN(numeroCVV) && !isNaN(cart_mes) && !isNaN(cart_ano)){
            PagSeguroDirectPayment.createCardToken({
                cardNumber: cartaoNumero,
                brand: window.cardBrand,
                cvv: numeroCVV,
                expirationMonth: cart_mes,
                expirationYear: cart_ano,
                    success: function(r){
                        window.cardToken = r.card.token;
                        console.log(r);
                        encaminhar(id, nome, cpf, telefone, email, pass, cep, rua, numero, complemento, bairro, cidade, estado, cartaoTitular, cartaoCpf, cartaoNumero, numeroCVV, cart_mes, cart_ano, parc );
                    },
                    error: function(r){
                        console.log(r);
                    },
                    complete: function(r){
                        
                    }
            });
        }
    });
    
    $('.informacoesPAG').find('#cartao_numero').on('keyup', function(e){
        var qtd = parseInt($(this).val().length);
        var valor = $(this).val();
        var total = parseFloat($('.pagamentoArea').find('#total').val());
        
        if (qtd === 6){
            PagSeguroDirectPayment.getBrand({
                    cardBin: valor,
                    success: function(r){
                        window.cardBrand = r.brand.name;
                        var cvvLimit = r.brand.cvvSize;
                        var expire = r.brand.expirable;
                        $('.informacoesPAG').find('#cartao_cvv').attr('maxlength', cvvLimit);
                        if (!expire){
                            $('.informacoesPAG').find('#cartao_mes').attr('disabled', true);
                            $('.informacoesPAG').find('#cartao_ano').attr('disabled', true);
                        } else {
                            $('.informacoesPAG').find('#cartao_mes').attr('disabled', false);
                            $('.informacoesPAG').find('#cartao_ano').attr('disabled', false);
                        }
                        console.log(r);
                    },
                    error: function(r){
                        console.log(r);
                    },
                    complete: function(r){
                        
                    }
                });
            
            PagSeguroDirectPayment.getPaymentMethods({
                    cardBin: $(this).val(),
                    success: function(r){
                        console.log(r);
                    },
                    error: function(r){
                        console.log(r);
                    },
                    complete: function(r){
                        
                    }
                });
        } else {
            if (typeof window.cardBrand !== "undefined" ){
                if (typeof window.htmlLog === "undefined"){
                    PagSeguroDirectPayment.getInstallments({
                        amount: total,
                        brand: window.cardBrand,
                        success: function(r){
                            if (r.error === false){
                                var parc = r.installments[window.cardBrand];
                                var html = '';
                                for (var i in parc) {
                                    var optionValue = parc[i].quantity+';'+parc[i].installmentAmount+';';
                                    if (parc[i].interestFree == true){
                                        optionValue += 'true';
                                    } else {
                                        optionValue += 'false';
                                    }
                                    html += '<option value="'+optionValue+'">'+parc[i].quantity+'x de R$ '+parc[i].installmentAmount+'</option>';
                                }
                                console.log(html);
                                window.htmlLog = html;
                                $('.informacoesPAG').find('#parc').html(html);
                            }
                            console.log(r);
                        },
                        error: function(r){
                            console.log(r);
                        },
                        complete: function(r){
                            
                        }
                    });
                }
            }
        }
    });
    
} );

function encaminhar(id, nome, cpf, telefone, email, pass, cep, rua, numero, complemento, bairro, cidade, estado, cartaoTitular, cartaoCpf, cartaoNumero, numeroCVV, cart_mes, cart_ano, parc ){
    $.ajax({
                    url: BASE_URL+'pagamento/checkout',
                    type:'POST',
                    data:{
                        id: id, 
                        name: nome, 
                        cpf: cpf, 
                        telefone: telefone, 
                        email: email, 
                        pass: pass, 
                        cep: cep, 
                        rua: rua, 
                        numero: numero, 
                        complemento: complemento, 
                        bairro: bairro, 
                        cidade: cidade, 
                        estado: estado, 
                        cartao_titular: cartaoTitular, 
                        cartao_cpf: cartaoCpf, 
                        cartao_numero: cartaoNumero, 
                        cvv: numeroCVV, 
                        v_mes: cart_mes, 
                        v_ano: cart_ano, 
                        cartao_token: window.cardToken, 
                        parc: parc 
                    },
                    dataType:'json',
                    success:function(json) {
                        if(json.error === true) {
                            alert(json.msg);
                        } else {
                            alert(json);
                            alert(json.error);
                            console.log(json);
                            window.location.href = BASE_URL+"pagamento/obrigado";
                        }
                    },
                    error:function(e) {
                        console.log(e);
                    }
                });
}