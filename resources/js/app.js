import './bootstrap';

//? import scss:
import '~resources/scss/app.scss';

//? import boostrap:
import * as bootstrap from 'bootstrap';

//? importo il componente password_confirm:
import confirmPassword from './components/password_confirm';

//? import per le immagini:
import.meta.glob(['../img/**']);

confirmPassword();

