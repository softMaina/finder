<template>
    <div class="row">

        <div class="col-8">
            <div class="card card-default">
                <div class="card-header">Messages</div>
                <div class="card-body p-0">
                    <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll="">
                        <li class="p-2" v-for="(message, index) in messages" :key="index">
                            <strong>{{ message.user.firstname }}</strong>
                            {{ message.message }}
                        </li>
                    </ul>
                </div>

                <input
                    v-on:keydown="sendTypingEvent"
                    v-on:keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control">
            </div>
            <span class="text-muted" v-if="activeUser">{{ activeUser.firstname }} is typing...</span>
        </div>

        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Active Users</div>
                <div class="card-body">
                    <ul>
                        <li class="py-2" v-for="(user, index) in users.filter(u => u.id != user.id)" key="index"
                            @click="activeFriend=user.id">
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
                newMessage: '',
                users: [],
                activeUser: false,
                typingTimer: false,
            }
        },

        created() {
            this.fetchMessages();
            Echo = new Echo({
                authEndpoint: domain + 'broadcasting/auth',
                broadcaster: 'pusher',
                key: 'anyKey'/*process.env.MIX_PUSHER_APP_KEY*/,
                wsHost: window.location.hostname,
                wsPort: 6001,
                disableStats: true,
            });
            Echo.join('plchat')
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
                })

        },

        methods: {
            fetchMessages() {
                axios.get('messages/get').then(response => {
                    this.messages = response.data;
                    if (this.friends.length > 0) {
                        this.activeFriend = this.messages[0].user.id;
                    }
                })
            },

            sendMessage() {
                var sending_user = JSON.parse(this.user);//this.user.replace(/\\"/g, "\"");
                var addedum = {
                    user: sending_user,
                    message: this.newMessage
                }

                this.messages.push(addedum);

                axios.post('messages', {message: this.newMessage});

                this.newMessage = '';

            },

            sendTypingEvent() {
                Echo.join('chat')
                    .whisper('typing', this.user);
            }
        }
    }
</script>
