<template>
    <div class="table-responsive" id="">
        <form id="frm-example" class="padding-horiz-10 padding-right-10" action="xxx">
            <table class="table" id="cdatatable">

            </table>
            <button class="btn btn-success" type="button" name="submit" :style="{display:submit_btn_visibility}">{{
                btntext }}
            </button>
        </form>

    </div>
</template>

<script type="text/javascript">
    module.exports = {
        props: {
            titles: {
                default: "",
                type: String
            },
            data: {
                default: "",
                type: String
            },
            url: {
                type: String
            },
            action: {
                default: "",
                type: String
            },
            ctitle: {
                default: "",
                type: String
            },
            btntext: {
                default: "Submit",
                type: String
            },
            akey: {
                default: "id",
                type: String
            },
            submit_btn_visibility: {
                default: "true",
                type: String
            }
        },
        data() {
            //this.ops = '';
            let vm = this;
            return {
                rows: [],
                dtHandle: null
            }
        },
        mounted() {
            let vm = this;
            //var ckey = window;
            this.getTData();
            VEvent.$on('submitted', function () {
                vm.getTData()
            });
            this.$root.$on('submitted', () => {
                // your code goes here
                //vm.getTData()
                //vm.test();
            });
        },
        methods: {

            updateDataTableSelectAllCtrl: function ($table) {
                var $table = this.table.table().node();
                var $chkbox_all = $('tbody input[type="checkbox"]', $table);
                var $chkbox_checked = $('tbody input[type="checkbox"]:checked', $table);
                var chkbox_select_all = $('thead input[name="select_all"]', $table).get(0);

                // If none of the checkboxes are checked
                if ($chkbox_checked.length === 0) {
                    chkbox_select_all.checked = false;
                    if ('indeterminate' in chkbox_select_all) {
                        chkbox_select_all.indeterminate = false;
                    }

                    // If all of the checkboxes are checked
                } else if ($chkbox_checked.length === $chkbox_all.length) {
                    chkbox_select_all.checked = true;
                    if ('indeterminate' in chkbox_select_all) {
                        chkbox_select_all.indeterminate = false;
                    }

                    // If some of the checkboxes are checked
                } else {
                    chkbox_select_all.checked = true;
                    if ('indeterminate' in chkbox_select_all) {
                        chkbox_select_all.indeterminate = true;
                    }
                }
            },
            getTData() {

                let vm = this;
                vm.rows = [];
                vm.jsonObj = [];
                vm.columnDefsObj = [];

                var str = vm.titles;
                var myarray = str.split(',');
                var mydata = vm.data.split(',');
                var count = myarray.length;

                vm.count = count;

                for (var i = 0; i < myarray.length; i++) {
                    column = {}

                    column ["title"] = myarray[i];
                    column ["data"] = mydata[i];
                    column ["className"] = "left";
                    if (myarray[i].match('input') || myarray[i].match('select')) {
                        columnDef = {}
                        columnDef ["targets"] = i;
                        columnDef ["searchable"] = false;
                        columnDef ["orderable"] = false;
                        columnDef ["width"] = "1%";
                        columnDef ["className"] = "dt-body-center";
                        columnDef ["render"] = function (data, type, full, meta) {
                            return '<input type="checkbox">';
                        };//<input name='select_all' value='1' type='checkbox'>
                        column ["title"] = '<input name="select_all" value="1" type="checkbox">';
                        vm.columnDefsObj.push(columnDef);
                    }
                    vm.jsonObj.push(column);
                }
                var jsonString = JSON.stringify(vm.jsonObj);
                var jsonColsString = JSON.stringify(vm.columnDefsObj);
                var action = vm.action;
                var ctitle = vm.ctitle;
                if (typeof action != 'undefined' || action != null) {

                    columnDef = {}
                    columnDef ["targets"] = vm.count;
                    columnDef ["searchable"] = false;
                    columnDef ["orderable"] = false;
                    columnDef ["width"] = "30%";
                    columnDef ["title"] = ctitle == null ? "" : ctitle;
                    columnDef ["render"] = function (data, type, full, meta) {

                        var strArray = action.split('/');
                        var output = '';
                        for (var i = 0; i < strArray.length; i++) {
                            var option = (strArray[i]);
                            switch (option) {
                                case 'Edit':
                                    output += '<span class="btn btn-light edit" title="Edit" style="margin-right: 10%;"><i class="zmdi zmdi-edit"></i></span>';
                                    break;
                                case 'Delete':
                                    output += '<span class="btn btn-light delete" title="Delete" ><i class="zmdi zmdi-delete"></i></span>';
                                    break;
                                case 'View':
                                    output += '<span class="btn btn-light view" title="View" ><i class="zmdi zmdi-eye"></i></span>';
                                    break;
                                case 'Map':
                                    output += '<span class="btn btn-light map" title="Map" ><i class="zmdi zmdi-pin"></i></span>';
                                    break;
                                default:
                                    break;
                            }
                        }
                        return output;
                    };//<input name='select_all' value='1' type='checkbox'>
                    //column ["title"] = 'Action time';
                    vm.columnDefsObj.push(columnDef);
                    //vm.jsonObj.push(column);
                }
                axios.get(vm.url)

                    .then(function (response) {

                        //console.log(response.data.data);

                        //let vm = this;
                        let val = response.data.data;
                        /*var avrate = response.data.average;

                        if(avrate >0){
                            averagerate = avrate;
                            VEvent.$emit('rated')
                        }*/
                        var columns = vm.jsonObj;//[{'title':'Name',data: 'name',className: 'center'},{'title':'Email',data: 'email',className: 'center'},{'title':'Phone Number',data: 'phone_number',className: 'center'}];
                        var columnDefs = vm.columnDefsObj
                        var rows_selected = [];
                        vm.table = $('#cdatatable').DataTable({
                            "processing": true,
                            //"serverSide": true,
                            "data": val,
                            columns: columns/*[
                        {'title':'Name',data: "name",
                            className: 'center'
                        },
                        {'title':'Email',data: "email",
                            className: 'center'}
                        ,
                        {'title':'Phone Number',data: "phone_number",
                            className: 'center'}
                    ]*/
                            , bDestroy: true,
                            columnDefs: columnDefs/*[{
                            'targets': 0,
                            'searchable': false,
                            'orderable': false,
                            'width': '1%',
                            'className': 'dt-body-center',
                            'render': function (data, type, full, meta) {
                                return '<input type="checkbox">';
                            }
                        }]*/,
                        });
                        let table = vm.table;

                        // Handle click on checkbox
                        $('#cdatatable tbody').on('click', 'input[type="checkbox"]', function (e) {
                            var $row = $(this).closest('tr');


                            // Get row data
                            var data = table.row($row).data();
                            //alert(eval('data.name'))
                            // Get row ID
                            var rowId = eval('data.' + vm.akey);//data.id; //alert(rowId)
                            alert(rowId)
                            //var writerId = data.name;


                            // Determine whether row ID is in the list of selected row IDs
                            var index = $.inArray(rowId, rows_selected);

                            // If checkbox is checked and row ID is not in list of selected row IDs
                            if (this.checked && index === -1) {
                                rows_selected.push(rowId);
                                //alert(rowId)

                                // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
                            } else if (!this.checked && index !== -1) {
                                rows_selected.splice(index, 1);
                            }

                            if (this.checked) {
                                $row.addClass('selected');
                                //alert(rowId)
                                // get users total


                            } else {
                                $row.removeClass('selected');
                                //remove totals text
                                //$('#sum' + writerId + '').text('');
                                //$('.sum').text('');
                            }

                            // Update state of "Select all" control
                            vm.updateDataTableSelectAllCtrl(table);

                            // Prevent click event from propagating to parent
                            e.stopPropagation();
                        });

                        // Handle click on table cells with checkboxes
                        $('#cdatatable').on('click', 'tbody td, thead th:first-child', function (e) {
                            $(this).parent().find('input[type="checkbox"]').trigger('click');
                        });

                        //Handle edit
                        $('#cdatatable tbody').on('click', 'td', 'td.edit', function (e) {
                            // to avoid to receive the button click inside the td you need:
                            if ($(e.target).is(':not(td)') && $(e.target).closest('span').hasClass('edit')) {
                                //alert('This is inside td');
                                $('#modal-wizard').modal('show');
                                var $row = $(this).closest('tr');

                                // Get row data
                                var tdata = table.row($row).data();

                                // Get row ID
                                var rowId = tdata.id;
                                //alert(rowId)

                                //$("button[type=submit-update]").parents("form:first").attr("action", " {{ route('branch.update') }}");


                                return;
                            }


                        });

                        //Handle view
                        $('#cdatatable tbody').on('click', 'td', 'td.view', function (e) {
                            // to avoid to receive the button click inside the td you need:
                            if ($(e.target).is(':not(td)') && $(e.target).closest('span').hasClass('view')) {
                                //alert('This is inside td');
                                $('#modal-wizard').modal('show');
                                var $row = $(this).closest('tr');

                                // Get row data
                                var tdata = table.row($row).data();

                                // Get row ID
                                var rowId = tdata.id;
                                //alert(rowId)

                                var email = tdata.slug;
                                var route = $('meta[name="app-url"]').attr('content') + '/admin/profile/' + email;
                                window.location.href = (route)
                                //window.href = route;

                                //$("button[type=submit-update]").parents("form:first").attr("action", " {{ route('branch.update') }}");


                                return;
                            }


                        });

                        //Handle map
                        $('#cdatatable tbody').on('click', 'td', 'td.map', function (e) {
                            // to avoid to receive the button click inside the td you need:
                            if ($(e.target).is(':not(td)') && $(e.target).closest('span').hasClass('map')) {
                                //alert('This is inside td');
                                $('#modal-wizard').modal('show');
                                var $row = $(this).closest('tr');

                                // Get row data
                                var tdata = table.row($row).data();

                                // Get row ID
                                var rowId = tdata.id;
                                //alert(rowId)

                                var lat = tdata.lat;
                                var lng = tdata.lng;
                                var coordinate = lat + "," + lng;
                                $('#map_title').text(tdata.location);
                                // Juja - -1.2795904,36.8238592
                                var src = "https://maps.google.com/maps?q=" + coordinate + "&t=&z=13&ie=UTF8&iwloc=&output=embed&maptype=roadmap";
                                $('#gmap_canvas').attr('src', src);
                                $('#modal-map').modal('show');

                                return;
                            }


                        });


                        //Handle delete
                        $('#cdatatable tbody').on('click', 'td', 'td.delete', function (e) {
                            // to avoid to receive the button click inside the td you need:
                            if ($(e.target).is(':not(td)') && $(e.target).closest('span').hasClass('delete')) {
                                //alert('This is inside td');
                                $('#modal-wizard').modal('show');
                                var $row = $(this).closest('tr');

                                // Get row data
                                var tdata = table.row($row).data();

                                // Get row ID
                                var rowId = tdata.id;
                                alert(rowId)

                                //$("button[type=submit-update]").parents("form:first").attr("action", " {{ route('branch.update') }}");


                                return;
                            }


                        });
                        // Handle click on "Select all" control
                        $('thead input[name="select_all"]', vmtable.table().container()).on('click', function (e) {
                            if (this.checked) {
                                $('#cdatatable tbody input[type="checkbox"]:not(:checked)').trigger('click');
                            } else {
                                $('#cdatatable tbody input[type="checkbox"]:checked').trigger('click');
                            }

                            // Prevent click event from propagating to parent
                            e.stopPropagation();
                        });

                        // Handle table draw event
                        table.on('draw', function () {
                            // Update state of "Select all" control
                            updateDataTableSelectAllCtrl(vm.table);
                        });

                        // Handle form submission event
                        $('button[name="submit"]').click(function (e) {

                            e.preventDefault();
                            var action = $(this).attr('name');
                            var form = jQuery(this).parents("form:first");
                            // Iterate over all selected checkboxes
                            $.each(rows_selected, function (index, rowId) {
                                // Create a hidden element
                                $(form).append(
                                    $('<input>')
                                        .attr('type', 'hidden')
                                        .attr('name', 'id[]')
                                        .val(rowId)
                                ).append(
                                    $('<input>')
                                        .attr('type', 'hidden')
                                        .attr('name', 'action[]')
                                        .val(action)
                                );
                            });
                            var dataString = form.serialize();
                            var formAction = form.attr('action');

                            $('dynamic-table-console').text($(form).serialize());
                            console.log("Form submission", $(form).serialize());
                            alert(dataString);
                        });
                    })

                    .catch(function (error) {


                    });

            }
        }
    }
</script>
<style>


</style>
