// document.addEventListener("DOMContentLoaded", function () {
//     // Richiedi il token cliente dal backend
//     fetch("/braintree/token")
//         .then(response => response.json())
//         .then(data => {
//             if (data.error) {
//                 console.error('Errore nella generazione del token:', data.error);
//                 return;
//             }
//             console.log('Token generato:', data.token);
//             console.log('Token che sto usando per il drop-in:', data.token);

//             // Inizializza il drop-in UI di Braintree
//             braintree.dropin.create({
//                 authorization: data.token,
//                 container: '#dropin-container'
//             }, function (createErr, instance) {
//                 if (createErr) {
//                     console.error('Errore nella creazione del drop-in:', createErr);
//                     return;
//                 }

//                 // Quando l'utente invia il form
//                 document.getElementById('payment-form').addEventListener('submit', function (event) {
//                     event.preventDefault();

//                     // Recupera l'importo selezionato
//                     const sponsorship = document.querySelector('input[name="sponsorship"]:checked');
//                     if (!sponsorship) {
//                         alert("Per favore seleziona un'opzione di sponsorizzazione.");
//                         return;
//                     }

//                     const amount = sponsorship.value;
//                     const slug = document.getElementById('home-slug').value;

//                     // Richiedi il metodo di pagamento
//                     instance.requestPaymentMethod(function (err, payload) {
//                         if (err) {
//                             console.error('Errore nel metodo di pagamento:', err);
//                             return;
//                         }

//                         // Invia il nonce, l'importo e lo slug al backend per processare il pagamento
//                         fetch("/braintree/process", {
//                             method: 'POST',
//                             headers: {
//                                 'Content-Type': 'application/json',
//                                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                             },
//                             body: JSON.stringify({
//                                 payment_method_nonce: payload.nonce,
//                                 amount: amount,
//                                 home_slug: slug
//                             })
//                         })
//                         .then(response => response.json())
//                         .then(result => {
//                             if (result.success) {
//                                 alert('Pagamento completato con successo!');
//                             } else {
//                                 alert('Errore nel pagamento: ' + result.message);
//                             }
//                         });
//                     });
//                 });
//             });
//         })
//         .catch(err => {
//             console.error('Errore durante la richiesta del token:', err);
//         });
// });


// //? demo:
document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('#payment-form');
  const submitButton = document.querySelector('#submit-button');
  const errorMessageDiv = document.querySelector('#error-message'); // Div per gli errori

  // Creazione del drop-in di Braintree
  braintree.dropin.create({
      authorization: 'sandbox_g42y39zw_348pk9cgf3bgyw2b', // sostituisci con il tuo token di autorizzazione
      container: '#dropin-container'
  }, function (err, instance) {
      if (err) {
          console.error('Errore nella creazione del drop-in:', err);
          return;
      }

      // Disabilita il submit finché il pagamento non è verificato
      submitButton.addEventListener('click', function (event) {
          event.preventDefault();

          // Nascondi eventuali messaggi di errore precedenti
          errorMessageDiv.style.display = 'none';
          errorMessageDiv.textContent = '';

          const selectedSponsorship = document.querySelector('input[name="sponsorship"]:checked');
          if (!selectedSponsorship) {
              errorMessageDiv.style.display = 'block';
              errorMessageDiv.textContent = 'Seleziona un\'opzione di sponsorizzazione (platinum, gold o silver).';
              return; 
          }

          instance.requestPaymentMethod(function (err, payload) {
              if (err) {
                  // Mostra l'errore sulla pagina invece di usare alert
                  errorMessageDiv.style.display = 'block';
                  errorMessageDiv.textContent = 'Errore nei dati della carta. Per favore, verifica i dati inseriti.';
                  console.error('Errore nel metodo di pagamento:', err);

                  setTimeout(function() {
                    errorMessageDiv.style.transition = 'opacity 1s ease';
                    errorMessageDiv.style.opacity = '0';
                  }, 3000); 
                  
                  return; 
              }

              const hiddenNonceInput = document.createElement('input');
              hiddenNonceInput.type = 'hidden';
              hiddenNonceInput.name = 'payment_method_nonce';
              hiddenNonceInput.value = payload.nonce;
              form.appendChild(hiddenNonceInput);

              form.submit();
          });
      });
  });
});