<template>
    <div>
        <h2>Sponsor Area</h2>

        <div class="table" v-if="stays.length > 0">
            <form @submit.prevent="buy()">
                <ul>
                    <li v-for="(stay,i) in stays" :key="i" @click="assign(stay.id)">
                        <h4>{{stay.title}}</h4>
                        <select v-model="result.sponsorPackage_id">
                            <!-- <option disabled value="">Please select one</option> -->
                            <option v-for="(sponsor,index) in sponsorPackages" :key="index" :value="sponsor.id">{{sponsor.name}}</option>
                                            <!-- <span>Selected: {{sponsor.name}}</span> -->

                        </select>

                        <!-- <div v-for="(sponsor,index) in sponsorPackages" :key="index">
                            <a @click="assaign(stay.id,sponsor.id)">{{sponsor.name}}</a>
                        </div> -->
                        <!-- <a @click="assaign()"></a> -->
                    </li>

                </ul>
                <button type="submit">Compra Sponsorizzazione</button>
            </form>
        </div>
        <div v-else>
            <h3>Non hai nessun annuncio</h3>
        </div>

        <!-- <div class="table">

        </div>

        <div class="table">

        </div> -->

    </div>
</template>

<script>
export default {
    name:'SponsorPackages',
    data() {
        return {
            stays: [],
            sponsorPackages: [],
            sponsorHistory: [],
            result: {
                stay_id:1,
                sponsorPackage_id:1,
                start_date: '2022-03-16 16:11:10',
                end_date: '2022-03-16 17:11:10',
            }
        }
    },
    created() {
        axios.get('/user/sponsor-packages')
        .then((response) => {
            this.stays = response.data[0];
            this.sponsorPackages = response.data[1];
            this.sponsorHistory = response.data[2];
        })
        .catch((error) => {
            // console.log(error)
        });
    },
    methods: {
        assign(stayId) {
            this.result.stay_id = stayId
            },
        buy() {
            axios.post('/user/add-sponsor',this.result).then((response) => {
            // console.log(response.data);
            })
        .catch((error) => {
            // console.log(error)
        });
        }
    }
}
</script>

<style lang="scss" scoped>

</style>