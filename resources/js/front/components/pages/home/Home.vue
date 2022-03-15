<template>
  <div>
      <Hero :randomApartment="randomApartment"/>
  </div>
</template>

<script>
import Hero from './partials/Hero.vue'

export default {
    name: 'Home',
    components: { Hero },
    data() {
      return {
        apartments: [],
        randomApartment: null
      }
    },
    created() {
      axios.get('/api/stays')
        .then(response => {
          this.apartments = response.data
          const ids = this.apartments.map(apartment => apartment.id)
          this.randomApartment = ids[ Math.floor( Math.random() * ids.length ) ]
        })
    }
}
</script>

<style>

</style>