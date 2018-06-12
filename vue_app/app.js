import Vue from 'vue'
import App from './App.vue'
import './styles/main.scss'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
        /**
         * Messages <type>:<message>
         */
        messages: []
    },
    mutations: {
        errorPush (state, message) {
            state.messages.push(message)
            setTimeout(() => {
                state.messages.pop()
            }, 10000)
        }
    }
})

new Vue({
    el: '#app',
    store,
    render: h => h(App)
})