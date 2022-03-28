<template>
  <div class="dashboard">
    <div class="hero">
      <img src="/img/dashboard.jpg" alt="Hero image" class="img">
      <div class="container">
        <h2 class="welcome">Welcome {{data.loggedUserName}}</h2>
      </div>
    </div>
    <section class="stats container">
      <PageHeading :title="'Apartments statistics'"/>
      <Charts dataSet="visit"/>
    </section>
  </div>

</template>

<script>
import PageHeading from '../commons/PageHeading.vue'
import data from '../../../vue-commons/vueGlobal.js'
import Charts from '../commons/Chart.vue'
export default {
    name: 'Dashboard',
    components: { PageHeading,Charts },
    data() {
      return {
        data,
      }
    },   
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.dashboard {
  .hero {
    width: 100%;
    height: 30vh;
    position: relative;
    color: white;
    padding-top: 10rem;
    .img {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: -1;
      object-fit: cover;
      object-position: right;
    }
    @media screen and (min-width: $medium) {
      height: 400px;
      padding-top: 3rem;
      .img {
        object-position: center;
      }
    }
    .welcome {
      font-weight: 400;
      text-align: right;
      @media screen and (min-width: $medium) {
        text-align: left;
        font-size: 2.5rem;
        font-weight: 400;
      }
    }
  }
  .stats {
    margin-bottom: 2rem;
  }
}
</style>
