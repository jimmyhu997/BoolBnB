<template>
    <div class="search-page">

        <form class="filters" @submit.prevent="advancedSearch()">
            <div class="basic-filters">
                <div class="input-group">
                    <label class="input-group-label" for="guests">Guests</label>
                    <div class="number-buttons">
                        <button class="round-btn" :class="{'disabled' : filters.guests == inputs.min || !filters.guests}" @click.prevent="decrement('guests')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28"></path></svg>
                        </button>
                        <div class="choice">{{filters.guests || inputs.default}}</div>
                        <button class="round-btn" :class="{'disabled' : filters.guests == inputs.max}" @click.prevent="increment('guests')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28m-14-14v28"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-group-label" for="guests">Bedrooms</label>
                    <div class="number-buttons">
                        <button class="round-btn" :class="{'disabled' : filters.rooms == inputs.min || !filters.rooms}" @click.prevent="decrement('rooms')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28"></path></svg>
                        </button>
                        <div class="choice">{{filters.rooms || inputs.default}}</div>
                        <button class="round-btn" :class="{'disabled' : filters.rooms == inputs.max}" @click.prevent="increment('rooms')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28m-14-14v28"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-group-label" for="beds">Beds</label>
                    <div class="number-buttons">
                        <button class="round-btn" :class="{'disabled' : filters.beds == inputs.min || !filters.beds}" @click.prevent="decrement('beds')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28"></path></svg>
                        </button>
                        <div class="choice">{{filters.beds || inputs.default}}</div>
                        <button class="round-btn" :class="{'disabled' : filters.beds == inputs.max}" @click.prevent="increment('beds')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28m-14-14v28"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-group-label" for="guests">Baths</label>
                    <div class="number-buttons">
                        <button class="round-btn" :class="{'disabled' : filters.bathrooms == inputs.min || !filters.bathrooms}" @click.prevent="decrement('bathrooms')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28"></path></svg>
                        </button>
                        <div class="choice">{{filters.bathrooms || inputs.default}}</div>
                        <button class="round-btn" :class="{'disabled' : filters.bathrooms == inputs.max}" @click.prevent="increment('bathrooms')">
                            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28m-14-14v28"></path></svg>
                        </button>
                    </div>
                </div>
                <div class="input-group">
                    <label class="input-group-label" for="radius">Research Radius</label>
                    <input type="range" min="10" max="500" step="5" v-model="radius" id="radius">
                    <span class="km">{{radius}} km</span>
                </div>
            </div>
            <div class="perks">
                <ul class="perksul">
                    <li v-for="(perk, index) in indexPerks" :key="index">
                        <label :for="perk.name">{{perk.name}}</label>
                        <input :ref="perk.name" type="checkbox" :id="perk.name" :checked="filters.perks.includes(perk.name)" :value="perk.name" @change="togglePerk(perk.name)">
                    </li>
                </ul>
            </div>
            <button type="submit">Apply Filters</button>
        </form>

        <div class="results-section">
            <div class="apartments">
                <div class="apartments__heading">
                    <span class="total" v-if="stays.length > 0">{{stays.length}} stays in selected area.</span>
                    <span class="total" v-else>No matches in this area.</span>
                </div>
                <ul class="apartments__list">
                    <li class="item" v-for="apartment in stays" :key="apartment.id">
                        <router-link :to="{name: 'apartment', params: {stay: apartment.slug}}" class="apartment">
                            <div class="apartment-preview">
                                <img :src="'/storage/' + apartment.image_path" :alt="apartment.title" class="img">
                            </div>
                            <div class="apartment-overview">
                                <div class="info">
                                    <p class="type">Entire apartment in {{apartment.city}}</p>
                                    <h3 class="title">{{apartment.title}}</h3>
                                    <div class="separator"></div>
                                    <p class="basic-options">{{apartment.guests}} guests • {{apartment.rooms}} bedrooms • {{apartment.beds}} beds • {{apartment.bathrooms}} baths</p>
                                    <p class="perks">{{apartment.perks.map(perk => perk.name).join(' • ')}}</p>
                                </div>
                                <div class="price">
                                    <p class="price"><span class="num">€{{apartment.price}}</span> <span class="night">/ night</span></p>
                                </div>
                            </div>
                        </router-link>
                    </li>
                </ul>
            </div>
            <div class="map" v-if="this.stays.length > 0">
                <Map :lat="parseFloat(this.$route.query.latitude)" :lon="parseFloat(this.$route.query.longitude)" :houses="this.stays" :zoom="12"/>
            </div>
        </div>
    </div>
</template>

<script>
import Map from '../commons/InteractiveMap.vue'
export default {
    name:'AdvancedSearch',
    components: {
        Map,
    },
    data() {
        return {
            indexPerks: [],
            filters:{
                perks: this.$route.query.perks == undefined ? []  : this.$route.query.perks.split(','),
                beds: this.$route.query.beds || 1,
                guests: this.$route.query.guests || 1,
                bathrooms: this.$route.query.bathrooms || 1,
                rooms: this.$route.query.rooms || 1,
            },
            radius: this.$route.query.radius / 1000,
            stays: [],
            inputs: {
                min: 1,
                max: 16,
                default: 1
            },
        }
    },
    methods: {
        advancedSearch(){
            this.$router.push({ name: 'advancedSearch', query: {
                queryKey: this.$route.query.queryKey, 
                latitude:  this.$route.query.latitude,
                longitude: this.$route.query.longitude,
                radius: this.radius * 1000,
                perks:this.filters.perks.length > 0 ? this.filters.perks.join(',')  : undefined,  
                beds: this.filters.beds,
                guests: this.filters.guests,
                bathrooms: this.filters.bathrooms,
                rooms: this.filters.rooms,
              }
            })
        },
        togglePerk(name){
            if (this.$refs[name][0].checked && !this.filters.perks.includes(name)){
                this.filters.perks.push(name)
            } else if (!this.$refs[name][0].checked){
                let index = this.filters.perks.indexOf(name)
                this.filters.perks.splice(index,1)
            }
        },
        increment(input) {
            if (this.filters[input] < this.inputs.max) {
                this.filters[input]++
            }
        },
        decrement(input) {
            if (this.filters[input] > this.inputs.min) {
                this.filters[input]--
            }
        },
    },
    created() {
        axios.get('api/perks').then((response) => {
            this.indexPerks = response.data
        })
        axios.get("/api/search/basic",{params: this.$route.query}).then( (response) => {
            if(Object.keys(this.$route.query).length <= 4) {
                this.stays = response.data;
            }
            else{
                for (let stay in response.data){
                    let isIncluded = true
                    for (const [filterKey, filterValue] of Object.entries(this.filters)) {
                        if (Array.isArray(filterValue)){
                            let stayPerks = response.data[stay][filterKey].map((data) => data = data.name)
                            for (let elem of filterValue){
                                if(!stayPerks.includes(elem)){
                                    isIncluded = false
                                    break
                                }
                            }
                        } else {
                            if (!isNaN(filterValue) && parseInt(filterValue) > response.data[stay][filterKey] ){
                                isIncluded = false
                            } 
                        }
                    }
                    if (isIncluded == true){
                        this.stays.push(response.data[stay])
                    }
                }
            }
        });
    },
}
</script>

<style lang='scss' scoped>
@import '../../../../sass/_variables.scss';
@import '../../../../sass/mixins.scss';
$top: 230px;
.search-page {
    max-width: 1440px;
    margin: 0 auto ;
    position: relative;
    .filters{
        position: sticky;
        z-index: 1;
        top: 80px;
        left: 0;
        height: 150px;
        width: 100%;
        background-color: #fff;
        border-bottom: .5px solid rgba(0, 0, 0, 0.3);
        display: block;
        @include round-btn;
        .basic-filters {
            display: flex;
            padding: 1rem;
            flex-wrap: nowrap;
            overflow-x: scroll;
            .input-group {
                flex-shrink: 0;
                display: flex;
                align-items: center;
                padding-right: 1rem;
                margin-right: 1rem;
                &:not(:last-of-type) {
                    border-right: .5px solid rgba(0, 0, 0, 0.3);
                }
                &-label {
                    font-size: 1.1rem;
                    color: #111;
                }
                .number-buttons {
                    display: flex;
                    align-items: center;
                    margin-left: .5rem;
                    .choice {
                        flex-shrink: 0;
                        text-align: center;
                        font-size: 1rem;
                        font-weight: 300;
                        margin: 0 .7rem;
                        flex-wrap: nowrap;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    }
                }
                .km {
                    display: inline-block;
                    margin-left: 1rem;
                }
                #radius {
                    margin-left: 1rem;
                }
            }
        }
        .box{
            margin: 0 1rem;
        }
        .fillable{
            border: 2px solid black;
            
        }
    }
    .results-section {
        position: relative;
        @media screen and (min-width: $medium) {
            display: flex;
        }
        .apartments {
            display: flex;
            flex-direction: column;
            padding: 1rem 1rem 0;
            @media screen and (min-width: $medium) {
                padding: 1rem 2rem 0;
                width: 50%;
            }
            &__heading {
                padding-bottom: 2rem;
                border-bottom: .5px solid rgba(0, 0, 0, 0.3);
            }
            &__list {
                list-style: none;
                .item {
                    padding: 1rem 0;
                    &:not(:last-of-type) {
                        border-bottom: .5px solid rgba(0, 0, 0, 0.3);
                    }
                }
                .apartment {
                    text-decoration: none;
                    color: black;
                    @media screen and (min-width: $medium) {
                        display: flex;
                    }
                    &-preview {
                        width: 100%;
                        height: 50vw;
                        border-radius: .7rem;
                        overflow: hidden;
                        @media screen and (min-width: $medium) {
                            width: 40%;
                            height: 13vw;
                            max-height: 200px;
                        }
                        .img {
                            object-fit: cover;
                            object-position: center;
                            width: 100%;
                            height: 100%;
                        }
                    }
                    &-overview {
                        margin-top: 1rem;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-between;
                        @media screen and (min-width: $medium) {
                            margin-top: 0;
                            width: 70%;
                            padding-left: 1rem;
                        }
                        .type {
                            font-size: .9rem;
                            color: grey;
                        }
                        .title {
                            font-weight: 400;
                            margin-bottom: .5rem;
                        }
                        .basic-options {
                            color: #333;
                            font-size: .9rem;
                            margin-bottom: .3rem;
                        }
                        .perks {
                            font-size: .9rem;
                            color: grey;
                        }
                        .price {
                            text-align: right;
                            .num {
                                font-size: 1.1rem;
                                font-weight: 500;
                            }
                            .night {
                                font-size: .8rem;
                                font-weight: 400;
                            }
                        }
                    }
                }
            }
        }
        .map {
            display: none;
            @media screen and (min-width: $medium) {
                position: sticky;
                top: $top;
                left: 0;
                width: 50%;
                height: calc(100vh - $top);
                display: block;
            }
        }
    }
}
.perksul{
    li {
        margin: 15px;

    }
    display: flex;
    flex-wrap: nowrap;
    overflow-x: scroll;
}
</style>