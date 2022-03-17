<template>
  <div class="search__wrapper" @click.stop title="Start search">
      <input class="search__input" type="text" v-model="searchKeyword" placeholder="Start your search" @input="searchHints()" @click="searchHints()">
      <!-- <input class="search__input" type="text" v-model="searchKeyword" placeholder="Start your search"> -->
      <div class="search__icon" @click="search(`${searchKeyword}`)">
        <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: white; stroke-width: 5.333333333333333px; overflow: visible;"><g fill="none"><path d="m13 24c6.0751322 0 11-4.9248678 11-11 0-6.07513225-4.9248678-11-11-11-6.07513225 0-11 4.92486775-11 11 0 6.0751322 4.92486775 11 11 11zm8-3 9 9"></path></g></svg>
      </div>
      <div class="hints" ref="hints">
        <ul class="hints__list" v-if="searchResults.length > 0">
          <li class="hints__item" v-for="(hint, index) in searchResults.slice(0,5)" :key="index">
            <a class="hints__link" :title="hint.address.postalCode" @click="search(`${searchKeyword} ${hint.address.countryCode} ${hint.address.countrySubdivision} ${hint.address.postalCode}`)">
              <div class="place-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/></svg>
              </div>
              <span v-if="hint.type == 'Street' "> {{searchKeyword}} , {{ hint.address.municipality }}, {{ hint.address.countryCode }}</span>
              <span v-else>{{searchKeyword}}, {{ hint.address.countryCode }}</span>
            </a>
          </li>
        </ul>
        <div v-else class="hints__list">
            <span class="hints__no-results">No results.</span>
        </div>
      </div>
  </div>
</template>

<script>
import data from '../../../vue-commons/vueGlobal'

export default {
    name: 'SearchBar',
    data() {
      return {
        timeout: null,
        data,
        searchKeyword: '',
        stays: [],
        searchResults: []
      }
    },
    methods: {
      search(keyword) {
        if (keyword == null){
          keyword = this.keyword
        }
        if (keyword.length < 1){
          this.$router.push({ name: 'advancedSearch'})
        } 
        else {
          externalAxios.get(`https://api.tomtom.com/search/2/geocode/${keyword}.json?`,{
            params: {
              key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
              limit: 1,
            }
          })
          .then((response) => {
            this.$router.push({ name: 'advancedSearch', query: { 
              queryKey: keyword,
              latitude:  response.data.results[0].position.lat,
              longitude: response.data.results[0].position.lon,
              radius: 20000,
              }
            })
            this.searchKeyword = ''
            data.hintsOpened = false
          })
          .catch(error => {
            console.log(error);
            this.errors = error.response.data.errors;
          });
        }
      },
      searchHints() {
        if (this.searchKeyword){
          clearTimeout(this.timeout);
          this.timeout = setTimeout(() => {
            // operatore ternario per costruzione api call per definire il type della risposta ${this.searchKeyword.toLowerCase().includes('street ' || 'via ') ? '&type' : 'type'}
            externalAxios.get(`https://api.tomtom.com/search/2/geocode/${this.searchKeyword}.json?`,{
              params: {
                key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
                radius: 200000,
              }
            })
            .then((response) => {
              console.log(response.data.results)
              data.hintsOpened = true
              this.searchResults = response.data.results
            })
            .catch(error => {
              console.log(error);
              this.errors = error.response.data.errors;
            });
          },500);
        } else {
          data.hintsOpened = false
          this.searchResults = []
        }
      }
    },
    watch: {
      '$data.data.hintsOpened'(hints) {
        if (hints) {
          this.$refs.hints.classList.add('active')
        } else {
          this.$refs.hints.classList.remove('active')
        }
      }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.search {
  &__wrapper {
    width: 100%;
    max-width: 300px;
    height: 2.4rem;
    background-color: #fff;
    border-radius: 1.5rem;
    border: 1px solid lightgray;
    box-shadow: 0 .5rem .7rem rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: box-shadow .2s;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 0 auto;
    &:hover {
      box-shadow: 0 .5rem .7rem rgba(0, 0, 0, .2);
    }
    @media screen and (min-width: $medium) {
      height: 3rem;
      min-width: 300px;
    }
    .hints {
      display: none;
      position: absolute;
      top: 3.5rem;
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      max-width: 350px;
      height: max-content;
      background-color: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 0 .7rem rgba(0, 0, 0, .2);
      &.active {
        display: block;
      }
      &__list {
        list-style: none;
        padding: 1rem 0;
      }
      &__link {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        .place-icon {
          flex-shrink: 0;
          width: 2.7rem;
          height: 2.7rem;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: .5rem;
          background-color: rgba(0, 0, 0, .07);
          border: 1px solid $lightGrey;
          margin-right: 1rem;
          svg {
            width: 1.2rem;
          }
        }
        &:hover {
          background-color: rgba(0, 0, 0, 0.05);
        }
      }
      &__no-results {
        padding: 1rem 1.5rem;
        display: block;
      }
    }
  }
  &__icon {
    width: 1.8rem;
    height: 1.8rem;
    background-color: $pink;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: .3rem;
    flex-shrink: 0;
    display: none;
    @media screen and (min-width: 375px) {
      display: flex;
    }
    @media screen and (min-width: $medium) {
      width: 2.2rem;
      height: 2.2rem;
      margin-right: .4rem;
    }
  }
  &__input {
    font-size: 1rem;
    font-weight: 400;
    border: none;
    margin-left: 1rem;
    margin-right: .5rem;
    cursor: pointer;
    width: 100%;
    outline: none;
    &::placeholder {
      color: black;
    }
  }
}
</style>