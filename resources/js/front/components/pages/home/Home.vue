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
        randomApartment: ''
      }
    },
    created() {
      axios.get('/api/stays')
        .then(response => {
          this.apartments = response.data
          const slugs = this.apartments.map(apartment => apartment.slug)
          this.randomApartment = slugs[ Math.floor( Math.random() * slugs.length ) ]
        })
    }
}
</script>

<style>

</style>