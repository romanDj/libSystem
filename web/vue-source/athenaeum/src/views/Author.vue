<template>
    <div class="container mt-4 mb-3">
        <template v-if="typePage=='view'">
            <h4 class="mb-3">Список авторов</h4>

            <button type="button"
                    @click.prevent="addView"
                    class="btn btn-primary btn-sm mb-3">Добавить
            </button>

            <template v-if="isLoading">
                <p class="text-center text-secondary mt-4">
                    Загрузка...</p>
            </template>
            <template v-else>
                <p class="text-center text-secondary mt-4"
                   v-if="authors==null||authors.length == 0">
                    пока нет ни одного автора</p>
                <table class="table table-striped table-hover" v-else>
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ФИО</th>
                        <th scope="col">Об авторе</th>
                        <th scope="col">Кол-во книг</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in authors"
                        :key="'author'+value.id">
                        <th scope="row">{{index+1}}</th>
                        <td>{{value.fio}}</td>
                        <td>{{value.description}}</td>
                        <td>{{value.books ? value.books.length : 0 }}</td>
                        <td>
                            <span class="mdi mdi-pencil text-primary m-1" style="font-size: 20px"
                                  @click.prevent="()=>editView(value)"></span>
                            <span class="mdi mdi-delete text-danger m-1" style="font-size: 20px"
                                  @click.prevent="()=>deleteView(value)"></span>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </template>
        </template>

        <template v-else-if="typePage=='add'">
            <h4 class="mb-3">Добавление</h4>
            <form @submit.prevent="addAuthor" style="max-width: 450px">
                <div class="mb-3">
                    <label for="fio" class="form-label">
                        ФИО</label>
                    <input id="fio" type="text"
                           class="form-control"
                           v-model.trim="currAuthor.fio">
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label">
                        Об авторе</label>
                    <textarea id="description" class="form-control" rows="3"
                              v-model.trim="currAuthor.description"></textarea>
                </div>

                <button type="button" @click.prevent="mainView"
                        class="btn btn-secondary mr-2">
                    Отмена
                </button>
                <button type="submit" class="btn btn-primary" v-if="!isLoading">
                    Сохранить
                </button>
                <button type="submit" class="btn btn-primary" disabled
                        v-else>Загрузка...
                </button>
            </form>
        </template>


        <template v-else-if="typePage=='edit'">
            <h4 class="mb-3">Редактирование</h4>
            <form @submit.prevent="editAuthor" style="max-width: 450px">
                <div class="mb-3">
                    <label for="fio1" class="form-label">
                        ФИО</label>
                    <input id="fio1" type="text"
                           class="form-control"
                           v-model.trim="currAuthor.fio">
                </div>
                <div class="mb-4">
                    <label for="description1" class="form-label">
                        Об авторе</label>
                    <textarea id="description1" class="form-control" rows="3"
                              v-model.trim="currAuthor.description"></textarea>
                </div>

                <button type="button" @click.prevent="mainView"
                        class="btn btn-secondary mr-2">
                    Отмена
                </button>
                <button type="submit" class="btn btn-primary" v-if="!isLoading">
                    Сохранить
                </button>
                <button type="submit" class="btn btn-primary" disabled
                        v-else>Загрузка...
                </button>
            </form>
        </template>

        <template v-else-if="typePage=='delete'">
            <h4 class="mb-3">Подтверждение</h4>
            <p class="mb-4">Вы уверены, что хотите удалить ({{currAuthor.fio}}) ?</p>
            <button type="button" @click.prevent="mainView"
                    class="btn btn-secondary mr-2">
                Отмена
            </button>
            <button type="submit" class="btn btn-danger"
                    v-if="!isLoading"
                    @click.prevent="removeAuthor">
                Удалить
            </button>
            <button type="submit" class="btn btn-danger" disabled
                    v-else>Загрузка...
            </button>
        </template>

    </div>
</template>

<script>
    const emptyAuthor = {
        id: null,
        fio: '',
        description: ''
    };

    export default {
        name: "Author",
        data: () => ({
            isLoading: false,
            typePage: 'view',
            currAuthor: Object.assign({}, emptyAuthor)
        }),
        computed: {
            authors() {
                return this.$store.getters.authors;
            }
        },
        methods: {
            loadAuthors() {
                this.isLoading = true;
                this.$store.dispatch('loadAuthors')
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            mainView() {
                this.typePage = 'view';
            },
            addView() {
                this.currAuthor = Object.assign({}, emptyAuthor);
                this.typePage = 'add';
            },
            editView(author) {
                this.currAuthor = Object.assign({},author);
                this.typePage = 'edit';
            },
            deleteView(author) {
                this.currAuthor = Object.assign({},author);
                this.typePage = 'delete';
            },
            addAuthor() {
                this.isLoading = true;
                this.$store.dispatch('addAuthor', this.currAuthor)
                    .finally(() => {
                        this.isLoading = false;
                        this.mainView();
                    });
            },
            editAuthor() {
                this.isLoading = true;
                this.$store.dispatch('editAuthor', this.currAuthor)
                    .finally(() => {
                        this.isLoading = false;
                        this.mainView();
                    });
            },
            removeAuthor() {
                this.isLoading = true;
                this.$store.dispatch('removeAuthor', this.currAuthor.id)
                    .finally(() => {
                        this.isLoading = false;
                        this.mainView();
                    });
            }
        },
        mounted() {
            this.loadAuthors();
        }
    }
</script>

<style scoped>

</style>