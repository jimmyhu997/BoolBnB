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
        houses: Array,
    },
    mounted(){
        function addMarker(map,lon,lat){
            let location = [lon,lat]
            let popupOffset = 25;
            let marker = new tt.Marker().setLngLat(location).addTo(map);
        }
        let map = tt.map({
            key: '7zrguVO9WJPTeQrtoQpjRTiYmA8UOI4E',
            container: this.$refs.mapRef,
            style: 'tomtom://vector/1/basic-main',
            zoom: 1
        });
        map.addControl(new tt.FullscreenControl());
        map.addControl(new tt.NavigationControl());
        for (let stay of this.houses){
            addMarker(map,stay.longitude,stay.latitude)
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