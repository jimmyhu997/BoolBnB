<template>
    <div>
        <form action="" @submit.prevent="advancedSearch()">
            <div class="filters">
                <div class="box">
                    <label for="beds">N. Beds</label>
                    <input class="fillable" type="number" v-model="filters.beds" id="beds" >
                </div>
                <div class="box">
                    <label for="guests">N. Guests</label>
                    <input class="fillable" type="number" v-model="filters.guests" id="guests" >
                </div>
                <button type="submit">Apply Fileters</button>
            </div>

        </form>
    </div>
</template>

<script>
export default {
    name:'AdvancedSearch',
    
    data() {
        return {
            filters:{
                perks: [4,2,3,6],
                beds: 0,
                guests: 0,
                bathrooms: 0,
                rooms: 0,
            } ,
            stays:{}
        }
    },
    methods: {
        advancedSearch(){
            this.$router.push({ name: 'advancedSearch', query: {
                queryKey: this.$route.query.queryKey, 
                latitude:  this.$route.query.latatitude,
                longitude: this.$route.query.longitude,
                radius: 20000,
                perks: this.filters.perks.join(','),  
                beds: this.filters.beds,
                guests: this.filters.guests,
                bathrooms: this.filters.bathrooms,
                rooms: this.filters.rooms,
              }
            })
        },
    },
    created() {
        if(Object.keys(this.$route.query).length <= 4) {
            axios.get("/api/search/basic",{params: this.$route.query}).then( (response) => {
                this.stays = response.data;
            });
        }
        else{
             axios.get("/api/search/advanced",{params: this.$route.query}).then( (response) => {
                this.stays = response.data;
            });
        }
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
</style>