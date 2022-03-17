<template>
  <div class="container">

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
              name: 'Hotel room',
              messages:
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
              name: 'Hotel room',
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
              name: 'Hotel room',
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
            }
        ]
      }
    }
}


</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';

  .container{ 
    display: flex;
    
    

    // .left{

    // }

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
  }

</style>