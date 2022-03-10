<template>
  <div>
      <h2>Login</h2>

        <form  @submit.prevent="login()">

            <input type="email" v-model="user.email" placeholder="Scrivi qui il nome..">

           <input type="password" v-model="user.password" placeholder="Scrivi qui la password.."> 

        </form>
  </div>
</template>

<script>
export default {
    name: 'Login',
    data() {
      return {
        user: {
          email: '',
          password: ''
        }
      }
    },
    methods: {
      login(){
        axios.post('/login', this.user)
        .then((response) => {
          console.log('forza Roma > Lazio')
        }).catch((error) => {
          console.log('git fetch --prugne')
        })
      }
    }
}
</script>

<style>

</style>