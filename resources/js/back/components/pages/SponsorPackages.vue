<template>
    <div class="sponsor container">
        <PageHeading :title="'Boost your listings'"/>
        <nav class="section-links">
            <ul class="section-links__list">
                <li class="section-links__item" :class="{'active' : currentSection == 'Active'}" @click="changeSection('Active')">Active</li>
                <li class="section-links__item" :class="{'active' : currentSection == 'New'}" @click="changeSection('New')">New</li>
                <li class="section-links__item" :class="{'active' : currentSection == 'History'}" @click="changeSection('History')">History</li>
            </ul>
        </nav>
        <div class="active-sponsor section" v-if="currentSection == 'Active'">
            <ul class="sponsored__list" v-if="sponsorActive.length > 0">
                <li class="sponsored__item" v-for="purchase in sponsorActive" :key="purchase.id">
                    <div class="apartment__card">
                        <div class="apartment__top">
                            <div class="apartment__preview">
                                <img class="img" :src="'/storage/' + purchase.stay_image_path" :alt="purchase.stay_title + ' preview'">
                            </div>
                            <div class="apartment__info">
                                <h3 class="apartment__title">
                                    {{purchase.stay_title}}
                                </h3>
                                <p class="end-date">Boost ends on <span class="date">{{getDay(purchase.end_date)}}, {{getHour(purchase.end_date)}}</span>.</p>
                            </div>
                        </div>
                        <a class="action-btn" :href="'/apartment/' + purchase.stay_slug" :title="purchase.stay_title">Show</a>
                    </div>
                </li>
            </ul>
            <p v-else>There are no active boosts.</p>
        </div>
        <div class="new-sponsor section" v-if="currentSection == 'New'">
            <div class="apartments">
                <h3 class="heading-title">Choose an apartment to boost</h3>
                <ul class="apartments__list">
                    <li class="apartments__item" v-for="stay in stays" :key="stay.id" @click="chooseStay(stay)">
                        <div class="preview">
                            <img class="img" :src="'/storage/' + stay.image_path" :alt="stay.title + ' preview'">
                        </div>
                        <h4 class="title">{{stay.title}}</h4>
                    </li>
                </ul>
            </div>
            <div class="no-select" v-if="!choosenStay">
                <p class="text">Select your listing.</p>
            </div>
            <Payment v-else :stay="choosenStay" :packages="sponsorPackages" @update='refresh()'/>
        </div>
        <div class="history-sponsor section" v-if="currentSection == 'History'">
            <ul class="purchases__list" v-if="sponsorHistory.length > 0">
                <li class="purchases__item" v-for="purchase in sponsorHistory" :key="purchase.id">
                    <div class="heading">
                        <span class="date">{{getDatetime(purchase.created_at)}}</span>
                        <span class="price">€{{purchase.price}}</span>
                        <span class="tier">{{purchase.tier_name}}</span>
                        <span class="transaction">ID: #{{purchase.transaction}}</span>
                    </div>
                    <div class="body">
                        <h4 class="title">{{purchase.stay_title}}</h4>
                        <div class="info">
                            <span class="status active" v-if="dayJs(purchase.end_date).isAfter(dayJs())">Active until {{getDatetime(purchase.end_date)}}</span>
                            <span class="status" v-else>Ended on {{getDatetime(purchase.end_date)}}</span>
                        </div>
                    </div>
                </li>
            </ul>
            <p v-else>There are no purchases.</p>
        </div>
    </div>
</template>

<script>
import PageHeading from '../commons/PageHeading.vue'
import Payment from '../commons/Payment.vue'
import data from '../../../vue-commons/vueGlobal'
export default {
    name:'SponsorPackages',
    components: {PageHeading,Payment},
    data() {
        return {
            data,
            currentSection: 'Active',
            choosenStay: '',
            choosenPackage: null,
            stays: [],
            sponsorPackages: [],
            sponsorHistory: [],
            sponsorActive: [],
            activeIds: [],
            dayJs,
        }
    },
    created() {
        axios.get('/user/sponsor-info')
        .then((response) => {
            this.stays = response.data.stays
            this.sponsorPackages = response.data.sponsorPackages;
            this.sponsorHistory = response.data.purchaseHistory;
            this.sponsorActive = response.data.sponsorActive;
        })
        .catch((error) => {
            // console.log(error)
        });
        
    },
    methods: {
        changeSection(section) {
            this.currentSection = section
            this.choosenStay = ''
        },
        chooseStay(stay) {
            this.choosenStay = ''
            data.buyInfo.stay_id = stay.id
            this.choosenStay = stay.title
            data.purchaseView = 'tiers'
        },
        getDay(date) {
            return dayJs(date).format('MMMM DD')
        },
        getHour(date) {
            return dayJs(date).format('HH:mm')
        },
        getDate(date) {
            return dayJs(date).format('DD MMMM YYYY')
        },
        getDatetime(date) {
            return dayJs(date).format('DD MMMM YYYY, HH:mm')
        },
        refresh() {
            axios.get('/user/sponsor-info').then((response) => {
                this.stays = response.data.stays
                this.sponsorPackages = response.data.sponsorPackages;
                this.sponsorHistory = response.data.purchaseHistory;
                this.sponsorActive = response.data.sponsorActive;
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
@import '../../../../sass/mixins.scss';
.sponsor {
  margin-bottom: 5rem;
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
            padding-bottom: .5rem;
            &.active {
                border-bottom: 1px solid black;
            }
        }
    }
    .section {
        margin-top: 2rem;
        &.active-sponsor {
            .sponsored {
                &__list {
                    list-style: none;
                    display: flex;
                    flex-wrap: wrap;
                }
                &__item {
                    border: .5px solid rgba(0, 0, 0, .2);
                    border-radius: 1rem;
                    overflow: hidden;
                    width: 100%;
                    margin-bottom: 1rem;
                    @media screen and (min-width: $small) {
                        width: 200px;
                        margin-right: 2rem;
                    }
                    .apartment {
                        &__card {
                            display: flex;
                            flex-direction: column;
                            justify-content: space-between;
                            align-items: flex-end;
                            height: 100%;
                            width: 100%;
                            @include action-btn;
                            .action-btn {
                                width: max-content;
                                margin: 1rem;
                                padding: .5rem;
                                font-size: .9rem;
                            }
                        }
                        &__info {
                            padding: .3rem 1rem;
                            .date {
                                color: $pink;
                            }
                        }
                        &__preview {
                            flex-shrink: 0;
                            width: 100%;
                            height: 40vw;
                            @media screen and (min-width: $small) {
                                height: 7vw;
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
                            margin-bottom: 1rem;
                        }
                    }
        
                }
            }
        }
        &.new-sponsor {
            display: flex;
            flex-direction: column;
            @media screen and (min-width: $medium) {
                flex-direction: row;
            }
            .apartments {
                flex-shrink: 0;
                @media screen and (min-width: $medium) {
                    width: 50%;
                    padding-right: 2rem;
                    border-right: .5px solid rgba(0, 0, 0, .2);
                }
                .heading-title {
                    font-size: 1.3rem;
                    font-weight: 500;
                    margin-bottom: 1rem;
                }
                &__item {
                    display: flex;
                    align-items: center;
                    padding: .5rem;
                    cursor: pointer;
                    &:not(:last-of-type) {
                        border-bottom: .5px solid rgba(0, 0, 0, .2);
                    }
                    &:hover {
                        background-color: #f8f8f8;
                    }
                    .preview {
                        flex-shrink: 0;
                        width: 5rem;
                        height: 3rem;
                        margin-right: 1rem;
                        width: 5rem;
                        height: 3rem;
                        .img {
                            object-fit: cover;
                            object-position: center;
                            width: 100%;
                            height: 100%;
                            border-radius: .2rem;
                        }
                    }
                    .title {
                        font-size: 1.1rem;
                        font-weight: 500;
                    }
                }
            }
            .no-select {
                width: 100%;
                // height: 100%;
                padding: 2rem;
                display: flex;
                align-items: center;
                justify-content: center;
                .text {
                    font-size: 1.2rem;
                    color: grey;
                }
            }
        }
        &.history-sponsor {
            .purchases {
                &__list {
                    list-style: none;
                    border: .5px solid rgba(0, 0, 0, .2);
                    border-radius: .2rem;
                }
                &__item {
                    .heading {
                        margin-top: 1rem;
                        .date {
                            display: inline-block;
                            padding: .5rem 1rem;
                            border-right: .5px solid rgba(0, 0, 0, .2);
                        }
                        .price {
                            display: inline-block;
                            padding: .5rem 1rem;
                            border-right: .5px solid rgba(0, 0, 0, .2);
                        }
                        .tier {
                            display: inline-block;
                            padding: .5rem 1rem;
                            border-right: .5px solid rgba(0, 0, 0, .2);
                        }
                        .transaction {
                            display: inline-block;
                            padding: .5rem 1rem;
                        }
                    }
                    .body {
                        padding: 1rem;
                        border-bottom: .5px solid rgba(0, 0, 0, .2);
                        background-color: #fcfcfc;
                        display: flex;
                        flex-direction: column;
                        @media screen and (min-width: $medium) {
                            flex-direction: row;
                            justify-content: space-between;
                        }
                        .info {
                            .status {
                                color: rgb(193, 53, 21);
                                &.active {
                                    color: rgb(0, 138, 5);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>