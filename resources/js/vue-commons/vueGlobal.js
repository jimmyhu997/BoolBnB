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
    loggedUserEmail:'',
    purchaseView: '',
    buyInfo: {
        stay_id: null,
        sponsorPackage_id: null,
        sponsorPackage_duration :null,
        sponsorPackage_price: null,
        times: 1
    }
})