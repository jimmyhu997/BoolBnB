<template>
    <div>
        <h2>Sponsor Area</h2>

        <div class="table" v-if="stays.length > 0">
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
        <div>
            <h2>Storico Sponsorizzazioni</h2>
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
        </div>

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
                stay_id: 1,
                sponsorPackage_id: 1,
                start_date: '',
                end_date: '',
            }
        }
    },
    created() {
        axios.get('/user/sponsor-packages')
        .then((response) => {
            console.log(response.data);
            for (const key in response.data[0]) {
                this.stays.push(response.data[0][key])
            }
            // this.stays = response.data[0];
            this.sponsorPackages = response.data[1];
            this.sponsorHistory = response.data[2];
        })
        .catch((error) => {
            // console.log(error)
        });
    },
    methods: {
        setData(n_Hours,stayId) {
            this.result.stay_id = stayId
            axios.get('/user/sponsor-packages-stay/' + stayId).then((response) => {
                let sponsoredList = response.data
                let result_start = ''
                let result_end = ''
                if (sponsoredList.length > 0 ) {    
                    let lastDate = dayJs(sponsoredList[0].end_date)
                    for(let i=0; i < sponsoredList.length; i++) {
                        if (dayJs(sponsoredList[i].end_date) > lastDate) {
                            lastDate = dayJs(sponsoredList[i].end_date)
                        }
                        result_start = lastDate.format('YYYY-MM-DDTHH:mm')
                        result_end = lastDate.add(n_Hours, 'hour').format('YYYY-MM-DDTHH:mm')  
                    }
                }
                else {
                    result_start = dayJs().format('YYYY-MM-DDTHH:mm')
                    result_end = dayJs().add(n_Hours, 'hour').format('YYYY-MM-DDTHH:mm')  
                }            
                this.result.start_date = result_start
                this.result.end_date = result_end
            })

        },
        buy() {
            axios.post('/user/add-sponsor',this.result).then((response) => {
                axios.get('/user/sponsor-packages').then((response) => {
                    this.stays = response.data[0];
                    this.sponsorPackages = response.data[1];
                    this.sponsorHistory = response.data[2];
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

</style>