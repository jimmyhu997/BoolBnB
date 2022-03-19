<template>
  <div class="contenitore">

    <div class="colonna" ref="menuHamb">
      <div class="wrapper" @click="changeMenu()">
          <div class="hamburger">
            <div class="menulogo"></div>
            <div class="menulogo"></div>
            <div class="menulogo"></div>
          </div>

      </div>

      

        <div class="menu" ref="menu" :v-if="!showMenu"> 
          <span class="ads">Annunci</span>     
          <ul class="listato">
            <li class="list" v-for="(stay , index) in stays" :key="index">

              <div class="mini-card" @click="changeStay(index)">                
                <div class="content">

                  <span class="title">{{stay.title}}</span>
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
       <div class="message">
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
        visual: true,
        showMenu: false,
        currentStay : 0,
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
      // stringa: function(){
      //   let data = this.stays.created_at.substring(0,9);
      // }

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
    // margin:1rem auto;
    border: .2px solid $lightGrey;
    border-radius: .4rem;
    // background-color: aquamarine;
    display: flex;

    .colonna{
      width: 0;
      display: flex;
      flex-direction: column;
      background-color: $lightGrey;
    }

    .wrapper {
      width: 100%;
      margin: 0 auto;
    }

    .hamburger {
      position: fixed;
      z-index: 999;
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
      padding: 5rem 2rem;
      transform: translateX(-2000px);
      transition: 0s;
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
      font-size: 20px;
      transition: font-weight 0.2s;
      cursor: pointer;
      padding: 20px 0;
    }   
    
    .menu li .mini-card:hover {
      font-weight: bold;
    }   

    .content{
      display: flex;
      justify-content: space-between;
    }

    .ads{
      font-weight: bold;
      color: grey;
    }


    // DIVISIONE


    .messages{
      width: 100%;

      // HO MODIFICATO UN PO PER AGGIUSTARE LA GRAFICA
      border: .5px solid $lightGrey; 
      border-left:none;
      overflow-y: auto;
      padding: 0 6rem;

      // .activeMessages{
      //   display: hidden;
      // }

      .title{
        display: flex;
        justify-content: center;
        margin: 0 auto;
        margin-bottom: 50px;
        padding-top: 25px;
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
          margin-bottom: 10px;
          padding-bottom: 1rem;
          .name{
            font-weight: 600;
            // background-color: beige;
          }
          .mail{
            margin: 10px 0;
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
          // background-color: aquamarine;

          // // .name {
          // //   // width: 80%;
          // // }

          .mail{
            // width: 20%;
            margin: 0 1rem;
            // background-color: red;
          }
          }
        }
        }
      }       
  }



</style>