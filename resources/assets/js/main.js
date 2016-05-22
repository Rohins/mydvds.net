var Vue = require('vue');

Vue.component('browse-list', {
    props: ['dvds'],
    template: '#browse-list'
});

new Vue({
    el: '#app-browse', 

    data: {
        dvds:
            [
                {
                    'name' : "Test"
                }
            ]
    },

    ready() {

    }
});
