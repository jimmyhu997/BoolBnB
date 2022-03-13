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
            <div class="input-group">
              <input class="input" type="email" v-model="loginData.email" required placeholder="Email"/>
              <input class="input" type="password" v-model="loginData.password" required placeholder="Password"/>
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
            <div class="input-group">
              <input class="input" type="text" v-model="registerData.name" required placeholder="Name*">
              <input class="input" type="text" v-model="registerData.surname" placeholder="Surname">
              <div class="input date">
                <!-- Flowbite date picker using Tailwind framework -->
                <div class="relative flex">
                  <div class="z-auto flex absolute inset-y-0 left-0 items-center pointer-events-none"></div>
                  <input v-model="registerData.birthday" datepicker datepicker-format="dd/mm/yyyy" datepicker-title="Birthday" datepicker-autohide type="text" class="p-0 text-gray-900 rounded-lg block w-full light:bg-gray-700 light:placeholder-gray-400 light:text-white" placeholder="Birthday">
                  <svg class="w-5 h-5 text-gray-500 light:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </div>
              </div>
              <input class="input" type="email" v-model="registerData.email" required placeholder="Email*">
              <input class="input" type="password" v-model="registerData.password" required placeholder="Password*">
              <input class="input" type="password" v-model="registerData.password_confirmation" required  placeholder="Confirm password*">
            </div>
            <button class="action-btn" type="submit">Sign up</button>
          </form>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
import data from '../../global'

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
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  methods: {
    login() {
      axios.post("/login", this.loginData)
        .then(response => {
          location.href = '/user'
        })
        .catch(error => {
          console.log(error);
        });
    },
    register(){
      axios.post('/register', this.registerData)
      .then(response => {
        location.href = '/user'
      }).catch(error => {
        console.log(error)
      })
    },
    close() {
      data.authOpened = false
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
  width: calc(100vw - (100% - 100vw));
  height: 100vh;
  background-color: transparent;
  visibility: hidden;
  transition: background-color .3s;
  display: grid;
  place-items: center;
  overflow-y: auto;
  &.visible {
    visibility: visible;
    background-color: rgba(0, 0, 0, 0.3);
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
    @media screen and (min-width: 568px) {
      height: max-content;
      border-radius: 1rem;
      margin: 2rem 0;
    }
  }
  &__header {
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
    .body-title {
      font-weight: 500;
      margin-bottom: 1.3rem;
    }
    .input-group {
      display: flex;
      flex-direction: column;
      border-radius: .8rem;
      border: 1px solid #888;
      overflow: hidden;
      .input, .date {
        border: none;
        padding: 1rem;
        font-size: 1.2rem;
        font-weight: 300;
      }
      .date {
        svg {
          fill: $darkPink;
        }
        input {
          outline: none;
          font-size: 1.2rem;
          font-weight: 300;
          cursor: pointer;
        }
      }
      .input:not(:last-of-type), .date {
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