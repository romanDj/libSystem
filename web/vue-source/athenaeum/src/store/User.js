import {Api, User} from './api';


export default {
    state: {
        token: Api.getCookie("access_token")
            || null,
        user: null
    },
    mutations: {
        setToken(state, payload) {
            state.token = payload;
        },
        setUser(state, payload) {
            state.user = payload;
        }
    },
    getters: {
        user(state) {
            return state.user;
        },
        checkAuth(state) {
            return state.token !== null;
        }
    },
    actions: {
        async loginUser({commit}, {login, password}) {
            try {
                const query = await User.login({login, password});
                if (query.data.status) {
                    Api.setCookie("access_token", query.data.token);
                    commit("setToken", query.data.token);
                }
            } catch (e) {
                throw e;
            }
        },
        logoutUser({commit}, payload) {
            Api.deleteCookie("access_token");
            commit("setToken", null);
            commit("setUser", null);
        },
        async registerUser({commit}, {login, password, fio}) {
            try {
                const query = await User.registration({login, password, fio});
                if (query.data.status) {
                    console.log(query.data)
                }
            } catch (e) {
                throw e;
            }
        }
    }
};
