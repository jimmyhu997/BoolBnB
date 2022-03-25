<template>
  <div>
    <div  class="filters">
      <select name="yearSelector" id="years" v-model="selected_year" @change="UpdateData(chart, selected_slug)">
        <option v-for="year, index in this.uniqueYears" :key="index"  :value="year">{{year}}</option>
      </select>
      <select name="yearSelector" id="years" v-model="selected_slug" @change="UpdateData(chart, selected_slug)">
        <option value="">Select A Stay For the Filtered Data</option>
        <option v-for="apartment, index in this.namesData" :key="index+10"  :value="apartment.slug">{{apartment.title}}</option>
      </select>
    </div>
    <canvas  ref="mychart"  ></canvas>
  </div>
</template>

<script>
import Chart from 'chart.js'
import data from '../../../vue-commons/vueGlobal'
export default {
  name:'charts',
  props:{
    dataSet: String
  },
  data(){
    return{
      data,
      slugData: [],
      namesData : [],
      visistsData: [],
      chart:null,
      baseSet: {
        year: null,
        data: [],
      },
      stays: [],
      uniqueYears: [],
      selected_year: null, //place holder si deve modificare con la data attuale
      selected_slug: ''
    }
  },
  methods:{
    randomRGB(){
      return `rgb(${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)},${Math.floor(Math.random() * 255)})`
    },
    UpdateData(chart, slug){
      let newDataset = [
        {
          label: slug ? `Total visits in ${this.selected_year}` : `Total visits in ${this.selected_year} of `,
          backgroundColor: `transparent`,
          borderColor: `rgb(252, 28, 74)`,
          data: [],
        }
      ]
      let setup = [0,0,0,0,0,0,0,0,0,0,0,0]
      // let month = data.months[parseInt(splittedDate[1])-1]
      this.visistsData.forEach(data =>{
        let splittedDate = data.created_at.split('-')
        let year = dayJs(data.created_at).format('YYYY')
        let month = dayJs(data.created_at).format('MM')
          // parte di logica di miglliorare in quanto c'è codice ripetuto, questo semplicemente se esiste uno slug allora fa il controllo anche su quello
          if (slug){
            if (year == this.selected_year && this.selected_slug == data.slug){
              setup[parseInt(month)-1] += 1
            }
          } else {
            if (year == this.selected_year){
              setup[parseInt(month)-1] += 1
            }
          }
      })
      if (this.selected_year == dayJs().format('YYYY')){
        for (let i = 0; i < parseInt(dayJs().format('MM')); i++){
          newDataset[0].data.push(setup[i])
        }
      } else{
        newDataset[0].data = setup
      }
      chart.data.datasets = newDataset
      chart.update();
    }
  },
  created(){
    let date= new Date()
    this.selected_year = date.getFullYear()
    this.baseSet.year = this.selected_year
  },
  mounted(){
    let month_visit = {}
    //chiamata axios per ricevere tutti i dati (VisitController)
    axios.get(`/user/get-info-${this.dataSet}`).then((response)=>{
      this.visistsData = response.data
      response.data.forEach(item => {
        //Per ogni elemento va a dare un nome allanno ed al mese
        let splittedDate = item.created_at.split('-')
        let year = splittedDate[0]
        //il mese viene convertito in una string del nome del mese associato, i dati sono nel documento importato per DATA
        let month = data.months[parseInt(splittedDate[1])-1]
        // Se l'anno non è presente nell'elemento creato prima allora va a creare il mese con un valore, oppure va alla key ed aggiunge una visita
        if (year == this.selected_year){
          if(!(month in month_visit)){
            month_visit[month] = 1
          } else{
            month_visit[month] += 1
          }
        }
        // creazione di un elenco per i select dove saranno presenti slug degli stays
        if (!this.uniqueYears.includes(year)){
          this.uniqueYears.push(year)
        }
        this.uniqueYears.sort().reverse()
        if (!this.slugData.includes(item.slug)){
          let names = {
            slug: item.slug,
            title: item.title,
          }
          this.slugData.push(item.slug)
          this.namesData.push(names)
        }
      });
      // Dichiarazione dei tag per l'asse X della tabella
      const labels = data.months
      // creazione di un array che rappresenta i dati nella tabella
      let barData = []
      // dato che i mesi sono già ordinati si deve sistemare anche i dati in nomo ordinato nell'array
      // si cicla sui mesi, nel caso in cui in quel mese non ci siano stati visite allora mette uno zero, altrimento pusha il numero di visite allegato al mese
      for (let month of labels){
        if (month in month_visit){
          barData.push(month_visit[month])
        }
      }
      this.baseSet.data = barData
      //Creazione dei dati da mettere all'interno della tabella
      // in Dataset ogli oggetto rappresenta una categoria da mostrare con i propri dati
      const datacol = {
        labels: labels,
        datasets: [
          {
          label: `Visit of All Stays in ${this.selected_year}`,
          backgroundColor: `transparent`,
          borderColor: `rgb(252, 28, 74)`,
          data: barData,
          },
        ]
      };
      // Settaggio della configurazione della tabella
      const config = {
        type: 'line',
        data: datacol,
        options: {
          responsive: true,
          scales: {
            yAxes: [{
              display: true,
              stacked: true,
              beginAtZero: true,
              ticks:{
                min: 0,
                max: 250,
                stepSize: 15
              }
            }]
          }
        },
      };
      const myChart = new Chart (
        this.$refs.mychart,
        config
      );
      this.chart = myChart
      
    })
  }
}
</script>

<style lang="scss" scoped>

</style>