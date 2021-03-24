import Vue from 'vue'
import Vuex from 'vuex'
Vue.use(Vuex)



export default new  Vuex.Store({
    state : {
        counter : 100,
        user: false,
        userPermission: null
    },
    getters : {
        getCounter(state){
            return state.counter
        },
        getUserPermission(state){
            return state.userPermission
        }
    },
    mutations : {
        changeTheCounter(state, data){
            state.counter += data
        },
        setUpdateUser(state, data){
            state.user = data
        },
        setUserPermission(state, data){
            state.userPermission = data
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
