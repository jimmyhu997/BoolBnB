<template>
    <form class="purchase-form" @submit.prevent="buy()">
        <div class="no-select" v-if="!stay">
            <p class="text">Select your listing.</p>
        </div>
        <div v-else>
            <h4 class="title">{{stay}}</h4>
            <div class="packages">
                <div class="packages-card" v-for="sponsor in packages" :key="sponsor.id">
                    <div class="name">{{sponsor.name}}</div>
                    <div class="body" @click="choosePackage(sponsor)">
                        <div class="duration">{{sponsor.duration / 24 == 1 ? sponsor.duration / 24 + ' day' : sponsor.duration / 24 + ' days'}}</div>
                        <div class="price">{{sponsor.price}}€</div>
                    </div>
                </div>
            </div>
            <div class="buttons" v-if="choosenPackage">
                {{choosenPackage}}
                <button @click.prevent="decrement()">-</button>
                <span class="times">{{buyInfo.times}}</span>
                <button @click.prevent="increment()">+</button>
            </div>
            <div v-if="choosenPackage" ref="payment"></div>
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
            dropinForm: false,
            CLIENT_AUTHORIZATION: '',
            dropinInstance: {}
        }
    },
    mounted() {
        // Step two: create a dropin instance using that container (or a string
        //   that functions as a query selector such as `#dropin-container`)
        // console.log(braintree);
        
    },
    methods: {
        choosePackage(sponsor) {
            this.dropinForm = true
            this.buyInfo.sponsorPackage_id = sponsor.id
            this.buyInfo.sponsorPackage_duration = sponsor.duration
            this.buyInfo.sponsorPackage_price = parseFloat(sponsor.price)
            this.choosenPackage = sponsor.name

        },
        increment() {
            if (this.buyInfo.times < 10) this.buyInfo.times++
        },
        decrement() {
            if (this.buyInfo.times > 1) this.buyInfo.times--
        },
        buy() {
            this.dropinInstance.requestPaymentMethod().then(payload => {
                axios.post('/user/add-sponsor', {
                    
                        payment: {
                            nonce: payload.nonce                           
                        },
                        data: this.buyInfo
  
                }).then((response) => {
                    this.$emit('update')
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
        '$data.dropinForm'(open) {
            if (open) {
                axios.get('/user/get-token')
                    .then(response => {
                        // console.log(response.data);
                        // this.CLIENT_AUTHORIZATION = response.data
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
    .no-select {
        width: 100%;
        height: 100%;
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        .text {
            font-size: 1.2rem;
            color: grey;
        }
    }
    .title {
        text-align: center;
        font-size: 1.4rem;
        font-weight: 500;
        margin-bottom: 2rem;
    }
    .packages {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-around;
        overflow: scroll;
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
                width: 80px;
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
                    // @media screen and (min-width: $large) {
                    //     height: 110px;
                    //     line-height: 110px;
                    //     font-size: 1.5rem;
                    // }
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
}
</style>