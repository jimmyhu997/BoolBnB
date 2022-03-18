<template>
  <div class="auth-modal" ref="modal">
    <div class="auth-modal__wrapper" @click.stop>

      <div class="auth-modal__header">
        <div class="close">
          <button class="close-icon" @click="close()">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3px; overflow: visible;"><path d="m6 6 20 20"></path><path d="m26 6-20 20"></path></svg>
          </button>
        </div>
        <h3 class="header-title">Log in or sign up</h3>
      </div>

      <div class="auth-modal__body">
        <div class="log-in">
          <h2 class="body-title">Log in to Boolbnb</h2>
          <form @submit.prevent="login()">
            <div class="input-list">
              <div class="input-group">
                <input class="input" type="email" v-model="loginData.email" placeholder="Email*"/>
                <span class="error" ref="loginEmail">Insert a valid email.</span>
              </div>
              <div class="input-group">
                <input class="input" type="password" v-model="loginData.password" placeholder="Password*"/>
                <span class="error" ref="loginPassword">Your password must be at least 8 characters long.</span>
              </div>
            <span class="error" ref="loginError">Email or password is incorrect.</span>
            </div>
            <button class="action-btn" type="submit">Continue</button>
          </form>
        </div>
        <div class="separator">
          <span>or</span>
        </div>
        <div class="sign-up">
          <h2 class="body-title">Sign up to Boolbnb</h2>
          <form @submit.prevent="register()">
            <div class="input-list">
              <div class="input-group">
                <input class="input" ref="registerName" type="text" v-model="registerData.name" placeholder="Name*">
                <span class="error" ref="registerName">Name is required.</span>
              </div>
              <div class="input-group">
                <input class="input" type="text" v-model="registerData.surname" placeholder="Surname*">
                <span class="error" ref="registerSurname">Surname is required.</span>
              </div>
              <div class="input-group">
                <label for="birthday" class="date-label">Birthday</label>
                <input id="birthday" class="input date" type="date" v-model="registerData.birthday" placeholder="Birthday">
                <span class="error" ref="registerBirthday">Insert a valid birthday date.</span>
              </div>
              <div class="input-group">
                <input class="input" type="email" v-model="registerData.email" placeholder="Email*">
                <span class="error" ref="registerEmail">Email is required.</span>
              </div>
              <div class="input-group">
                <input class="input" type="password" v-model="registerData.password" placeholder="Password*">
                <span class="error" ref="registerPassword">Password is required.</span>
              </div>
              <div class="input-group">
                <input class="input" type="password" v-model="registerData.password_confirmation"  placeholder="Confirm password*">
                <span class="error" ref="registerPasswordConfirmation">Passwords do not match.</span>
              </div>
            </div>
            <button class="action-btn" type="submit">Sign up</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import data from '../../../vue-commons/vueGlobal'

export default {
  name: "Login",
  data() {
    return {
      data,
      loginData: {
        email: "",
        password: "",
      },
      registerData:{
        name: '',
        surname: '',
        // birthdayNotFormatted: '',
        birthday: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    login() {
      if (this.loginValidations()) {
        axios.post("/login", this.loginData)
          .then(() => {
            location.href = '/user'
          })
          .catch(() => {
            this.$refs.loginError.classList.add('visible')
          });
      }
    },
    register(){
      if (this.registerValidations()) {
        axios.post('/register', this.registerData)
        .then(() => {
          location.href = '/user'
        }).catch(error => {
          if (error.response.data.errors.email == 'The email has already been taken.') {
            this.$refs.registerEmail.innerHTML = 'This user is already registered.'
            this.$refs.registerEmail.classList.add('visible')
          }
        })
      }
    },
    close() {
      data.authOpened = false
    },
    loginValidations() {
      let validated = 0
      // email
      const email = this.loginData.email
      if (email.length == 0 || !email.includes('@') || email.length > 255) {
        this.$refs.loginEmail.classList.add('visible')
        validated = 0
      } else {
        this.$refs.loginEmail.classList.remove('visible')
        validated++
      }
      // password
      const password = this.loginData.password
      if (password.length < 8) {
        password == '' ? this.$refs.registerPassword.innerHTML = 'Password is required.' : this.$refs.registerPassword.innerHTML = 'Your password must be at least 8 characters long.'
        this.$refs.loginPassword.classList.add('visible')
        validated = 0
      } else {
        this.$refs.loginPassword.classList.remove('visible')
        validated++
      }
      return validated == 2
    },
    registerValidations() {
      let validated = 0
      // name
      const name = this.registerData.name
      if (name == '' || name.length > 255) {
        validated = 0
        name == '' ? this.$refs.registerName.innerHTML = 'Name is required.' : this.$refs.registerName.innerHTML = 'Insert a valid name.'
        this.$refs.registerName.classList.add('visible')
      } else {
        validated++
        this.$refs.registerName.classList.remove('visible')
      }
      // surname
      const surname = this.registerData.surname
      if (surname == '' || surname.length > 255) {
        validated = 0
        surname == '' ? this.$refs.registerSurname.innerHTML = 'Surname is required.' : this.$refs.registerSurname.innerHTML = 'Insert a valid surname.'
        this.$refs.registerSurname.classList.add('visible')
      } else {
        validated++
        this.$refs.registerSurname.classList.remove('visible')
      }
      // birthday
      const birthday = this.registerData.birthday
      if (!dayJs(birthday).isBefore(dayJs()) && birthday.length > 0) {
        validated = 0
        this.$refs.registerBirthday.classList.add('visible')
      } else {
        validated++
        this.$refs.registerBirthday.classList.remove('visible')
      }
      // email
      const email = this.registerData.email
      if (email.length == 0 || !email.includes('@') || email.length > 255 || email.includes(' ')) {
        validated = 0
        email == '' ? this.$refs.registerEmail.innerHTML = 'Email is required.' :
        this.$refs.registerEmail.innerHTML = 'Insert a valid email.'
        this.$refs.registerEmail.classList.add('visible')
      } else {
        validated++
        this.$refs.registerEmail.classList.remove('visible')
      }
      // password
      const password = this.registerData.password
      if (password == '' || password.length > 255 || password.length < 8) {
        validated = 0
        password == '' ? this.$refs.registerPassword.innerHTML = 'Password is required.' :
        password.length < 8 ? this.$refs.registerPassword.innerHTML = 'Your password must be at least 8 characters long.' :
        this.$refs.registerPassword.innerHTML = 'Password must not be longer than 255 characters.'
        this.$refs.registerPassword.classList.add('visible')
      } else {
        validated++
        this.$refs.registerPassword.classList.remove('visible')
      }
      // password confirmation
      const passwordConfirmation = this.registerData.password_confirmation
      if (passwordConfirmation != password) {
        validated = 0
        this.$refs.registerPasswordConfirmation.classList.add('visible')
      } else {
        validated++
        this.$refs.registerPasswordConfirmation.classList.remove('visible')
      }

      return validated == 6
    }

  },
  watch: {
    '$data.data.authOpened'(opened) {
      if (opened) {
        document.body.style.overflow = 'hidden';
        this.$refs.modal.classList.add('visible')
      } else {
        document.body.style.overflow = 'auto';
        this.$refs.modal.classList.remove('visible')
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.auth-modal {
  position: fixed;
  z-index: 3;
  top: 0;
  left: 0;
  width: calc(100% - (100% - 100vw));
  height: 100vh;
  background-color: transparent;
  visibility: hidden;
  transition: background-color .3s;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow-y: auto;
  @media screen and (min-width: 568px) {
    display: grid;
    place-items: center;
  }
  &.visible {
    visibility: visible;
    background-color: rgba(0, 0, 0, 0.3);
    // background-color: red;
    .auth-modal__wrapper {
      transform: translateY(0);
    }
  }
  &__wrapper {
    width: 100%;
    max-width: 568px;
    height: 100%;
    background-color: #fff;
    transform: translateY(100%);
    transition: transform .3s;
    display: flex;
    flex-direction: column;
    @media screen and (min-width: 568px) and (min-height: 500px) {
      width: 568px;
      height: max-content;
      border-radius: 1rem;
      margin: 2rem 0;
    }
  }
  &__header {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid $lightGrey;
    padding: 1rem;
    .close {
      flex: 1;
      &-icon {
        background-color: transparent;
        box-shadow: none;
        border: none;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        display: grid;
        place-content: center;
        cursor: pointer;
        &:hover {
          background-color: rgba(0, 0, 0, 0.05);
        }
      }
    }
    .header-title {
      flex: 2;
      font-weight: 600;
    }
  }
  &__body {
    padding: 1.5rem;
    width: 100%;
    // height: 100%;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    .body-title {
      font-weight: 500;
      margin-bottom: 1.3rem;
    }
    .input-list {
      width: 100%;
      display: flex;
      flex-direction: column;
      border-radius: .8rem;
      border: 1px solid #888;
      overflow: hidden;
      .input-group {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
      }
      .input {
        width: 100%;
        border: none;
        padding: 1rem;
        font-size: 1.2rem;
        font-weight: 300;
      }
      .error {
        display: none;
        padding: .3rem 1rem;
        border-top: .5px solid black;
        color: red;
        &.visible {
          display: inline;
        }
      }
      .date {
        font-size: 1rem;
        padding: 0 1rem 1rem;
        &-label {
          color: rgba(0, 0, 0, .3);
          padding: .3rem 1rem;
        }
      }
      .input-group:not(:last-of-type) {
        border-bottom: 1px solid #888;
      }
    }
    .action-btn {
      width: 100%;
      padding: .9rem;
      text-align: center;
      background-color: $darkPink;
      border: none;
      box-shadow: none;
      color: white;
      border-radius: .4rem;
      margin-top: 1.5rem;
      font-weight: 400;
      font-size: 1.1rem;
      cursor: pointer;
      // transition: opacity .3s;
      // &:hover {
      //   opacity: .9;
      // }
    }
    .separator {
      margin: 1rem 0;
      display: flex;
      align-items: center;
      justify-content: space-between;
      span {
        margin: 0 1rem;
        font-weight: 300;
        font-size: .8rem;
      }
      &::after, &::before {
        content: '';
        width: 100%;
        height: 1px;
        background-color: #ccc;
      }
    }
  }
}
</style>