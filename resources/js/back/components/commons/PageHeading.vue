<template>
    <div class="page__heading">
        <h2 class="heading-title" v-if="!title.includes('undefined')">{{title}}</h2>
        <div class="button" v-if="button">
            <router-link class="heading-btn large" :to="{name: button.route}">{{button.desktop}}</router-link>
            <router-link class="heading-btn small" :to="{name: button.route}">{{button.mobile}}</router-link>
        </div>
    </div>
</template>

<script>
export default {
    name: 'PageHeading',
    props: {
        title: String,
        button: Object
    }
}
</script>

<style lang="scss" scoped>
@import '../../../../sass/_variables.scss';
.page__heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
    margin-bottom: 2rem;
    @media screen and (min-width: $medium) {
        margin-top: 2rem;
    }
    .heading {
        &-title {
        font-weight: 500;
        }
        &-btn {
        border: 1px solid black;
        color: black;
        text-decoration: none;
        transition: background-color .2s;
        &.small {
            flex-shrink: 0;
            border-radius: 50%;
            height: 2.4rem;
            width: 2.4rem;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.7rem;
            font-weight: 300;
        }
        &.large {
            display: none;
            border-radius: .7rem;
            padding: 1rem 2rem;
        }
        @media screen and (min-width: $medium) {
            &.large {
            display: inline-block;
            }
            &.small {
            display: none;
            }
        }
        &:hover {
            background-color: rgba(0, 0, 0, .02);
        }
        }
    }
}
</style>