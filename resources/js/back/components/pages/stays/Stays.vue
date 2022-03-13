<template>
  <div>
    <router-link :to="{name:'create-stay'}">Crea Annuncio</router-link>


    <h2>Elenco annunci</h2>
    <ul>
      <li v-for="stay in stays" :key="stay.id">
        <h5>{{stay.title}}</h5>
        <p>{{stay.description}}</p>
        <router-link :to="{name:'edit-stay', params:{stay: stay.id}}">Modifica Annuncio</router-link>
        
        <form @submit.prevent="deleteStay(stay.id)">
        
          <button type="submit">Elimina Annuncio</button>
        </form>
      </li>
    </ul>
  </div>
</template>

<script>
import data from '../../../global.js'
export default {
    name: 'Stays',
        data() {
        return {
            data,
            stays: [],
        }
    },

    created() {
      axios.get("/user/stays").then( (response) => {
          console.log(response.data);
          this.stays = response.data[0];
      });
    },

    methods: {
      deleteStay(stay) {
        axios.delete(`/user/stays/${stay}`).then( (response) => {
          console.log(response);
          axios.get("/user/stays").then( (response) => {
            this.stays = response.data[0];
          });
        });
      }
    }
}
</script>

<style>

</style>