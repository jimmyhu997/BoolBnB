<template>
    <form class="purchase-form" @submit.prevent="buy()">
        <div class="heading">
            <div class="back">
                <button class="back round-btn" :class="{'disabled' : data.purchaseView == 'tiers'}" @click.prevent="back()">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 4px; overflow: visible;"><g fill="none"><path d="m20 28-11.29289322-11.2928932c-.39052429-.3905243-.39052429-1.0236893 0-1.4142136l11.29289322-11.2928932"></path></g></svg>
                </button>
            </div>
            <h4 class="title" v-if="stay">{{stay}}</h4>
            <div class="empty"></div>
        </div>
        <!-- Packages -->
        <div class="packages" v-if="data.purchaseView == 'tiers'">
            <div class="packages-card" v-for="sponsor in packages" :key="sponsor.id">
                <div class="name">{{sponsor.name}}</div>
                <div class="body" @click="choosePackage(sponsor)">
                    <div class="duration">{{sponsor.duration / 24 == 1 ? sponsor.duration / 24 + ' day' : sponsor.duration / 24 + ' days'}}</div>
                    <div class="price">{{sponsor.price}}€</div>
                </div>
            </div>
        </div>
        <!-- Quantity -->
        <div class="quantity" v-if="data.purchaseView == 'quantity'">
            <div class="package-card">
                <div class="name">{{choosenPackage.name}}</div>
                <div class="body">
                    <div class="duration">{{choosenPackage.duration / 24 == 1 ? choosenPackage.duration / 24 + ' day' : (choosenPackage.duration / 24) * data.buyInfo.times + ' days'}}</div>
                    <div class="price">{{(data.buyInfo.sponsorPackage_price * data.buyInfo.times).toFixed(2)}}€</div>
                </div>
            </div>
            <div class="number-buttons">
                <button class="round-btn" :class="{'disabled' : data.buyInfo.times == 1}" @click.prevent="decrement()">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28"></path></svg>
                </button>
                <span class="times">{{data.buyInfo.times}}</span>
                <button class="round-btn" :class="{'disabled' : data.buyInfo.times == 10}" @click.prevent="increment()">
                    <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28m-14-14v28"></path></svg>
                </button>
            </div>
            <div class="checkout-btn">
                <button class="large-btn" @click="data.purchaseView = 'pay'">Checkout</button>
            </div>
        </div>
        <!-- Payment -->
        <div class="payment" v-if="data.purchaseView == 'pay'">
            <div class="heading">
                <span class="purchase-info">{{choosenPackage.name}}: x{{data.buyInfo.times}} - <span class="pink">{{data.buyInfo.sponsorPackage_price * data.buyInfo.times}}€</span></span>
            </div>
            <div ref="payment"></div>
            <button class="action-btn" v-if="buyButton">BUY</button>
        </div>
        <PaymentSuccessModal :confirmation="confirmation"/>
    </form>
</template>

<script>
import data from '../../../vue-commons/vueGlobal'
import PaymentSuccessModal from '../modals/PaymentSuccessModal.vue'
export default {
    name:'Payment',
    components: {PaymentSuccessModal},
    props: {
        stay: String,
        packages: Array,
    },
    data() {
        return {
            data,
            choosenPackage: null,
            dropinInstance: {},
            purchaseView: 'tiers',
            buyButton: false,
            confirmation: false
        }
    },
    mounted() {
        // Step two: create a dropin instance using that container (or a string
        //   that functions as a query selector such as `#dropin-container`)
        // console.log(braintree);
        
    },
    methods: {
        choosePackage(sponsor) {
            data.buyInfo.sponsorPackage_id = sponsor.id
            data.buyInfo.sponsorPackage_duration = sponsor.duration
            data.buyInfo.sponsorPackage_price = parseFloat(sponsor.price)
            this.choosenPackage = sponsor
            data.purchaseView = 'quantity'
            this.buyButton = false
        },
        back() {
            this.buyButton = false
            if (this.$refs.payment) {
                this.$refs.payment.innerHTML = ''
            }
            if (data.purchaseView == 'quantity') {
                data.purchaseView = 'tiers'
                data.buyInfo.sponsorPackage_id = null
                data.buyInfo.sponsorPackage_duration = null
                data.buyInfo.sponsorPackage_price = null
                data.buyInfo.times = 1
            }
            if (data.purchaseView == 'pay') {
                data.purchaseView = 'quantity'
            }
        },
        increment() {
            if (data.buyInfo.times < 10) data.buyInfo.times++
        },
        decrement() {
            if (data.buyInfo.times > 1) data.buyInfo.times--
        },
        buy() {
            this.dropinInstance.requestPaymentMethod().then(payload => {
                axios.post('/user/add-sponsor', {
                    payment: {
                        nonce: payload.nonce                           
                    },
                    data: data.buyInfo
                }).then((response) => {
                    this.$emit('update')
                    this.confirmation = true
                    setTimeout(() => {
                        this.confirmation = false
                        this.$router.go()
                    }, 5000);
                })
                .catch((error) => {
                    console.log(error)
                });
            }).catch((error) => {
                console.log(error);
            })
        
        }
    },
    watch: {
        '$data.data.purchaseView'(view) {
            if (view == 'pay') {
                axios.get('/user/get-token')
                    .then(response => {
                        dropin.create({
                            authorization: response.data,
                            container: this.$refs.payment,
                            card: {
                                overrides: {
                                    fields: {
                                        number: {
                                        placeholder: '1111 1111 1111 1111' // Update the number field placeholder
                                        },
                                        postalCode: {
                                        minlength: 5 // Set the minimum length of the postal code field
                                        },
                                        // cvv: null // Remove the CVV field from your form
                                    },
                                    styles: {
                                        input: {
                                        'font-size': '18px' // Change the font size for all inputs
                                        },
                                        // ':focus': {
                                        // color: 'red' // Change the focus color to red for all inputs
                                        // }
                                    }
                                }
                            }
                        }).then((dropinInstance) => {
                            this.dropinInstance = dropinInstance
                            this.buyButton = true
                        }).catch((error) => {
                            console.log(error);
                        });
                    })
            }
        }
    }
}
</script>

<style  lang="scss" scoped>
@import '../../../../sass/_variables.scss';
@import '../../../../sass/mixins.scss';
@include round-btn;
@include large-btn;
@include action-btn;
.purchase-form {
    flex-shrink: 0;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: .5px solid rgba(0, 0, 0, .2);
    @media screen and (min-width: $medium) {
        width: 50%;
        padding-top: 0;
        margin-top: 0;
        padding-left: 2rem;
        border: none;
    }
    .heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        .title {
            flex: 1;
            text-align: center;
            font-size: 1.4rem;
            font-weight: 500;
            margin-right: 2rem
        }
    }
    .packages {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        @media screen and (min-width: $small) {
            flex-direction: row;
        }
        @media screen and (min-width: $medium) {
            // flex-direction: column;
        }
        &-card {
            flex-shrink: 0;
            width: 100%;
            height: 100%;
            text-align: center;
            margin-bottom: 1rem;
            @media screen and (min-width: $small) {
                width: 160px;
            }
            @media screen and (min-width: $medium) {
                width: 30%;
                max-width: 160px;
            }
            .name {
                font-size: 1.3rem;
                font-weight: 500;
                margin-bottom: 1rem;
            }
            .body {
                border: .5px solid rgba(0, 0, 0, .2);
                border-radius: .6rem;
                overflow: hidden;
                cursor: pointer;
                .duration {
                    width: 100%;
                    background-color: $darkPink;
                    color: white;
                    font-weight: 700;
                    font-size: 2rem;
                    padding: 3rem 0;
                    @media screen and (min-width: $medium) {
                        
                        font-size: 1.5rem;
                    }
                }
                .price {
                    padding: 1rem;
                    font-size: 1.2rem;
                    font-weight: 500;
                }
            }
        }
    }
    .quantity {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        .package-card {
            flex-shrink: 0;
            width: 160px;
            height: 100%;
            text-align: center;
            margin-bottom: 1rem;
            .name {
                font-size: 1.3rem;
                font-weight: 500;
                margin-bottom: 1rem;
            }
            .body {
                border: .5px solid rgba(0, 0, 0, .2);
                border-radius: .6rem;
                overflow: hidden;
                .duration {
                    width: 100%;
                    background-color: $darkPink;
                    color: white;
                    font-weight: 700;
                    font-size: 2rem;
                    padding: 3rem 0;
                    @media screen and (min-width: $medium) {
                        
                        font-size: 1.5rem;
                    }
                }
                .price {
                    padding: 1rem;
                    font-size: 1.2rem;
                    font-weight: 500;
                }
            }
        }
        .number-buttons {
            display: flex;
            align-items: center;
            .times {
                padding: 0 1rem;
            }
        }
        .checkout-btn {
            width: 100%;
            text-align: right;
            margin-top: 1rem;
            .large-btn {
                background-color: transparent;
                cursor: pointer;
                font-size: 1rem;
                width: max-content;
                &:hover {
                background-color: rgba(0, 0, 0, .02);
                }
            }
        }
    }
    .payment {
        .heading {
            margin: 0;
            .purchase-info {
                font-size: 1.3rem;
                font-weight: 400;
                .pink {
                    color: $pink;
                }
            }
        }
    }
}
</style>