<template>
  <div>
      <h2>Modifica annuncio</h2>
      
      <form @submit.prevent="update()">
        <div>
          <input type="text" v-model="apartment.title" placeholder="Inserisci il titolo">
          <div v-if="errors.title" >
            <p v-for="(error, i)  in errors.title" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <textarea v-model="apartment.description" placeholder="Inserisci la descrizione" rows="4" cols="50"></textarea>
          <div v-if="errors.description" >
            <p v-for="(error, i)  in errors.description" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="square_meters">Inserisci numero metri quadrati</label>
          <input type="number" v-model="apartment.square_meters" id="square_meters" >
          <div v-if="errors.square_meters" >
            <p v-for="(error, i)  in errors.square_meters" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="guests">Inserisci numero Ospiti</label>
          <input type="number" v-model="apartment.guests" id="guests" >
          <div v-if="errors.guests" >
            <p v-for="(error, i)  in errors.guests" :key="i">
              {{ error }}
            </p>
          </div>
        </div>
        
        <div>
          <label for="rooms">Inserisci numero stanze</label>
          <input type="number" v-model="apartment.rooms" id="rooms" >
          <div v-if="errors.rooms" >
            <p v-for="(error, i)  in errors.rooms" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="beds">Inserisci numero dei letti</label>
          <input type="number" v-model="apartment.beds" id="beds" >
          <div v-if="errors.beds" >
            <p v-for="(error, i)  in errors.beds" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="bathrooms">Inserisci numero dei bagni</label>
          <input type="number" v-model="apartment.bathrooms" id="bathrooms" >
          <div v-if="errors.bathrooms" >
            <p v-for="(error, i)  in errors.bathrooms" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="street_address">Inserisci indirizzo</label>
          <input type="text" v-model="apartment.street_address" id="street_address" >
          <div v-if="errors.street_address" >
            <p v-for="(error, i)  in errors.street_address" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="zip_code">Inserisci codice postale</label>
          <input type="text" v-model="apartment.zip_code" id="zip_code" >
          <div v-if="errors.zip_code" >
            <p v-for="(error, i)  in errors.zip_code" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="city">Inserisci Città</label>
          <input type="text" v-model="apartment.city" id="city" >
          <div v-if="errors.city" >
            <p v-for="(error, i)  in errors.city" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="province_state">Inserisci Provincia</label>
          <input type="text" v-model="apartment.province_state" id="province_state" >
          <div v-if="errors.province_state" >
            <p v-for="(error, i)  in errors.province_state" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <label for="country">Inserisci Paese</label>
          <input type="text" v-model="apartment.country" id="country" >
          <div v-if="errors.country" >
            <p v-for="(error, i)  in errors.country" :key="i">
              {{ error }}
            </p>
          </div>
        </div>
        
        <div>
          <label for="price">Inserisci prezzo per notte</label>
          <input type="number" step="0.01" v-model="apartment.price" id="price" >
          <div v-if="errors.price" >
            <p v-for="(error, i)  in errors.price" :key="i">
              {{ error }}
            </p>
          </div>
        </div> 

        <button type="submit">Salva Dati</button>
      </form>
  </div>
</template>

<script>

export default {
  name:'EditStay',
  data() {
    return {
      apartment:{},
      errors:{},
    }
  },
  created() {
    axios.get(`/user/stays/${this.$route.params.stay}/edit`).then( (response) => {
      this.apartment = response.data;
      console.log(this.apartment);
    
    }).catch((error) => {
            console.log(error.response.status);
            if(error.response.status == 404) {
               this.$router.push( {name: '404'})
            }
            else {
              this.errors = error.response.data.errors;
            }

          });
  }, 

  methods: {
    update() {
       axios.put(`/user/stays/${this.$route.params.stay}`, this.apartment).then((response) => {
            console.log(response.data)
            this.$router.push( {name: 'stays'})
            console.log('ciao');
          })
          .catch((error) => {
            console.log(error);
            this.errors = error.response.data.errors;

          });
    }
  }
 
}
</script>

<style>

</style>