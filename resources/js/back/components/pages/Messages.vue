<template>
  <div class="contenitore">

    <div class="left">
      
      <div class="menu">

        <!-- IN LAVORAZIONE (MANCANO DELLE MODIFICHE) -->
        <div class="hamburger-menu">
              <ul class="listato">
                <li v-for="(stay , index) in stays" :key="index" >

                  <div class="mini-card" @click="changeStay(index)">
                    
                    <div class="content">

                      <span class="title ">{{stay.title}}</span>
                      <span class="time ">data last message</span>

                    </div>

                  </div>

                </li>
              </ul>

            <div class="close">
              <span>chiudi</span>
            </div>

        </div>
        <!-- IN LAVORAZIONE (MANCANO DELLE MODIFICHE) -->

        <span class="build-ads">Annunci</span>
      </div>

      <div class="stays">
        <ul class="hambg-list">
          <li class="list" v-for="(stay , index) in stays" :key="index" >

            <div class="mini-card" @click="changeStay(index)">
              
              <div class="content">
                <img src="" alt="Icona">
                 <span class="title">{{stay.title}}</span>
                <span class="time">data last message</span>

              </div>

            </div>

          </li>
        </ul>
      </div>

    </div>

    <div class="messages">
      <div class="title">
        <div>
          <h2>Titolo annuncio</h2>
        </div>
      </div>
       <div class="message" v-if="stays.length > 0">
        <div class="messages-box" v-for="message in stays[currentStay].messages" :key="message.id">
          <div class="date">
            <span class="day">Today</span> <span class="dot">•</span> <span>{{message.date}}</span>
          </div>
          <div class="head-message">
            <div class="name">
              {{message.name}}
            </div>
            <div class="mail">
              {{message.email}}
            </div>
          </div>
          <div class="main-message">
            <div>
              {{message.content}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
export default {
    name: 'Messages',
    data() {
      return {
        currentStay : 0,
        stays : []
      }
    },
    created() {
        axios.get("/user/messages").then( (response) => {
          this.stays = response.data;
        })
    },
    methods: {
      changeStay: function(index){
        this.currentStay = index;
      }
    },   
    menu : function (){
      const openMenu = document.querySelector(".header-right > .icone");
      const closeMenu = document.querySelector(".close");

    // ***creo le funzioni

    openMenu.addEventListener("click", function(){
        document.querySelector(".hamburger-menu").classList.add("active")
    });

    closeMenu.addEventListener("click", function(){
        document.querySelector(".hamburger-menu").classList.remove("active")
    });
    }   
}


</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
  
  .contenitore { 
    height: 70vh;
    max-width: 1750px;
    margin:1rem auto;
    padding: 0 4.8rem;
    display: flex;

    .left {
      width: 450px;
      border: .8px solid $lightGrey;

      .menu {
        padding: .5rem .5rem;

        .hamburger-menu {
            .listato {
              list-style: none;
              height: 100%;
              text-align: right;
            }
        }

        .build-ads {
          padding-left: 1rem;
          font-size: 1.6rem;
          font-weight: bold;
        }
      }

      .stays {
        width: 300px;
        margin: 1rem 1rem;
        overflow-y: auto;

        .mini-card{
          padding: 2rem 1rem;
        }
      }

      .stays li {
        border-bottom: 1px solid $lightGrey;
        display: none;
      }

      .stays ul{
        list-style: none;
      }

      .stays ul li {
        display: inline-block;     
      }

      .hamburger-menu {
        display: none;
        width: 100%;
        height: 100%;
        min-width: 100vw;
        min-height: 100vh;
        background-color: $cyan;
      }

      .hamburger-menu ul{
        display: flex;
        height: 100%;
        flex-direction: column;
        justify-content: space-around;
        align-items: flex-start;
        list-style: none;
      }

      .hamburger-menu ul li .mini-card {
        color: white;
      }

      .content{
        display: flex;
        justify-content: space-between; 
      }
    }

    // DIVISIONE


    .messages{
      width: 100%;

      // HO MODIFICATO UN PO PER AGGIUSTARE LA GRAFICA
      border: .5px solid $lightGrey; 
      border-left:none;
      overflow-y: auto;
      // HO MODIFICATO UN PO PER AGGIUSTARE LA GRAFICA

      .title{
        display: flex;
        justify-content: space-between;
        margin: 0 auto;
        padding-top: 10px;
        width: 80%;
      }
      
      .message{

        .messages-box{
        width: 75%;
        margin: 0 auto;
        padding: 25px 0;
        &:not(:last-of-type){
        border-bottom: 0.5px solid rgba(0,0,0,0.1);
      }
      }
      
        
        .date{
          display: flex;
          justify-content: center;
          margin-bottom: 20px;
          color: #717171;
          font-size: 14px ;
          .day{
            font-weight: 600;
          }
          .dot{
            margin: 0 5px;
          }
        }
        .head-message{
          display: flex;
          flex-direction: column;
          font-weight: 500;
          @media screen and (min-width: $medium) {
            flex-direction: row; 
            justify-content: space-between;
            margin-bottom: 10px;
          }
          .name{
            font-weight: 600;
          }
          .mail{
            margin: 10px 0;
            @media screen and (min-width: $medium) {
              margin: 0;
            }
          }
        }
        .main-message{
          font-weight: 300;
        }
      }
    }
  }

</style>