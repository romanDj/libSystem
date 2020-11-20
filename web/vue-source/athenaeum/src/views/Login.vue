<template>
    <div class="container">

        <div class="card w-100 mt-4 ml-auto mr-auto" style="max-width: 450px">
            <div class="card-body">
                <h5 class="text-center">Авторизация</h5>
                <form @submit.prevent="onSubmit" class="">
                    <div class="mb-3">
                        <label for="login" class="form-label">
                            Логин</label>
                        <input id="login" type="text"
                               class="form-control"
                               v-model.trim="login">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            Пароль</label>
                        <input id="password" type="password"
                               class="form-control"
                               v-model.trim="password">
                    </div>

                    <button type="submit" class="btn btn-success w-100"
                            v-if="!isLoading">Войти
                    </button>
                    <button type="submit" class="btn btn-success w-100" disabled
                            v-else>Загрузка...
                    </button>

                    <div class="alert alert-danger mb-0 mt-4 p-2" v-if="errors">
                        <p class="mb-1" v-for="(value, name, index) in errors"
                           :key="'error'+index">{{value[0]}}</p>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: "Login",
        data: () => ({
            login: '',
            password: '',
            errors: null,
            isLoading: false
        }),
        methods: {
            onSubmit() {
                if (this.isLoading == false) {
                    this.isLoading = true;
                    this.$store.dispatch('loginUser', {
                        login: this.login,
                        password: this.password
                    }).then(() => {
                        this.isLoading = false;
                        this.$router.push("/");
                    }).catch((e) => {
                        this.isLoading = false;
                        this.errors = e.data.errors;
                    });
                }
            }
        }
    }
</script>

<style scoped>

</style>