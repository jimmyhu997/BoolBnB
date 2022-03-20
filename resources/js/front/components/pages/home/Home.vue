<template>
  <div>
      <Hero :randomApartment="randomApartment"/>
      <!-- Sponsored apartments -->
      <div class="featured container">
        <div class="featured__heading">
          <h2 class="featured__title">Featured listings</h2>
          <div class="nav-buttons">
            <button class="round-btn" :class="{'disabled' : scrollLimit == 'min'}" @click="scrollLeft()">
              <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 4px; overflow: visible;"><g fill="none"><path d="m20 28-11.29289322-11.2928932c-.39052429-.3905243-.39052429-1.0236893 0-1.4142136l11.29289322-11.2928932"></path></g></svg>
            </button>
            <button class="round-btn" :class="{'disabled' : scrollLimit == 'max'}" @click="scrollRight()">
              <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 4px; overflow: visible;"><g fill="none"><path d="m12 4 11.2928932 11.2928932c.3905243.3905243.3905243 1.0236893 0 1.4142136l-11.2928932 11.2928932"></path></g></svg>
            </button>
          </div>
        </div>
        <ul class="featured__list" ref="featuredList">
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
        randomApartment: '',
        scrollLimit: 'min',
        cardListWidth: 0,
        cardScrollWidth: 0
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
    mounted() {
      this.cardListWidth = this.$refs.featuredList.getBoundingClientRect().width
      this.cardScrollWidth = this.$refs.featuredList.scrollWidth
      window.addEventListener('resize', () => {
        this.cardListWidth = this.$refs.featuredList.getBoundingClientRect().width
        this.cardScrollWidth = this.$refs.featuredList.scrollWidth
      })
      this.$refs.featuredList.addEventListener('scroll', () => {
        this.cardScrollWidth = this.$refs.featuredList.scrollWidth
        if (this.$refs.featuredList.scrollLeft + this.cardListWidth >= this.cardScrollWidth) {
          this.scrollLimit = 'max'
        } else if (this.$refs.featuredList.scrollLeft <= 0) {
          this.scrollLimit = 'min'
        } else {
          this.scrollLimit = ''
        }
      })
    },
    methods: {
      showApartment(slug) {
        this.$router.push({name: 'apartment', params: {stay: slug}})
      },
      scrollLeft() {
        this.$refs.featuredList.scrollLeft -= 300
      },
      scrollRight() {
        this.$refs.featuredList.scrollLeft += 300
      },
    },
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/_variables.scss';
@import '../../../../../sass/mixins.scss';
.featured {
  margin-bottom: 3rem;
  &__heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 3rem 0 1.5rem;
    @media screen and (min-width: $medium) {
      margin: 5rem 0 3rem;
    }
    .nav-buttons {
      display: flex;
      align-items: center;
      @include round-btn;
      .round-btn {
        margin-left: .5rem;
      }
    }
  }
  &__title {
    font-size: 1.5rem;
    font-weight: 500;
    @media screen and (min-width: $medium) {
      font-size: 2.6rem;
    }
  }
  &__list {
    list-style: none;
    display: flex;
    flex-wrap: nowrap;
    width: 100%;
    overflow-x: scroll;
    scroll-behavior: smooth;
    scrollbar-width: none;
    &::-webkit-scrollbar {
        display: none;
    }
  }
  &__card {
    cursor: pointer;
    flex-shrink: 0;
    margin-right: 1rem;
    width: 10rem;
    border-radius: 1rem;
    overflow: hidden;
    $colors: rgb(211, 25, 64), rgb(172, 0, 90), rgb(190, 23, 58), rgb(205, 37, 37);
    $apartments: 50;
    $j: 1;
    @for $i from 1 through $apartments {
      @if $j < length($colors)  {
        $j: $j + 1;
      } @else {
        $j: 1
      }
      &:nth-child(#{length($colors)}n+#{$i}) {
        background-color: nth($colors, $j);
      }
    }
    &-preview {
      width: 100%;
      height: 7rem;
      .img {
        object-fit: cover;
        object-position: center;
        width: 100%;
        height: 100%;
      }
    }
    &-content {
      padding: 1rem;
      color: white;
      .title {
        font-weight: 500;
        margin-bottom: 1rem;
      }
      .description {
        margin-bottom: 1rem;
        .location {
          font-size: .9rem;
          font-weight: 300;
        }
      }
    }
    @media screen and (min-width: $medium) {
      width: 18rem;
      margin-right: 2rem;
      &-preview {
        height: 13rem;
      }
      &-content {
        padding: 1.3rem;
        .title {
          font-size: 1.6rem;
        }
        .description {
          font-size: 1.2rem;
          margin-bottom: 4rem;
        }
      }
    }
  }
}
</style>