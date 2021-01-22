import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)



export default new  Vuex.Store({
    state : {
        counter : 100,
        user: false
    },
    getters : {
        getCounter(state){
            return state.counter
        }
    },
    mutations : {
        changeTheCounter(state, data){
            state.counter += data
        },
        updateUser(state, data){
            state.user = data
        }
    }
})
export const strict = false
export const state =() => ({

});

 export const getters = {

}

//export common mutations for changing data from action
export const mutations = {

}

//actions for commiting mutations
export const actions = {

}
