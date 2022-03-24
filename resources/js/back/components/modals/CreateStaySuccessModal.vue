<template>
  <div class="modal" ref="modal">
    <div class="modal__wrapper" @click.stop>
        <!-- Header -->
      <div class="modal__header">
        <h3 class="header-title">Listing confirmation</h3>
      </div>
        <!-- Body -->
      <div class="modal__body">
        <p class="body-text">You created a new listing</p>
        <div class="icon">
          <img class="img" src="/img/tick-icon.png">
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "CreateStaySuccessModal",
  props: {
    confirmation: Boolean
  },
  watch: {
    '$props.confirmation'(opened) {
      if (opened) {
        this.$refs.modal.classList.add('visible')
      } else {
        this.$refs.modal.classList.remove('visible')
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.modal {
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
    .modal__wrapper {
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
    border-bottom: 1px solid $lightGrey;
    padding: 1rem;
    .header-title {
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
      font-size: 1.2rem;
    }
    .icon {
      text-align: center;
      margin-top: 2rem;
      .img {
        width: 3rem;
      }
    }
  }
}
</style>