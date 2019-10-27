<template>
    <div class="row">
        <div class="col-8">
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">

                                <h4>Recent </h4>
                            </div>
                            <div class="srch_bar">
                                <div class="stylish-input-group">
                                    <input type="text" id="search" class="search-bar-" placeholder="Search"
                                           onkeydown="searchMessageDown()" onkeyup="searchMessageUp()"/>
                                    <!--<span class="input-group-addon-">
                                        <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                                    </span>-->
                                </div>
                            </div>
                        </div>
                        <div class="inbox_chat">
                            <!--<div class="chat_list active_chat" conversation_id="d->conversation_id}}"
                                 friend_id="friend->id}}">
                                <div class="chat_people">
                                    <div class="chat_img"><img src="https://ptetutorials.com/images/user-profile.png"
                                                               alt="sunil"></div>
                                    <div class="chat_ib">
                                        <h5>Simon Kamau <span class="chat_date">Dec 25</span></h5>
                                        &lt;!&ndash;                                            <p>Test, which is a new approach to have all solutions
                                                                                    astrology under one roof.</p>&ndash;&gt;
                                        <p>fddgdgd</p>

                                    </div>
                                </div>
                            </div>-->
                            <div v-for="(recent, index) in recents" :key="index" class="chat_list"
                                 conversation_id="conversation_id" friend_id="friend->id">
                                <div class="chat_people" @click="fetchByID(recent.user.id)">
                                    <div class="chat_img"><img
                                        v-bind:src="app_url+'uploads/avatars/'+recent.user.avatar"
                                        alt="sunil"></div>
                                    <div class="chat_ib">
                                        <h5>{{ recent.user.firstname }} <span
                                            class="chat_date">{{ recent.created_at }}</span></h5>

                                        <p>{{ recent.message }}</p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="recents.length===0" class="chat_list" conversation_id="conversation_id"
                                 friend_id="friend->id">
                                <div class="chat_people">
                                    <div class="chat_img"></div>
                                    <div class="chat_ib">

                                        <p>{{recents_not_found}}</p>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="mesgs">
                        <div class="msg_history" style="height:300px; overflow-y:scroll" v-chat-scroll="">
                            <div v-if="messages.length > 0" v-for="(message, index) in messages" :key="index">
                                <div class="incoming_msg" v-if="JSON.parse(user).id==message.user.id">
                                    <div class="incoming_msg_img">
                                        <img src="https://ptetutorials.com/images/user-profile.png" alt="">
                                    </div>
                                    <div class="received_msg">
                                        <div class="received_withd_msg">
                                            <p>{{ message.message }}</p>
                                            <span class="time_date"> {{ message.created_at }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="outgoing_msg">
                                    <div class="sent_msg">
                                        <p>{{ message.message }}</p>
                                        <span class="time_date"> {{ message.created_at }}</span></div>
                                </div>
                            </div>
                            <div v-if="messages.length ===0" style="margin: 120px 150px;color: #989898;">
                                <p>{{messages_not_found}}</p>
                            </div>

                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input
                                    v-on:keydown="sendPrivateTypingEvent"
                                    v-on:keyup.enter="sendPrivateMessage"
                                    v-model="newMessage"
                                    type="text"
                                    name="message"
                                    placeholder="Type a message"
                                    class="write_msg">
                                <button class="msg_send_btn" type="button" v-on:click="sendPrivateMessage"><i
                                    class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                            </div>
                            <span class="text-muted"
                                  v-if="activeUser">{{ activeUser.firstname }} is typing...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2 pointer" v-for="(user, index) in users.filter(u => u.id != loggedInUser.id)"
                            key="index"
                            @click="fetchByID(user.id)" style="padding-left: 1em;">
                            {{ user.firstname }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</template>

<script type="text/javascript">
    module.exports = {

        props: ['user'],

        data() {
            return {
                messages: [],
                recents: [],
                newMessage: '',
                typingFriend: {},
                users: [],
                activeUser: false,
                typingTimer: false,
                loggedInUser: '',
                app_url: document.head.querySelector('meta[name="app-url"]').content + '/',
                recents_not_found: '',
                messages_not_found: ''
            }
        },

        created() {
            this.recentMessages();
            //this.fetchMessages();
            let vm = this;


            Echo = new Echo({
                authEndpoint: domain + 'broadcasting/auth',
                broadcaster: 'pusher',
                key: 'anyKey'/*process.env.MIX_PUSHER_APP_KEY*/,
                wsHost: window.location.hostname,
                wsPort: 6001,
                disableStats: true,
            });
            /*Echo.join('chat')
                .here(user => {
                    this.users = user;
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;

                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }

                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 3000);
                })*/
            Echo.join('plchat')
                .here(user => {
                    this.users = user;
                    this.loggedInUser = JSON.parse(this.user);
                    //alert(JSON.stringify(this.loggedInUser))
                    this.recentMessages();
                })
                .joining(user => {
                    this.users.push(user);
                })
                .leaving(user => {
                    this.users = this.users.filter(u => u.id != user.id);
                })
                .listen('MessageSent', (event) => {
                    this.messages.push(event.message);
                })
                .listenForWhisper('typing', user => {
                    this.activeUser = user;
                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }

                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 3000);
                })

            Echo.private('privatechat.' + JSON.parse(this.user).id)
                .listen('PrivateMessageSent', (e) => {
                    console.log(e.message)
                    this.activeFriend = e.message.user_id;
                    this.messages.push(e.message)
                    setTimeout(this.scrollToEnd, 100);
                    /*if(this.recents.length ===0){
                        this.recentMessages();
                    }*/
                    //this.recentMessages();
                    var message = e.message;
                    var unread = message.unread;
                    var sender = message.sender;
                    var note = message.message;
                    var date = message.created_at;
                    //console.log(notification)
                    $html = '<div class="notfication-details">' +
                        '    <div class="noty-user-img">' +
                        '        <img src="' + domain + 'uploads/avatars/' + message.user.avatar + '" alt="">' +
                        '    </div>' +
                        '    <div class="notification-info">' +
                        '        <h3><a href="messages.html" title="">' + message.user.firstname + '</a></h3>' +
                        '        <p>' + note + '</p>' +
                        '        <span>' + date + '</span>' +
                        '    </div><!--notification-info -->' +
                        '</div>';
                    $('.notfication-details').filter(':last').remove();
                    jQuery('#notification_menu_message').prepend($html).trigger('ul');
                    var count = $('.noti-badge-message').text();
                    var total = 1 + parseInt(count);
                    jQuery('.noti-badge-message').text(total).trigger('span');

                })
                .listenForWhisper('typing', (e) => {
                    alert()
                    if (e.user.id == this.activeFriend) {

                        this.typingFriend = e.user;

                        if (this.typingClock) clearTimeout();

                        this.typingClock = setTimeout(() => {
                            this.typingFriend = {};
                        }, 9000);
                    }

                    this.activeUser = user;

                    if (this.typingTimer) {
                        clearTimeout(this.typingTimer);
                    }

                    this.typingTimer = setTimeout(() => {
                        this.activeUser = false;
                    }, 3000);
                });

            VEvent.$on('ping', function () {
                //alert()
                if (!this.activeUser) {
                    //vm.recentMessages();
                }

            });

        },

        methods: {
            fetchMessages() {
                axios.get('messages/get').then(response => {
                    this.messages = response.data;
                    if (this.messages.length > 0) {


                    }
                })
            },
            fetchByID(user_id) {

                //var url = 'messages/fetch/' + this.activeFriend;
                var url = 'messages/fetch/' + user_id;
                axios.get(url).then(response => {

                    if (response.data.length > 0) {

                        this.messages = response.data;
                    } else {
                        if (this.messages.length == 0) {
                            this.messages_not_found = 'No Messages'
                        }

                    }
                    this.activeFriend = user_id;
                })


                //this.activeFriend=this.user.id;
                /*if(typeof this.activeFriend !='undefined'){
                    var url = '/message/fetch/.' + this.activeFriend;
                    alert(url)
                    axios.get(url).then(response => {
                        this.messages = response.data;
                        if (this.messages.length > 0) {


                        }
                    })
                }*/

            },
            recentMessages() { /*recent/get*/
                axios.get('following/users').then(response => {
                    if (response.data.length > 0) {
                        this.recents = (response.data);
                        //alert(JSON.stringify(this.recents))
                        this.activeFriend = this.recents[0].user.id;
                        /*this.activeFriend = typeof(this.recents[0].messages.user_id)==='undefined'?this.users[0].id:this.recents[0].messages.user_id;*/

                        this.fetchByID(this.activeFriend);
                    } else {
                        this.recents_not_found = 'No Recent Conversations yet';

                    }

                })
            }, sendPrivateMessage() {

                //check if there message
                if (!this.newMessage) {
                    return alert('Please enter message');
                }
                if (!this.activeFriend) {
                    return alert('Please select friend');
                }

                axios.post('private-messages/' + this.activeFriend, {message: this.newMessage}).then(response => {

                    /*var $message = response.data.message;
                    var $user = $message.user;

                    var $recent = {
                        user: $user,
                        message: $message.message
                    }

                    this.recents.splice(0,0,$recent)*/

                    var $result = response.data;
                    var $message = $result.message;
                    //alert(JSON.stringify($message))

                    var sending_user = JSON.parse(this.user);//this.user.replace(/\\"/g, "\"");
                    var addedum = {
                        user: sending_user,
                        message: this.newMessage
                    }

                    //this.messages.push(addedum);/**/
                    this.messages.push($message);
                    this.newMessage = null;
                    //this.recentMessages();

                });
            },
            sendMessage() {
                var sending_user = JSON.parse(this.user);//this.user.replace(/\\"/g, "\"");
                var addedum = {
                    user: sending_user,
                    message: this.newMessage
                }

                this.messages.push(addedum);
                //this.recents.push(addedum);

                axios.post('messages', {message: this.newMessage});

                this.newMessage = '';

            },

            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            },
            sendPrivateTypingEvent() {
                Echo.join('plchat')
                    .whisper('typing', this.user);
            }
        }
    }
</script>
<style>
    .container {
        max-width: 1170px;
        margin: auto;
    }

    .chat_ib > h5, .chat_img {
        cursor: pointer;
    }

    img {
        max-width: 100%;
    }

    .inbox_people {
        background: #f8f8f8 none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 40%;
        border-right: 1px solid #c4c4c4;
    }

    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }

    .top_spac {
        margin: 20px 0 0;
    }

    .recent_heading {
        float: left;
        width: 40%;
    }

    .srch_bar {
        display: inline-block;
        text-align: right;
        width: 60%;
        padding: 4px;
    }

    .headind_srch {
        padding: 10px 29px 10px 20px;
        overflow: hidden;
        border-bottom: 1px solid #c4c4c4;
    }

    .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
    }

    .srch_bar input {
        border: 1px solid #cdcdcd;
        border-width: 0 0 1px 0;
        width: 80%;
        padding: 2px 0 4px 6px;
        background: none;
    }

    .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
    }

    .srch_bar .input-group-addon {
        margin: 0 0 0 -27px;
    }

    .chat_ib h5 {
        font-size: 15px;
        color: #464646;
        margin: 0 0 8px 0;
    }

    .chat_ib h5 span {
        font-size: 13px;
        float: right;
    }

    .chat_ib p {
        font-size: 14px;
        color: #989898;
        margin: auto
    }

    .chat_img {
        float: left;
        width: 11%;
    }

    .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
    }

    .chat_people {
        overflow: hidden;
        clear: both;
    }

    .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
    }

    .inbox_chat {
        height: 300px;
        overflow-y: scroll;
    }

    .active_chat {
        background: #ebebeb;
    }

    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }

    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }

    .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }

    .received_withd_msg {
        width: 57%;
    }

    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
    }

    .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0;
        color: #fff;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .outgoing_msg {
        overflow: hidden;
        margin: 26px 0 26px;
    }

    .sent_msg {
        float: right;
        width: 46%;
    }

    .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    .type_msg {
        border-top: 1px solid #c4c4c4;
        position: relative;
    }

    .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
    }

    .messaging {
        padding: 0 0 50px 0;
    }

    .msg_history {
        height: 300px;
        overflow-y: auto;
    }

    .pointer {
        cursor: pointer;
    }

</style>
