<template>
  <div>
    <h2>Apartment</h2>
    <form @submit.prevent="sendMessage()">

        <div>
          <label for="name">Inserisci il nome </label>
          <input type="text" v-model="message.name" id="name" >
          <div v-if="errors.name" >
            <p v-for="(error, i)  in errors.name" :key="i">
              {{ error }}
            </p>
          </div>
        </div> 

        <div>
          <label for="email">Inserisci la mail </label>
          <input type="email" v-model="message.email" id="email" >
          <div v-if="errors.email" >
            <p v-for="(error, i)  in errors.email" :key="i">
              {{ error }}
            </p>
          </div>
        </div> 

         <div>
          <textarea type="content" v-model="message.content" placeholder="Inserisci qui il messaggio" rows="4" cols="50"></textarea>
          <div v-if="errors.content" >
            <p v-for="(error, i)  in errors.content" :key="i">
              {{ error }}
            </p>
          </div>
        </div> 

        <button type="submit">Invia Messaggio</button>

    </form>
  </div>
</template>

<script>
export default {
    name: 'Apartment',
    data() {
      return {
        stay: [],
        message: {
          name: 'pippo',
          email:'pippo@gmail.com',
          content:'forza roma',
          stay_id:this.$route.params.stay
        },
        errors: {}
      }
    },
    created() {
      axios.get(`/api/stays/${this.$route.params.stay}`).then( (response) => {
        
        this.stay = response.data
        console.log(response.data)
      })
    },
    methods: {
      sendMessage() {
        axios.post('/api/send-message',this.message).then( (response) => {
          console.log(response.data)
        }).catch(error => {
            this.errors = error.response.data.errors;
          });
      }
    }
}
</script>

<style>

</style>