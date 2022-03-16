<template>
  <div class="container">

    <div class="menu">
        dfgdf
    </div>

    <div class="messages">
fghfgh
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
              message: {
                content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                email: "ciccio@gmnail.com",
                date: "12:20"
              }
            },
            {
              name: 'Hostel room',
              message: {
                content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                email: "ciccio@gmnail.com",
                date: "12:20"
              }
            },
            {
              name: 'Apartment room',
              message: {
                content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                email: "ciccio@gmnail.com",
                date: "12:20"
              }
            },
            {
              name: 'Villa room',
              message: {
                content: "sdf sdfg sdfg sdf sdf s drh sdfh  sdfh sdf sdf hgsdfh",
                email: "ciccio@gmnail.com",
                date: "12:20"
              }
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
    background-color: aquamarine;

    // .menu{

    // }
    // .messages{

    // }
  }

</style>