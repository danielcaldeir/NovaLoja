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
