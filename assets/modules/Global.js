/**
 * @property {HTMLFormElement} form
 * @property {HTMLElement} iconCart
 * @property {HTMLElement} iconCart2
 * @property {HTMLElement} addCart
 */

export default class Global {

    /**
     *
     * @param {HTMLElement|null} element
     */
    constructor(element) {
        if (element === null) {
            return
        }

        this.iconCart = document.querySelector('.js-cart-icon');
        this.iconCart2 = document.querySelector('.js-cart-icon2');
        this.iconCart3 = document.querySelector('.sqs-cart-dropzone');
        this.addCart = document.querySelectorAll('.js-cart-add');
        this.form =document.querySelector('.js-detail-cart-form');
        this.bindEvents();
    }


    bindEvents() {
        if(this.addCart){

            this.addCart.forEach(a=>{
                a.addEventListener('click', e =>{
                    e.preventDefault();
                    console.log('POSTTTTTTTTTtTTTTTTTT');
                    let addCart = a.querySelector('.btn');
                    addCart.classList.add('clicked');
                    this.loadUrl(a);
                })
            })

        }
        if(this.form){
            this.form.addEventListener('submit', e =>{
                e.preventDefault();
                console.log('POSTDDDDDDDDDDDDDDDDDDD');
                let addCart = this.form.querySelector('.btn');
                addCart.classList.add('clicked');
                this.loadUrl(this.form, 'POST');
            })
        }
    }

    async loadUrl(a, method = 'GET', clear = false) {
        let url = '';
        let init = {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        if (method === 'POST'){
            const form = new FormData(a);
            url = a.getAttribute('action');
            let params = {};
            form.forEach((value, key) => {
                params[key] = value.toString();
            });
            init = {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(params)
            };
        }else{
            url = a.getAttribute('href');
        }
        const request = new Request(url, init);
        const response = await fetch(request);
        if (response.status >= 200 && response.status < 300)
        {
            a.querySelector('.btn').classList.add('success');
            setTimeout(function(){
                a.querySelector('.btn').classList.remove('clicked');
                a.querySelector('.btn').classList.remove('success');
            },2000);
            const data = await response.json();
            let iconCart = this.iconCart.querySelector('.total');
            let iconCart2 = this.iconCart2.querySelector('.total');
            let totalCart = this.iconCart2.querySelector('.price').firstChild;
            iconCart.textContent = data.cartLength;
            iconCart2.textContent = data.cartLength;
            totalCart.textContent = data.cartTotal;
            a.querySelector('.btn').setAttribute("data-content", "x " + data.productQuantity)
            this.iconCart3.style.display = 'block';
        }else {
            console.error(response);
        }
    }
}