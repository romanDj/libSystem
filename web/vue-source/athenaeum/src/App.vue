<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">LibSystem</a>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mb-2 mb-lg-0">
                        <li class="nav-item"
                            v-for="(item, i) in menu"
                            :key="`menuitem${i}`">
                            <a class="nav-link"
                               :href="item.route"
                               @click.prevent="()=>goLink(item.route)">
                                {{item.title}}
                            </a>
                        </li>
                        <li class="nav-item" v-if="checkUser">
                            <a class="nav-link" href="/"
                               @click.prevent="logout">Выйти</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div>
            <RouterView/>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'App',
        components: {},
        data: () => ({
            //
        }),
        computed: {
            checkUser() {
                return this.$store.getters.checkAuth;
            },
            menu() {
                if (this.$store.getters.checkAuth) {
                    return [
                        {title: 'Книги', route: '/books'},
                        {title: 'Авторы', route: '/authors'},
                        // {title: 'Профиль', route: '/profile'}
                    ];
                } else {
                    return [
                        {title: 'Авторизация', route: '/login'},
                        {title: 'Регистрация', route: '/registration'}
                    ];
                }
            }
        },
        methods: {
            goLink(link) {
                this.$router.push(link)
            },
            logout() {
                this.$store.dispatch("logoutUser");
                this.$router.push('/login')
            }
        }
    };
</script>
