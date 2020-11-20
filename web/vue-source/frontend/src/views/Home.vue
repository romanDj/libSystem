<template>
  <div>
    <v-card :elevation="3" class="mx-auto card-size">
      <div class="login-form">
        <v-card-text class="my-4 text-center title">Вход на портал</v-card-text>
        <v-text-field label="Имя пользователя" v-model="login"/>
        <v-text-field label="Пароль" type="password" v-model="password"/>
        <v-btn @click="enter" class="enter-btn" rounded color="primary" dark>Войти</v-btn>
      </div>
    </v-card>
  </div>
</template>

<script lang="ts">
// @ is an alias to /src
import Vue from 'vue'
import axios from 'axios';

interface Props {}

interface Data {
  login: string
  password: string
}

interface Computed {}

interface Methods {
  enter: () => void
}

interface loginForm {
  login: string
  password: string
}

export default Vue.extend<Data, Methods, Computed, Props>({
  methods: {
    enter() {
      let loginData = {} as loginForm;

      loginData.login = this.login;
      loginData.password = this.password;

      axios.post('user/login', loginData).then((response) => {
        if(response.status === 404) {
          alert(response.statusText);
          return;
        } else {
          localStorage.setItem("auth_token", response.data.token);
          window.location.href = "/foo?access-token=" + response.data.token;
        }
      });
    }
  },
  data() {
    return {
      login: "",
      password: ""
    }
  },
  computed: {},
  props: {},
})
</script>

<style>
  .card-size {
    margin: auto;
    width: 30%;
  }

  .enter-btn{
    width: 100%;
    margin-bottom: 20px;
  }

  .login-form{
    margin: auto;
    width: 90%;
  }
</style>
