import { createStore } from "vuex"

export default createStore({
    state: {
        user: {
            username: localStorage.getItem('username'),
            level: localStorage.getItem('level')
        }
    },

    mutations: {
        CONFIRM_USERNAME:(state, username) => {
            state.user.username = username
        },

        CONFIRM_LEVEL:(state, level) => {
            state.user.level = level
        }
    },

    actions: {
        setUsername({commit}, username) {
            commit('CONFIRM_USERNAME', username)
        },

        setLevel({commit}, level) {
            commit('CONFIRM_LEVEL', level)
        }
    }
})