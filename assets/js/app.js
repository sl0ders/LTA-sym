$('.cross').on('click', () => {
    console.log('close');
});

new WOW().init();
import '../css/app.css';

class Autogrow extends HTMLTextAreaElement {

    constructor() {
        super();
        this.onFocus = this.onFocus.bind(this);
        this.autogrow = this.autogrow.bind(this);
    }

    /**
     * Executer quand l'element est ajouter au DOM
     */
    connectedCallback() {
        this.addEventListener('focus', this.onFocus);
        this.addEventListener('input', this.autogrow);
    }

    /**
     * Appeler quand l'element sera supprimer
     */
    disconnectedCallback() {

    }

    onFocus() {
        this.autogrow()
        this.removeEventListener('focus', this.onFocus)
    }

    autogrow() {
        this.style.height = 'auto';
        this.style.overflow = 'hidden';
        this.style.height = this.scrollHeight + 'px';
    }
}

customElements.define('textarea-autogrow', Autogrow, {extends: 'textarea'});