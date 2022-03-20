<template>
  <div class="view-apartment container">
    <div class="view-apartment__heading">
      <div class="overview">
        <h2 class="title">
          {{apartment.title}}
        </h2>
        <div class="location">
          {{apartment.city}}, {{apartment.province_state}}, {{apartment.country}}
        </div>
      </div>
      <div class="actions">
        <a class="large-btn" :href="'/user/edit-apartment/' + apartment.id" v-if="apartmentOwner">Edit your listing</a>
        <a class="edit" :href="'/user/edit-apartment/' + apartment.id" v-if="apartmentOwner">Edit</a>
      </div>
    </div>
    <div class="view-apartment__image">
      <img :src="'/storage/' + apartment.image_path" :alt="apartment.title" class="img">
    </div>
    <div class="view-apartment__body">
      <div class="content-top">
        <div class="content">
          <section class="content-heading">
            <div class="left">
              <h3 class="hosted-by" v-if="apartment.user">Entire apartment hosted by {{apartment.user.name}}</h3>
              <span class="basic-options">{{apartment.guests}} guests • {{apartment.rooms}} bedrooms • {{apartment.beds}} beds • {{apartment.bathrooms}} baths • {{apartment.square_meters}} sqm</span>
            </div>
            <div class="right">
              <p class="price"><span class="num">€{{apartment.price}}</span> <span class="night">/ night</span></p>
            </div>
          </section>
          <section class="content-description section">
            <h4 class="title">Overview</h4>
            <p class="text">
              {{apartment.description}}
            </p>
          </section>
          <section class="content-options section">
            <h4 class="title">What this place offers</h4>
            <ul class="options-list">
              <li class="option" v-for="option in apartment.perks" :key="option.id">
                {{option.name}}
              </li>
            </ul>
          </section>
        </div>
        <div class="floating" id="float">
          <div class="check-messages" v-if="apartmentOwner">
            <h5 class="title">Hello {{userName()}}, go check your messages</h5>
            <a class="action-btn" href="/user/inbox">Check messages</a>
          </div>
          <div class="send-message" v-else>
            <h5 class="title">Send a message to the host</h5>
            <form @submit.prevent="sendMessage()" class="message-form">
              <div class="inputs-section">
                <div class="user-info">
                  <div class="input-group">
                    <label for="name">Name*</label>
                    <input v-if="!window.loggedIn" class="input" type="text" v-model="message.name" id="name" placeholder="Your name">
                    <span v-else>{{userName()}}</span>
                    <span class="error" ref="messageName">Name is required.</span>
                  </div>
                  <div class="input-group">
                    <label for="email">Email*</label>
                    <input v-if="!window.loggedIn" class="input" type="email" v-model="message.email" id="email" placeholder="Your email">
                    <span v-else>{{userEmail()}}</span>
                    <span class="error" ref="messageEmail">Email is required.</span>
                  </div>
                </div>
                <div class="user-message">
                  <div class="input-group">
                    <label for="message">Message*</label>
                    <textarea class="input" id="message" v-model="message.content" rows="2" placeholder="Your message"></textarea>
                    <span class="error" ref="messageContent">Message is required.</span>
                  </div>
                </div>
              </div>
              <button class="action-btn" type="submit">Send message</button>
              <span class="confirmation" ref="messageSent">Thank you, the host will write you back via email.</span>
            </form>
          </div>
        </div>
      </div>
      <div class="content-bottom">
        <div class="content">
          <section class="content-location section">
            <h4 class="title">Where you'll be</h4>
            <div class="map">
              Mappa tomtom
            </div>
            <div class="location-info">
              <p>{{apartment.street_address}}</p>
            </div>
          </section>
          <section class="host section">
            <h4 class="title" v-if="apartment.user">Hosted by {{apartment.user.name}}</h4>
            <p class="text">
              Joined in {{host.joined}}
            </p>
            <a href="#float" class="large-btn" v-if="!apartmentOwner">Contact Host</a>
            <a href="/user/inbox" class="large-btn" v-else>Check your inbox</a>
          </section>
        </div>
      </div>
    </div>

    <!-- div per mostrare le informazioni dell'appartamento -->
    <!-- <div>
      <h2>{{this.apartment.title}}</h2>
      <img :src="'/storage/' + this.apartment.image_path" :alt="this.apartment.title + ' preview'">
      
      <h2>informazioni generali:</h2>
      <h3>Metri quadrati: {{this.apartment.square_meters}}</h3>
      <h3>Numero ospiti: {{this.apartment.guests}}</h3>
      <h3>Numero stanze: {{this.apartment.rooms}}</h3>
      <h3>Numero letti: {{this.apartment.beds}}</h3>
      <h3>Numero bagni: {{this.apartment.bathrooms}}</h3>

      <h2>informazioni stradali</h2>
      <h3>Indirizzo: {{this.apartment.street_address}}</h3>
      <h3>Città: {{this.apartment.city}}</h3>
      <h3>Provincia: {{this.apartment.province_state}}</h3>
      <h3>Paese: {{this.apartment.country}}</h3>

      <h3>Prezzo per notte: {{this.apartment.price}}</h3>

      <h2>Descrizione:</h2>
      <p>{{this.apartment.overview}}</p>
    </div> -->

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
        apartment:{},
        apartmentOwner:false,
        message: {
          name: '',
          email:'',
          content:'',
          stay_id:null
        },
        host: {
          joined: ''
        },
        errors: {}
      }
    },
    created() {
      axios.get(`/api/stays/${this.$route.params.stay}`).then( (response) => {
        if (response.data.visible == false ) {
          if (response.data.user_id == data.loggedUserId) {
            this.apartment = response.data
            console.log(this.apartment.user);
            this.message.stay_id = this.apartment.id
              if(data.loggedUserId == this.apartment.user_id) {
                this.apartmentOwner = true
              }
          }
          else {
            // da rimandare ad una pagina 404 
            this.$router.push({ name: 'home'})
          }
        } 
        else {
          this.apartment = response.data
          this.host.joined = dayJs(this.apartment.user.created_at).format('MMMM YYYY')
          this.message.stay_id = this.apartment.id
          if(data.loggedUserId == this.apartment.user_id) {
            this.apartmentOwner = true
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
      validations() {
        let validated = 0
        // name
        const name = this.message.name
        if (name == '' || name.length > 255) {
          validated = 0
          name == '' ? this.$refs.messageName.innerHTML = 'Name is required.' : this.$refs.messageName.innerHTML = 'Insert a valid name.'
          this.$refs.messageName.classList.add('visible')
        } else {
          validated++
          this.$refs.messageName.classList.remove('visible')
        }
        // email
        const email = this.message.email
        if (email == '' || email.length > 255) {
          validated = 0
          email == '' ? this.$refs.messageEmail.innerHTML = 'Email is required.' : this.$refs.messageEmail.innerHTML = 'Insert a valid email.'
          this.$refs.messageEmail.classList.add('visible')
        } else {
          validated++
          this.$refs.messageEmail.classList.remove('visible')
        }
        // content
        const content = this.message.content
        if (content == '' || content.length > 500) {
          validated = 0
          content == '' ? this.$refs.messageContent.innerHTML = 'Message is required.' : this.$refs.messageContent.innerHTML = 'Message must not be longer than 500 characters.'
          this.$refs.messageContent.classList.add('visible')
        } else {
          validated++
          this.$refs.messageContent.classList.remove('visible')
        }

        return validated == 3
      },
      sendMessage() {
        if (this.validations()) {
          axios.post('/api/send-message',this.message).then(() => {
            this.message.content = ''
            this.$refs.messageSent.classList.add('visible')
            setTimeout(() => {
              this.$refs.messageSent.classList.remove('visible')
            }, 5000);
          }).catch(error => {
              this.errors = error.response.data.errors;
            });
        }
      }
    }
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
@import '../../../../sass/mixins.scss';
.view-apartment {
  @include large-btn;
  &__heading {
    margin-top: 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    .overview {
      .title {
        font-weight: 500;
      }
      .location {
        margin-top: .7rem;
        font-weight: 400;
        font-size: .9rem;
        color: grey;
      }
    }
    .actions {
      flex-shrink: 0;
      .large-btn {
        display: none;
        @media screen and (min-width: $medium) {
          display: inline-block;
          flex-shrink: 0;
        }
      }
      .edit {
        font-weight: 500;
        color: black;
        @media screen and (min-width: $medium) {
          display: none;
        }
      }
    }
  }
  &__image {
    margin-top: 1rem;
    width: 100%;
    height: 50vw;
    border-radius: 1rem;
    overflow: hidden;
    @media screen and (min-width: $medium) {
      height: 30vw;
    }
    .img {
      object-fit: cover;
      object-position: center;
      width: 100%;
      height: 100%;
    }
  }
  &__body {
    .content-top, .content-bottom {
      border-bottom: .5px solid rgba(0, 0, 0, 0.3);
      padding-bottom: 2rem;
      .content {
        .section {
          margin-top: 2rem;
          &:not(:last-of-type) {
            padding-bottom: 2rem;
            border-bottom: .5px solid rgba(0, 0, 0, 0.3);
          }
          .title {
            font-size: 1.4rem;
            font-weight: 500;
            margin-bottom: 1rem;
          }
        }
      }
    }
    .content-top {
      display: flex;
      flex-direction: column;
      padding-top: 2rem;
      @media screen and (min-width: $medium) {
        flex-direction: row;
      }
      .content {
        padding-right: 2rem;
        min-width: 70%;
        &-heading {
          border-bottom: .5px solid rgba(0, 0, 0, 0.3);
          padding-bottom: 2rem;
          display: flex;
          align-items: center;
          justify-content: space-between;
          .left {
            .hosted-by {
              font-weight: 500;
              font-size: 1.5rem;
              margin-bottom: .5rem;
            }
            .basic-options {
              font-weight: 400;
              font-size: 1rem;
              color: #888;
            }
          }
          .right {
            flex-shrink: 0;
            .price {
              .num {
                font-size: 1.5rem;
                font-weight: 600;
              }
              .night {
                font-size: 1.1rem;
                font-weight: 400;
              }
            }
          }
        }
        .section {
          .options-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            @media screen and (min-width: $medium) {
              flex-wrap: wrap;
              height: 200px;
            }
            .option {
              font-size: 1.2rem;
              color: #555;
              margin: .4rem 0;
            }
          }
        }
      }
      .floating {
        position: relative;
        min-width: 30%;
        margin-top: 2rem;
        @media screen and (min-width: $medium) {
          margin-top: 0;
        }
        .check-messages, .send-message {
          position: sticky;
          top: 120px;
          left: 0;
          width: 100%;
          border: 1px solid rgba(0, 0, 0, .1);
          border-radius: 1rem;
          box-shadow: 0 .5rem .5rem .5rem rgba(0, 0, 0, .05);
          @include action-btn;
        }
        .check-messages {
          padding: 1.4rem;
          .action-btn {
            width: 100%;
          }
        }
        .title {
          font-size: 1.2rem;
          font-weight: 400;
          margin-bottom: 1rem;
        }
        .send-message {
          padding: 1rem;
          .message-form {
            .inputs-section {
              border: 1px solid black;
              border-radius: .5rem;
              .user-info {
                display: flex;
              }
              .user-message {
                border-top: 1px solid black;
              }
              .input-group {
                display: flex;
                flex-direction: column;
                flex: 1;
                padding: .5rem;
                &:not(:first-of-type) {
                  border-left: 1px solid black;
                }
                .input {
                  border: none;
                  background-color: transparent;
                  width: 100%;
                  outline: none;
                  padding: .5rem 0;
                  resize: none;
                  font-size: 1rem;
                  &::placeholder {
                    font-size: 1rem;
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
              }
            }
            .action-btn {
              margin-top: 1.5rem;
            }
            .confirmation {
              display: none;
              margin-top: .5rem;
              color: black;
              border: .5px solid rgba(0, 0, 0, .2);
              background-color: rgba(51, 148, 32, 0.4);
              padding: .5rem;
              border-radius: .3rem;
              &.visible {
                display: inline-block;
              }
            }
          }
        }
      }
    }
    .content-bottom {
      .map {
        width: 100%;
        height: 50vw;
        background-color: lightgrey;
        margin-bottom: 1rem;
        border-radius: .3rem;
        @media screen and (min-width: $medium) {
          height: 30vw;
        }
      }
      .host {
        .text {
          font-size: .9rem;
          color: grey;
          margin: .5rem 0 1rem;
        }
        .large-btn {
          display: inline-block;
        }
      }
    }
  }
}
</style>