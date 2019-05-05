<template>
  <v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar dark color="primary">
                <v-toolbar-title>Login</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-tooltip bottom>
                  <v-btn
                    icon
                    large
                    :href="source"
                    target="_blank"
                    slot="activator"
                  >
                    <v-icon large>account_circle</v-icon>
                  </v-btn>
                  <span>Source</span>
                </v-tooltip>
              </v-toolbar>
              <v-card-text>
                <v-form id="login-form">
                  <v-text-field
                    prepend-icon="person"
                    name="email"
                    label="Email"
                    type="text"
                    v-model="email"
                    :rules="emailRules"
                    ></v-text-field>
                  <v-text-field
                    prepend-icon="lock"
                    name="password"
                    label="Password"
                    id="password"
                    type="password"
                    v-model="password"
                    :rules="passwordRules"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn @click="submitLoginForm" color="primary">Submit</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { EventBus } from '../event-bus.js';

export default {
    data() {
        return {
            email: null,
            password: null,
            token: null,
            emailRules: [
              v => !!v || "E-mail is required"
            ],
            passwordRules: [
              v => !!v || "Password is required"
            ]
        }
    },
    props: {
        source: String
    },
    methods: {
      // checkEmpty(value, field){
      //   console.log(value,field)
      //   if(!value.trim()){
      //     this.field = this.field
      //   }
      // },
      submitLoginForm() {
          axios.post('http://localhost:8000/api/auth/login', {
              email: this.email,
              password: this.password
          })
          .then(function (response) {
              const token = response.data.access_token
              if (token) {
                  // this.token = token
                  EventBus.$emit('set-token',token)
              }
          })
          .catch(function (error) {
              console.log(error)
          });
      }
    }
}
</script>