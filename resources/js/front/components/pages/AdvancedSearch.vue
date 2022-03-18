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
                <button type="submit">Apply Fileters</button>
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
    </div>
</template>

<script>
export default {
    name:'AdvancedSearch',
    
    data() {
        return {
            filters:{
                perks: [],
                beds: this.$route.query.beds,
                guests: this.$route.query.guests,
                bathrooms: this.$route.query.bathrooms,
                rooms: this.$route.query.rooms,
            } ,
        }
    },
    methods: {
        advancedSearch(){
            this.$router.push({ name: 'advancedSearch', query: {
                queryKey: this.$route.query.queryKey, 
                latitude:  this.$route.query.latitude,
                longitude: this.$route.query.longitude,
                radius: 20000,
                perks: this.filters.perks,  
                beds: this.filters.beds,
                guests: this.filters.guests,
                bathrooms: this.filters.bathrooms,
                rooms: this.filters.rooms,
              }
            })
        },
    },
    created() {
        axios.get("/api/search/basic",{params: this.$route.query}).then( (response) => {
            if(Object.keys(this.$route.query).length <= 4) {
                this.stays = response.data;
            }
            else{
                axios.get("/api/search/basic",{params: this.$route.query}).then( (response) => {
                    for (let stay in response.data){
                        let isIncluded = true
                        for (const [filterKey, filterValue] of Object.entries(this.filters)) {
                            if (Array.isArray(filterValue)){
                                for (let elem in filterValue){
                                    if(!response.data[stay][filterKey].includes(elem)){
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
                });
                console.log(this.stays)
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
</style>