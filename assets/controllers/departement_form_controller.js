
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input'];

    showAlert() {
        alert('Vous avez modifié un champ !');
    }
}
