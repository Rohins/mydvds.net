var Vue = require('vue');

/**
 * Component for listing all books
 **/

Vue.component('browse-list', {
    props: ['dvds'],
    template: '#browse-list',

    created: function() { $.getJSON('/book', function (data) {
            this.dvds = data;
        }.bind(this));

    }
});

/**
 * Component for listing results from a search
 **/
Vue.component('search-list', {
    template: '#search-list',

    data: function() {
        return {
            searchDvd: "",
            dvds: []
        }
    },
    methods: {
        searchDvds: function() {
            $.getJSON('/search/'+this.searchDvd, function(data) {
                this.dvds = data;
            }.bind(this));
        }
    }
});


new Vue({
    el: '#app',

    data: {
        browse_name: "Test",
        browse_book_id: "",
        browse_pages: []
    },

    methods: {
        modalBook: function(book_id) {
            $.getJSON('book/'+book_id, function(data) {
                this.browse_pages = data.pages;
                this.browse_name  = data.name;
                this.browse_book_id = data.id;
            }.bind(this));
        },

        createBook: function() {
            var book_title = prompt("Please enter the name of the book:", "");
            if (book_title !== null) {
                $.get("new/book/"+book_title, function(data) {
                    location.reload();
                });
            }
        },

        editBookName: function(book_id, original_name) {
            var book_name = prompt("Please enter a new name for the book:", original_name);
            if (book_name !== null) {
                $.get("book/"+book_id+"/"+book_name, function(data) {
                    location.reload();
                });
            }
        },
        editBookNameB: function(book_id, original_name) {
            var book_name = prompt("Please enter a new name for the book:", original_name);
            if (book_name !== null) {
                $.post("book/rename", {id: book_id, name: book_name}, function(data) {
                    console.log('data');
                });
            }
        },
        updateDisk: function(book_id, page_id, disk, original_name) {
            var disk_name = prompt("Please enter a new name for this disk:", original_name);

            if (disk_name !== null) {
                $.get("page/"+page_id+"/"+disk+"/"+disk_name, function(data) {
                    $.getJSON('book/'+book_id, function(data) {
                        this.browse_pages = data.pages;
                        this.browse_name  = data.name;
                        this.browse_book_id = data.id;
                    }.bind(this));
                }.bind(this,book_id));
            }
        }
    }

});
