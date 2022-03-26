<template>
    <div id="map" ref="mapRef">
        <router-link v-for="stay,index in this.houses" :key="index" :id="index" :to="{name: 'apartment', params: {stay: stay.slug}}" class="apartment">
            <div class="apartment-preview">
                <img :src="'storage/' + stay.image_path" :alt="stay.title" class="img">
            </div>
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
            bottom: [0, -40],
            'bottom-right': [0, -35],
            'bottom-left': [0, -35],
            left: [25, -35],
            right: [-25, -35]
        }
        function addMarker(map,lon,lat){
            let location = [lon,lat]
            let marker = new tt.Marker()
                .setLngLat(location)
                .addTo(map);
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
            let popUp = new tt.Popup({
                offset: popupOffsets,
                className: 'marker-popup',
                closeButton: false
            }).setDOMContent(content);
            popUp._content.style.padding = '0'
            popUp._content.style.overflow = 'hidden'
            popUp._content.style.borderRadius = '.5rem'
            console.log(popUp._content);
            marker.setPopup(popUp);
            marker.getElement().innerHTML =
            `<div
            style="
                background-color: white;
                border: 1px solid rgba(0, 0, 0, .2);
                height: 2rem; width: max-content;
                padding: 0 .5rem; font-size: 1rem;
                font-weight: 500;
                line-height: 2rem;
                border-radius: 1rem;
                cursor: pointer"
            onmouseover="
                this.style.background = '#f5f5f5'"
            onmouseleave="
                this.style.background = 'white'"
            >€${parseInt(stay.price)}</div>`
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
.apartment {
    color: black;
    text-decoration: none;
    width: 170px;
    &-preview {
        width: 100%;
        height: 150px;
        .img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }
    }
    &-overview {
        padding: .5rem;
        .type {
            font-size: .9rem;
            color: grey;
        }
        .title {
            font-weight: 300;
            margin-top: .5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-size: 1.2rem;
        }
        .price {
            text-align: right;
            .num {
                font-size: 1.1rem;
                font-weight: 400;
            }
            .night {
                font-size: .8rem;
                font-weight: 300;
            }
        }
    }
}
</style>