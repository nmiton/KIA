document.addEventListener("DOMContentLoaded", function() {

    const chien    = document.getElementById('chien');  
    const block_chien = document.getElementById('img_animal')
    const chien_queue =  document.getElementById('queue'); 

    let caresses = 0;
    
    //~ On lance l'initialisation 
    init();
    //~ Déclenchement de base
    function init(){
        //~ On assigne un évènement à chaque bouton : tu cliques ou tu meures
        chien.addEventListener('click', function(){
            //~ Go go go le calcul \o/
            calcul();
            est_content();
        });
    }

    function calcul(){
        caresses++;
    }

    function est_content(){
        if(caresses>3) {
            chien.style.position = 'inherit'
            setInterval("chien.style.position = 'relative'",750)
        }
    }

});