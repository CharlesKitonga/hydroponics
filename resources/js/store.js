import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)



export default new  Vuex.Store({
    state : {
        counter : 100
    },
    getters : {
        getCounter(state){
            return state.counter
        }
    },
    mutations : {
    changeTheCounter(state, data){
        state.counter += data
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
