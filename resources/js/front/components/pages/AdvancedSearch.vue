<template>
    <div>
        
    </div>
</template>

<script>
export default {
    name:'AdvancedSearch',
    
    data() {
        return {
            stays:{},
        }
    },
    created() {
        if(!this.$route.query) {
            axios.get("/api/stays").then( (response) => {
            this.stays = response.data;
            });
        }
        else{
            axios.get("/api/search/basic",{params: this.$route.query}).then( (response) => {
                this.stays = response.data;
            });
        }
    }
}
</script>

<style>

</style>