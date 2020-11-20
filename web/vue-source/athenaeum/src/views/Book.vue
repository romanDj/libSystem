<template>
    <div class="container mt-4 mb-3">
        <template v-if="typePage=='view'">
            <h4 class="mb-3">Список книг</h4>

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
                   v-if="books==null||books.length == 0">
                    пока нет ни одной книги</p>
                <table class="table table-striped table-hover" v-else>
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Автор</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in books"
                        :key="'book'+value.id">
                        <th scope="row">{{index+1}}</th>
                        <td>{{value.title}}</td>
                        <td>{{value.description}}</td>
                        <td>{{value.author ? value.author.fio : '' }}</td>
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
            <form @submit.prevent="addBook" style="max-width: 450px">
                <div class="mb-3">
                    <label for="title" class="form-label">
                        Название</label>
                    <input id="title" type="text"
                           class="form-control"
                           v-model.trim="currBook.title">
                </div>
                <div class="mb-4">
                    <label for="description" class="form-label">
                        Описание</label>
                    <textarea id="description" class="form-control" rows="3"
                              v-model.trim="currBook.description"></textarea>
                </div>
                <div class="mb-4">
                    <label for="author" class="form-label">
                        Автор</label>
                    <select id="author" class="form-select"
                            v-model="currBook.author_id">
                        <option disabled :value="null">-- выберите автора --</option>
                        <option v-for="(value, index) in authors"
                                :key="'author'+value.id" :value="value.id">{{value.fio}}
                        </option>
                    </select>
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
            <form @submit.prevent="editBook" style="max-width: 450px">
                <div class="mb-3">
                    <label for="title1" class="form-label">
                        Название</label>
                    <input id="title1" type="text"
                           class="form-control"
                           v-model.trim="currBook.title">
                </div>
                <div class="mb-4">
                    <label for="description1" class="form-label">
                        Описание</label>
                    <textarea id="description1" class="form-control" rows="3"
                              v-model.trim="currBook.description"></textarea>
                </div>
                <div class="mb-4">
                    <label for="author1" class="form-label">
                        Автор</label>
                    <select id="author1" class="form-select"
                            v-model="currBook.author_id">
                        <option disabled :value="null">-- выберите автора --</option>
                        <option v-for="(value, index) in authors"
                                :key="'author'+value.id" :value="value.id">{{value.fio}}
                        </option>
                    </select>
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
            <p class="mb-4">Вы уверены, что хотите удалить ({{currBook.title}}) ?</p>
            <button type="button" @click.prevent="mainView"
                    class="btn btn-secondary mr-2">
                Отмена
            </button>
            <button type="submit" class="btn btn-danger"
                    v-if="!isLoading"
                    @click.prevent="removeBook">
                Удалить
            </button>
            <button type="submit" class="btn btn-danger" disabled
                    v-else>Загрузка...
            </button>
        </template>

    </div>
</template>

<script>
    const emptyBook = {
        id: null,
        title: '',
        description: '',
        author_id: null,
        author: null
    };

    export default {
        name: "Book",
        data: () => ({
            isLoading: false,
            typePage: 'view',
            currBook: Object.assign({}, emptyBook)
        }),
        computed: {
            authors() {
                return this.$store.getters.authors;
            },
            books() {
                return this.$store.getters.books;
            }
        },
        methods: {
            loadAuthors() {
                this.$store.dispatch('loadAuthors');
            },
            loadBooks() {
                this.isLoading = true;
                this.$store.dispatch('loadBooks')
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
            mainView() {
                this.typePage = 'view';
            },
            addView() {
                this.currBook = Object.assign({}, emptyBook);
                this.typePage = 'add';
            },
            editView(book) {
                this.currBook = Object.assign({}, book);
                this.typePage = 'edit';
            },
            deleteView(book) {
                this.currBook = Object.assign({}, book);
                this.typePage = 'delete';
            },
            addBook() {
                this.isLoading = true;
                this.$store.dispatch('addBook', this.currBook)
                    .finally(() => {
                        this.isLoading = false;
                        this.mainView();
                    });
            },
            editBook() {
                this.isLoading = true;
                this.$store.dispatch('editBook', this.currBook)
                    .finally(() => {
                        this.isLoading = false;
                        this.mainView();
                    });
            },
            removeBook() {
                this.isLoading = true;
                this.$store.dispatch('removeBook', this.currBook.id)
                    .finally(() => {
                        this.isLoading = false;
                        this.mainView();
                    });
            }
        },
        mounted() {
            this.loadBooks();
            this.loadAuthors();
        }
    }
</script>

<style scoped>

</style>