import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'
import {routes} from '../routes';
import VueRouter from "vue-router";

Vue.use(Vuex)
const router = new VueRouter({
    mode: 'history',
    routes: routes
});
axios.defaults.baseURL = 'http://takehometest.test/api'

export const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('access_token') || null,
        loans: [],
        loan: [],
        frequencies: [],
        currencies: [],
        curUser: [],
        status: [],
        payments: [],
    },
    getters: {
        loggedIn(state) {
            return state.token !== null
        },
        payableLoan(state) {
            return state.loans.filter(loan => loan.status_id === 2)
        },
        loans(state){
            return state.loans
        },
        status(state){
            return state.status
        },
        payments(state){
            return state.payments
        },
        frequencies(state){
            return state.frequencies
        },
        ifStaff(state){
            return state.curUser.user_type === 1
        },
        curUser(state){
            return state.curUser
        },
        currency(state){
            return state.currencies
        },
        showLoan(state) {
            return state.loan
        },
    },
    mutations: {
        addLoan(state, loan) {
            state.loans.push({
                user_id: loan.user_id,
                frequency_id: loan.selectedFreq,
                loan_name: loan.loan_name,
                loan_amount: loan.loan_amount,
                loan_balance: loan.loan_amount,
                loan_term: loan.loan_term
            })
        },
        updateLoan(state, loan) {

            const index = state.loans.findIndex(item => item.id == loan.loan.id)
            state.loans.splice(index, 1, {
                'id': loan.loan.id,
                'user_id' : loan.loan.user_id,
                'loan_name': loan.loan_name,
                'loan_amount': loan.loan.loan_amount,
                'loan_balance': loan.loan.loan_amount,
                'frequency_id': loan.loan.frequency_id,
                'status_id': loan.loan.status_id,
                'loan_term': loan.loan.loan_term
            })
        },
        retrieveToken(state, token) {
            state.token = token
        },
        retrieveLoans(state,loans) {
            state.loans = loans
        },
        showLoan(state,loan) {
            state.loan = loan
        },
        retrieveFrequencies(state,frequencies) {
            state.frequencies = frequencies
        },
        retrieveStatus(state,status) {
            state.status = status
        },
        retrieveCurUser(state,curUser) {
            state.curUser = curUser
        },
        retrievePayments(state,payments) {
            state.payments = payments
        },
        retrieveCurrency(state,currencies) {
            state.currencies = currencies
        },
        clearLoans(state) {
            state.loans = []
        },
        destroyToken(state) {
            state.token = null
        }
    },
    actions: {
        clearLoans(context) {
            context.commit('clearLoans')
        },
        register(context, data) {
            return new Promise((resolve,reject) => {
                axios.post('/register', {
                    name: data.name,
                    email: data.email,
                    password: data.password,
                    password_confirmation: data.password_confirmation
                })
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error=>{
                        reject(error)
                    })
            })
        },
        destroyToken(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    axios.post('/logout')
                        .then(response => {
                            localStorage.removeItem('access_token')
                            context.commit('destroyToken')
                            resolve(response)
                        })
                        .catch(error => {
                            localStorage.removeItem('access_token')
                            context.commit('destroyToken')
                            reject(error)
                        })
                })
            }
        },
        retrieveToken(context, credentials) {
            return new Promise((resolve,reject) => {
                axios.post('/login', {
                    email: credentials.email,
                    password: credentials.password
                })
                    .then(response => {
                        const token = response.data.access_token
                        localStorage.setItem('access_token', token)
                        context.commit('retrieveToken', token)
                        resolve(response)
                    })
                    .catch(error=>{
                        console.log(error);
                        reject(error)
                    })
            })
        },
        retrieveLoans(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

            axios.get('/loan')
                .then(response=> {
                    context.commit('retrieveLoans', response.data)
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        retrieveFrequencies(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('/getFrequency')
                .then(response=> {
                    context.commit('retrieveFrequencies', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        retrieveStatus(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('/getStatus')
                .then(response=> {
                    context.commit('retrieveStatus', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        retrieveCurUser(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('/user')
                .then(response=> {
                    context.commit('retrieveCurUser', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        retrieveCurrency(context) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('/getCurrency')
                .then(response=> {
                    context.commit('retrieveCurrency', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        addLoan(context, loan) {
            return new Promise((resolve,reject) => {
                axios.post('/loan', {
                    user_id: loan.user_id,
                    frequency_id: loan.selectedFreq,
                    loan_name: loan.loan_name,
                    loan_amount: loan.loan_amount,
                    loan_balance: loan.loan_amount,
                    loan_term: loan.loan_term,
                    loan_currency: loan.selectedCurrency
                })
                    .then(response => {
                        context.commit('addLoan', response.data)
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        makePayment(context, loan) {
            axios.post('/makePayment', {
                user_id: loan.user_id,
                loan_id: loan.loan_id,
            })
                .then(response => {
                    console.log(response)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        retrievePayments(context, id) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token

            axios.get('/getPayment/' + id)
                .then(response=> {
                    context.commit('retrievePayments', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        showLoan(context, id) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + context.state.token
            axios.get('/loan/' + id)
                .then(response=> {
                    context.commit('showLoan', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
        updateLoan(context, loan) {
            axios.patch('/loan/' + loan.id, {
                frequency_id: loan.frequency_id,
                loan_name: loan.loan_name,
                loan_amount: loan.loan_amount,
                status_id: loan.status_id
            })
                .then(response => {
                    context.commit('updateLoan', response.data)
                })
                .catch(error => {
                    console.log(error)
                })
        },
    }
})
