// (nouvelle) charte graphique  :
// 1- flèche du bas      = 6fb4a1; 
// 1- barre de recherche = 87b1a7;
// 2- légende            = 87b1a7;
// 3- stroke             = 73afa3;
// 4- end fill           = 73afa3;
// 4* start fill         = eff8f7;


var canvas = $('canvas'),
    next = $('.next');
if(canvas.length){
    $(next).css('margin-top', '-3%');
}
else{
    $(next).css('margin-top', '2%');
}


function getData(param) {
    $.getJSON( "http://dataviz.dev/api_php/search/"+param, function( data ) {
        init(data);
    });   
}

function init(data) {

    var canvas = document.getElementById("seriecanvas"),
        ctx = canvas.getContext("2d"),
        width = canvas.width,
        height = canvas.height,
        dataLenght = data.length;

    //fade canvas
    $(canvas).animate({opacity: 0}, 0).stop().delay(800).stop().animate({opacity: 1}, 700);
    $('.txt-episode-season').animate({opacity: 0}, 0).stop().delay(800).stop().animate({opacity: 1}, 700);

    function serie(){

        var dataLenghtz = data.length,
            repartition1 = width / dataLenghtz,
            repartition1Change = (-0.5) * (repartition1);

        //begin drawing
        ctx.beginPath();
        ctx.moveTo(0,380);


        //change text of legend
        $('.txt-episode-season').animate({opacity: 0}, 350, function(){$(this).replaceWith("<p class='txt-legend txt-episode-season'>SEASONS</p>")}).animate({opacity: 1}, 350);
        $('.txt-grade').animate({opacity: 0}, 350, function(){$(this).replaceWith("<p class='txt-legend txt-grade'>AVERAGE (SEASONS)</p>")}).animate({opacity: 1}, 350);
        for(i=0;i<dataLenght;i++){

            var count = 0;


            for(x = 0; x <data[i].length; x++) 
            { 
                count += data[i][x];
            }
            repartition1Change = repartition1Change + repartition1;

            // x & y coords.
            var xCoords = repartition1Change,
                yCoords = ((-1) * (((count*30)/ (data[i].length)))) + 375 - 10,
                r=20;

            ctx.lineTo( xCoords, yCoords);
            ctx.strokeStyle = "#73afa3";
            ctx.lineWidth = "6";

            //gradient
            var my_gradient = ctx.createLinearGradient(0, 0, 0, 380);
            my_gradient.addColorStop(0, "#73afa3");
            my_gradient.addColorStop(1, "#eff8f7");
            ctx.fillStyle = my_gradient;

            //add "a" Element
            var $linkSeries = $("<a >", { class: "link_series transition important", href:"#", "data-season" : i});
            $(".seriecanvas_wrp").append($linkSeries);
            $linkSeries.css({ left:(xCoords-10)+"px", top:(yCoords-13)+"px"});
            $linkSeries.append( "<span class='name-of-saison'>Season "+(i+1)+"</span>" );
        }
        //draw canvas
        ctx.lineJoin = "round";
        ctx.stroke();
        ctx.lineTo(569,380);
        ctx.moveTo(569,380);
        ctx.fill();
    }
    serie();
    tryhard();

    $('input').click(function(){

        var inputName = $(this).attr('name');
        inputName = inputName -1;

        //fade in fade out
        $(canvas).animate({opacity: 0}, 0).stop().delay(800).stop().animate({opacity: 1}, 700);
        ctx.clearRect ( 0 , 0 , width, height );
        $('.seriecanvas_wrp a').remove();

        if(inputName === -1)
        {
            serie();
            tryhard();
        }
        else{
            //change text of legend
            $('.txt-episode-season').animate({opacity: 0}, 350, function(){$(this).replaceWith("<p class='txt-legend txt-episode-season'>EPISODES</p>")}).animate({opacity: 1}, 350);
            $('.txt-grade').animate({opacity: 0}, 350, function(){$(this).replaceWith("<p class='txt-legend txt-grade'>GRADE</p>")}).animate({opacity: 1}, 350); 
            ctx.beginPath();
            ctx.moveTo(0,380);

            var dataLenght2 = data[inputName].length,
                repartition2       = (width) / dataLenght2,
                repartition1Change = (-0.5)*(repartition2);

            for(i=0;i<dataLenght2;i++){
                repartition1Change = repartition1Change + repartition2;

                var val = data[inputName][i];
                var xCoords = repartition1Change,
                    yCoords = ((-1)*((val*90)/3))+375-10,
                    r=10; 

                ctx.lineTo( xCoords, yCoords);
                // ctx.strokeStyle="#cb4460";
                ctx.strokeStyle="#73afa3;";
                ctx.lineWidth = "6";

                //add "a" Element
                var $linkSeries = $("<a>", { class: "link_series transition", href:"#"});
                $(".seriecanvas_wrp").append($linkSeries);
                $linkSeries.css({ left:(xCoords-10)+"px", top:(yCoords-13)+"px"});


                $linkSeries.append( "<span class='name-of-ep'>EP "+(i+1)+"</span>" );
            }

            var my_gradient = ctx.createLinearGradient(0, 0, 0, 380);
            my_gradient.addColorStop(0, "#73afa3");
            my_gradient.addColorStop(1, "#eff8f7");
            ctx.fillStyle = my_gradient;
            ctx.lineJoin = "round";
            ctx.stroke();
            ctx.lineTo(588,380);
            ctx.moveTo(588,380);
            ctx.fill();
        }
    });

    function tryhard(){
        $('.important').click( function(){


            $('.active').removeClass('active');
            var detect = $(this).attr('data-season'),
                add_active = parseInt(detect) + 1,
                input = $('input[name='+add_active+']');
            coord_input = $(input).offset().left-100;
            //                coord_input = coord_input - 100;
            console.log(coord_input);



            $(".seasons").animate({ 
                scrollLeft: $(input).offset().left-350 
            }, 600);
            $(input).addClass('active');


            ctx.clearRect ( 0 , 0 , width, height );

            $('.seriecanvas_wrp a').remove();

            //change text of legend
            $('.txt-episode-season').animate({opacity: 0}, 350, function(){$(this).replaceWith("<p class='txt-legend txt-episode-season'>EPISODES</p>")}).animate({opacity: 1}, 350);
            $('.txt-grade').animate({opacity: 0}, 350, function(){$(this).replaceWith("<p class='txt-legend txt-grade'>GRADE</p>")}).animate({opacity: 1}, 350);


            //fades
            $(canvas).animate({opacity: 0}, 0).stop().delay(800).stop().animate({opacity: 1}, 700);

            ctx.beginPath();
            ctx.moveTo(0,380);

            var dataLenght2 = data[detect].length,
                repartition2       = (width) / dataLenght2,
                repartition1Change = (-0.5)*(repartition2);

            for(i=0;i<dataLenght2;i++){
                repartition1Change = repartition1Change + repartition2;

                var val = data[detect][i];
                var xCoords = repartition1Change,
                    yCoords = ((-1)*((val*90)/3))+375-10,
                    r=10; 

                ctx.lineTo( xCoords, yCoords);
                ctx.strokeStyle="#73afa3;";
                ctx.lineWidth = "6";

                //add "a" Element
                var $linkSeries = $("<a>", { class: "link_series transition", href:"#"});
                $(".seriecanvas_wrp").append($linkSeries);
                $linkSeries.css({ left:(xCoords-10)+"px", top:(yCoords-13)+"px"});

                $linkSeries.append( "<span class='name-of-ep'>EP "+(i+1)+"</span>" );
            }

            var my_gradient = ctx.createLinearGradient(0, 0, 0, 380);
            my_gradient.addColorStop(0, "#73afa3");
            my_gradient.addColorStop(1, "#eff8f7");
            ctx.fillStyle = my_gradient;
            ctx.lineJoin = "round";
            ctx.stroke();
            ctx.lineTo(588,380);
            ctx.moveTo(588,380);
            ctx.fill();

        });
    }
}

$('.next2').click(function(){

    $('.first_graph').delay(1000).animate({opacity:'1'},1000);
    $('.status').delay(1000).animate({width:'75%'},2000);
    $('.last').delay(2200).animate({opacity:'1'},1000);

    $('.count').each(function () {
        $(this).delay(1000).animate({opacity:'1'},1000);
        $(this).prop('Counter',0).animate({
            Counter: $(this).children('input').attr('name')
        }, {
            duration: 3000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });

})


var menu_length = $('ul.seasons > *').length;
if(menu_length > 6){
    $('ul.seasons').css('overflow-x', 'scroll');
}
else{
    $('ul.seasons').css('overflow-y', 'hidden');
}

$('input').click(function(){
    $('.active').removeClass('active');
    $(this).addClass('active');
});

// Fonction qui detecte le scroll de la souris et le stock dans x
// Il applique ensuite les changement de class et l'animation de la page 'Lionel' 
// en fonction du scroll de la souris

$('a.important').on('click' ,function(){
    console.log('yo');
    var serie = $(this).attr('data-season');
    console.log(serie);
});

var x = 0;
$('body').bind('mousewheel', function(e){

    var scroll  = parseInt(e.originalEvent.wheelDelta);
    x = x + scroll;
    console.log(x);

    if(x > -1000){

        $('.popularity').removeClass('passed').addClass('actual');
        $('.characters').removeClass('actual').addClass('waiting');

    }
    else if( x < -1000 && x > -2000){

        $('.popularity').removeClass('actual').addClass('passed');
        $('.characters').removeClass('waiting').addClass('actual');
        $('.characters').removeClass('passed').addClass('actual');
        $('.Lionel').removeClass('actual').addClass('waiting');

    }
    else if( x < -2000){

        $('.characters').removeClass('actual').addClass('passed');
        $('.Lionel').removeClass('waiting').addClass('actual');

        $('.first_graph').delay(1000).animate({opacity:'1'},1000);
        $('.status').delay(1000).animate({width:'75%'},2000);
        $('.last').delay(2200).animate({opacity:'1'},1000);

        $('.count').each(function () {
            $(this).delay(1000).animate({opacity:'1'},1000);
            $(this).prop('Counter',0).animate({
                Counter: $(this).children('input').attr('name')
            }, {
                duration: 3000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    }
})


$('.next').click(function ()
                 {
    $('.popularity').removeClass('actual').addClass('passed');
    $('.characters').removeClass('waiting').addClass('actual');
});

$('.next2').click(function (e)
                  {
    $('.characters').removeClass('actual').addClass('passed');
    $('.Lionel').removeClass('waiting').addClass('actual');
});

$('.prec').click(function (e)
                 {
    $('.popularity').removeClass('passed').addClass('actual');
    $('.characters').removeClass('actual').addClass('waiting');
});

$('.prec2').click(function (e)
                  {
    $('.characters').removeClass('passed').addClass('actual');
    $('.Lionel').removeClass('actual').addClass('waiting');
});



