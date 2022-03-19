<template>
  <div>
      <Hero :randomApartment="randomApartment"/>
      <!-- Sponsored apartments -->
      <div class="featured container">
        <h2 class="featured__title">Featured listings</h2>
        <ul class="featured__list">
          <li class="featured__card" v-for="apartment in apartments" :key="apartment.id" @click="showApartment(apartment.slug)">
            <div class="featured__card-preview">
              <img :src="'storage/' + apartment.image_path" :alt="apartment.title" class="img">
            </div>
            <div class="featured__card-content">
              <h4 class="title">
                {{apartment.title}}
              </h4>
              <div class="description">
                <span class="location">{{apartment.city}}, {{apartment.country}}</span>
              </div>
            </div>
          </li>
        </ul>
      </div>
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
    },
    methods: {
      showApartment(slug) {
        this.$router.push({name: 'apartment', params: {stay: slug}})
      }
    }
}
</script>

<style lang="scss" scoped>
.featured {
  margin-bottom: 3rem;
  &__title {
    font-size: 2.6rem;
    font-weight: 500;
    margin: 5rem 0 3rem;
  }
  &__list {
    list-style: none;
    display: flex;
    flex-wrap: nowrap;
    width: 100%;
    overflow-x: scroll;
  }
  &__card {
    cursor: pointer;
    flex-shrink: 0;
    margin-right: 2rem;
    width: 18rem;
    border-radius: 1rem;
    overflow: hidden;
    $colors: rgb(211, 25, 64), rgb(172, 0, 90), rgb(190, 23, 58), rgb(205, 37, 37);
    $apartments: 50;
    $j: 1;
    @for $i from 1 through $apartments {
      @if $i < length($colors) + 1 {
        $j: $i;
      } @else {
        $j: 1
      }
      &:nth-child(#{length($colors)}n+#{$i}) {
        background-color: nth($colors, $j);
      }
    }
    &-preview {
      width: 100%;
      height: 13rem;
      .img {
        object-fit: cover;
        object-position: center;
        width: 100%;
        height: 100%;
      }
    }
    &-content {
      padding: 1.3rem;
      color: white;
      .title {
        font-size: 1.6rem;
        font-weight: 500;
        margin-bottom: 1rem;
      }
      .description {
        margin-bottom: 4rem;
        .location {
          font-size: 1.2rem;
          font-weight: 300;
        }
      }
    }
  }
}
</style>