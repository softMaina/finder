<template>
    <div class="">
        <div class="form-group">
            <button type="button" style="cursor: pointer" class="btn btn-primary col-sm-5" @click="post($event)">{{
                action }}
            </button>
            <button type="button" style="cursor: pointer" class="btn btn-primary col-sm-6 btn-danger"
                    @click="clearform($event)">{{
                btncancel }}
            </button>
        </div>

        {{ output }}
    </div>
</template>

<script type="text/javascript">
    module.exports = {
        mounted: function () {

        },
        /*props:[
            'action',
        ],*/
        props: {
            action: {
                default: "Submit",
                type: String
            },
            btncancel: {
                default: "Reset",
                type: String
            }, info_type: {
                default: "info",
                type: String
            }
        },
        data: function () {
            return {

                btnname: 'Submit 1',
                output: ''


            }
        },
        methods: {
            post: function (e) {
                e.preventDefault();
                let currentObj = this;
                //const postClub = domain + 'clubs';
                var form = $(e.target).parent().closest('form');
                form.find("input").filter(':disabled').removeAttr('disabled');
                var postClub = form.attr('action');
                //var input = JSON.stringify(form.serializeArray());
                var input = form.serialize();

                axios.post(postClub, input, config)

                    .then(function (response) {

                        //currentObj.output = response.data;
                        console.log(currentObj.output);
                        form.trigger('reset')
                        //call method, refresh table data
                        //this.$root.$emit('submitted') //like this
                        VEvent.$emit('submitted');
                        var result = response.data.data;
                        //alert(JSON.stringify(result))
                        if (result.success) {

                            toastr.success(result.message)
                            toastr.options.timeOut = 3000; // 3s

                        } else {
                            toastr.error(result.message)
                            toastr.options.timeOut = 3000; // 3s
                        }

                    })

                    .catch(function (error) {

                        this.name = error;

                    });
            },
            clearform: function (e) {
                e.preventDefault();
                let currentObj = this;
                //const postClub = domain + 'clubs';
                var form = $(e.target).parent().closest('form');
                form.trigger('reset');
            }
        }
    }
</script>
<style>


</style>
