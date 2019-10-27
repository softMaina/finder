(function () {
    "use strict";
    window.addEventListener("load", function () {

        new Vue({
            el: '#app',

            data: {
                isFirstDataLoaded: false,
                persons: () => []
            },
            props: {
                /*persons: {
                    default: () => [],
                    type: Array
                },
                isFirstDataLoaded: {
                    default: false,
                    type: Boolean
                }*/
            },
            created: function () {
                // non-observable vars can go here

            }, mounted: function () {
                this.dataTable = null;
                this.persons = [];
                this.init();
            },

            methods: {

                init: function () {
                    var self = this;
                    let url = $('.table').attr('url');
                    // using axios to get data from server
                    axios.get(url).then(function (response) {
                        self.isFirstDataLoaded = true;
                        if ((response)) {
                            self.persons = (response.data.data);
                            Vue.nextTick(function () {
                                // save a reference to the DataTable
                                self.dataTable = $('.table').DataTable({
                                    "paging": true,
                                    "pageLength": 50,
                                    "info": false,
                                    // etc
                                });
                            });
                        }
                        else {
                            console.log(response);
                        }
                    }).catch(function (error) {
                        // showWarning(error);
                        console.log(error)
                    });
                },
            },

            // call this with the person once you've confirmed you really want to delete it.
            // this deletes it from the DataTable, our non-observed list, and deletes it on the server too.
            handleConfirmedDelete: function (person) {
                var index = this.findIndex(person.personId);
                if (null != index) {
                    // Found it in our non-observable list
                    var self = this;
                    // tell the server to delete the person
                    axios.post('/rest/call/to/person/delete/' + candidate.executionId).then(function (response) {
                        if (isGood(response)) {
                            // tell DataTable to remove a row by id (which we set in the html).
                            // the 'full-hold' is so that the pagination stays on the same page after deletion.
                            self.dataTable.row('#row-' + person.personId).remove().draw('full-hold');
                            // now clean up our list
                            self.persons.splice(index, 1);
                        }
                        else {
                            //showWarning(response);
                            console.log(error);
                        }
                    }).catch(function (error) {
                        console.log(error);
                        //showWarning(error);
                    });
                }
                else {
                    // Wasn't in our list, but I found some corner cases where DataTables still hangs on and will
                    // render an item that is no longer in our persons[] list. I could never pin it down, so I just
                    // did this simple workaround. I'd like to know if someone can pin it down.
                    self.dataTable.row('#row-' + person.personId).remove().draw('full-hold');
                }
            },

        }); // Vue

    });
}());
