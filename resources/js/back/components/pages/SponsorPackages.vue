<template>
    <div>
        <h2>Sponsor Area</h2>

        <div class="table">
            
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
            apartments: [],
            sponsorPackages: [],
            sponsorHistory: []
        }
    },
    created() {
        axios.get('/user/sponsor')
        .then((response) => {
            this.apartments = response.data[0];
            this.sponsorPackages = response.data[1];
            this.sponsorHistory = response.data[2];
        })
        .catch((error) => {
            console.log(error)
        });
    }
}
</script>

<style lang="scss" scoped>

</style>