<template>
<!-- Header -->
  <header class="header" ref="header">
    <div class="container">
      <div class="header__wrapper">

          <!-- Logo -->
        <div class="header__left">
          <a class="logo" href="/" title="BoolBnB">
            <div class="icon">
              <svg width="30" height="32" fill="currentcolor" style="display: block;"><path d="M29.24 22.68c-.16-.39-.31-.8-.47-1.15l-.74-1.67-.03-.03c-2.2-4.8-4.55-9.68-7.04-14.48l-.1-.2c-.25-.47-.5-.99-.76-1.47-.32-.57-.63-1.18-1.14-1.76a5.3 5.3 0 00-8.2 0c-.47.58-.82 1.19-1.14 1.76-.25.52-.5 1.03-.76 1.5l-.1.2c-2.45 4.8-4.84 9.68-7.04 14.48l-.06.06c-.22.52-.48 1.06-.73 1.64-.16.35-.32.73-.48 1.15a6.8 6.8 0 007.2 9.23 8.38 8.38 0 003.18-1.1c1.3-.73 2.55-1.79 3.95-3.32 1.4 1.53 2.68 2.59 3.95 3.33A8.38 8.38 0 0022.75 32a6.79 6.79 0 006.75-5.83 5.94 5.94 0 00-.26-3.5zm-14.36 1.66c-1.72-2.2-2.84-4.22-3.22-5.95a5.2 5.2 0 01-.1-1.96c.07-.51.26-.96.52-1.34.6-.87 1.65-1.41 2.8-1.41a3.3 3.3 0 012.8 1.4c.26.4.45.84.51 1.35.1.58.06 1.25-.1 1.96-.38 1.7-1.5 3.74-3.21 5.95zm12.74 1.48a4.76 4.76 0 01-2.9 3.75c-.76.32-1.6.41-2.42.32-.8-.1-1.6-.36-2.42-.84a15.64 15.64 0 01-3.63-3.1c2.1-2.6 3.37-4.97 3.85-7.08.23-1 .26-1.9.16-2.73a5.53 5.53 0 00-.86-2.2 5.36 5.36 0 00-4.49-2.28c-1.85 0-3.5.86-4.5 2.27a5.18 5.18 0 00-.85 2.21c-.13.84-.1 1.77.16 2.73.48 2.11 1.78 4.51 3.85 7.1a14.33 14.33 0 01-3.63 3.12c-.83.48-1.62.73-2.42.83a4.76 4.76 0 01-5.32-4.07c-.1-.8-.03-1.6.29-2.5.1-.32.25-.64.41-1.02.22-.52.48-1.06.73-1.6l.04-.07c2.16-4.77 4.52-9.64 6.97-14.41l.1-.2c.25-.48.5-.99.76-1.47.26-.51.54-1 .9-1.4a3.32 3.32 0 015.09 0c.35.4.64.89.9 1.4.25.48.5 1 .76 1.47l.1.2c2.44 4.77 4.8 9.64 7 14.41l.03.03c.26.52.48 1.1.73 1.6.16.39.32.7.42 1.03.19.9.29 1.7.19 2.5z"></path></svg>
            </div>
            <h1 class="site-name">boolbnb</h1>
          </a>
        </div>

        <div class="header__center">
          <SearchBar/>
        </div>

          <!-- Menu -->
        <div class="header__right">
          <div class="menu">
            <button class="menu__button" @click.stop="openMenu()">
              <div class="menu__icon">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3px; overflow: visible;"><g fill="none" fill-rule="nonzero"><path d="m2 16h28"></path><path d="m2 24h28"></path><path d="m2 8h28"></path></g></svg>
              </div>
              <div class="menu__avatar">

              </div>
            </button>
            <div class="menu__hidden" ref="menu" v-show="data.menuOpened" @click.stop>
              <nav class="menu__list">
                <div class="menu__item" v-if="window.loggedIn">
                  <a class="menu__link" @click.prevent="logout()" title="Log out">Log out</a>
                </div>
                <div class="menu__item" v-if="window.loggedIn">
                  <a class="menu__link" href="/user" title="Dashboard">Dashboard</a>
                </div>
                <div class="menu__item" v-if="!window.loggedIn">
                  <a class="menu__link" @click.prevent="openAuth()" title="Sign up">Sign up</a>
                </div>
                <div class="menu__item" v-if="!window.loggedIn">
                  <a class="menu__link" @click.prevent="openAuth()" title="Log in">Log in</a>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </div>

    </div>
  </header>
</template>

<script>
import SearchBar from '../commons/SearchBar.vue'
import data from '../../global'
export default {
    name: 'Header',
    components: { SearchBar },
    data() {
      return {
        data
      }
    },
    mounted() {
      window.addEventListener( 'scroll', () => {
        if (window.scrollY <= 0) {
          this.$refs.header.classList.remove('scrolled')
        } else this.$refs.header.classList.add('scrolled')
      })
    },
    methods: {
      openMenu() {
        data.menuOpened = true
      },
      logout() {
        axios.post("/logout")
          .then(response => {
            location.href = '/'
          })
          .catch(error => {
            console.log(error);
          });
      },
      openAuth() {
        data.authOpened = true
        data.menuOpened = false
      }
    },
    computed: {
      window() {
        return window
      }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.header {
  height: 80px;
  width: 100%;
  transition: background-color .2s;
  position: sticky;
  top: 0;
  left: 0;
  z-index: 999;
  display: flex;
  align-items: center;
  &.scrolled {
    background: #fff;
    .logo {
      svg {fill: $pink;}
      .site-name {
        color: $pink;
      }
    }
  }
  
  &__wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
  }
  &__left, &__right, &__center {
    flex-shrink: 0;
    @media screen and (min-width: $medium) {
      flex: 1;
    }
  }
  &__left .logo {
    display: flex;
    align-items: center;
    width: max-content;
    text-decoration: none;
    svg {fill: white}
    .site-name {
      display: none;
      @media screen and (min-width: $x-large) {
        color: white;
        display: inline;
        margin-left: .3rem;
        font-size: 1.3rem;
      }
    }
  }
  &__center {
    flex: 1;
    padding: 0 1rem;
  }
  &__right {
    display: flex;
    justify-content: flex-end;
    .menu {
      position: relative;
      &__button {
        background: #fff;
        height: 2.6rem;
        border-radius: 1.3rem;
        border: 1px solid lightgray;
        box-shadow: none;
        display: flex;
        align-items: center;
        padding: 0 .4rem;
        cursor: pointer;
        transition: box-shadow .2s;
        &:hover {
          box-shadow: 0 .2rem .2rem rgba(0, 0, 0, 0.2);
        }
      }
      &__icon {
        margin: 0 .8rem 0 .4rem;
      }
      &__avatar {
        height: 1.8rem;
        width: 1.8rem;
        border-radius: 50%;
        background-color: grey;
      }
      &__hidden {
        position: absolute;
        top: 3.5rem;
        right: 0;
        width: 250px;
        background-color: #fff;
        border-radius: .3rem;
        box-shadow: 0 0 .2rem rgba(0, 0, 0, 0.2);
        padding: .6rem 0;
        .menu__ {
          &link {
            display: block;
            padding: 1rem;
            text-decoration: none;
            color: black;
            cursor: pointer;
            &:hover {
              background-color: rgba(0, 0, 0, 0.05);
            }
          }
        }
      }
    }
  }

}

</style>