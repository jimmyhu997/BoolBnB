<template>
  <main>

    <router-view :key="$route.path"></router-view>
    
    <AuthModal/>
  </main>
</template>

<script>
import AuthModal from "../modals/AuthModal.vue";

export default {
  name: "Main",
  components: {
    AuthModal
  },
  data() {
    return {
      window
    }
  },
  methods: {

  },
};
</script>

<style lang="scss" scoped>

</style>