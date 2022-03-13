<template>
  <div>
      <h2>Home Back Office</h2>
      <h3>Benvenuto {{userInfo.name}}</h3>
      <button @click="deleteUser()">Cancella Account</button>
      <router-link :to="{name:'create-stay'}">Nuovo annuncio</router-link>
  </div>
</template>

<script>

export default {
    name: 'Dashboard',
    data() {
      return {
        userInfo: {},
      }
    },
    created() {
      axios.get('user/manage').then( (response) => {
        this.userInfo = response.data[0];
        console.log(this.userInfo);
      })
    },
    methods: {
      deleteUser() {
        axios.delete(`/user/manage/${this.userInfo.id}`).then( (response) => {
          location.reload();          
        });
      } 
    }
}
</script>

<style>

</style>