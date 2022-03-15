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
        axios.get("/api/search/basic",{params: this.$route.query}).then( (response) => {
            this.stays = response.data;
          console.log(response.data);
      });
    }
}
</script>

<style>

</style>