<template>
  <div class="contenitore">

    <div class="left">
    </div>

    

    <div class="messages">
      <div class="title">
        <div>
          <h2>Titolo annuncio</h2>
        </div>
      </div>
      <div class="messages-box" v-for="(message,i) in stays[0].messages" :key="i">
       <div class="message">
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
    <nav role="navigation">
      <div id="menuToggle">
        <!--
        A fake / hidden checkbox is used as click reciever,
        so you can use the :checked selector on it.
        -->
        <input type="checkbox" name="checkbox">
        
        <!--
        Some spans to act as a hamburger.
        
        They are acting like a real hamburger,
        not that McDonalds stuff.
        -->
        <span></span>
        <span></span>
        <span></span>
        
        <!--
        Too bad the menu has to be inside of the button
        but hey, it's pure CSS magic.
        -->
        <ul class="menu">
          <h4>Annunci</h4>

          <li v-for="(stay , i) in stays" :key="i" >{{stay.title}}</li>

        </ul>
      </div>
    </nav>

    <div class="content">
      Lista messaggi cada Annuncio
    </div>

  </div>

</template>

<script>
export default {
    name: 'Messages',
    data() {

      return {

        stays : [
            {
              title: 'Hotel room',
              message:
              [
                {
                  content: "ciao sono interessato al tuo annucio",
                  email: "ciccio@gmnail.com",
                  name:"giorgio",
                  date: "12:20"
                },
                {
                  content: "mi interessa il tuo appartamento",
                  email: "franco@gmnail.com",
                  name:"franco",
                  date: "14:20"
                },
                {
                  content: "che prezzo mi fai per il tuo appartamento,che prezzo mi fai per il tuo appartamento",
                  email: "pippo@gmnail.com",
                  name:"pippo",
                  date: "15:20"
                }
              ] 
            },
            {
              title: 'Hotel room',
              message:
              [
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                }
              ] 
            },
            {
              title: 'Hotel room',
              message:
              [
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                },
                {
                  content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                  email: "ciccio@gmnail.com",
                  date: "12:20"
                }
              ] 
            }
        ]
      }
    },
    methods: {
      
    }
    
}


</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
  
  .contenitore { 
    height: 71vh;
    position: relative;
      margin: 0;
      padding: 0;
      background: #ffffff;
      color: black;

    .content {
      position: absolute;
      width: 100%;
      left: 100px;
      top: 50px;
      // background-color: aqua;
    }

    .navigation {
      width: 300px;
      background-color: antiquewhite;
    }

    .messages{
      width: 100%;
      .title{
        display: flex;
        justify-content: space-between;
        margin: 0 auto;
        margin-bottom: 50px;
        width: 80%;
      }
      .messages-box{
        width: 75%;
        margin: 0 auto;
      }
      .message{
        border-bottom: 0.5px solid rgba(0,0,0,0.1);
        padding: 25px 0;
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
          .name{
            font-weight: 600;
          }
        }
        .main-message{
          font-weight: 300;
        }
      }
    }

    #menuToggle {
      display: block;
      position: relative;
      top: 50px;
      left: 50px;     
      z-index: 1;     
      -webkit-user-select: none;
      user-select: none;
    }

    #menuToggle a {
      text-decoration: none;
      color: #232323;      
      transition: color 0.3s ease;
    }

    #menuToggle a:hover {
      color: tomato;
    }


    #menuToggle input {
      display: block;
      width: 40px;
      height: 32px;
      position: absolute;
      top: -7px;
      left: -5px;     
      cursor: pointer;      
      opacity: 0; 
      z-index: 2;     
      -webkit-touch-callout: none;
    }

    #menuToggle span {
      display: block;
      width: 33px;
      height: 4px;
      margin-bottom: 5px;
      position: relative; 
      background: #cdcdcd;
      border-radius: 3px;
      z-index: 1;  
      transform-origin: 4px 0px;
      transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
                  background 0.5s cubic-bezier(0.77,0.2,0.05,1.0),
                  opacity 0.55s ease;
    }

    #menuToggle span:first-child {
      transform-origin: 0% 0%;
    }

    #menuToggle span:nth-last-child(2)
    {
      transform-origin: 0% 100%;
    }

    #menuToggle input:checked ~ span {
      opacity: 1;
      transform: rotate(45deg) translate(-2px, -1px);
      background: #232323;
    }

    #menuToggle input:checked ~ span:nth-last-child(3) {
      opacity: 0;
      transform: rotate(0deg) scale(0.2, 0.2);
    }

    #menuToggle input:checked ~ span:nth-last-child(2) {
      transform: rotate(-45deg) translate(0, -1px);
    }

    .menu {
      position: absolute;
      width: 100%;
      height: 74.1vh;
      margin: -100px 0 0 -50px;
      padding: 50px;
      padding-top: 125px;
      background: #ededed;
      list-style-type: none;
      -webkit-font-smoothing: antialiased;
      transform-origin: 0% 0%;
      transform: translate(-100%, 0); 
      transition: transform 0.5s cubic-bezier(0.77,0.2,0.05,1.0);
    }

    .menu li {
      padding: 10px 0;
      font-size: 22px;
    }

    #menuToggle input:checked ~ ul {
      transform: none;
    }

    @media screen and (min-width: $medium) {

      .menu {
        width: 300px;
      }


    }
  }

</style>