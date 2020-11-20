<template>
  <v-app>
    <v-app-bar dark app>
      <v-toolbar-side-icon>
        <v-img class="mr-3" src="@/assets/logo.png">
        </v-img>
      </v-toolbar-side-icon>
    </v-app-bar>

    <v-content>
      <RouterView/>
    </v-content>

    <v-card height="150">
      <v-footer absolute dark class="font-weight-medium">
        <v-col class="text-center" cols="12">
          {{ new Date().getFullYear() }}
        </v-col>
      </v-footer>
    </v-card>
  </v-app>
</template>

<script>
import Vue from 'vue';
import Vuetify from 'vuetify/lib';


export default Vue.extend({
  name: 'App',

  components: {},

  data: () => ({
    //
  }),
});
</script>
