$( function() {
    if (typeof maxslider !== 'undefined'){
        $( "#slider-range" ).slider({
            range: true,
            min: minslider,
            max: maxslider,
            values: [ $("#slider0").val(), $("#slider1").val() ],
            slide: function( event, ui ) {
                $( "#amount" ).val( "R$" + ui.values[ 0 ] + " - R$" + ui.values[ 1 ] );
            },
            change: function( event, ui){
                $("#slider"+ui.handleIndex).val(ui.value);
                $('.filterarea form').submit();
            }
        });
    }
    
    
    $( "#amount" ).val( "R$" + $( "#slider-range" ).slider( "values", 0 ) +
            " - R$" + $( "#slider-range" ).slider( "values", 1 ) );
    
    $('.filterarea').find('input').on('change', function(){
        $('.filterarea form').submit();
    });
    
    $('.addtocartform button').on('click',function(e){
        e.preventDefault();
        
        var qtd = parseInt($('.addtocart_qt').val());
        var action = $(this).attr('data-action');
        
        if (action == 'decrementar'){
            qtd--;
            if (qtd <1){
                qtd++;
            }
        } else if(action == 'incrementar'){
            qtd++;
        }
        $('.addtocart_qt').val(qtd);
    });
    
    $('.photo_item').on("click", function(){
       var url = $(this).find('img').attr('src');
       $('.mainphoto').find('img').attr('src', url);
    });
    
} );

$("#menu").menu();

function  incrementar(){
    var qtd = parseInt(document.getElementById('qtd').value);
    qtd++;
    document.getElementById('qtd').value = qtd;
    document.getElementById('qtd_prd').value = qtd;
}

function  decrementar(){
    var qtd = parseInt(document.getElementById('qtd').value);
    qtd--;
    if (qtd <1){
        qtd++;
    }
    document.getElementById('qtd').value = qtd;
    document.getElementById('qtd_prd').value = qtd;
}

function  estocar(){
    var qtd = parseInt(document.getElementById('estoque').value);
    qtd++;
    document.getElementById('estoque').value = qtd;
    document.getElementById('qtd').value = qtd;
}

function  retirar(){
    var qtd = parseInt(document.getElementById('estoque').value);
    qtd--;
    if (qtd <1){
        qtd++;
    }
    document.getElementById('estoque').value = qtd;
    document.getElementById('qtd').value = qtd;
}

function newImage(){
    var node = document.createElement('input');
    var image = document.getElementById('fileImage');
    var id = parseInt(image.getAttribute('idFileImage'));
    var txtFotos = ("fotos") + (++id);
    node.setAttribute("type", "file");
    node.setAttribute("name", "fotos[]");
    node.setAttribute("class","btn btn-box-tool");
    node.setAttribute("id", txtFotos);
    image.appendChild(node);
    image.setAttribute('idFileImage', id);
}

function delImage(){
    var image = document.getElementById('fileImage');
    var id = parseInt(image.getAttribute('idFileImage'));
    var txtFotos = ("fotos") + (id--);
    var input = document.getElementById(txtFotos);
    if (id >= 0){
        image.removeChild(input);
        image.setAttribute('idFileImage', id);
    }
}
/*   @brief Converte um valor em formato float para uma string em formato moeda
      @param valor(float) - o valor float
      @return valor(string) - o valor em moeda
*/
function converteFloatMoeda(valor){
    var inteiro = null;
    var decimal = null;
    var c = null;
    var j = null;
    var aux = new Array();
    valor = ""+valor;
    c = valor.indexOf(".",0);
    //encontrou o ponto na string
    if(c > 0){
         //separa as partes em inteiro e decimal
         inteiro = valor.substring(0,c);
         decimal = valor.substring(c+1,valor.length);
    }else{
         inteiro = valor;
    }
    
    //pega a parte inteiro de 3 em 3 partes
    for (j = inteiro.length, c = 0; j > 0; j-=3, c++){
         aux[c]=inteiro.substring(j-3,j);
    }
    
    //percorre a string acrescentando os pontos
    inteiro = "";
    for(c = aux.length-1; c >= 0; c--){
         inteiro += aux[c]+'.';
    }
    //retirando o ultimo ponto e finalizando a parte inteiro
    inteiro = inteiro.substring(0,inteiro.length-1);
    
    decimal = parseInt(decimal);
    if(isNaN(decimal)){
        decimal = "00";
    }else{
        decimal = ""+decimal;
        if(decimal.length === 1){
            decimal = decimal+"0";
        }
    }
    
    valor = "R$ "+inteiro+","+decimal;
    
    return valor;
}
   
/*   @brief Converte uma string em formato moeda para float
      @param valor(string) - o valor em moeda
      @return valor(float) - o valor em float
*/
function converteMoedaFloat(valor){
    
    if(valor === ""){
        valor =  0;
    }else{
        valor = valor.replace(".","");
        valor = valor.replace(",",".");
        valor = parseFloat(valor);
    }
    
    return valor;
}

function getMoney( str ){
    return parseInt( str.replace(/[\D]+/g,'') );
}

// WRITE THE VALIDATION SCRIPT.
function isNumber(evt) {
    var iKeyCode = (evt.which) ? evt.which : evt.keyCode;
    if (iKeyCode !== 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57)){
        return false;
    }
    return true;
}

function formatReal( int ){
    var tmp = int + '';
    tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
    if( tmp.length > 6 )
        tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    return tmp;
}

function formatarMoeda() {
    var elemento = document.getElementById('preco');
    var valor = elemento.value;
    var inteiro = null;
    var decimal = null;
    var real = null;
    var len = null;
    
    //valor = valor + '';
    //valor = parseInt(valor.replace(/[\D]+/g,''));
    real = getMoney(valor);
    real = real + '';
    len = real.length;
    
    decimal = real.substring(len - 2, len);
        if (decimal.length === 1){
            decimal = '0' + decimal;
        }
    //alert("Decimal: "+decimal);
    if (len > 2){
        inteiro = real.substring(0, len - 2);
        //alert("Inteiro: "+inteiro);
    } else {
        inteiro = '0';
    }
    real = inteiro + decimal;
    
    valor = formatReal(real);
    
    //valor = valor.replace(/([0-9]{2})$/g, ",$1");
    //switch (valor.length) {
    //    case 1: break;
    //    case 2: break;
    //    case 3: break;
    //    case 4: break;
    //    case 5: break;
    //    case 6: break;
    //    case 7:
    //        valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    //        break;
    //    case 8:
    //        valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    //        break;
    //    case 9:
    //        valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    //        break;
    //    default:
    //        valor = valor.replace(/([0-9]{3}),([0-9]{3}),([0-9]{2}$)/g, ".$1.$2,$3");
    //        break;
    //}
    
    //if (valor.length > 6) {
    //    valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");
    //}
    
    elemento.value = valor;
}