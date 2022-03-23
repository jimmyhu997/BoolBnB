<template>
  <div class="contenitore">

    <div class="colonna" ref="menuHamb">
      <div class="wrapper" :class="{'background': showMenu }" @click="changeMenu()">
          <div class="hamburger">
            <div class="menulogo"></div>
            <div class="menulogo"></div>
            <div class="menulogo"></div>
          </div>

          <span class="ads">Listings</span> 
      </div>

      

        <div class="menu" ref="menu"> 
              
          <ul class="listato">
            <li class="list" v-for="(stay , index) in stays" :key="index">

              <div class="mini-card" @click="changeStay(index)">                
                <div class="content">

                  <span class="title" :class="{'selected' : currentStay == index }">{{stay.title}}</span>
                  <span class="data"></span>

                </div>
              </div>

            </li>
          </ul>
        </div>
    </div>

    <!-- spazio -->
    <!-- spazio -->
    <!-- spazio -->
    <!-- spazio -->

    <div class="messages" ref="activeMessages"  v-if="stays.length > 0  && visual" >
      <div class="title">
        <div>
          <h2>{{stays[currentStay].title}}</h2>
        </div>
      </div>
       <div class="message" v-if=" stays[currentStay].messages == 0">
        <p class="no-message">There are no messages for this listing.</p>
      </div>
      <div class="message" v-else>
        <div class="messages-box" v-for="message in stays[currentStay].messages.slice().reverse()" :key="message.id">
          <div class="date">
            <span class="day">{{getDay(message.created_at)}}</span> <span class="dot">•</span> <span>{{getHour(message.created_at)}}</span>
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
        visual: true,
        showMenu: false,
        currentStay : 0,
        strin : "",
        stays : []
      }
    },
    created() {
        axios.get("/user/messages").then( (response) => {
          this.stays = response.data;
          if(window.innerWidth >= 744){
            this.showMenu = true;
          }else {
            this.showMenu = false;
          }
        })
    },
    methods: {
      changeStay: function(index){
        this.currentStay = index
        if(this.showMenu && window.innerWidth < 744){
          this.showMenu = false;
        }

      },
      changeMenu: function(){
        if(this.showMenu == false){
          this.showMenu = true; 
        }
        else{
          this.showMenu = false
        }
      },
      getDay: function(date){
        if(dayJs().format('DD/MM/YYYY') == dayJs(date).format('DD/MM/YYYY')){
          return 'Today'
        }else{
          return dayJs(date).format('DD/MM/YYYY')
        }
      },
      getHour: function(date){
        return dayJs(date).format('HH:mm')
      }
    },
    mounted() {
      window.addEventListener('resize' , () => {
        if(window.innerWidth >= 744) {
          this.visual = true;
          this.showMenu = true;
        }else if(this.showMenu){
          this.showMenu = false;
          this.visual = true;
        }
      });
    },
    watch: {
      '$data.showMenu'(menu) {
        if(menu) {
          this.$refs.menu.classList.add('active');
          this.$refs.menuHamb.classList.add('active');
          if(window.innerWidth < 744) {
            this.visual = false;
          }
        }else{
          this.visual = true;
          this.$refs.menu.classList.remove('active');
          this.$refs.menuHamb.classList.remove('active');
        }
      }
    }

}


</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
  
  .contenitore { 
    height: 70vh;
    min-width: 380px;
    max-width: 1440px;
    margin: 0 auto;
    border: .2px solid $lightGrey;
    border-radius: .4rem;
    display: flex;

    .colonna{
      width: 0;
      display: flex;
      flex-direction: column;
      background-color: #fafafa;
    }

    .wrapper {
      width: 100%;
      margin: 0 auto;
      position: fixed;
      z-index: 999;
      display: flex;
      align-items: center;
    }

    .background {
      background-color: #fafafa;
    }

    .hamburger {
      height: 1rem;
      width: 30px;
      margin: 1.4rem 1rem;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      align-items: center;
      cursor: pointer;
    }

    .menulogo{
      height: 2px;
      width: 1.3rem;
      background-color: black;
    }
    .menu {
      width: 100%;
      height: 70vh;
      padding: 3.5rem 1.5rem;
      overflow-y: auto;
      transform: translateX(-2000px);
      transition: 0s;
      scrollbar-width: none;
    }

    .menu li {
      list-style-type: none;
      border-bottom: .5px solid $lightGrey;
    }

    .active {
      width: 100%;
      transform: translateX(0);
    }

    .menu li:last-child {
      border-bottom: none;
    } 

    .menu li:last-first .mini-card {
      font-weight: bold;
    } 

    .menu li .mini-card {
      color: rgb(150, 150, 150);
      text-decoration: none;
      font-size: 1.1rem;
      transition: font-weight 0.2s , color 0.2s;
      cursor: pointer;
      padding: 1.4rem 0.5rem;
    }   
    
    .menu li .mini-card:hover , .selected{
      font-weight: 500;
      color: black;
    }   

    .content{
      display: flex;
      justify-content: space-between;
    }

    .ads{
      font-weight: 500;
      font-size: 1.3rem;
      color: black;
    }


    // DIVISIONE


    .messages{
      width: 100%;

      // HO MODIFICATO UN PO PER AGGIUSTARE LA GRAFICA
      border: .5px solid $lightGrey; 
      border-left:none;
      overflow-y: auto;
      padding: 0 6rem;

      .title{
        display: flex;
        justify-content: center;
        margin: 0 auto;
        padding-top: 10px;
        width: 80%;
      }
      
      .message{
        .no-message{
          text-align: center;
          margin-top: 100px;
          font-size: 18px;
          font-weight: 500;
        }

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
          padding-bottom: 1rem;
        }
      }
    }
  }

  @media screen and (min-width: $medium) {

      .contenitore{

        .active {
          width: 300px;
        }

        .messages {

          .message {
          .head-message {
            display: flex;
            justify-content: space-between;
            flex-direction: row;

          .mail{
            margin: 0 1rem;
          }
          }
        }
        }
      }       
  }



</style>