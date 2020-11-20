import {Api, Athenaeum} from './api';

export default {
    state: {
        authors: null,
        books: null
    },
    getters: {
        authors(state) {
            return state.authors;
        },
        books(state) {
            return state.books;
        }
    },
    mutations: {
        setAuthors(state, payload) {
            state.authors = payload;
        },
        addAuthor(state, payload) {
            state.authors.push(payload);
        },
        removeAuthor(state, payload) {
            state.authors = state.authors
                .filter(x => x.id != payload);
        },
        editAuthor(state, payload) {
            state.authors = state.authors
                .map((item) => {
                    if (item.id == payload.id) {
                        return {
                            ...item,
                            ...payload
                        };
                    }
                    return item;
                });
        },
        setBooks(state, payload) {
            state.books = payload;
        },
        addBook(state, payload) {
            state.books.push(payload);
        },
        removeBook(state, payload) {
            state.books = state.books
                .filter(x => x.id != payload);
        },
        editBook(state, payload) {
            state.books = state.books
                .map((item) => {
                    if (item.id == payload.id) {
                        return {
                            ...item,
                            ...payload
                        };
                    }
                    return item;
                });
        },
    },
    actions: {
        async loadAuthors({commit}) {
            try {
                const query = await Athenaeum.Author.list();
                commit('setAuthors', query.data);
            } catch (e) {
                throw e;
            }
        },
        async getAuthor({commit}, id) {
            try {
                const query = await Athenaeum.Author.get(id);
                console.log(query.data);
            } catch (e) {
                throw e;
            }
        },
        async addAuthor({commit}, {fio, description}) {
            try {
                const query = await Athenaeum.Author.add({fio, description});
                commit('addAuthor', query.data);
            } catch (e) {
                throw e;
            }
        },
        async editAuthor({commit}, {id, fio, description}) {
            try {
                const query = await Athenaeum.Author.edit({id, fio, description});
                commit('editAuthor', query.data);
            } catch (e) {
                throw e;
            }
        },
        async removeAuthor({commit}, id) {
            try {
                const query = await Athenaeum.Author.remove(id);
                if (query.response.status == 204) {
                    commit('removeAuthor', id);
                }
            } catch (e) {
                throw e;
            }
        },
        async loadBooks({commit}) {
            try {
                const query = await Athenaeum.Book.list();
                commit('setBooks', query.data);
            } catch (e) {
                throw e;
            }
        },
        async addBook({commit, state}, {title, description, author_id}) {
            try {
                const query = await Athenaeum.Book
                    .add({title, description, author_id});

                const author = state.authors.find(x => x.id == author_id);

                commit('addBook', {
                    ...query.data,
                    author: author ? {
                        id: author.id,
                        fio: author.fio,
                        description: author.description
                    } : null
                });
            } catch (e) {
                throw e;
            }
        },
        async editBook({commit, state}, {id, title, description, author_id}) {
            try {
                const query = await Athenaeum.Book
                    .edit({id, title, description, author_id});

                const author = state.authors.find(x => x.id == author_id);


                commit('editBook', {
                    ...query.data,
                    author: author ? {
                        id: author.id,
                        fio: author.fio,
                        description: author.description
                    } : null
                });
            } catch (e) {
                throw e;
            }
        },
        async removeBook({commit}, id) {
            try {
                const query = await Athenaeum.Book.remove(id);
                if (query.response.status == 204) {
                    commit('removeBook', id);
                }
            } catch (e) {
                throw e;
            }
        },
    }
};
