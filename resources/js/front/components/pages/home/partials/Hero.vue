<template>
    <div class="home">
        <div class="hero">
            <div class="black-background"></div>
            <div class="hero__wrapper-text container">
                <div class="hero__content">
                    <h2 class="title">Find your next stay</h2>
                    <p class="text">Search deals on apartments and plan your next trip...</p>
                </div>
            </div>
            <div class="hero__wrapper-explore container">
                <div class="background">
                    <img class="img" src="img/casa-bosco.jpeg" alt="">
                </div>
                <div class="hero__content">
                    <h2 class="title">Let your curiosity do the booking</h2>
                    <button class="lucky-btn">I'm feeling lucky</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Hero'
}
</script>

<style lang="scss" scoped>
@import '../../../../../../sass/_variables.scss';
.hero {
    .black-background {
        position: absolute;
        top: 0;
        bottom: 0;
        z-index: -1;
        width: 100%;
        height: 110vh;
        max-height: 140vw;
        background-color: #000;
    }
    &__wrapper-text, &__wrapper-explore {
        margin: 1rem auto;
        width: 90%;
        min-height: 40vh;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        @media screen and (min-width: $medium) {
            margin: 3rem auto;
            height: 30vw;
            max-height: 500px;
        }
    }
    &__wrapper-text {
        background-color: $pink;
    }
    &__content {
        text-align: center;
        color: white;
        .title {
            font-size: 2rem; 
            font-weight: 500;
            @media screen and (min-width: $medium) {
                font-size: 3rem; 
                font-weight: 600;
            }
        }
        .text {
            font-size: 1.5rem; 
            font-weight: 300;
            @media screen and (min-width: $medium) {
                font-size: 2rem; 
                font-weight: 400;
            }
        }
    }
    &__wrapper-explore {
        position: relative;
        overflow: hidden;
        @media screen and (min-width: $medium) {
            margin-top: 6rem;
            height: 50vw;
            max-height: 600px;
        }
        .background {
            position: absolute;
            background-color: #000;
            z-index: -1;
            width: 100%;
            height: 100%;
            .img {
                opacity: .7;
                border-radius: 1rem;
                width: inherit;
                height: inherit;
                object-fit: cover;
                object-position: center;
            }
        }
        .lucky-btn {
            margin-top: 1rem;
            background-color: #fff;
            height: 3rem;
            padding: 0 2rem;
            line-height: 3rem;
            border-radius: 1.5rem;
            color: $darkPink;
            font-weight: 500;
            transition: opacity .3s;
            &:hover {
                opacity: .9;
            }
        }
    }
}
</style>