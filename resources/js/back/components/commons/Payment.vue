<template>
   <form class="purchase-form" @submit.prevent="buy()">
        <h4 v-if="!stay">Select an apartment to sponsor.</h4>
        <div v-else>
            <h4>{{stay}}</h4>
            <div class="packages">
                <div class="package" v-for="sponsor in packages" :key="sponsor.id" @click="choosePackage(sponsor)">{{sponsor.name}}</div>
            </div>
            <div class="buttons" v-if="choosenPackage">
                {{choosenPackage}}
                <button @click.prevent="decrement()">-</button>
                <span class="times">{{buyInfo.times}}</span>
                <button @click.prevent="increment()">+</button>
            </div>


            <div id="dropin-container"></div>
            <!-- <button id="submit-button" @click.prevent>compra</button> -->
            <button v-if="choosenPackage">BUY</button>
        </div>
    </form>
</template>

<script>
export default {
    name:'Payment',
    props: {
        buyInfo: Object,
        stay: String,
        packages: Array,
    },
    data() {
        return {
            choosenPackage: null,
            CLIENT_AUTHORIZATION: ''
        }
    },
    created() {
        // Step two: create a dropin instance using that container (or a string
        //   that functions as a query selector such as `#dropin-container`)
        // console.log(braintree);
        dropin.create({
            authorization: this.CLIENT_AUTHORIZATION,
            container: document.getElementById('dropin-container'),
            // card: {
            //     overrides: {
            //         fields: {
            //             number: {
            //             placeholder: '1111 1111 1111 1111' // Update the number field placeholder
            //             },
            //             postalCode: {
            //             minlength: 5 // Set the minimum length of the postal code field
            //             },
            //             cvv: null // Remove the CVV field from your form
            //         },
            //         styles: {
            //             input: {
            //             'font-size': '18px' // Change the font size for all inputs
            //             },
            //             ':focus': {
            //             color: 'red' // Change the focus color to red for all inputs
            //             }
            //         }
            //     }
            // }
        // ...plus remaining configuration
        }).then((dropinInstance) => {
            // document.getElementById('submit-button').addEventListener('click',() => {
                console.log('nooo signori di Dropin');
            // })
        // Use `dropinInstance` here
        // Methods documented at https://braintree.github.io/braintree-web-drop-in/docs/current/Dropin.html
        }).catch((error) => {});
    },
    methods: {
        choosePackage(sponsor) {
            this.buyInfo.sponsorPackage_id = sponsor.id
            this.buyInfo.sponsorPackage_duration = sponsor.duration
            this.choosenPackage = sponsor.name
        },
        increment() {
            if (this.buyInfo.times < 10) this.buyInfo.times++
        },
        decrement() {
            if (this.buyInfo.times > 1) this.buyInfo.times--
        },
        buy() {
            axios.post('/user/add-sponsor',this.buyInfo).then((response) => {
                this.$emit('update')
            })
            .catch((error) => {
                // console.log(error)
            });
        
        }
    }
}
</script>

<style  lang="scss" scoped>
.purchase-form {
        flex: 1;
        height: 500px;
        h4 {
            font-size: 2rem;
        }
        .packages {
            display: flex;
            margin-bottom: 2rem;
            .package {
                margin: 0 2rem;
                font-size: 1.3rem;
                font-weight: 400;
                cursor: pointer;
                &:hover {
                    text-decoration: underline;
                }
            }
        }
        button {
            min-width: 2rem;
            height: 2rem;
            display: inline-block;
            margin-top: 2rem;
            font-size: 1.3rem;
        }
    }
</style>