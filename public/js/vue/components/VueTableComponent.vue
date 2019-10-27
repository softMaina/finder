<template>
    <div class="dt-responsive table-responsive">
        <table id="dynamic-table" class="table table-striped table-bordered nowrap">
        </table>
    </div>
</template>

<script type="text/javascript">
    window.VEvent = new Vue();
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
            update_url: {
                default: "null",
                type: String
            },
            delete_url: {
                type: String
            },
            apply_url: {
                type: String
            },
            approve_url: {
                type: String
            },

            view_url: {
                type: String
            },
            has_details: {
                default: "true",
                type: String
            },
            is_child_row_form: {
                default: "true",
                type: String
            },
            can_download_file: {
                default: "false",
                type: String
            },
            action: {
                default: "null",
                type: String
            },
            action_icon: {
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
            has_category: {
                default: "false",
                type: String
            },
            has_image: {
                default: "false",
                type: String
            },
            image_key: {
                default: "",
                type: String
            },
            update_header: {
                default: "Update",
                type: String
            },
            categories: {
                default: "",
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
            this.dataTable = null;
            this.selectedRow = null;
            this.persons = [];
            this.init();
            /*this.$root.$on('refresh', () => {
                // your code goes here
                //vm.getTData()
                //vm.test();
                //alert()
                this.init();
            });*/
            VEvent.$on('submitted', function () {
                vm.init()
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
            init() {

                let vm = this;
                vm.rows = [];
                vm.jsonObj = [];
                vm.columnDefsObj = [];
                vm.fields = [];
                vm.capitalized_fields = [];

                var str = vm.titles;
                var myarray = str.split(',');
                var mydata = vm.data.split(',');
                var count = myarray.length;
                vm.title_array = myarray;
                vm.data_array = mydata;

                vm.count = count;


                for (var i = 0; i < myarray.length; i++) {
                    if (i == 0) {
                        customColumn = {}
                        customColumn ["class"] = 'details-control';
                        customColumn ["orderable"] = false;
                        customColumn ["data"] = null;
                        customColumn ["defaultContent"] = '';

                        if (vm.has_details === 'true') {
                            vm.jsonObj.push(customColumn);
                        }

                        //myarray[i] = JSON.stringify(customColumn);
                        //alert(JSON.stringify(customColumn))

                        //customColumn = {}
                        /*myarray[i] = {
                            "class":          'details-control',
                            "orderable":      false,
                            "data":           null,
                            "defaultContent": ''
                        };*/
                    }
                    column = {}

                    column ["title"] = myarray[i] === 'details' ? '' : myarray[i];
                    column ["data"] = mydata[i];
                    //column ["className"] = "left";
                    if (myarray[i].match('details') || myarray[i].match('details')) {
                        columnDef = {}
                        columnDef ["class"] = 'details-control';
                        columnDef ["searchable"] = false;
                        columnDef ["orderable"] = false;
                        columnDef ["data"] = null;
                        columnDef ["defaultContent"] = "";
                        columnDef ["targets"] = 0;
                        /*columnDef ["render"] = function (data, type, full, meta) {
                            return '<input type="checkbox">';
                        };*/

                        /*columnDef ["targets"] = i;
                        columnDef ["searchable"] = false;
                        columnDef ["orderable"] = false;
                        columnDef ["width"] = "1%";
                        columnDef ["className"] = "details-control";
                        columnDef ["defaultContent"] = "";
                        columnDef ["render"] = function (data, type, full, meta) {
                            //return '<input type="checkbox">';
                        };*/

                        //<input name='select_all' value='1' type='checkbox'>
                        /*column ["title"] = '<input name="select_all" value="1" type="checkbox">';*/
                        vm.columnDefsObj.push(columnDef);
                    }
                    vm.jsonObj.push(column);
                }

                var jsonString = JSON.stringify(vm.jsonObj);
                var jsonColsString = JSON.stringify(vm.columnDefsObj);
                var action = vm.action;
                var ctitle = vm.ctitle;
                if (action !== "null") {

                    columnDef = {}
                    columnDef ["targets"] = vm.count + 1;
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
                                    output += '<strong><i class="hand-cursor fa fa-lg fa-trash-o deleteRecord" title="Delete"></i><strong>';
                                    break;
                                case 'View':
                                    output += '<span class="btn btn-light view" title="View" ><i class="zmdi zmdi-eye"></i></span>';
                                    break;
                                case 'Apply':
                                    output += '<span class="btn btn-light apply" title="Apply" ><i class="hand-cursor fa fa-lg  fa-check-square-o apply"></i></span>';
                                    break;
                                case 'Approve':
                                    output += '<span class="btn btn-light approve" title="Approve" ><i class="hand-cursor fa fa-lg  fa-check-square approve"></i></span>';
                                    break;
                                default:
                                    break;
                            }
                        }
                        return output;
                    };//<input name='select_all' value='1' type='checkbox'>
                    //column ["title"] = 'Action time';
                    if (vm.has_details === 'true') {
                        vm.columnDefsObj.push(columnDef);
                    }

                    //vm.jsonObj.push(column);
                }
                axios.get(vm.url)

                    .then(function (response) {

                        //console.log(response.data.data);

                        //let vm = this;
                        let val = response.data.data;
                        //vm.fields = Object.keys(val[0])
                        var array = Object.keys(val[0]);
                        //alert(array)
                        for (let i = 1; i < (array.length - 2); i++) {
                            var field = array[i];
                            if (field !== 'api_token' && field !== 'avatar' && field !== 'image') {
                                vm.fields.push(field);
                            }

                        }

                        for (let i = 1; i < (array.length - 2); i++) {
                            var capitalized_title = array[i];
                            var capital = capitalized_title.charAt(0).toUpperCase() + capitalized_title.slice(1)
                            //capital = capital.replace(/_/g, " ")
                            if (capital !== 'Api_token' && capital !== 'Avatar' && capital !== 'Image') {
                                vm.capitalized_fields.push(capital);
                            }


                        }
                        //console.log(vm.capitalized_fields)
                        //console.log(vm.fields);
                        //console.log(vm.fields)
                        //console.log(Object.keys(val[0]))

                        /*$.each(val, function (key, value) {
                            console.log("key : " + key + " ; value : " + value);

                            //alert(value[key])
                            /!*if (form.find('input[name=' + key + ']')) {
                                form.find('input[name=' + key + ']').attr('placeholder', val)
                            }

                            if (form.find('textarea[name=' + key + ']')) {
                                form.find('textarea[name=' + key + ']').attr('placeholder', val)
                            }*!/


                        });*/
                        var avrate = response.data.average;

                        if (avrate > 0) {
                            averagerate = avrate;
                            VEvent.$emit('rated')
                        }
                        var columns = vm.jsonObj;//[{'title':'Name',data: 'name',className: 'center'},{'title':'Email',data: 'email',className: 'center'},{'title':'Phone Number',data: 'phone_number',className: 'center'}];
                        var columnDefs = vm.columnDefsObj
                        var rows_selected = [];
                        Vue.nextTick(function () {
                            vm.dataTable = $('#dynamic-table').DataTable({
                                "processing": true,
                                "data": val,
                                columns: columns/*[
                            {
                                "class":          'details-control',
                                "orderable":      false,
                                "data":           null,
                                "defaultContent": ''
                            },
                            {data: "idea_title"},
                            {data: "description"},
                            {data: "country"},
                            {data: "id","className":"center",
                                'render': function (data, type, row, meta) {
                                    return '<strong><i class="hand-cursor fa fa-lg fa-trash-o deleteRecord" id="deleteRecord' + row.id + '" title="Delete Goal"></i><strong>';
                                }}

                        ]*/
                                , bDestroy: true,
                                columnDefs: vm.has_details === 'true' ? columnDefs : null/*[{
                            'targets': 0,
                            'searchable': false,
                            'orderable': false,
                            'width': '1%',
                            'className': 'dt-body-center',
                            'render': function (data, type, full, meta) {
                                return '<input type="checkbox">';
                            }
                        }]*/,
                                initComplete: function () {
                                    $('.dataTables_filter input[type="search"]').css({
                                        'width': '250px',
                                        'display': 'inline-block',
                                        "position": "relative",
                                        "right": "25px",
                                        "margin-right": "-20px;",
                                        "margin-top": "1em"
                                    })
                                        .attr('placeholder', 'Search here ...');
                                },
                                "lengthChange": false,
                                "language": {
                                    "search": "",
                                    "zeroRecords": "No Records Found",
                                    "info": "", /*/!*Total*!/*/
                                    "infoEmpty": ""/*/!*No records available*!/*/
                                    /*/!*,"infoFiltered": "(filtered from _MAX_ total records)"/!**!/*/
                                }
                            });

                            $('#dynamic-table').css('font-size', "0.75em");
                            $('.panel-default').css('font-size', "0.75em");
                            $('#dynamic-table').css({paddingLeft: '0.5em'});

                            $('#dynamic-table tbody').on('click', 'td.details-control', function (e) {
                                let tr = $(this).closest('tr');
                                let row = vm.dataTable.row(tr);
                                vm.selectedRow = row;

                                if (row.child.isShown()) {
                                    // This row is already open - close it
                                    row.child.hide();
                                    tr.removeClass('shown');
                                }
                                else {//alert(JSON.stringify(row.data()))
                                    // Open this row
                                    row.child(vm.format(row.data())).show();
                                    //row.child('ddgggfdgjh').show();
                                    tr.addClass('shown');

                                }

                            });

                            $('#dynamic-table tbody').on('click', 'td', function (e) {
                                //alert()
                                // handle deletes
                                if ($(e.target).is(':not(td)') && $(e.target).closest('i').hasClass('deleteRecord')) {
                                    let tr = $(this).closest('tr');
                                    let row = vm.dataTable.row(tr);
                                    var id = row.data().id;

                                    swal({
                                        title: '<strong style="color: #ffffff">Are you sure?</strong>',
                                        html: '<strong style="color: #ffffff">You will not recover this record</strong>',
                                        type: 'warning',
                                        showCancelButton: true,
                                        buttonsStyling: false,
                                        confirmButtonClass: 'btn btn-danger',
                                        confirmButtonText: 'Yes, delete it!',
                                        cancelButtonClass: 'btn btn-light',
                                        background: 'rgba(0,0,0,.5)'
                                    }).then(function () {
                                        var postURL = vm.delete_url;
                                        //alert(id)
                                        axios.post(postURL, {
                                            id: id
                                        })

                                            .then(function (response) {

                                                //vm.output = response.data;
                                                var results = response.data.data;
                                                if (results.success) {

                                                    toastr.success(results.message)
                                                    toastr.options.timeOut = 3000; // 3s

                                                    //delete selected row ...
                                                    row.remove().draw();


                                                }


                                            })

                                            .catch(function (error) {
                                                console.log(error);
                                                //post_response= error;

                                            });

                                        swal({
                                            title: '<strong style="color: #ffffff">Done!</strong>',
                                            html: '<strong style="color: #ffffff">You will not recover this goal</strong>',
                                            type: 'success',
                                            buttonsStyling: false,
                                            confirmButtonClass: 'btn btn-light',
                                            background: 'rgba(0,0,0,.5)'
                                        });
                                    });
                                }

                                if ($(e.target).is(':not(td)') && $(e.target).closest('i').hasClass('apply')) {
                                    let tr = $(this).closest('tr');
                                    let row = vm.dataTable.row(tr);
                                    var id = row.data().id;
                                    var organisation_id = row.data().organisation_id;


                                    var postURL = vm.apply_url;
                                    //alert(organisation_id)
                                    var htmlcontent = '<form id="apply_form" enctype="multipart/form-data" method="post" action="' + postURL + '">' +
                                        '        ' +
                                        '        <div class="form-group row">' +
                                        '            <label class="col-sm-2 col-form-label">Upload CV</label>' +
                                        '            <div class="col-sm-10">' +
                                        '                <input class="form-control" type="file" id="document name="document"  enctype="multipart/form-data" >' +
                                        '                <input class="form-control" type="hidden" name ="id" value = "' + id + '">' +
                                        '                <input class="form-control" type="hidden" name ="organisation_id" value = "' + organisation_id + '">' +
                                        '            </div>' +
                                        '        </div>' +
                                        '        ' +
                                        '    </form>'
                                    swal({
                                        title: '<span style="color:#000000;font-size: 14px;">Attach CV ... </span>',
                                        html: htmlcontent,
                                        type: 'info',
                                        buttonsStyling: false,
                                        confirmButtonClass: 'btn btn-sm btn-light',
                                        background: 'rgba(255,255,255,1.0)'
                                    }).then(function () {
                                        let data = new FormData();
                                        let form = $("#apply_form");

                                        let $file = form.find('input[type=file]')[0];
                                        let TotalImages = $file.files.length;  //Total Images
                                        for (let i = 0; i < TotalImages; i++) {
                                            data.append('document', $file.files[i]);
                                        }
                                        data.append('id', id);
                                        data.append('organisation_id', organisation_id);

                                        var input = $(htmlcontent).serialize();

                                        axios.post(postURL, data, config)
                                            .then(function (response) {

                                                //vm.output = response.data;
                                                var results = response.data.data;
                                                if (results.success) {

                                                    toastr.success(results.message)
                                                    toastr.options.timeOut = 3000; // 3s

                                                    //refresh table
                                                    vm.init();


                                                } else {
                                                    toastr.error(results.message)
                                                    toastr.options.timeOut = 3000; // 3s
                                                }


                                            })

                                            .catch(function (error) {
                                                console.log(error);
                                                //post_response= error;

                                            });
                                    })

                                }

                                if ($(e.target).is(':not(td)') && $(e.target).closest('span').hasClass('view')) {
                                    let tr = $(this).closest('tr');
                                    let row = vm.dataTable.row(tr);
                                    var id = row.data().id;


                                    var redirect_url = vm.view_url + id;
                                    window.location.href = redirect_url;


                                }

                                if ($(e.target).is(':not(td)') && $(e.target).closest('i').hasClass('approve')) {
                                    let tr = $(this).closest('tr');
                                    let row = vm.dataTable.row(tr);
                                    var id = row.data().id;
                                    var organisation_id = row.data().organisation_id;


                                    var postURL = vm.approve_url;
                                    //alert(organisation_id)
                                    axios.post(postURL, {
                                        id: id,
                                        organisation_id: organisation_id
                                    })
                                        .then(function (response) {

                                            //vm.output = response.data;
                                            var results = response.data.data;
                                            if (results.success) {

                                                toastr.success(results.message)
                                                toastr.options.timeOut = 3000; // 3s


                                                //refresh table
                                                vm.init();


                                            } else {
                                                toastr.warning(results.message)
                                                toastr.options.timeOut = 3000; // 3s
                                            }


                                        })

                                        .catch(function (error) {
                                            console.log(error);
                                            //post_response= error;

                                        });


                                }

                                if ($(e.target).is(':not(td)') && $(e.target).closest('span').hasClass('approve_s')) {
                                    let tr = $(this).closest('tr');
                                    let row = vm.dataTable.row(tr);
                                    var id = row.data().id;


                                    var postURL = vm.approve_url;
                                    //alert(organisation_id)
                                    axios.post(postURL, {
                                        id: id,
                                        organisation_id: organisation_id
                                    })
                                        .then(function (response) {

                                            //vm.output = response.data;
                                            var results = response.data.data;
                                            if (results.success) {

                                                toastr.success(results.message)
                                                toastr.options.timeOut = 3000; // 3s


                                                //refresh table
                                                vm.init();


                                            } else {
                                                toastr.warning(results.message)
                                                toastr.options.timeOut = 3000; // 3s
                                            }


                                        })

                                        .catch(function (error) {
                                            console.log(error);
                                            //post_response= error;

                                        });
                                }
                            })

                            jQuery(document).on('click', '.update-goal', function () {
                                let form = $(this).parents("form:first");
                                var postURL = vm.update_url;//form.attr('action');
                                //alert(postURL)
                                // let tr = $(this).closest('tr');
                                // var row = vm.dataTable.row( tr );
                                // var id = row.data().id;
                                //alert(form.closest('tr').html())
                                /*$('<input>').attr({
                                    type: 'hidden',
                                    id: 'id',
                                    name: 'id',
                                    value: id
                                }).appendTo(form);*/
                                var input = form.serialize();
                                axios.put(postURL, input, config)

                                    .then(function (response) {

                                        //vm.output = response.data;
                                        var results = response.data.data;
                                        if (results.success) {

                                            toastr.success(results.message)
                                            toastr.options.timeOut = 3000; // 3s

                                            var post = results.post;
                                            $.each(post, function (key, val) {
                                                console.log("key : " + key + " ; value : " + val);
                                                if (form.find('input[name=' + key + ']')) {
                                                    form.find('input[name=' + key + ']').attr('placeholder', val)
                                                }

                                                if (form.find('textarea[name=' + key + ']')) {
                                                    form.find('textarea[name=' + key + ']').attr('placeholder', val)
                                                }


                                            });
                                            var title = post.title;
                                            var description = post.description;
                                            form.find('input[name=idea_title]').attr('placeholder', title)
                                            form.find('textarea[name=description]').attr('placeholder', description);
                                            //update selected row ...
                                            vm.selectedRow.data(post).invalidate().draw()

                                        }

                                        form.trigger('reset');


                                    })

                                    .catch(function (error) {
                                        console.log(error);
                                        //post_response= error;

                                    });
                            });

                            jQuery(document).on('click', '.cancel-update-goal', function () {

                                var form = $(this).parents("form:first");
                                form.trigger('reset');
                            })


                        });

                    })

                    .catch(function (error) {


                    });

            },
            format: function (d) {
                let vm = this;
                //var data_array = vm.data_array;
                var data_array = vm.fields;
                //alert(data_array)
                //var title_array = vm.title_array;
                var title_array = vm.capitalized_fields;
                //(vm.fields).split(',');//
                //alert(vm.fields)
                var arr = vm.fields.length;
                //alert( arr)
                // `d` is the original data object for the row
                var child_row = '';
                if (data_array.length === data_array.length) {


                    var html = '';
                    var child_div = '';
                    var image_div = '';
                    if (vm.is_child_row_form === 'false') {
                        child_div += '<div class="col-xs-12 col-md-12 col-lg-12">' +
                            '                                                <div class="card payment-card">' +
                            '                                                    <div>' +
                            '                                                        <a href="' + $('meta[name="app-url"]').attr('content') + '/download/' + d.document + '" title="Download CV"><i class="icofont icofont-file-pdf icofont-3x"></i></a>' +
                            '                                                        <h5>Curriculum Vitae</h5>' +
                            '                                                        <div class="row m-t-10">' +
                            '                                                            <div class="col-sm-6">' +
                            '                                                                <strong class="m-r-5">Name : ' + d.others + ' ' + d.surname + '</strong>' +
                            '                                                                <p><strong class="m-r-5">Specialization :</strong>' + d.area_of_specialization + '</p>' +
                            '                                                            </div>' +
                            '                                                            <div class="col-sm-6 text-right">' +
                            '                                                                <strong class="m-r-5">Department :</strong>' + d.department + '' +
                            '                                                            </div>' +
                            '                                                        </div>' +
                            '                                                    </div>';
                        ;
                        child_row = child_div;
                        // for (var i = 0; i < data_array.length; i++) {
                        //     //var rowId = eval('data.'+vm.akey);
                        //     //alert(eval('d.'+data_array[i]))
                        //
                        // }
                        // child_div+='                                                </div>' +
                        // '                                            </div>';
                    } else {
                        var form = '<form id="form_update_goal" action="' + $('meta[name="app-url"]').attr('content') + '/updateidea" method="post" role="form"' +
                            '      class="form-horizontal">' +
                            '        <div class="form-group">';
                        for (var i = 0; i < data_array.length; i++) {
                            //var rowId = eval('data.'+vm.akey);
                            //alert(data_array[i])


                            if (title_array[i] === eval('d.' + title_array[i])) {
                                //alert(eval('d.'+data_array[i]))
                            }
                            var image_picker = '';
                            if (vm.has_image === 'true') {
                                image_picker += '<input name="all_files" id="all_files" type="hidden">';
                                image_picker += '                <span folder="directory" value="uploads/avatars" class="hidden"></span> <input' +
                                    '                        value="' + $("meta[name='csrf-token']").attr('content') + '" name="_token" type="hidden">' +
                                    '                <div><input accept="image/*" id="file-input" multiple="multiple" style="margin-top: 1em;" type="file">' +
                                    '                </div>';

                            }

                            html += data_array[i] === 'description' ? (' <div class="form-group"><label for="inputEmail3" class="col-sm-2 control-label">' + title_array[i] + '</label>' +
                                '            <div class="col-sm-10"> <textarea name="' + data_array[i] + '"' +
                                '                                                                                                   id="' + data_array[i] + '"' +
                                '                                                                                                   placeholder="' + eval('d.' + data_array[i]) + '"' +
                                '                                                                                                   class="form-control"></textarea>' +
                                '' + image_picker + '' +
                                '            </div>' +
                                '        </div>') : data_array[i] === 'country' ? '' : '<div class="form-group">' +
                                '            <label for="inputEmail3" class="col-sm-2 control-label">' + title_array[i] + '</label>' +
                                '            <div class="col-sm-10">' +
                                // '           <input name="'+'id'+'" id="'+'id'+'" value="'+d.id+'"'+
                                // '                                          class="form-control" type="hidden">' +
                                // '           <input name="'+data_array[i]+'" id="'+data_array[i]+'" value="'+eval('d.'+data_array[i])+'"'+
                                // '                                          class="form-control" type="hidden">' +
                                '           <input name="' + data_array[i] + '" id="' + data_array[i] + '" placeholder="' + eval('d.' + data_array[i]) + '"' +
                                '                                          class="form-control" type="text">' +
                                '           </div></div>';
                        }
                        var col_sm = 'col-sm-12';
                        if (vm.has_image === 'true') {
                            image_div += '    <div class="col-xs-12 col-sm-3">' +
                                '        <div class="text-center">' +
                                '           <img class="thumbnail inline no-margin-bottom" alt="Domain Owner\'s Avatar"' +
                                '                                      src="' + $('meta[name="app-url"]').attr('content') + '/uploads/avatars/' + eval('d.' + vm.image_key) + '" height="100">' +
                                '           <span class="white">' + eval('d.' + data_array[0]) + '</span>' +

                                '        </div>' +
                                '    </div>';
                            col_sm = 'col-sm-9';

                        }
                        //alert(category_div);
                        child_div += '<div class="table-detail">';
                        child_div += '<div class="row">';
                        child_div += image_div;
                        child_div += '    <div class="col-xs-12 ' + col_sm + '">' +
                            '        <div class="space visible-xs"></div>' +

                            '        <div class="space-6">' +
                            '<h4 class="header blue lighter less-margin center" style="margin-left: 50%;">' + vm.update_header + '</h4>' +
                            '</div>';
                        var form = '<form id="form_update_goal" action="' + $('meta[name="app-url"]').attr('content') + '/updateidea" method="post" role="form"' +
                            '      class="form-horizontal">' +
                            '        <div class="form-group">';
                        form += '<input name="' + 'id' + '" id="' + 'id' + '" value="' + d.id + '"' +
                            '                                          class="form-control" type="hidden">';
                        var form_buttons = '<div class="form-group" style="float: right;margin-right: 20%;">' +
                            '                <button type="button" class="btn btn-success update-goal" style="cursor: pointer;"><i class="glyphicon "></i>&nbsp;Update' +
                            '                </button>' +
                            '                <button type="button" class="btn btn-danger cancel-update-goal" style="cursor: pointer;"><i class="glyphicon "></i>&nbsp;Cancel' +
                            '                </button>' +
                            '            </div>';
                        form += html;
                        form += form_buttons
                        form += '</form>';
                        child_div += form;

                        child_row = child_div
                    }


                }


                return child_row;
            },
            detailFormat: function (d) {
                let vm = this;
                var data_array = vm.data_array;
                var title_array = vm.title_array;

                // `d` is the original data object for the row
                var child_row = '';
                if (title_array.length === data_array.length) {

                    var form = '<form id="form_update_goal" action="' + $('meta[name="app-url"]').attr('content') + '/updateidea" method="post" role="form"' +
                        '      class="form-horizontal">' +
                        '        <div class="form-group">';

                    var html = '';
                    for (var i = 0; i < data_array.length; i++) {
                        //var rowId = eval('data.'+vm.akey);
                        //alert(data_array[i])


                        if (title_array[i] === eval('d.' + title_array[i])) {
                            //alert(eval('d.'+data_array[i]))
                        }
                        var image_picker = '';
                        if (vm.has_image === 'true') {
                            image_picker += '<input name="all_files" id="all_files" type="hidden">';
                            image_picker += '                <span folder="directory" value="uploads/avatars" class="hidden"></span> <input' +
                                '                        value="' + $("meta[name='csrf-token']").attr('content') + '" name="_token" type="hidden">' +
                                '                <div><input accept="image/*" id="file-input" multiple="multiple" style="margin-top: 1em;" type="file">' +
                                '                </div>';

                        }

                        html += data_array[i] === 'description' ? (' <div class="form-group"><label for="inputEmail3" class="col-sm-2 control-label">' + title_array[i] + '</label>' +
                            '            <div class="col-sm-10"> <textarea name="' + data_array[i] + '"' +
                            '                                                                                                   id="' + data_array[i] + '"' +
                            '                                                                                                   placeholder="' + eval('d.' + data_array[i]) + '"' +
                            '                                                                                                   class="form-control"></textarea>' +
                            '' + image_picker + '' +
                            '            </div>' +
                            '        </div>') : data_array[i] === 'country' ? '' : '<div class="form-group">' +
                            '            <label for="inputEmail3" class="col-sm-2 control-label">' + title_array[i] + '</label>' +
                            '            <div class="col-sm-10">' +
                            // '           <input name="'+'id'+'" id="'+'id'+'" value="'+d.id+'"'+
                            // '                                          class="form-control" type="hidden">' +
                            // '           <input name="'+data_array[i]+'" id="'+data_array[i]+'" value="'+eval('d.'+data_array[i])+'"'+
                            // '                                          class="form-control" type="hidden">' +
                            '           <input name="' + data_array[i] + '" id="' + data_array[i] + '" placeholder="' + eval('d.' + data_array[i]) + '"' +
                            '                                          class="form-control" type="text">' +
                            '           </div></div>';
                    }

                    var child_div = '';
                    var image_div = '';
                    var col_sm = 'col-sm-12';
                    if (vm.has_image === 'true') {
                        image_div += '    <div class="col-xs-12 col-sm-3">' +
                            '        <div class="text-center">' +
                            '           <img class="thumbnail inline no-margin-bottom" alt="Domain Owner\'s Avatar"' +
                            '                                      src="' + $('meta[name="app-url"]').attr('content') + '/uploads/avatars/' + eval('d.' + vm.image_key) + '" height="100">' +
                            '           <span class="white">' + eval('d.' + data_array[0]) + '</span>' +

                            '        </div>' +
                            '    </div>';
                        col_sm = 'col-sm-9';

                    }
                    //alert(category_div);
                    child_div += '<div class="table-detail">';
                    child_div += '<div class="row">';
                    child_div += image_div;
                    child_div += '    <div class="col-xs-12 ' + col_sm + '">' +
                        '        <div class="space visible-xs"></div>' +

                        '        <div class="space-6">' +
                        '<h4 class="header blue lighter less-margin center" style="margin-left: 50%;">' + vm.update_header + '</h4>' +
                        '</div>';
                    var form = '<form id="form_update_goal" action="' + $('meta[name="app-url"]').attr('content') + '/updateidea" method="post" role="form"' +
                        '      class="form-horizontal">' +
                        '        <div class="form-group">';
                    form += '<input name="' + 'id' + '" id="' + 'id' + '" value="' + d.id + '"' +
                        '                                          class="form-control" type="hidden">';
                    var form_buttons = '<div class="form-group" style="float: right;margin-right: 20%;">' +
                        '                <button type="button" class="btn btn-success update-goal" style="cursor: pointer;"><i class="glyphicon "></i>&nbsp;Update' +
                        '                </button>' +
                        '                <button type="button" class="btn btn-danger cancel-update-goal" style="cursor: pointer;"><i class="glyphicon "></i>&nbsp;Cancel' +
                        '                </button>' +
                        '            </div>';
                    form += html;
                    form += form_buttons
                    form += '</form>';
                    child_div += form;

                    child_row = child_div

                }


                return child_row;
            }
        }
    }
</script>
<style>


</style>
