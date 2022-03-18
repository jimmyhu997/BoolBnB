<template>
  <div @click="closeAll()">
    <Header/>
    <Main/>
    <Footer/>
  </div>
</template>

<script>
import Header from '../vue-commons/macro/Header.vue';
import Main from './components/macro/Main.vue';
import Footer from '../vue-commons/macro/Footer.vue';
import data from '../vue-commons/vueGlobal'


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
        data.addressHintsOpened = false
        data.deleteOpened = false
      }
    }
}
</script>