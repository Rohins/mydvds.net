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
            bootbox.prompt({
                title: "Please enter the name of the book:",
                callback: function(book_title) {
                    if (book_title !== null) {
                        $.get("new/book/"+book_title, function(data) {
                                location.reload();
                        });
                    }
                }
            });
        },

        editBookName: function(book_id, original_name) {
            bootbox.prompt({
                title: "Please enter a new name for the book",
                value: original_name,
                callback: function(original_name, book_id, book_name) {
                    if (book_name !== null) {
                        $.get("book/"+book_id+"/"+book_name, function(data) {
                            location.reload();
                        });
                    }
                }.bind(this, original_name, book_id)
            });

        },
        updateDisk: function(book_id, page_id, disk, original_name) {
            bootbox.prompt({
              title: "What is your real name?",
              value: "makeusabrew",
              callback: function(result) {
                if (result === null) {
                  Example.show("Prompt dismissed");
                } else {
                  Example.show("Hi <b>"+result+"</b>");
                }
              }
            });
            
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
