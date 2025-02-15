/* ***********************************
 *      AUTOCOMPLETAMENTO
 *        DELL'INDIRIZZO
*********************************** */

document.addEventListener('DOMContentLoaded', function () {
    const addressInput = document.getElementById('address');
    const suggestionsList = document.getElementById('address-suggestions');

    addressInput.addEventListener('keyup', function () {
        const query = addressInput.value;

        if (query.length >= 3) {
            fetch(`${addressSuggestionsUrl}?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    //? ripulisce i suggerimenti precedenti:
                    suggestionsList.innerHTML = '';

                    //? aggiungiamo nuovi suggerimenti:
                    data.forEach(suggestion => {
                        const listItem = document.createElement('li');
                        listItem.classList.add('list-group-item', 'suggestion-item');
                        listItem.textContent = suggestion;

                        //? evento click per selezionare l'indirizzo:
                        listItem.addEventListener('click', function () {
                            addressInput.value = suggestion;

                            //? ripulisce i suggerimenti dopo la selezione:
                            suggestionsList.innerHTML = '';  
                        });

                        suggestionsList.appendChild(listItem);
                    });
                })
                .catch(error => {
                    console.error('Errore nella chiamata API:', error);
                });
        } else {
            //? cancella i suggerimenti se la query è troppo corta:
            suggestionsList.innerHTML = '';
        }
    });
});
