<template>
  <v-app id="inspire" v-if="loggedIn">
    <v-toolbar color="indigo" dark fixed app>
      <v-toolbar-title>Noticeboard</v-toolbar-title>
    </v-toolbar>
    <v-content>
      <v-container fluid fill-height>
        <v-layout
          justify-center
          align-center
        >
          <v-flex text-xs-center>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
    <v-footer color="indigo" app>
      <span class="white--text">&copy; 2019</span>
    </v-footer>
  </v-app>
  <login v-else></login>
</template>

<script>
import Login from './Login'
import { EventBus } from '../event-bus';

export default {
    data() {
        return {
            loggedIn: false
        }
    },
    props: {
        source: String
    },
    components: {
        Login
    },
    mounted() {
      EventBus.$on('set-token', (e) => {
        this.loggedIn = true
      });
    }
}
</script>