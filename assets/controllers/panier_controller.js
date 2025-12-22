import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        addUrl: String
    }
    
    static targets = ["successMessage"]

    async add(event) {
        event.preventDefault();
        if (!this.addUrlValue) return;

        try {
            const response = await fetch(this.addUrlValue, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' }
            });
            const data = await response.json();

            const eventGlobal = new CustomEvent('panier:change', { 
                detail: data.totalQuantity 
            });
            window.dispatchEvent(eventGlobal);

            this.successMessageTarget.classList.remove('d-none');
            
            setTimeout(() => {
                this.successMessageTarget.classList.add('d-none');
            }, 3000);

        } catch (error) {
            console.error(error);
        }
    }
}