<template>
  <div>
      <h2>Login</h2>

        <form  @submit.prevent="login()">

            <input type="email" v-model="user.email" placeholder="Scrivi qui il nome..">

           <input type="email" v-model="user.password" placeholder="Scrivi qui il nome.."> 

        </form>
  </div>
</template>

<script>
export default {
    name: 'Login'
}
</script>

<style>

</style>