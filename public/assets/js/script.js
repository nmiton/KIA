document.addEventListener("DOMContentLoaded", function () {

    const chien = document.getElementById('chien');
    const block_chien = document.getElementById('img_animal')
    const chien_queue = document.getElementById('queue');

    let monAnimal = new Object();
    monAnimal.caresses = 0;
    monAnimal.estContent = false;
    //~ On lance l'initialisation 
    init();
    //~ Déclenchement de base
    function init() {
        //~ On assigne un évènement à chaque bouton : tu cliques ou tu meures
        chien.addEventListener('click', function () {
            //~ Go go go le calcul \o/
            setCaresse()
            screamer()
        });
    }

    function setCaresse() {
        monAnimal.caresses++;
        if (monAnimal.caresses > 10) {
            monAnimal.caresses = 0
        }
        setEstContent()
    }

    function setEstContent() {
        if (monAnimal.caresses > 3) {
            monAnimal.estContent = true
        } else {
            monAnimal.estContent = false
        }
    }

    function screamer() {
        if (monAnimal.caresses > 5 & monAnimal.estContent) {
            chien.style.position = 'inherit'
            setInterval("chien.style.position = 'relative'", 800)
        }
    }

});