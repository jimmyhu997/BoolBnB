<template>
  <div class="new-apartment container">
    <PageHeading :title="'Create a new listing'" :button="{ route: 'stays', desktop: 'Cancel', mobile: '-' }"/>
    <form @submit.prevent>



    </form>

      <form @submit.prevent="create()" enctype="multipart/form-data">
        <div>
          <input type="text" v-model="apartment.title" placeholder="Inserisci il titolo">
          <div v-if="errors.title" >
            <p v-for="(error, i)  in errors.title" :key="i">
              {{ error }}
            </p>
          </div>
        </div>

        <div>
          <textarea  v-model="apartment.description" placeholder="Inserisci la descrizione" rows="4" cols="50"></textarea>
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
          <input type="number" v-model="apartment.beds" id="beds">
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

        <div>
          <input type="file" id="image" @change="onChangeImage">
          <img src="" ref="prova" alt="">
          
        </div>

        <div>
          <h5>Opzioni</h5>
          <div v-for="(perk,i) in data.perks" :key="i">
            <label :for="perk.name">{{perk.name}}</label>
            <input type="checkbox" v-model="apartment.perks" :id="perk.name" :value="perk.id" >
           
          </div>
           <!-- <p>
              {{apartment.perks}}
            </p> -->
        </div>

        <button type="submit">Salva Dati</button>
      </form>

  </div>
</template>

<script>
import PageHeading from '../../commons/PageHeading.vue'
import data from '../../../../vue-commons/vueGlobal'
export default {
    name: 'CreateStay',
    components: { PageHeading },
    data() {
      return {
        data,
        storedImage : '',
        perks: [],
        apartment: {
          title: '',
          description: '',
          square_meters: null,
          guests: null,
          rooms: null,
          beds: null,
          bathrooms: null,
          street_address: '',
          zip_code: '',
          city: '',
          province_state: '',
          country: '',
          image_path:{},
          price: null,
          perks:[],
          latitude: null,
          longitude: null,
          visible: true
        },
        errors:{},
      }
    },
    methods: {
      onChangeImage(e){
        this.apartment['image_path'] = e.target.files[0]
        // metodo 2

        
        // console.log(formData)
        // console.log(this.apartment['imagePath'])
      },
      create() {
        // tomtom Api call
        // externalAxios.get( `https://api.tomtom.com/search/2/geocode/${this.apartment.street_address},${this.apartment.zip_code},${this.apartment.city},${this.apartment.province_state},${this.apartment.country}.json?`,{
        //   params: {
        //     key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
        //     limit: 3,
        //   }
        // }).then((response) => {
        //     console.log(response.data.results)
        //   }).catch(error => {
        //     console.log(error);
        //     this.errors = error.response.data.errors;
        //   });

        let dataImage = new FormData();

        for (let element in this.apartment) {
          dataImage.append(String(element), this.apartment[element])
        }
        axios.post("stays", dataImage).then((response) => {
          this.$router.push( {name: 'stays'})
          console.log(response.data)
          })
          .catch(error => {
            // console.log(error);
            this.errors = error.response.data.errors;
          });
      },
     
    },
    // mounted() {
    //   // console.log(this.$refs.image);
    //   this.$refs.image.addEventListener('change', () => {
    //     const [file] = this.$refs.image.files;
    //     if (file) {
    //       // let formData = new FormData();
    //       this.apartment.imagePath =  file;
    //       // formData.append('file', file) 
    //       // console.log(formData);
    //       // this.$refs.prova.src = URL.createObjectURL(file);
    //     } 
    //   })
    // },
}
</script>


<style lang="scss" scoped>
@import '../../../../../sass/_variables.scss';
// .new-apartment {
  // .create {

  // }
// }
</style>