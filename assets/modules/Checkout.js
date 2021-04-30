/**
 * @property {HTMLFormElement} form
 */

export default class Checkout {

    /**
     *
     * @param {HTMLElement|null} element
     */
    constructor(element) {
        if (element === null) {
            return
        }
        this.form =document.querySelector('.js-checkout-form');
        this.bindEvents();
    }


    bindEvents() {
        if(this.form){
            this.form.addEventListener('submit', e =>{
                e.preventDefault();
                console.log(this.form.value);

             //   this.loadForm();
            })
        }
    }

    async loadUrl(a, data = null) {
        let init = {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json'
            },
            method: 'POST',
            body: JSON.stringify(data)
        };
        const request = new Request(a, init);
        const response = await fetch(request);
        if (response.status >= 200 && response.status < 300)
        {
            const data = await response.json();

        }else {
            console.error(response);
        }
    }
    async loadForm() {
        const data = new FormData(this.form);
        const url = this.form.getAttribute('action');

        let params = {};
        data.forEach((value, key) => {
            params[key] = value.toString();
        });

        console.log(params);
        return this.loadUrl(url, params);
    }
}