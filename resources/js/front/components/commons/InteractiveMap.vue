<template>
    <div id="map" ref="mapRef">

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
    },
    mounted(){
        function addMarker(map,lat,lon){
            const tt = window.tt;
            let location = [lon,lat]
            // let offsets = {
            //     top: [0, 0],
            //     bottom: [0, -30],
            //     'bottom-right': [0, -30],
            //     'bottom-left': [0, -30],
            //     left: [25, -35],
            //     right: [-25, -35]
            // }
            let popupOffset = 25; 
            let marker = new tt.Marker().setLngLat(location).addTo(map);
            var ne = new tt.LngLat(location[0]);
            let sw = new tt.LngLat(location[1]);
            let llb = new tt.LngLatBounds(sw, ne);
        }
        let map = tt.map({
            key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
            container: this.$refs.mapRef,
            style: 'tomtom://vector/1/basic-main', 
            zoom: 1
        });
        map.addControl(new tt.FullscreenControl()); 
        map.addControl(new tt.NavigationControl()); 
        addMarker(map,this.lat,this.lon)
    },
    created(){
        console.log(this.lat)
        console.log(this.lon)
        
    },
    
}
</script>

<style lang='scss' scoped>
#map { 
    height: 100%; 
    width: 100%; 
} 
</style>