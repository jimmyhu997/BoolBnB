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

            <ul>
              <li class="message" v-for="(messaggio, i) in messaggi" :key="i">
                <div class="title">
                  <span class="message-title">{{messaggio.title}}</span>
                </div>

                <div class="user">
                  <img id="icon" src="//ssl.gstatic.com/ui/v1/icons/mail/profile_mask2.png" style="background-color: #cccccc">
                  
                  <div class="user-info">

                    <div class="name">
                      <span>{{messaggio.user}}</span>
                      <span><span>➥ </span><a class="email" href="https://www.instagram.com/giorgiomonne/?hl=it">{{messaggio.email}}</a></span>
                    </div>

                    <span id="date">{{messaggio.date}}</span>
                  </div>
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
            text: "Lorem ipsum, dolor sit amet consectetur adipisicing elit.",
            date: "13:20"         
          },
          {
            title: 'Hostel room',
            user: 'pasticcio',
            email: 'pasticcio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic.Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic." ,
            date: "13:20"             
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Studenti costretti a ripetere per 8 anni la stessa classe Centinaia di studenti di una scuola remota della Papua Nuova ..." ,
            date: "13:20"         
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic.",
            date: "13:20"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone" ,
            date: "13:20"         
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone",
            date: "13:20"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic.",
            date: "13:20"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: '1999giorgio.monne@gmail.com',
            text: "pippone",
            date: "11:20"          
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone",
            date: "09:20"         
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic.",
            date: "18:20"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone",
            date: "23:20"          
          }, 
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone",
            date: "22:20"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "Lorem ipsum dolor sit, amet consectetur adipisicing elit. Dignissimos, voluptatem iusto. Perferendis vero nisi porro omnis reprehenderit quo facilis consectetur repudiandae ipsa quibusdam? Mollitia doloribus quos explicabo rem praesentium hic.",
            date: "13:20"          
          },
          {
            title: 'Villa room',
            user: 'dio',
            email: 'dio@gmail.com',
            text: "pippone",
            date: "13:20"          
          }
        ]
      }
    },
    created() {
      axios.get('user/manage').then( (response) => {
        this.userInfo = response.data[0];
        console.log(this.userInfo);
      })
    },
    
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
    .dashboard-content {
      width: 96%;
      margin: 2rem auto ;

      h3 {
        padding: 2rem 0;
      }

      .card {
        width: 100%;
        border-radius: 1rem;
        padding: 1rem;
        border: .5px solid rgba(0, 0, 0, 0.1);
        background-color: $lightGrey;

        // .margine {
        //   height: 500px;
        // }

        // .search {
        //   margin: 1rem 0;

        //   input {
        //     width: calc(100% - 100px);
        //     padding: 5px;
        //     border-radius: .5rem;
        //   }

        //   button {
        //     width:90px;
        //     padding: 5px;
        //     border-radius: .5rem;
        //   }
        // }

        .top {
          display: inline-block;
          font-size: 1.2rem;
          font-weight: bold;
          padding-bottom: 1rem;
        }

        .messages {
          // margin: 1rem 0;
          height: 450px;
          overflow-y: auto;
          padding: 0 1rem;

          ul {
            
            li {
              width: 100%;
              margin: 1rem 0;
              // margin-bottom: .3rem;
              // margin-right: .2rem;
              border: .5px solid rgba(0, 0, 0, 0.3);
              border-radius: 1rem;
              list-style: none; 
              background-color: rgb(255, 255, 255);

              .title {
                width: 100%;
                padding: .7rem;
                font-weight: 300;
                font-size: 1.2rem;
                border-bottom: .5px solid rgba(0, 0, 0, 0.1);
              }
              
              .user {
                width: 100%;
                padding: .3rem .2rem;
                border-bottom: 1px solid lightgrey;
                display: flex;
                align-content: center; 

                #icon {
                  cursor: pointer;
                  border-radius: 50%;
                  margin: 0 .4rem  .2rem .2rem;
                }

                .user-info{
                  width: 100%;
                  display: flex;
                  justify-content: space-between;
                  align-items: center;

                  .name{
                    cursor: pointer;
                    .email {
                      color: black;
                      text-decoration: none;
                      font-size: 1rem;
                      &:hover {
                        text-decoration: underline;
                      }
                    }
                  }
                  
                  #date{
                    font-size: .8rem;
                    margin-right: .6rem;
                    color: rgb(182, 181, 181);
                  }
                }
              }

              .content {
                width: 100%;
                padding: .5rem .4rem;
                word-wrap: break-word;
                font-weight: 300;
                color: #333;
                padding: 1rem;     
              }
            }
          }
        }

        .empty {
          width: 100%;
          padding: 4rem;
          margin: 1rem 0;
          border-radius: 1.5rem;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;

          span {
            font-weight: bold;
          }
        }
      }
    }
</style>
