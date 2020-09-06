<template>
    <div>
        <h3 class="text-center">All Loans</h3><br/>
        <div>
            <router-link to="/api/loan/create" class="btn btn-primary" style="float: right" v-if="curUser.user_type === 2">Add Loan</router-link>
        </div>
        <br><br>
        <form @submit.prevent="submit" v-if="!savingSuccessful">
            <div class="success" v-if="savingSuccessful">
                {{ this.text }}
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Loan Name</th>
                <th>Loan Status</th>
                <th>Payment Frequency</th>
                <th>Loan Term(Years)</th>
                <th>Loan Amount</th>
                <th>Loan Balance</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="loan in loans" :key="loan.id">
                <td>{{ loan.id }}</td>
                <td>{{ loan.loan_name }}</td>
                <td>{{ loan.status && loan.status.status_name }}</td>
                <td>{{ loan.frequency && loan.frequency.frequencies }}</td>
                <td>{{ loan.loan_term }}</td>
                <td>{{ loan.loan_currency}} {{ loan.loan_amount }}</td>
                <td>{{ loan.loan_currency}} {{ loan.loan_balance }}</td>
                <td>
                    <div class="btn-group" role="group">

                        <button class="btn btn-success" @click="makePayment(loan.id)" v-if="loan.status_id === 2 && curUser.id === loan.user_id" >Payment</button>

                        <router-link :to="{name: 'edit', params: { id: loan.id }}" class="btn btn-primary" v-if="ifStaff">Update Loan
                        </router-link>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            savingSuccessful: false,
        }
    },
    created() {
        this.$store.dispatch('clearLoans')
        this.$store.dispatch('retrieveLoans')
        this.$store.dispatch('retrieveCurUser')
    },
    methods: {
        makePayment(loanID) {
            this.$store.dispatch('makePayment', {
                user_id: this.curUser.id,
                loan_id: loanID
            })
        }
    },
    computed: {
        loans() {
            return this.$store.getters.loans
        },
        curUser() {
            return this.$store.getters.curUser
        },
        ifStaff() {
            return this.$store.getters.ifStaff
        },
    }
}
</script>
