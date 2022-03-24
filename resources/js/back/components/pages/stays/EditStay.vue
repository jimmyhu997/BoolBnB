<template>
  <div class="edit-apartment container">
    <PageHeading :title="'Edit your listing'" :button="{ route: 'stays', desktop: 'Cancel', mobile: '-' }"/>
    <form @submit.prevent="update()" class="edit-apartment__form">

      <section class="input__category" v-for="(inputCategory, index) in formInputs" :key="index">
        <!-- Category title -->
        <h3 class="input__category-title">
          {{inputCategory.category}}
        </h3>
        <div class="input__group-list">
          <div class="input__group" v-for="input in inputCategory.inputs" :key="input.name">
            <!-- Title input -->
            <div :class="input.type" v-if="input.name == 'title'">
              <label :for="input.name" class="input__group-label">{{input.label}}</label>
              <input :type="input.type" :id="input.name" class="input__group-input" v-model="apartment[input.name]" :placeholder="input.placeholder" :maxlength="input.maxLength">
              <span v-if="input.name == 'title' && apartment.title" class="words-limit">{{apartment.title.length}}/{{input.maxLength}}</span>
              <span class="error" :ref="input.name">{{input.label}} is required.</span>
            </div>
            <!-- Address input -->
            <div :class="input.type" v-if="input.name == 'street_address'">
              <label :for="input.name" class="input__group-label">{{input.label}}</label>
              <input :type="input.type" :id="input.name" class="input__group-input" :placeholder="input.placeholder" v-model="searchKeyword" @input="searchHints()" @keydown.enter="validateAddress()" @click.stop="data.addressHintsOpened = true">
              <span class="error" :ref="input.name">{{input.label}} is required.</span>
              <!-- address hints -->
              <div class="hints" ref="hints">
                <ul class="hints__list" v-if="searchResults.length > 0">
                  <li class="hints__item" v-for="(hint, index) in searchResults.slice(0,5)" :key="index">
                    <div class="hints__link" :title="hint.address.postalCode" @click="addPosition(hint)">
                      <div class="place-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602zm0 11c-1.657 0-3-1.343-3-3s1.343-3 3-3 3 1.343 3 3-1.343 3-3 3z"/></svg>
                      </div>
                      <span>{{string(hint.address)}}</span>
                    </div>
                  </li>
                </ul>
                <div v-else class="hints__list">
                    <span class="hints__no-results">No results.</span>
                </div>
              </div>
            </div>
            <!-- Textarea input -->
            <div :class="input.type" v-else-if="input.type == 'textarea'">
              <label :for="input.name" class="input__group-label">{{input.label}}</label>
              <textarea class="input__group-input" :id="input.name" v-model="apartment[input.name]" :placeholder="input.placeholder" rows="2" :maxlength="input.maxLength"></textarea>
              <span v-if=" apartment.description" class="words-limit">{{apartment.description.length}}/{{input.maxLength}}</span>
              <span class="error" :ref="input.name">{{input.name}} is required.</span>
            </div>
            <!-- Image input -->
            <div :class="input.type" v-if="input.type == 'file'">
              <input :type="input.type" :id="input.name" accept=".png, .jpg, .jpeg" ref="fileSelector" @change="onChangeImage">
              <div class="image-preview" @click="fileSelector()">
                <span class="plus">+</span>
                <img class="img" ref="imagePreview">
              </div>
              <span class="image-info">Accepted formats: png/jpg/jpeg.<br>Max size: 5MB</span>
              <span class="error" ref="image">{{input.name}} is required.</span>
            </div>
            <!-- Number input -->
            <div :class="input.type" v-else-if="input.type == 'number'">
              <label class="input__group-label">{{input.label}}</label>
              <div class="number-buttons">
                <button class="round-btn" :class="{'disabled' : apartment[input.name] == input.min}" :ref="input.name + 'Decrement'" @click.prevent="decrement(input.name)">
                  <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28"></path></svg>
                </button>
                <div class="choice">{{apartment[input.name]}} {{input.name == 'price' ? '€' : ''}}</div>
                <button class="round-btn" :class="{'disabled' : apartment[input.name] == input.max}" :ref="input.name + 'Increment'" @click.prevent="increment(input.name)">
                  <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><path d="m2 16h28m-14-14v28"></path></svg>
                </button>
              </div>
            </div>
            <!-- Radius input -->
            <div :class="input.type" v-else-if="input.type == 'radius'">
              <label class="input__group-label">{{input.label}}</label>
              <button class="option" @click.prevent="visibility()">
                <div class="radius-btn" :class="{'checked' : apartment.visible}" ref="listed"></div>
                <span class="option-name listed">Listed</span>
              </button>
              <button class="option" @click.prevent="visibility()">
                <div class="radius-btn" :class="{'checked' : !apartment.visible}" ref="unlisted"></div>
                <span class="option-name unlisted">Unlisted</span>
              </button>
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
        <div class="input__group" v-for="perk in perks" :key="perk.id">
          <div class="checkbox">
            <label :for="perk.name" class="input__group-label">{{perk.name}}</label>
            <div class="checkbox-buttons">
              <button class="round-btn" :class="{'unchecked' : activePerks.includes(perk.id)}" @click.prevent="uncheck(perk.id)">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3px; overflow: visible;"><path d="m6 6 20 20"></path><path d="m26 6-20 20"></path></svg>
              </button>
              <button class="round-btn" :class="{'unchecked' : !activePerks.includes(perk.id)}" @click.prevent="check(perk.id)">
                <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3px; overflow: visible;"><path fill="none" d="m4 16.5 8 8 16-16"></path></svg>
              </button>
            </div>
          </div>
        </div>
      </section>
      <!-- Submit -->
      <div class="submit">
        <button class="submit-btn" type="submit">Save listing</button>
      </div>
    </form>
    <EditStaySuccessModal :confirmation="confirmation"/>
  </div>
</template>

<script>
import PageHeading from '../../commons/PageHeading.vue'
import EditStaySuccessModal from '../../modals/EditStaySuccessModal.vue'
import data from '../../../../vue-commons/vueGlobal'

export default {
  name:'EditStay',
  components: { PageHeading, EditStaySuccessModal },
  data() {
    return {
      data,
      confirmation: false,
      activePerks:[],
      apartment:{},
      errors:{},
      perks: [],
      apartment: {},
      formInputs: [
        {
          category: 'Photo*',
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
              maxLength: 50,
              label: 'Listing title',
              placeholder: 'Insert a title*',
              type: 'text'
            },
            {
              name: 'description',
              maxLength: 500,
              label: 'Listing description',
              placeholder: 'Insert a description*',
              type: 'textarea'
            },
            {
              name: 'guests',
              label: 'Number of guests',
              type: 'number',
              min: 1,
              max: 16
            },
            {
              name: 'visible',
              label: 'Listing status',
              type: 'radius'
            },
          ]
        },
        {
          category: 'Rooms and spaces',
          inputs: [
            {
              name: 'beds',
              label: 'Beds',
              type: 'number',
              min: 1,
              max: 16
            },
            {
              name: 'rooms',
              label: 'Bedrooms',
              type: 'number',
              min: 1,
              max: 16
            },
            {
              name: 'bathrooms',
              label: 'Bathrooms',
              type: 'number',
              min: 1,
              max: 16
            },
            {
              name: 'square_meters',
              label: 'Square meters',
              type: 'number',
              min: 10,
              max: 990
            },
          ]
        },
        {
          category: 'Location',
          inputs: [
            {
              name: 'street_address',
              label: 'Street address',
              placeholder: 'Insert a street address*',
              type: 'text'
            }
          ]
        },
        {
          category: 'Pricing',
          inputs: [
            {
              name: 'price',
              label: 'Nightly price',
              type: 'number',
              min: 10,
              max: 990
            }
          ]
        }
      ],
      timeout: null,
      types: ['Street', 'Point Address'],
      searchKeyword: '',
      searchResults: [],
      preciseAddress: true
    }
  },
  created() {
    axios.get('/api/perks')
      .then(response => {
        this.perks = response.data
      })
    axios.get(`/user/stays/${this.$route.params.stay}/edit`).then( (response) => {
      this.apartment = response.data;
      this.activePerks = this.apartment.perks.map(perk => {
        return perk.id
      });
      this.searchKeyword = this.apartment.street_address
      this.apartment.price = parseInt(this.apartment.price)
      this.$refs.imagePreview[0].src = '/storage/' + this.apartment.image_path
    }).catch((error) => {
      if(error.response.status == 404) {
        this.$router.push( {name: '404'})
      }
      else {
        this.errors = error.response.data.errors;
      }
    });
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
      let limit = 16
      let num = 1
      if (input == 'square_meters' || input == 'price') {
          limit = 990
          num = 10
      }
      if (this.apartment[input] < limit) {
        this.apartment[input] += num
      }
      if (this.apartment[input] == limit) {
      }
    },
    decrement(input) {
      let limit = 1
      let num = 1
      if (input == 'square_meters' || input == 'price') {
        limit = 10
        num = 10
      }
      if (this.apartment[input] > limit) {
        this.apartment[input] -= num
      }
      if (this.apartment[input] == limit) {
      }
    },
    check(input) {
      if (!this.activePerks.includes(input)) {
        this.activePerks.push(input)
      }
    },
    uncheck(input) {
      if (this.activePerks.includes(input)) {
        this.activePerks.splice(this.activePerks.indexOf(input), 1)
      }
    },
    visibility() {
      if (this.apartment.visible) {
        this.apartment.visible = ''
      } else {
        this.apartment.visible = true
      }
    },
    searchHints() {
      if (this.searchKeyword){
        this.searchResults = []
        clearTimeout(this.timeout);
        this.timeout = setTimeout(() => {
          externalAxios.get(`https://api.tomtom.com/search/2/geocode/${this.searchKeyword}.json?`,{
            params: {
              key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
              limit: 50,
            }
          })
          .then((response) => {
            data.addressHintsOpened = true
            for(let result in response.data.results){
              if(this.types.includes(response.data.results[result].type)){
                if (response.data.results[result].type == 'Point Address'){
                  this.searchResults.push(response.data.results[result])
                } else if (response.data.results[result].type == 'Street'){
                  this.searchResults.push(response.data.results[result])
                }
              }
            }
          })
          .catch(error => {
            this.errors = error.response.data.errors;
          });
        },500);
      } else {
        data.addressHintsOpened = false
        this.searchResults = []
      }
    },
    string(object){
      let result = ''
      result += `${object.streetName}, `
      if (object.streetNumber){
        result += `${object.streetNumber}, `
      }
      if (object.municipality){
        result += `${object.municipality}, `
      }
      if (object.countrySecondarySubdivision){
        result += `${object.countrySecondarySubdivision}, `
      }
      if (object.countrySubdivision){
        result += `${object.countrySubdivision}, `
      }
      result += object.countryCode
      return result
    },
    addPosition(object) {
      this.searchKeyword = this.string(object.address)
      data.addressHintsOpened = false
      if (!object.address.streetName) {
        this.preciseAddress = false
      } else {
        this.preciseAddress = true
        this.apartment.latitude = object.position.lat
        this.apartment.longitude = object.position.lon
        this.apartment.city = object.address.municipality
        this.apartment.province_state = object.address.countrySubdivision
        this.apartment.country = object.address.country
        this.apartment.zip_code = object.address.postalCode
        this.apartment.street_address = this.searchKeyword
      }
    },
    validateAddress() {
      this.preciseAddress = false
      if (this.searchResults.length > 0) {
        this.addPosition(this.searchResults[0])
      }
    },
    validations() {
      let validated = 0
      // title
      const title = this.apartment.title
      if (title == '' || title.length > 50) {
        validated = 0
        title == '' ? this.$refs.title[0].innerHTML = 'Title is required.' : this.$refs.title[0].innerHTML = 'Insert a valid title.'
        this.$refs.title[0].classList.add('visible')
      } else {
        validated++
        this.$refs.title[0].classList.remove('visible')
      }
      // description
      const description = this.apartment.description
      if (description == '' || description.length > 500) {
        validated = 0
        description == '' ? this.$refs.description[0].innerHTML = 'Description is required.' : this.$refs.description[0].innerHTML = 'Insert a valid description.'
        this.$refs.description[0].classList.add('visible')
      } else {
        validated++
        this.$refs.description[0].classList.remove('visible')
      }
      // image
      const image = this.apartment.image_path
      if (typeof(image) == 'string') {
        validated++
      } else if (!image.size || image.size > 5120000) {
        validated = 0
        !image.size ? this.$refs.image[0].innerHTML = 'Image is required.' : this.$refs.image[0].innerHTML = 'Image max size is 5MB.'
        this.$refs.image[0].classList.add('visible')
      } else {
        validated++
        this.$refs.image[0].classList.remove('visible')
      }
      // address
      const address = this.searchKeyword
      if (address == '' || !this.preciseAddress) {
        validated = 0
        address == '' ? this.$refs.street_address[0].innerHTML = 'Address is required.' : this.$refs.street_address[0].innerHTML = 'Specify a street name.'
        this.$refs.street_address[0].classList.add('visible')
      } else {
        validated++
        this.$refs.street_address[0].classList.remove('visible')
      }
      // hidden validations
      const guests = this.apartment.guests
      if (guests < 0 || guests > 16) {
        validated = 0
      } else validated++
      const beds = this.apartment.beds
      if (beds < 0 || beds > 16) {
        validated = 0
      } else validated++
      const rooms = this.apartment.rooms
      if (rooms < 0 || rooms > 16) {
        validated = 0
      } else validated++
      const bathrooms = this.apartment.bathrooms
      if (bathrooms < 0 || bathrooms > 16) {
        validated = 0
      } else validated++
      const square_meters = this.apartment.square_meters
      if (square_meters < 10 || square_meters > 990) {
        validated = 0
      } else validated++
      const price = this.apartment.price
      if (price < 10 || price > 990) {
        validated = 0
      } else validated++

      console.log(validated);
      return validated == 10
    },
    update() {
      this.apartment.perks = this.activePerks;
      if (this.validations()) {
        let formData = new FormData();
        for (let element in this.apartment) {
          formData.append(String(element),this.apartment[element])
        }
        axios.post(`/user/stays/${this.$route.params.stay}?_method=PUT`, formData).then((response) => {
          this.confirmation = true
          setTimeout(() => {
            this.confirmation = false
            this.$router.push( {name: 'stays'})
          }, 5000);
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
          });
      }
    },
  },
  watch: {
    '$data.data.addressHintsOpened'(hints) {
      if (hints) {
        this.$refs.hints[0].classList.add('active')
      } else {
        this.$refs.hints[0].classList.remove('active')
      }
    }
  }
 
}
</script>

<style lang="scss" scoped>
@import '../../../../../sass/_variables.scss';
@import '../../../../../sass/mixins.scss';
.edit-apartment {
  margin-bottom: 5rem;
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
          resize: none;
          &::placeholder {
            color: #aaa;
          }
        }
        .error {
          display: none;
          &::first-letter {
            text-transform: uppercase;
          }
          padding: .3rem 0;
          color: red;
          &.visible {
            display: inline;
          }
        }
        .file {
          #image {
            display: none;
          }
          .image-info {
            margin-top: 1rem;
            line-height: 1.4rem;
            color: grey;
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
            @include round-btn;
          }
        }
        .text, .textarea {
          border-bottom: .5px solid rgba(0, 0, 0, .2);
          margin-bottom: 2rem;
          position: relative;
          .words-limit {
            position: absolute;
            bottom: 0;
            right: 0;
            color: grey;
            font-size: .8rem;
          }
        }
        .checkbox {
          flex-direction: row;
          justify-content: space-between;
          align-items: center;
          padding-top: 1rem;
          &-buttons {
            display: flex;
            align-items: center;
            @include round-btn;
            .round-btn {
              margin-left: 1rem;
            }
          }
        }
        .radius {
          margin-top: 2.5rem;
          .input__group-label {
            margin-bottom: 1.2rem;
          }
          .option {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            width: max-content;
            cursor: pointer;
            margin: 1rem 0;
            border: none;
            background-color: transparent;
            &:hover .radius-btn {
              border: 1px solid black;
              background-color: rgba(0, 0, 0, .02);
            }
            .radius-btn {
              flex-shrink: 0;
              width: 1.5rem;
              height: 1.5rem;
              border-radius: 50%;
              border: 1px solid grey;
              &.checked {
                border: .5rem solid black;
              }
            }
            .option-name {
              display: flex;
              align-items: center;
              font-size: 1rem;
              font-weight: 300;
              &::before {
                content: '';
                display: block;
                width: .7rem;
                height: .7rem;
                border-radius: 50%;
                margin: 0 .5rem 0 1rem;
              }
              &.listed::before {
                background-color: rgb(0, 138, 5);
              }
              &.unlisted::before {
                background-color: rgb(193, 53, 21);
              }
            }
          }
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
    .hints {
      display: none;
      position: absolute;
      top: 5rem;
      left: 50%;
      transform: translateX(-50%);
      width: 100%;
      max-width: 500px;
      height: max-content;
      background-color: #fff;
      border-radius: 1.5rem;
      box-shadow: 0 0 .7rem rgba(0, 0, 0, .2);
      &.active {
        display: block;
      }
      &__list {
        list-style: none;
        padding: 1rem 0;
      }
      &__link {
        display: flex;
        align-items: center;
        padding: 1rem 1.5rem;
        cursor: pointer;
        .place-icon {
          flex-shrink: 0;
          width: 2.7rem;
          height: 2.7rem;
          display: flex;
          align-items: center;
          justify-content: center;
          border-radius: .5rem;
          background-color: rgba(0, 0, 0, .07);
          border: 1px solid $lightGrey;
          margin-right: 1rem;
          svg {
            width: 1.2rem;
          }
        }
        &:hover {
          background-color: rgba(0, 0, 0, 0.05);
        }
      }
      &__no-results {
        padding: 1rem 1.5rem;
        display: block;
      }
    }
  }
}
</style>