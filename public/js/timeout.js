
    // Esegui la funzione dopo 5 secondi (5000 millisecondi)
    setTimeout(function() {
        let flashMessage = document.getElementById('messaggio');
        if (flashMessage) {
            flashMessage.style.transition = 'opacity 1s ease';
            flashMessage.style.opacity = '0';

            // Rimuovi l'elemento dal DOM dopo che l'animazione è finita
            setTimeout(function() {
                flashMessage.remove();
            }, 1000); // Aspetta che l'animazione finisca (1s)
        }
    }, 5000);
     // Nasconde il messaggio dopo 5 secondi
    setTimeout(function() {
        let magicMessage = document.getElementById('houdini');
        if (magicMessage) {
            magicMessage.style.transition = 'opacity 1s ease';
            magicMessage.style.opacity = '0';

            // Rimuovi l'elemento dal DOM dopo che l'animazione è finita
            setTimeout(function() {
                magicMessage.remove();
            }, 1000); // Aspetta che l'animazione finisca (1s)
        }
    }, 4000); // Nasconde il messaggio dopo 5 secondi

