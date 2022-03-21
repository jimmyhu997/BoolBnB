<template>
    <div id="map" ref="mapRef">
        <router-link v-for="stay,index in this.houses" :key="index" :id="index" :to="{name: 'apartment', params: {stay: stay.slug}}" class="apartment">
            <div class="apartment-overview">
                <div class="info">
                    <p class="type">Entire apartment in {{stay.city}}</p>
                    <h3 class="title">{{stay.title}}</h3>
                    <div class="separator"></div>
                </div>
                <div class="price">
                    <p class="price"><span class="num">€{{stay.price}}</span> <span class="night">/ night</span></p>
                </div>
            </div>
        </router-link>
    </div>
</template>

<script>

export default {
    name: 'Map',
    data(){
        return{
        }
    },
    methods:{
        },
    props:{
        lat: Number,
        lon: Number,
        houses: Array,
        zoom: Number
    },
    mounted(){
         let popupOffsets = {
            top: [0, 0],
            bottom: [0, -35],
            'bottom-right': [0, -35],
            'bottom-left': [0, -35],
            left: [25, -35],
            right: [-25, -35]
        }
        function prova(string){
            console.log(string)
        }
        function addMarker(map,lon,lat){
            let location = [lon,lat]
            // let div = window.document.createElement('div')
            // div.innerHTML = `<a href='#'>Hello I'm a Popup!</a>`
            let marker = new tt.Marker().setLngLat(location).addTo(map);
            return marker
        }
        let map = tt.map({
            key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
            container: this.$refs.mapRef,
            style: 'tomtom://vector/1/basic-main',
            center: [this.lon,this.lat],
            zoom: this.zoom,
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
        let index = 0
        for (let stay of this.houses){
            let marker = addMarker(map,stay.longitude,stay.latitude)
            let content = document.getElementById(index)
            console.log(index)
            let popUp = new tt.Popup({
                offset: popupOffsets,
                className: 'marker-popup'
            }).setDOMContent(content);
            marker.setPopup(popUp); 
            index++
        }
    },
}
</script>

<style lang='scss' scoped>
#map {
    height: 100%;
    width: 100%;
}
</style>