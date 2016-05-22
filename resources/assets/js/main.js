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

new Vue({
    el: '#app-browse', 
});
