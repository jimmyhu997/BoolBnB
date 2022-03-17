<template>
  <div class="new-apartment container">
    <PageHeading :title="'Create a new listing'" :button="{ route: 'stays', desktop: 'Cancel', mobile: '-' }"/>
    <form @submit.prevent="create()" class="new-apartment__form">

      <section class="input__category" v-for="(inputCategory, index) in formInputs" :key="index">
        <!-- Category title -->
        <h3 class="input__category-title">
          {{inputCategory.category}}
        </h3>
        <div class="input__group-list">
          <div class="input__group" v-for="input in inputCategory.inputs" :key="input.name">
            <!-- Text input -->
            <div :class="input.type" v-if="input.type == 'text'">
              <label :for="input.name" class="input__group-label">{{input.label}}</label>
              <input :type="input.type" :id="input.name" class="input__group-input" v-model="apartment[input.name]" :placeholder="input.placeholder">
            </div>
            <!-- Textarea input -->
            <div :class="input.type" v-else-if="input.type == 'textarea'">
              <label :for="input.name" class="input__group-label">{{input.label}}</label>
              <textarea class="input__group-input" :id="input.name" v-model="apartment[input.name]" :placeholder="input.placeholder" rows="2"></textarea>
            </div>
            <!-- Image input -->
            <div :class="input.type" v-if="input.type == 'file'">
              <input :type="input.type" :id="input.name" ref="fileSelector" @change="onChangeImage">
              <div class="image-preview" @click="fileSelector()">
                <span class="plus">+</span>
                <img class="img" ref="imagePreview">
              </div>
            </div>
            <!-- Number input -->
            <div :class="input.type" v-else-if="input.type == 'number'">
              <label class="input__group-label">{{input.label}}</label>
              <div class="number-buttons">
                <button class="round-btn disabled" :ref="input.name + 'Decrement'" @click.prevent="decrement(input.name)">-</button>
                <div class="choice">{{apartment[input.name]}} {{input.name == 'price' ? '€' : ''}}</div>
                <button class="round-btn" :ref="input.name + 'Increment'" @click.prevent="increment(input.name)">+</button>
              </div>
            </div>
          </div>
        </div>
        <div class="separator"></div>
      </section>
      <!-- Checkboxes -->
      <section class="input__category">
        <!-- Category title -->
        <h3 class="input__category-title">
          Amenities
        </h3>
        <div class="input__group" v-for="perk in data.perks" :key="perk.id">
          <div class="checkbox">
            <label :for="perk.name" class="input__group-label">{{perk.name}}</label>
            <input type="checkbox" v-model="apartment.perks" :id="perk.name" :value="perk.id">
          </div>
        </div>
      </section>
      <!-- Submit -->
      <div class="submit">
        <button class="submit-btn" type="submit">Save listing</button>
      </div>
    </form>

      <!-- <form @submit.prevent="create()" enctype="multipart/form-data" style="margin-top: 5rem">
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
        </div>

        <div>
          <h5>Visibile</h5>
          <label for="visibile">seleziona la visibilità</label>
          <input type="checkbox" v-model="apartment.visibile" id="visibile" >
        </div>

        <button type="submit">Salva Dati</button>
      </form> -->

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
          square_meters: 10,
          guests: 1,
          rooms: 1,
          beds: 1,
          bathrooms: 1,
          street_address: '',
          zip_code: '',
          city: '',
          province_state: '',
          country: '',
          image_path:{},
          price: 10,
          perks:[],
          latitude: null,
          longitude: null,
          visible: true,
        },
        errors:{},
        formInputs: [
          {
            category: 'Photo',
            inputs: [
              {
                name: 'image',
                type: 'file'
              },
            ]
          },
          {
            category: 'Listing basics',
            inputs: [
              {
                name: 'title',
                label: 'Listing title:',
                placeholder: 'Insert a title',
                type: 'text'
              },
              {
                name: 'description',
                label: 'Listing description:',
                placeholder: 'Insert a description',
                type: 'textarea'
              },
              {
                name: 'guests',
                label: 'Number of guests',
                type: 'number'
              },
              {
                name: 'visible',
                label: 'Listing status',
                type: 'boolean'
              },
            ]
          },
          {
            category: 'Rooms and spaces',
            inputs: [
              {
                name: 'beds',
                label: 'Beds',
                type: 'number'
              },
              {
                name: 'rooms',
                label: 'Bedrooms',
                type: 'number'
              },
              {
                name: 'bathrooms',
                label: 'Bathrooms',
                type: 'number'
              },
              {
                name: 'square_meters',
                label: 'Square meters',
                type: 'number'
              },
            ]
          },
          {
            category: 'Location',
            inputs: [
              {
                name: 'street_address',
                label: 'Street address',
                placeholder: 'Insert a street address',
                type: 'text'
              },
              {
                name: 'city',
                label: 'City',
                placeholder: 'Insert a city',
                type: 'text'
              },
              {
                name: 'province_state',
                label: 'Province/State',
                placeholder: 'Insert a province or a state',
                type: 'text'
              },
              {
                name: 'zip_code',
                label: 'Postal code',
                placeholder: 'Insert a postal code',
                type: 'text'
              },
              {
                name: 'country',
                label: 'Country',
                placeholder: 'Insert a country',
                type: 'text'
              },
            ]
          },
          {
            category: 'Pricing',
            inputs: [
              {
                name: 'price',
                label: 'Nightly price',
                type: 'number'
              }
            ]
          }
        ]
      }
    },
    methods: {
      fileSelector() {
        this.$refs.fileSelector[0].click()
      },
      onChangeImage(e){
        const image = e.target.files[0]
        this.$refs.imagePreview[0].src = URL.createObjectURL(image)
        this.apartment['image_path'] = image
      },
      increment(input) {
        if (input == 'square_meters') {
          if (this.apartment[input] < 990) {
            this.$refs[input + 'Decrement'][0].classList.remove('disabled')
            this.apartment[input]+= 10
          }
          if (this.apartment[input] == 990) {
            this.$refs[input + 'Increment'][0].classList.add('disabled')
          }
        } else if (input == 'price') {
          if (this.apartment[input] < 990) {
            this.$refs[input + 'Decrement'][0].classList.remove('disabled')
            this.apartment[input]+= 10
          }
          if (this.apartment[input] == 990) {
            this.$refs[input + 'Increment'][0].classList.add('disabled')
          }
        } else {
          if (this.apartment[input] < 16) {
            this.$refs[input + 'Decrement'][0].classList.remove('disabled')
            this.apartment[input]++
          }
          if (this.apartment[input] == 16) {
            this.$refs[input + 'Increment'][0].classList.add('disabled')
          }
        }
      },
      decrement(input) {
        if (input == 'square_meters') {
          if (this.apartment[input] > 10) {
            this.$refs[input + 'Increment'][0].classList.remove('disabled')
            this.apartment[input]-= 10
          }
          if (this.apartment[input] == 10) {
            this.$refs[input + 'Decrement'][0].classList.add('disabled')
          }
        } else if (input == 'price') {
          if (this.apartment[input] > 10) {
            this.$refs[input + 'Increment'][0].classList.remove('disabled')
            this.apartment[input]-= 10
          }
          if (this.apartment[input] == 10) {
            this.$refs[input + 'Decrement'][0].classList.add('disabled')
          }
        } else {
          if (this.apartment[input] > 1) {
            this.$refs[input + 'Increment'][0].classList.remove('disabled')
            this.apartment[input]--
          }
          if (this.apartment[input] == 1) {
            this.$refs[input + 'Decrement'][0].classList.add('disabled')
          }
        }
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
.new-apartment {
  &__form {
    .input__ {
      &category {
        max-width: 600px;
        margin: 0 auto 3rem;
        border-bottom: .5px solid rgba(0, 0, 0, .4);
        &-title {
          font-size: 1.2rem;
          font-weight: 500;
          margin-bottom: 2rem;
        }
        .separator {
          width: 100%;
          padding: 1rem;
        }
      }
      &group {
        &-list {
          margin-bottom: 2rem;
        }
        &>* {
          margin: 1rem;
          display: flex;
          flex-direction: column;
        }
        &-label {
          font-size: 1.1rem;
          color: #111;
        }
        &-input {
          margin-top: .5rem;
          box-shadow: none;
          font-size: 1.2rem;
          font-weight: 200;
          padding: .5rem;
          border: none;
          outline: none;
          color: #777;
          &::placeholder {
            color: #aaa;
          }
        }
        .file {
          #image {
            display: none;
          }
          .image-preview {
            width: 100%;
            max-width: 350px;
            height: 40vw;
            max-height: 200px;
            background-color: rgba(0, 0, 0, .05);
            border: .5px solid rgba(0, 0, 0, .4);
            box-shadow: 0 0 .2rem .2rem rgba(0, 0, 0, 0.05);
            margin: 0 auto;
            border-radius: .5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            .plus {
              color: rgba(0, 0, 0, 0.5);
              font-size: 3rem;
              font-weight: 300;
              position: absolute;
              top: 50%;
              left: 50%;
              transform: translate(-50%, -50%);
              z-index: -1;
            }
            .img {
              width: 100%;
              height: 100%;
              object-fit: cover;
              object-position: center;
            }
          }
        }
        .number {
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
          padding-top: 1rem;
          &-buttons {
            display: flex;
            align-items: center;
            .choice {
              flex-shrink: 0;
              // width: 1rem;
              text-align: center;
              font-size: 1rem;
              font-weight: 300;
              margin: 0 1rem;
              flex-wrap: nowrap;
              display: flex;
              align-items: center;
              justify-content: center;
            }
            .round-btn {
              flex-shrink: 0;
              width: 2rem;
              height: 2rem;
              border-radius: 50%;
              border: 1px solid grey;
              font-size: 1.4rem;
              line-height: 2rem;
              font-weight: 100;
              background-color: transparent;
              display: flex;
              align-items: center;
              justify-content: center;
              cursor: pointer;
              &.disabled {
                cursor: not-allowed;
                color: grey;
                border: 1px solid lightgrey;
                &:hover {
                  background-color: transparent;
                  border: 1px solid lightgrey;
                }
              }
              &:hover {
                border: 1px solid black;
                background-color: rgba(0, 0, 0, .02);
              }
            }
          }
        }
        .text, .textarea {
          border-bottom: .5px solid rgba(0, 0, 0, .2);
        }
        .checkbox {
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
          padding-top: 1rem;
        }
      }
    }
    .submit {
      display: flex;
      justify-content: flex-end;
      max-width: 600px;
      margin: 0 auto 3rem;
      &-btn {
        background-color: transparent;
        font-size: 1rem;
        cursor: pointer;
        border: 1px solid black;
        color: black;
        text-decoration: none;
        transition: background-color .2s;
        border-radius: .7rem;
        padding: 1rem 2rem;
        &:hover {
          background-color: rgba(0, 0, 0, .02);
        }
      }
    }
  }
}
</style>