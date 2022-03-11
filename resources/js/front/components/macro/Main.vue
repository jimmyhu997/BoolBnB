<template>
    <main>

      <Login/>
      <Register/>

      <router-view :key="$route.path"></router-view>

    </main>
</template>

<script>

import Login from '../modals/Login.vue';
import Register from '../modals/Register.vue';

export default {
    name: "Main",
    components: {
        Login,
        Register
    },
}
</script>