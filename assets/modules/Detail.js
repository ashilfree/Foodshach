/**
 * @property {HTMLFormElement} form
 */

export default class Detail {

    /**
     *
     * @param {HTMLElement|null} element
     */
    constructor(element) {
        if (element === null) {
            return
        }
        this.form =document.querySelector('.js-detail-cart-form');
        this.bindEvents();
    }


    bindEvents() {
        if(this.form){
            this.form.addEventListener('submit', e =>{
                e.preventDefault();
                console.log('POSTDDDDDDDDDDDDDDDDDDD');
                let addCart = this.form.querySelector('.btn');
                addCart.classList.add('clicked');
                this.loadForm();
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
        const request = new Request(a.getAttribute('action'), init);
        await fetch(request);
        if (response.status >= 200 && response.status < 300)
        {
            a.querySelector('.btn').classList.add('success');
            setTimeout(function(){
                a.querySelector('.btn').classList.remove('clicked');
                a.querySelector('.btn').classList.remove('success');
            },2000);
            const data = await response.json();
            let iconCart = this.iconCart.querySelector('.total');
            iconCart.textContent = data.cartLength;

            // this.cart.querySelector('#sumItemsCart').textContent = data.sumItemsCart;
            // if(request.method === 'DELETE'){
            //     if(clear) {
            //         this.cart.querySelector('ul').innerHTML = data.cart;
            //         this.cart.querySelector('div.notEmpty').style.display = 'none';
            //         this.cart.querySelector('div.empty').removeAttribute('style');
            //     }else {
            //         a.parentNode.parentNode.removeChild(a.parentNode);
            //         if(data.countItemsCart === 0){
            //             this.cart.querySelector('div.notEmpty').style.display = 'none';
            //             this.cart.querySelector('div.empty').removeAttribute('style');
            //         }
            //     }
            // }
            // else
            // {
            //     this.cart.querySelector('ul').innerHTML += data.cart;
            //     if(data.countItemsCart === 1){
            //         this.cart.querySelector('div.empty').style.display = 'none';
            //         this.cart.querySelector('div.notEmpty').removeAttribute('style');
            //     }
            //     this.cart.querySelectorAll('[data-delete]').forEach(a => {
            //         a.addEventListener('click', e => {
            //             e.preventDefault();
            //             this.loadUrl(a, true);
            //         })
            //     });
            // }
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
        return this.loadUrl(this.form, params);
    }
}