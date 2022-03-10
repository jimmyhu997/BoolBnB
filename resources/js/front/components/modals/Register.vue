<template>
  <div>
      <h2>Registrazione</h2>

        <form @submit.prevent="register()">

          <input type="text" v-model="user.name" required placeholder="Nome ...">

          <input type="email" v-model="user.email" required placeholder="Email ...">

          <input type="password" v-model="user.password" required placeholder="Password ...">

          <input type="password" v-model="user.password_confirmation" required  placeholder="Conferma password ...">

          <button type="submit">Registrati</button>

        </form>

  </div>
</template>

<script>
export default {
    name: 'Register',
    data(){
      return{
        user:{
          name: '',
          email: '',
          password: '',
          password_confirmation: ''
        }
      }
    },
    methods: {
      register(){
        axios.post('/register', this.user)
        .then((response) => {
          console.log('forza Roma > Lazio')
        }).catch((error) => {
          console.log('prugne')
        })
      }
    }
}
</script>

<style>

</style>