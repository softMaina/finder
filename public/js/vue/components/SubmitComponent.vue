<template>
    <div class="col-sm-6">
        <div class="form-group">
            <button type="button" style="cursor: pointer" class="btn btn-primary m-b-0" @click="post($event)">{{ action
                }}
            </button>
            <button type="button" style="cursor: pointer" class="btn  m-b-0 btn-danger" @click="clearform($event)">{{
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
                //var input = form.serialize();
                var input = new FormData(form[0]);

                axios.post(postClub, input, config)

                    .then(function (response) {

                        //currentObj.output = response.data;
                        console.log(currentObj.output);
                        form.trigger('reset')
                        //call method, refresh table data
                        //this.$root.$emit('submitted') //like this

                        var result = response.data.data;
                        //alert(JSON.stringify(result))
                        if (result.success) {
                            toastr.success(result.message)
                            toastr.options.timeOut = 3000;
                            VEvent.$emit('submitted');


                            if(result.hasOwnProperty('img_post')){


                                var post = result.img_post;
                                let img = post.avatar;
                                let firstname = post.firstname;
                                let lastname = post.lastname;
                                let src = domain+'uploads/avatars'+'/'+img;
                                $('.profile-image img').attr("src",src);
                                if(!result.is_user){
                                    $('.image img').attr("src",src);
                                    $('.detail h4').text(firstname)
                                }


                                //$('h4.m-b-0 strong').text(lastname);
                                $('h4.m-t-0.m-b-0').text(firstname).append('&nbsp;').append('<strong>'+lastname+'</strong>');
                                //alert($('h4.m-t-0.m-b-0>strong').html()+' '+lastname)
                                //$('#image_preview').append("<img src='" + src + "'>");

                                $.each(post, function (key, val) {
                                    //console.log("key : " + key + " ; value : " + val);
                                    if (form.find('input[name=' + key + ']')) {
                                        form.find('input[name=' + key + ']').attr('placeholder', val)
                                    }

                                    if (form.find('textarea[name=' + key + ']')) {
                                        form.find('textarea[name=' + key + ']').attr('placeholder', val)
                                    }


                                });
                            }
                        } else {
                            toastr.error(results.message)
                            toastr.options.timeOut = 3000;
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
