<template>
    <div class="color">
      <div class="dashboard-content container">
        <PageHeading :title="'Welcome ' + data.loggedUserName"/>
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
    height: 60vh;
    background-color: purple;
    background-image: linear-gradient(to right, rgb(70, 0, 128) , rgb(255, 54, 198));

    .dashboard-content {
      padding: 1rem 3rem;
      color: white;
    }
  }
</style>
