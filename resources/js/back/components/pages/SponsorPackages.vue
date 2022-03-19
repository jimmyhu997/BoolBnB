<template>
    <div>
        <h2>Sponsor Area</h2>

        <div class="table" v-if="stays.length > 0">
            <form @submit.prevent="buy()">
                <ul>
                    <li v-for="(stay,i) in stays" :key="i" @click="setData(24,stay.id)">
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
                <h3>
                    Non ci sono Sponsorizzazioni
                </h3>
            </div>
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
                start_date: '',
                end_date: '',
            }
        }
    },
    created() {
        axios.get('/user/sponsor-packages')
        .then((response) => {
            this.stays = response.data[0];
            this.sponsorPackages = response.data[1];
            this.sponsorHistory = response.data[2];
            console.log(response.data[2]);
        })
        .catch((error) => {
            // console.log(error)
        });
    },
    methods: {
        assign(stayId) {
            this.result.stay_id = stayId
            let actualDate = dayJs()
            this.result.start_date = actualDate.format('YYYY-MM-DDTHH:mm:ss')
            this.result.end_date = actualDate.add(24, 'hour').format('YYYY-MM-DDTHH:mm:ss')
            console.log(dayJs( this.result.start_date) < (dayJs(this.result.end_date)))
            // this.result.start_date = .today
            // console.log(dayJs().format('YYYY-MM-DDTHH:mm:ss'))
            // let a = dayJs()
            // console.log(a.add(24,'hour').format('YYYY-MM-DDTHH:mm:ss'))
            // console.log(a.hour());
            // this.end_date = this.start_date.addHours(6)
            },
        setData(nHours,stayId) {
            this.result.stay_id = stayId
            let s_date = ''
            let e_date = ''
            // s_date = dayJs().format('YYYY-MM-DDTHH:mm:ss')
            // e_date = dayJs().add(nHours, 'hour').format('YYYY-MM-DDTHH:mm:ss')
            if ( this.sponsorHistory.length > 0 ) {
                for (let i=0; i < this.sponsorHistory.length; i++) {
                    let lastDate = dayJs()
                    if (this.sponsorHistory[i].stay_id == stayId) { 
                        console.log('forza roma');
                        if (dayJs(this.sponsorHistory[i].end_date) > lastDate) {
                            lastDate = dayJs(this.sponsorHistory[i].end_date)
                        }
                        else {
                            s_date = lastDate.format('YYYY-MM-DDTHH:mm:ss')
                            e_date = lastDate.add(nHours, 'hour').format('YYYY-MM-DDTHH:mm:ss')
                        }
                    }
                    // else {
                    //     s_date = dayJs().format('YYYY-MM-DDTHH:mm:ss')
                    //     e_date = dayJs().add(nHours, 'hour').format('YYYY-MM-DDTHH:mm:ss')
                    // }               
                }
            }
            else {
                s_date = dayJs().format('YYYY-MM-DDTHH:mm:ss')
                e_date = dayJs().add(nHours, 'hour').format('YYYY-MM-DDTHH:mm:ss')            }
            this.result.start_date = s_date
            this.result.end_date = e_date
            

        },
        buy() {
            axios.post('/user/add-sponsor',this.result).then((response) => {
            // console.log(response.data);
            // this.$router.push({name: 'sponsor'})
            })
        .catch((error) => {
            // console.log(error)
        });
        },


    }
}
</script>

<style lang="scss" scoped>

</style>