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
    months: [
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December',
    ],
    mid_month : [4,6,9,11],
    long_month: [1,3,5,7,8,10,12],
    special_month: [2],
    yearsOpened: false,
    listingsOpened: false,
    purchaseView: '',
    buyInfo: {
        stay_id: null,
        sponsorPackage_id: null,
        sponsorPackage_duration :null,
        sponsorPackage_price: null,
        times: 1
    }
})