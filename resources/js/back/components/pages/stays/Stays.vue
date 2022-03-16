<template>
  <div class="apartments container">
    <PageHeading :title="'All your listings'" :button="{ route: 'create-stay', desktop: 'Add a new listing', mobile: '+' }"/>
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
import PageHeading from '../../commons/PageHeading.vue'
import data from '../../../../vue-commons/vueGlobal'
export default {
    name: 'Stays',
    components: { DeleteModal, PageHeading },
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
        margin-bottom: 1rem;
        @media screen and (min-width: $small) {
          width: auto;
          max-width: 75%;
          flex-direction: row;
          align-items: center;
          margin-bottom: 0;
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