<template>
  <div @click="closeAll()">
    <Header/>
    <Main/>
    <Footer/>
  </div>
</template>

<script>
import Header from './components/macro/Header.vue';
import Main from './components/macro/Main.vue';
import Footer from './components/macro/Footer.vue';
import data from './global'

export default {
    name: "App",
    components: {
        Header,
        Main,
        Footer
    },
    data() {
      return {
        data
      }
    },
    methods: {
      closeAll() {
        data.menuOpened = false
        data.authOpened = false
        data.hintsOpened = false
      }
    }
}
</script>