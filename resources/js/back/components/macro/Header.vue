<template>
  <header>
      <h1>Ciaooo</h1>
      <button @click="logout()">Logout</button>
      <a href="/">HOME</a>
      <router-link :to="{name:'dashboard'}">Dashboard</router-link>
  </header>
</template>

<script>
export default {
    name: 'Header',
    methods: {
      logout() {
        axios.post("/logout")
          .then((response) => {
            location.href = '/'
          })
          .catch((error) => {
            console.log("sconfitta");
          });
      },
  },
}
</script>

<style>

</style>