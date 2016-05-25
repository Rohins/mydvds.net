var Vue = require('vue');

Vue.component('browse-list', {
    props: ['dvds'],
    template: '#browse-list',

    created: function() {
        $.getJSON('/book', function (data) {
            this.dvds = data;
            console.log(this.dvds);
        }.bind(this));

    }
});

Vue.component('search-list', {
    template: '#search-list',

    data: function () {
        return {
            searchDvd: "",
            dvds: []
        }
    },
    methods: {
        searchDvds: function() {
            var that_dvds = this.dvds;
            $.getJSON('/search/'+this.searchDvd, function(data) {
                this.dvds = data;
            }.bind(this));
        }
    }
});

new Vue({
    el: '#app'

});
