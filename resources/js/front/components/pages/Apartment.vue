<template>
  <div>

    <!-- div per mostrare le informazioni dell'appartamento -->
    <div>
      <!-- <h2>Apartment</h2> -->
      <h1>{{this.stay.title}}</h1>
      <img :src="'/storage/' + this.stay.image_path" :alt="this.stay.title + ' preview'">
      
      <h2>informazioni generali:</h2>
      <h3>Metri quadrati: {{this.stay.square_meters}}</h3>
      <h3>Numero ospiti: {{this.stay.guests}}</h3>
      <h3>Numero stanze: {{this.stay.rooms}}</h3>
      <h3>Numero letti: {{this.stay.beds}}</h3>
      <h3>Numero bagni: {{this.stay.bathrooms}}</h3>

      <h2>informazioni stradali</h2>
      <h3>Indirizzo: {{this.stay.street_address}}</h3>
      <h3>Città: {{this.stay.city}}</h3>
      <h3>Provincia: {{this.stay.province_state}}</h3>
      <h3>Paese: {{this.stay.country}}</h3>

      <h3>Prezzo per notte: {{this.stay.price}}</h3>

      <h2>Descrizione:</h2>
      <p>{{this.stay.description}}</p>
    </div>

    <!-- div per il form dei messaggi  -->
    <div v-if="!staysOwner">

      <h2>Invia un messaggio</h2>
      <form @submit.prevent="sendMessage()">
          <div v-if="!window.loggedIn">
            <label for="name">Inserisci il nome </label>
            <input type="text" v-model="message.name" id="name" >
            <div v-if="errors.name" >
              <p v-for="(error, i)  in errors.name" :key="i">
                {{ error }}
              </p>
            </div>
          </div>
          <div v-else>{{userName()}}</div>
          <div v-if="!window.loggedIn">
            <label for="email">Inserisci la mail </label>
            <input type="email" v-model="message.email" id="email" >
            <div v-if="errors.email" >
              <p v-for="(error, i)  in errors.email" :key="i">
                {{ error }}
              </p>
            </div>
          </div>
          <div v-else>{{userEmail()}}</div>

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
  </div>
</template>

<script>
import data from '../../../vue-commons/vueGlobal'
export default {
    name: 'Apartment',
    data() {
      return {
        data,
        window,
        stay:{},
        staysOwner:false,
        message: {
          name: '',
          email:'',
          content:'',
          stay_id:null
        },
        errors: {}
      }
    },
    created() {
      axios.get(`/api/stays/${this.$route.params.stay}`).then( (response) => {
        if (response.data.visible == false ) {
          if (response.data.user_id == this.data.loggedUserId) {
            this.stay = response.data
            this.message.stay_id = this.stay.id
              if(data.loggedUserId == this.stay.user_id) {
                this.staysOwner = true
              }
          }
          else {
            // da rimandare ad una pagina 404 
            this.$router.push({ name: 'home'})
          }
        } 
        else {
          this.stay = response.data
          this.message.stay_id = this.stay.id
          if(data.loggedUserId == this.stay.user_id) {
            this.staysOwner = true
          }
        }
        
      })
    },
    methods: {
      userName() {
        this.message.name = data.loggedUserName
        return data.loggedUserName
      },
      userEmail() {
        this.message.email = data.loggedUserEmail
        return data.loggedUserEmail
      },
      sendMessage() {
        axios.post('/api/send-message',this.message).then( (response) => {
        }).catch(error => {
            this.errors = error.response.data.errors;
          });
      }
    }
}
</script>

<style>

</style>