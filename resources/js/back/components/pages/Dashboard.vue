<template>
    <div class="dashboard-content container">
      <PageHeading :title="'Welcome ' + data.loggedUserName" :button="{ route: 'create-stay', desktop: 'Create a new listing', mobile: '+' }"/>
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

    }
</style>
