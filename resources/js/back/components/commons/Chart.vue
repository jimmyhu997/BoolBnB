<template>
  <div>
    <button>fjasfsjaoi</button>
    <canvas  ref="mychart"  ></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js'
import Data from '../../../vue-commons/vueGlobal'
export default {
  name:'charts',
  props:{
    dataSet: String
  },
  data(){
    return{
      Data,
      stays: {},
      test: {},
      days: 0,
      selected_year: '2021', //place holder si deve modificare con la data attuale
      selected_slug: ''
    }
  },
  methods:{
    
    
  },
  created(){
    
  },
  mounted(){
    let mounth_visit = {}
    axios.get(`/user/get-info-${this.dataSet}`).then((response)=>{
      response.data.forEach(data => {
        let splittedDate = data.created_at.split('-')
        let year = splittedDate[0]
        let month = Data.months[parseInt(splittedDate[1])-1]
        if (year == this.selected_year){
          if(!(month in mounth_visit)){
            mounth_visit[month] = 1
          } else{
            mounth_visit[month] += 1
          }
        }
      });
      const labels = Data.months
      let barData = []
      for (let month of labels){
        if (month in mounth_visit){
          barData.push(mounth_visit[month])
        }else{
          barData.push(0)
        }
      }
      const data = {
        labels: labels,
        datasets: [
          {
          label: `Your visit in ${this.selected_year}`,
          backgroundColor: `rgb(0, 251, 87)`,
          borderColor: 'rgb(255, 99, 132)',
          data: barData,
          },
        ]
      };
      const config = {
        type: 'bar',
        data: data,
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        },
      };
      const myChart = new Chart (
        this.$refs.mychart,
        config
      );
    })
  }
}
</script>

<style lang="scss" scoped>

</style>