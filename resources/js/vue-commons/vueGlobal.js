import Vue from 'vue';

export default Vue.observable({
    perks: [],
    menuOpened: false,
    authOpened: false,
    hintsOpened: false,
    addressHintsOpened: false,
    deleteOpened: false,
    loggedUserId: null,
    loggedUserName:'',
    loggedUserEmail:''
})