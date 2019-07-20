const state = () => ({

})

const mutations = {

}

const actions = {
    submit({ commit }, payload) {
        localStorage.setItem('token', null)
        commit('SET_TOKEN', null, { root: true })

        return new Promise((resolve, reject) => {
            axios.post('/login', payload)
            .then((response) => {
                if (response.data.status == 'success') {
                    localStorage.setItem('token', response.data.data.token)
                    axios.defaults.headers.common['Authorization'] = localStorage.getItem('token') != 'null' ? 'Bearer ' + localStorage.getItem('token') : '';
                    commit('SET_TOKEN', response.data.data.token, { root: true })
                } else {
                    commit('SET_ERRORS', { invalid: 'Email/Password Salah' }, { root: true })
                }
                resolve(response.data)
            })
            .catch((error) => {
                if (error.response.status == 422) {
                    commit('SET_ERRORS', error.response.data.errors, { root: true })
                }
            })
        })
    },
    logout({ commit }) {
        localStorage.setItem('token', null) //RESET LOCAL STORAGE MENJADI NULL
        commit('SET_TOKEN', null, { root: true }) //RESET STATE TOKEN MENJADI NULL
    }
}

export default {
    namespaced: true,
    state,
    actions,
    mutations
}
