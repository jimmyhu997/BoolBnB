<template>
  <div class="apartments container">
    <div class="apartments__header">
      <h2 class="header-title">All your listings</h2>
      <router-link class="header-btn large" :to="{name: 'create-stay'}">Add a new listing</router-link>
      <router-link class="header-btn small" :to="{name: 'create-stay'}">+</router-link>
    </div>
    <div class="apartments__wrapper" v-if="stays.length > 0">
      <ul class="apartments__list">
        <li class="apartment" v-for="stay in stays" :key="stay.id">
          <a class="apartment__link" :href="'/apartment/' + stay.id" :title="stay.title">
          <div class="apartment__preview">
            <img class="img" :src="'/storage/' + stay.image_path" :alt="stay.title + ' preview'">
          </div>
            <h3 class="apartment__title">
              {{stay.title}}
            </h3>
          </a>
          <div class="informations">
            <div class="options">
              <!-- <span>Show</span> -->
            </div>
            <div class="actions">
              <div class="edit">
                <router-link class="link" :to="{name:'edit-stay', params:{stay: stay.id}}">Edit</router-link>
              </div>
              <div class="delete">
                <button class="link" @click.stop="deleteConfirmation(stay)">Delete</button>
              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <p class="no-apartments" v-else>You don't have any listing, start creating a new one.</p>
    <DeleteModal :apartment="apartmentToDelete" @delete="refresh()"/>
  </div>
</template>

<script>
import DeleteModal from '../../modals/DeleteModal.vue'
import data from '../../../../vue-commons/vueGlobal'
export default {
    name: 'Stays',
    components: { DeleteModal },
    data() {
    return {
      data,
      stays: [],
      apartmentToDelete: {}
    }
    },

    created() {
      axios.get("/user/stays").then( (response) => {
          this.stays = response.data[0];
      });
    },

    methods: {
      deleteConfirmation(stay) {
        this.apartmentToDelete = stay
        data.deleteOpened = true
      },
      refresh() {
        axios.get("/user/stays").then( (response) => {
            this.stays = response.data[0];
        });
      }
    }
}
</script>

<style lang="scss" >
@import '../../../../../sass/_variables.scss';
.apartments {
  margin-top: 1rem;
  @media screen and (min-width: $medium) {
    margin-top: 2rem;
  }
  &__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
    .header {
      &-title {
        font-weight: 500;
      }
      &-btn {
        border: 1px solid black;
        color: black;
        text-decoration: none;
        transition: background-color .2s;
        &.small {
          flex-shrink: 0;
          border-radius: 50%;
          height: 2.4rem;
          width: 2.4rem;
          display: flex;
          justify-content: center;
          align-items: center;
          font-size: 1.7rem;
          font-weight: 300;
        }
        &.large {
          display: none;
          border-radius: .7rem;
          padding: 1rem 2rem;
        }
        @media screen and (min-width: $medium) {
          &.large {
            display: inline-block;
          }
          &.small {
            display: none;
          }
        }
        &:hover {
          background-color: rgba(0, 0, 0, .02);
        }
      }
    }
  }
  .no-apartments {
    display: inline-block;
    padding: 1rem;
    font-size: 1.3rem;
    font-weight: 300;
  }
  &__wrapper {
    border-radius: 1rem;
    border: .5px solid rgba(0, 0, 0, .2);
  }
  &__list {
    list-style: none;
    .apartment {
      padding: 1rem;
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      flex-direction: column;
        overflow: hidden;
      @media screen and (min-width: $small) {
        flex-direction: row;
        align-items: center;
      }
      &__link {
        color: black;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        width: 100%;
        transition: color .2s;
        @media screen and (min-width: $small) {
          max-width: 75%;
          flex-direction: row;
          align-items: center;
        }
        &:hover {
          color: $pink;
        }
      }
      &__preview {
        flex-shrink: 0;
        width: 100%;
        height: 40vw;
        margin-bottom: 1rem;
        @media screen and (min-width: $small) {
          margin-bottom: 0;
          margin-right: 1rem;
          width: 5rem;
          height: 3rem;
        }
        .img {
          object-fit: cover;
          object-position: center;
          width: 100%;
          height: 100%;
          border-radius: .2rem;
        }
      }
      &__title {
        font-weight: 400;
        width: 100%;
        display: inline-block;
        white-space: normal;
        overflow: hidden;
        text-overflow: ellipsis;
      }
      .informations {
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        // .options {

        // }
        .actions {
          display: flex;
          align-items: center;
          justify-content: center;
          .link {
            text-decoration: none;
            font-weight: 600;
            font-size: .9rem;
            color: black;
            cursor: pointer;
            border: none;
            background-color: transparent;
            margin-left: 1rem;
            @media screen and (min-width: $medium) {
              margin-left: 2rem;
            }
          }
          .edit {
            .link {
              &:hover {
                text-decoration: underline;
              }
            }
          }
          .delete {
            .link {
              transition: color .2s;
              &:hover {
                color: red;
              }
            }
          }
        }
      }
    }
    .apartment:not(:last-of-type) {
      border-bottom: .5px solid rgba(0, 0, 0, .2);
    }
  }
}
</style>