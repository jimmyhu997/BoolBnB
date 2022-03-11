<template>
  <main>
    <div v-if="!window.loggedIn">
      <Login/>
      <Register/>
    </div>
    <button @click="logout()" v-else>Logout</button>

    <router-view :key="$route.path"></router-view>
  </main>
</template>

<script>
import Login from "../modals/Login.vue";
import Register from "../modals/Register.vue";

export default {
  name: "Main",
  components: {
    Login,
    Register,
  },
  data() {
    return {
      window
    }
  },
  methods: {
    logout() {
      axios
        .post("/logout")
        .then((response) => {
          location.href = '/'
        })
        .catch((error) => {
          console.log("sconfitta");
        });
    },
  },
};
</script>