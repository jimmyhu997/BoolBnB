<template>
  <div class="delete-modal" ref="modal">
    <div class="delete-modal__wrapper" @click.stop>
        <!-- Header -->
      <div class="delete-modal__header">
        <div class="close">
          <button class="close-icon" @click="close()">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 16px; width: 16px; stroke: currentcolor; stroke-width: 3px; overflow: visible;"><path d="m6 6 20 20"></path><path d="m26 6-20 20"></path></svg>
          </button>
        </div>
        <h3 class="header-title">Delete listing</h3>
      </div>
        <!-- Body -->
      <div class="delete-modal__body">
        <h2 class="body-title">{{apartment.title}}</h2>
        <form @submit.prevent="deleteStay(apartment.id)">
            <p class="body-text">Are you sure you want to delete this listing?</p>
            <button class="action-btn" type="submit">Delete</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import data from '../../../vue-commons/vueGlobal'

export default {
  name: "Login",
  props: {
    apartment: Object
  },
  data() {
    return {
      data
    };
  },
  methods: {
    deleteStay(stay) {
        axios.delete(`/user/stays/${stay}`)
            .then(() => {
                this.$emit('delete')
                this.close()
            });
    },
    close() {
      data.deleteOpened = false
    },

  },
  watch: {
    '$data.data.deleteOpened'(opened) {
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
.delete-modal {
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
    .delete-modal__wrapper {
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
    .body-text {
        // text-align: center;
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
  }
}
</style>