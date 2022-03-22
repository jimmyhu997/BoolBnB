<template>
    <div class="dashboard-content">
      <div class="container">
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
    .dashboard-content {
      background-color: tomato;
      height: 50vw;
      @media screen and (min-width: $medium) {
        height: 400px;
      }
      .page__heading {
        margin-top: 0;
        padding-top: 1rem;
        padding-bottom: 2rem;
        color: white;
      }
    }
</style>
