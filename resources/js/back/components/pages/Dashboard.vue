<template>
    <div class="color">
      <div class="dashboard-content container">
        <PageHeading :title="'Welcome ' + data.loggedUserName"/>

        <div class="jumbo">
        </div>

      </div>


    </div>

</template>

<script>
import PageHeading from '../commons/PageHeading.vue'
import data from '../../../vue-commons/vueGlobal.js'
export default {
    name: 'Dashboard',
    components: { PageHeading },
    data() {
      return {
        data,
        userInfo: {},
      }
    },   
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
  .color {
    width: 100%;
    height: 700px;
    // background-color: purple;
    // background-image: linear-gradient(to right, rgb(70, 0, 128) , rgb(255, 54, 198));

    .dashboard-content {
      padding: 1rem 3rem;
      color: black;

      .jumbo {
        width: 100%;
        height: 30vh;
        border-radius: .3rem;
        background-image: url('../../../../../public/img/fake-images/GeniusHeroBanner.b4e6e233.jpg');
        background-size: cover;
        background-position: right;
        @media screen and (min-width: $medium) {
          height: 400px;
          background-position: center;
        }
      }
    }
  }
</style>
