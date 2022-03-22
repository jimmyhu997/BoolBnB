<template>
    <div class="sponsor container">
    <PageHeading :title="'Boost your listings'"/>
    <nav class="section-links">
        <ul class="section-links__list">
            <li class="section-links__item" :class="{'active' : currentSection == 'Active'}" @click="currentSection = 'Active'">Active</li>
            <li class="section-links__item" :class="{'active' : currentSection == 'New'}" @click="currentSection = 'New'">New</li>
            <li class="section-links__item" :class="{'active' : currentSection == 'History'}" @click="currentSection = 'History'">History</li>
        </ul>
    </nav>
    <div class="active-sponsor section" v-if="currentSection == 'Active'">
        <!-- <h3 class="section-title">Active sponsored listings</h3> -->
        <ul class="sponsored list" v-if="sponsorActive.length > 0">
            <li class="sponsored item" v-for="purchase in sponsorActive" :key="purchase.id">
                <a class="apartment__link" :href="'/apartment/' + purchase.stay_slug" :title="purchase.stay_title">
                    <div class="apartment__preview">
                        <img class="img" :src="'/storage/' + purchase.stay_image_path" :alt="purchase.stay_title + ' preview'">
                    </div>
                    <h3 class="apartment__title">
                        {{purchase.stay_title}}
                    </h3>
                </a>
            </li>
        </ul>
        <div v-if="sponsorActive.length > 0">
            <div v-for="(sponsorH, index) in sponsorActive" :key="index">
                <h3>{{sponsorH.stays_title}}</h3>
                <h4>Tipo di pacchetto: Tier {{sponsorH.sponsor_package_id}}</h4>
                <h5>Data Acquisto: {{sponsorH.created_at.split('T')[0]}}</h5>
                <h5>Data Inizio: {{sponsorH.start_date.split('T')[0]}} </h5>
                <h5>Data Fine: {{sponsorH.end_date.split('T')[0]}} </h5>
            </div>
        </div>
        <p v-else>There are no active boosts.</p>
    </div>
    <div class="new-sponsor section" v-if="currentSection == 'New'">
        <div class="apartments">
            <ul>
                <li v-for="stay in stays" :key="stay.id">
                    <h4 @click="chooseStay(stay)">{{stay.title}}</h4>
                </li>
            </ul>
        </div>

        <form class="purchase-form" @submit.prevent="buy()">
            <h4 v-if="!choosenStay">Select an apartment to sponsor.</h4>
            <div v-else>
                <h4>{{choosenStay}}</h4>
                <div class="packages">
                    <div class="package" v-for="sponsor in sponsorPackages" :key="sponsor.id" @click="choosePackage(sponsor)">{{sponsor.name}}</div>
                </div>
                <div class="buttons" v-if="choosenPackage">
                    {{choosenPackage}}
                    <button @click.prevent="decrement()">-</button>
                    <span class="times">{{buyInfo.times}}</span>
                    <button @click.prevent="increment()">+</button>
                </div>
                <button v-if="choosenPackage">BUY</button>
            </div>
        </form>

    </div>
    <div class="history-sponsor section" v-if="currentSection == 'History'">
        old
    </div>

        <!-- <div class="table" v-if="stays.length > 0">
            <form @submit.prevent="buy()">
                <ul>
                    <li v-for="(stay,i) in stays" :key="i">
                        <h4>{{stay.title}}</h4>
                        <select v-model="result.sponsorPackage_id">
                            <option v-for="(sponsor,index) in sponsorPackages" :key="index" :value="sponsor.id" @click="setData(sponsor.duration,stay.id)">{{sponsor.name}}</option>
                        </select>
                    </li>
                </ul>
                <button type="submit">Compra Sponsorizzazione</button>
            </form>
        </div>
        <div v-else>
            <h3>Non hai nessun annuncio</h3>
        </div>
        <div v-if="sponsorHistory">
            <h2>Storico Acquisti</h2>
            <div v-if="sponsorHistory.length > 0">
                <div v-for="(sponsorH, index) in sponsorHistory" :key="index">
                    <h3>{{sponsorH.stays_title}}</h3>
                    <h4>Tipo di pacchetto: Tier {{sponsorH.sponsor_package_id}}</h4>
                    <h5>Data Acquisto: {{sponsorH.created_at.split('T')[0]}}</h5>
                    <h5>Data Inizio: {{sponsorH.start_date.split('T')[0]}} </h5>
                    <h5>Data Fine: {{sponsorH.end_date.split('T')[0]}} </h5>
                </div>
            </div>
            <div v-else>
                <h3>Non ci sono Sponsorizzazioni</h3>
            </div>
        </div> -->

    </div>
</template>

<script>
import PageHeading from '../commons/PageHeading.vue'
export default {
    name:'SponsorPackages',
    components: {PageHeading},
    data() {
        return {
            currentSection: 'New',
            choosenStay: '',
            choosenPackage: null,
            buyInfo: {
                stay_id: null,
                sponsorPackage_id: null,
                sponsorPackage_duration :null,
                times: 1
            },
            stays: [],
            sponsorPackages: [],
            sponsorHistory: [],
            sponsorActive: [],
            
            // result: {
            //     stay_id: 1,
            //     sponsorPackage_id: 1,
            //     start_date: '',
            //     end_date: '',
            // }
        }
    },
    created() {
        axios.get('/user/sponsor-packages')
        .then((response) => {
            console.log(response.data);
            for (const key in response.data[0]) {
                this.stays.push(response.data[0][key])
            }
            this.sponsorPackages = response.data[1];
            this.sponsorHistory = response.data[2];
            this.sponsorActive = response.data[3];
        })
        .catch((error) => {
            // console.log(error)
        });
    },
    methods: {
        chooseStay(stay) {
            this.buyInfo.stay_id = stay.id
            this.choosenStay = stay.title
        },
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
                axios.get('/user/sponsor-packages').then((response) => {
                    this.stays = []
                    for (const key in response.data[0]) {
                        this.stays.push(response.data[0][key])
                    }
                    this.sponsorPackages = response.data[1];
                    this.sponsorHistory = response.data[2];
                    this.sponsorActive = response.data[3];
                })
                .catch((error) => {
                    // console.log(error)
                });            
            })
            .catch((error) => {
                // console.log(error)
            });
        
        }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.sponsor {
    .section-links {
        &__list {
            display: flex;
            justify-content: center;
            list-style: none;
        }
        &__item {
            margin: 0 2rem;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 500;
            &.active {
                border-bottom: 1px solid black;
            }
        }
    }
    .section {
        margin-top: 2rem;
        .list {
            list-style: none;
        }
        .item {
            padding: 1rem;
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-direction: column;
            overflow: hidden;
            &:not(:last-of-type) {
                border-bottom: .5px solid rgba(0, 0, 0, .2);
            }
            @media screen and (min-width: $small) {
                flex-direction: row;
                align-items: center;
            }
            .apartment {
                &__link {
                    color: black;
                    text-decoration: none;
                    display: flex;
                    flex-direction: column;
                    width: 100%;
                    transition: color .2s;
                    margin-bottom: 1rem;
                    @media screen and (min-width: $small) {
                    width: auto;
                    max-width: 75%;
                    flex-direction: row;
                    align-items: center;
                    margin-bottom: 0;
                    }
                    &:hover {
                    color: $pink;
                    }
                }
                &__preview {
                    flex-shrink: 0;
                    width: 100%;
                    height: 40vw;
                    margin-bottom: 1rem;
                    @media screen and (min-width: $small) {
                    margin-bottom: 0;
                    margin-right: 1rem;
                    width: 5rem;
                    height: 3rem;
                    }
                    .img {
                    object-fit: cover;
                    object-position: center;
                    width: 100%;
                    height: 100%;
                    border-radius: .2rem;
                    }
                }
                &__title {
                    font-weight: 400;
                    width: 100%;
                    display: inline-block;
                    white-space: normal;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
            }

        }
    }
    .active-sponsor {

    }
    .new-sponsor {
        display: flex;
        .apartments {
            flex: 1;
            height: 500px;
            h4 {
                cursor: pointer;
                font-size: 2rem;
                &:hover {
                    text-decoration: underline;
                }
            }
        }
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
    }
}
</style>