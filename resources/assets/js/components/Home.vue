<template>
  <v-app id="inspire" v-if="loggedIn">
    <v-toolbar color="indigo" dark fixed app>
      <v-toolbar-title>Noticeboard</v-toolbar-title>
    </v-toolbar>
      <v-content>
        <v-layout>
          <v-flex xs12 md12>
                <v-card>
                  <v-card-title primary-title>
                    <div>
                      <h3 class="headline mb-0">Community Notices</h3>
                    </div>
                  </v-card-title>
                <v-card-text>
                  <form id="submit-notice-form" @submit.prevent="submitNoticeForm">
                    <v-text-field label="Create a new notice" solo v-model="notice" name="post"></v-text-field>
                    <v-btn type="submit">Create Notice</v-btn>
                  </form>
                </v-card-text>
                  <v-layout v-for="obj in posts.slice().reverse()" v-bind:key="obj.id">
                    <v-flex>
                      <v-card>
                        <v-card-title>
                          <div>
                            <h4>{{ obj.post }}</h4><br>
                            <p>{{ obj.user.name }}</p>
                            <span>{{ obj.created_at }}</span>
                          </div>
                        </v-card-title>
                      </v-card>
                    </v-flex>
                  </v-layout>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-content>
    <v-footer color="indigo" app>
      <span class="white--text">&copy; 2019</span>
    </v-footer>
  </v-app>
  <login v-else></login>
</template>

<script>
import Login from './Login'
import { EventBus } from '../event-bus'

export default {
    data() {
      return {
        loggedIn: false,
        posts: [],
        notice: null,
        token: null,
      }
    },
    components: {
        Login
    },
    mounted() {
      EventBus.$on('set-token', (token) => {
        this.token = token
        this.loggedIn = true
        this.pusherConfig()
        this.fetchData()
      })
    },
    methods: {
      fetchData() {
        let self = this
        axios
          .get('http://localhost:8000/api/auth/posts/0',{
            headers: {
              Authorization: `Bearer ${self.token}`,
            }
          })
          .then(function (response) {
            response.data.forEach(function(obj) {
              self.posts.push(obj)
            })
          })
          .catch(function (error) {
            console.log(error)
          })
      },
      pusherConfig() {

        let self = this
        
        const pusher = new Pusher(GLOBALS.PUSHER_APP_KEY, {
            cluster: GLOBALS.PUSHER_APP_CLUSTER,
            forceTLS: true
        })

        const channel = pusher.subscribe('my-channel')

        channel.bind('submit-notice', function(data) {
          // console.log(data.message)
          axios
            .get(`http://localhost:8000/api/auth/posts/${data.message}`,{
              headers: {
                Authorization: `Bearer ${self.token}`,
              }
            })
            .then(function (response) {
              response.data.forEach(function(obj) {
                self.posts.push(obj)
              })
            })
            .catch(function (error) {
              console.log(error)
            })
        })
      },
      submitNoticeForm() {
        let formData = $("#submit-notice-form").serialize();
        let config = {headers: {Authorization: `Bearer ${this.token}`,"Content-Type": "application/x-www-form-urlencoded"}}
        axios.post('http://localhost:8000/api/auth/posts',formData,config)
          .then(function (response) {
            console.log(response.data)
          })
          .catch(function (error) {
              console.log(error)
          })
      }
    }
}
</script>
