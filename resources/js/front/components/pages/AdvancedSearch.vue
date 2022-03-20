<template>
    <div>
        <form action="" @submit.prevent="advancedSearch()">
            <div class="filters">
                <div class="box">
                    <label for="beds">N. Beds</label>
                    <input class="fillable" type="number" v-model="filters.beds" id="beds"  >
                </div>
                <div class="box">
                    <label for="guests">N. Guests</label>
                    <input class="fillable" type="number" v-model="filters.guests" id="guests" >
                </div>
                <div class="box">
                    <label for="bathrooms">N. bathrooms</label>
                    <input class="fillable" type="number" v-model="filters.bathrooms" id="bathrooms"  >
                </div>
                <div class="box">
                    <label for="rooms">N. rooms</label>
                    <input class="fillable" type="number" v-model="filters.rooms" id="rooms"  >
                </div>
                <div class="box">
                    <label for="radius">Research Radius (Km)</label>
                    <input class="fillable" type="number" v-model="radius" id="radius"  >
                </div>
                <button type="submit">Apply Fileters</button>
            </div>
                <div class="perksDiv">
                    <ul class="perksul">
                        <li v-for="(perk, index) in indexPerks" :key="index">
                            <label :for="perk.name">{{perk.name}}</label>
                            <input :ref="perk.name" type="checkbox" :id="perk.name" :checked="filters.perks.includes(perk.name)" :value="perk.name" @change="togglePerk(perk.name)">
                        </li>
                    </ul>
                </div>
        </form>
        <div v-if="this.stays.length > 0">
            <ul>
                <li class="stayCard" v-for="(stay, index) in stays" :key="index">
                    <h3>title{{stay.title}}</h3>
                    <div>beds{{stay.beds}}</div>
                    <div>guests{{stay.guests}}</div>
                    <div>bathrooms{{stay.bathrooms}}</div>
                    <div>rooms{{stay.rooms}}</div>
                </li>
            </ul>
        </div>
        <div v-else>
            <h2 class="noMatch">No Match</h2>
        </div>
        <div class="map_box">
            <Map :lat="parseFloat(this.$route.query.latitude)" :lon="parseFloat(this.$route.query.longitude)"/>
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
                beds: this.$route.query.beds,
                guests: this.$route.query.guests,
                bathrooms: this.$route.query.bathrooms,
                rooms: this.$route.query.rooms,
            } ,
            radius: this.$route.query.radius / 1000,
            stays: []
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
            console.log(this.filters.perks)
        }
    },
    created() {
        axios.get('api/perks').then((response) => {
            this.indexPerks = response.data
            console.log(this.indexPerks)
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
    }
}
</script>

<style lang='scss' scoped>
.filters{
    display: flex;
    .box{
        margin: 0 30px;
    }
    .fillable{
        border: 2px solid black;
        
    }
}
.stayCard{
    margin: 20px;
    border: 2px solid black;
}
.noMatch{
    font-weight: 900;
    font-size: 60px;
    text-align: center;
}
.perksul{
    li {
        margin: 15px;

    }
    display: flex;
    justify-content: start;
    flex-wrap: wrap;
.map_box{
    height: 500px;
    width: 500px;
}
</style>