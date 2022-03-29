<template>
  <div class="chart-section">
    <div class="filters">
      <div class="year-menu">
        <button class="option-btn" @click="data.yearsOpened = true; data.listingsOpened = false;">
          {{selected_year}}
          <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><g fill="none"><path d="m28 12-11.2928932 11.2928932c-.3905243.3905243-1.0236893.3905243-1.4142136 0l-11.2928932-11.2928932"></path></g></svg>
        </button>
        <div class="menu" v-if="data.yearsOpened">
          <ul class="list">
            <li class="item" v-for="year, index in this.uniqueYears" :key="index" @click="selected_year = year; data.yearsOpened = false; UpdateData(chart, selected_title)">{{year}}</li>
          </ul>
        </div>
      </div>
      <div class="apartment-menu">
        <button class="option-btn" @click="data.listingsOpened = true; data.yearsOpened = false;">
          <div class="option-title">
            {{selected_title || 'All apartments'}}
          </div>
          <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" role="presentation" focusable="false" style="display: block; fill: none; height: 12px; width: 12px; stroke: currentcolor; stroke-width: 5.333333333333333px; overflow: visible;"><g fill="none"><path d="m28 12-11.2928932 11.2928932c-.3905243.3905243-1.0236893.3905243-1.4142136 0l-11.2928932-11.2928932"></path></g></svg>
        </button>
        <div class="menu listings" v-if="data.listingsOpened">
          <ul class="list">
            <li class="item" @click="selected_title = ''; data.listingsOpened = false; UpdateData(chart, selected_title)">All apartments</li>
            <li class="item" v-for="apartment in this.namesData" :key="apartment.id" @click="selected_title = apartment.title; data.listingsOpened = false; UpdateData(chart, selected_title)">{{apartment.title}}</li>
          </ul>
        </div>
      </div>
    </div>
    <canvas class="chart" ref="mychart"></canvas>
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
      titleData: [],
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
      selected_title: ''
    }
  },
  methods:{
    UpdateData(chart, title){
      let newDataset = [
        {
          label: title ? `Visits in ${this.selected_year} of ${this.selected_title}` : `Total visits in ${this.selected_year}`,
          backgroundColor: `transparent`,
          borderColor: `rgb(252, 28, 74)`,
          data: [],
        }
      ]
      let setup = [0,0,0,0,0,0,0,0,0,0,0,0]
      // let month = data.months[parseInt(splittedDate[1])-1]
      this.visistsData.forEach(item =>{
        let year = dayJs(item.created_at).format('YYYY')
        let month = dayJs(item.created_at).format('MM')
          // parte di logica di miglliorare in quanto c'è codice ripetuto, questo semplicemente se esiste uno title allora fa il controllo anche su quello
          if (title){
            if (year == this.selected_year && this.selected_title == item.title){
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
    this.selected_year = dayJs().format('YYYY')
    this.baseSet.year = this.selected_year
  },
  mounted(){
    let month_visit = {}
    //chiamata axios per ricevere tutti i dati (VisitController)
    axios.get(`/user/get-info-${this.dataSet}`).then((response)=>{
      this.visistsData = response.data
      response.data.forEach(item => {
        //Per ogni elemento va a dare un nome allanno ed al mese
        let year = dayJs(item.created_at).format('YYYY')
        //il mese viene convertito in una string del nome del mese associato, i dati sono nel documento importato per DATA
        let month = data.months[parseInt(dayJs(item.created_at).format('MM'))-1]
        // Se l'anno non è presente nell'elemento creato prima allora va a creare il mese con un valore, oppure va alla key ed aggiunge una visita
        if (year == dayJs().format('YYYY')){
          if(!(month in month_visit)){
            month_visit[month] = 1
          } else{
            month_visit[month] += 1
          }
        }
        // creazione di un elenco per i select dove saranno presenti title degli stays
        if (!this.uniqueYears.includes(year)){
          this.uniqueYears.push(year)
        }
        this.uniqueYears.sort().reverse()
        if (!this.titleData.includes(item.title)){
          let names = {
            // title: item.title,
            title: item.title,
          }
          this.titleData.push(item.title)
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
          label: `Total visits in ${this.selected_year}`,
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
          mantainAspectRatio: true,
          aspectRatio: 2.5,
          scales: {
            yAxes: [{
              display: true,
              stacked: true,
              beginAtZero: true,
              ticks:{
                min: 0,
                max: 270,
                stepSize: 30
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
@import '../../../../sass/_variables.scss';
@import '../../../../sass/mixins.scss';
@include round-btn;
.chart-section {
  .filters {
    display: flex;
    align-items: center;
    .year-menu, .apartment-menu {
      position: relative;
    }
    .option-btn {
        border-radius: 1rem;
        height: 2rem;
        padding: 0 1rem;
        border: 1px solid black;
        font-size: 1.4rem;
        line-height: 2rem;
        font-weight: 100;
        background-color: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-right: 1rem;
        display: flex;
        max-width: 150px;
        justify-content: flex-start;
        @media screen and (min-width: $medium) {
          max-width: 230px;
        }
        &:hover {
          border: 1px solid black;
          background-color: rgba(0, 0, 0, .02);
        }
        .option-title {
          text-overflow: ellipsis;
          white-space: nowrap;
          overflow: hidden;
        }
        svg {
          flex-shrink: 0;
          margin-left: .5rem;
        }
    }
    .menu {
      position: absolute;
      top: 2.5rem;
      left: 0;
      background-color: #fff;
      border-radius: .3rem;
      box-shadow: 0 0 .2rem rgba(0, 0, 0, 0.2);
      padding: .6rem 0;
      @media screen and (min-width: $small) {
        &.listings {
          min-width: 230px;
        }
      }
      .list {
        list-style: none;
        .item {
          cursor: pointer;
          padding: 1rem 1.5rem;
          &:hover {
            background-color: rgba(0, 0, 0, 0.05);
          }
        }
      }
    }
  }
}
</style>