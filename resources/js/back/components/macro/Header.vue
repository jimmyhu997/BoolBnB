<template>
  <header>
    <div class="icon">
      <a href="/"><img src="" alt=""><h3>icona</h3></a>
    </div>
    <div class="middle_menu">
      <ul>
        <li><router-link :to="{name:'dashboard'}">Dashboard</router-link></li>
        <li v-for="option,index in this.menu" :key="index" ><router-link :to="{name:'stays'}">My Apartment</router-link></li>
      </ul>
      
    </div>
    <div class="profile_options"> 
      <button @click="logout()">Logout</button>

    </div>
  </header>
</template>

<script>
export default {
    name: 'Header',
    data(){
      return {
        menu: ['My Apartment']
      }
    },
    methods: {
      logout() {
        axios.post("/logout")
          .then((response) => {
            location.href = '/'
          })
          .catch((error) => {
            console.log("sconfitta");
          });
      },
  },
}
</script>

<style lang='scss' scoped>
  header{
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: black;
    height: 200px;
    color: white;
    .icon{
      color: inherit;
      a{
        color:white;
        text-decoration: none;
      }
    }
    .middle_menu{
      color: inherit;
      ul{
        display: flex;
        list-style: none;
        li{
          margin: 20px;
          a{
            text-decoration: none;
            color: inherit;
          }
        }
      }
    }
  }
</style>