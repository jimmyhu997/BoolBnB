<template>
    <div class="dashboard-content">
      <h3>Welcome {{userInfo.name}}</h3>
      <!-- <button @click="deleteUser()">Cancella Account</button>
      <router-link :to="{name:'create-stay'}">Nuovo annuncio</router-link> -->

      <div class="card">
        <div class="margine">
          <span class="top">All messages</span>
          <!-- <div class="search">
            <input type="text" placeholder="Cerca messaggio ...">
            <button type="submit">Cerca</button>
          </div> -->

          <div class="messages" v-if="messaggi != '' ">

            <ul v-for="(messaggio, i) in messaggi" :key="i">
              <li>
                <div class="title">
                  <span>{{messaggio.title}}</span>
                </div>

                <div class="user">
                  <span>{{messaggio.user}} - {{messaggio.email}}</span>
                </div>

                <div class="content">
                  <p>{{messaggio.text}}</p>
                </div>

              </li>
            </ul>
          </div>

          <div v-else class="empty">
              <span>No result founds</span>
              <p>No messages found</p>
          </div>
        </div>
      </div>

      <!-- <div class="card">
        <span class="top">New messages</span>
        <div class="search">
          <input type="text" placeholder="Cerca messaggio ...">
          <button type="submit">Cerca</button>
        </div>

        <div class="messages" v-if="messaggi != '' ">
          <ul v-for="(messaggio, i) in messaggi" :key="i">
            <li>
              <div class="user">
                <span>{{messaggio.title}} - Use: {{messaggio.user}} - New Message</span>
              </div>

              <div class="content">
                <span>{{messaggio.text}}</span>
              </div>
            </li>
          </ul>
        </div>

        <div v-else class="empty">
            <span>No result founds</span>
            <p>No messages found</p>
        </div>

      </div> -->
    </div>
</template>

<script>

import '../../../../sass/_variables.scss';

export default {
    name: 'Dashboard',
    data() {
      return {
        userInfo: {},
        messaggi: [
          {
            title: 'Hotel room',
            user: 'pippofranco',
            email: 'pippo@gmail.com',
            text: "Lorem ipsum, dolor sit amet consectetur adipisicing elit."         
          },
          {
            title: 'Hostel room',
            user: 'pasticcio',
            email: 'pasticcio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic.Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic."          
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Studenti costretti a ripetere per 8 anni la stessa classe Centinaia di studenti di una scuola remota della Papua Nuova ..."          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic."          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic."          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic."          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic."          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone"          
          }
        ]
      }
    },
    created() {
      axios.get('user/manage').then( (response) => {
        this.userInfo = response.data;
      })
    },
    
}
</script>

<style lang="scss" scoped>
    .dashboard-content{
      width: 96%;
      margin: 2rem auto ;

      h3{
        padding: 2rem 0;
      }

      .card{
        width: 100%;
        border-radius: 0.4rem;
        padding: 1rem;
        border: 1px solid rgb(115, 146, 169);
        background-color: rgb(135, 173, 255);

        .margine{
          height: 500px;
        }

        .search{
          margin: 1rem 0;

          input{
            width: calc(100% - 100px);
            padding: 5px;
            border-radius: 0.5rem;
          }

          button{
            width:90px;
            padding: 5px;
            border-radius: 0.5rem;
          }
        }

        .top{
          font-size: 1.2rem;
          font-weight: bold;
        }

        .messages{
          margin: 1rem 0;
          height: 450px;
          overflow-y: auto;

          ul {
            cursor: pointer;
            li {
              width: 99%;
              margin-bottom: 0.3rem;
              margin-right: 0.2rem;
              border: 1px solid grey;
              border-radius: 0.5rem;
              list-style: none; 
              background-color: rgb(255, 255, 255);
              
              .title, .user{
                width: 100%;
                padding: 0.3rem 0.1rem;
              }

              .title{
                font-weight: bold;
                border-bottom: 1px solid grey;
              }

              .content{
                width: 100%;
                padding: 0.5rem 0.2rem;
                word-wrap: break-word;               
              }
            }
          }
        }

        .empty{
          width: 100%;
          padding: 4rem;
          margin: 1rem 0;
          border-radius: 1.5rem;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;

          span{
            font-weight: bold;
          }
        }
      }
    }
</style>