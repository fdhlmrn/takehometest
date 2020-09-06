<template>
    <div class="login-form">
        <h2 class="login-heading">Edit Loan</h2>
        <form action="#">
            <div class="form-group">
                <label>Loan Name</label>
                <input type="text" class="form-control" v-model="loan.loan_name" disabled>
            </div>

            <div class="form-group">
                <label>Loan Amount ({{loan.loan_currency}})</label>
                <input type="number" min="0" class="form-control" v-model="loan.loan_amount" disabled>
            </div>

            <div class="form-group">
                <label>Loan Frequency</label>
                <input type="text" class="form-control" v-if="loan.frequency" v-model="loan.frequency.frequencies" disabled>
            </div>

            <div class="form-group">
                <label>Loan Status</label>
                <br>
                <select name="freqSelect" v-model="loan.status_id">
                    <option v-for="stat in status" v-bind:key="stat.id" v-bind:value="stat.id">
                        {{ stat.status_name }}
                    </option>
                </select>
            </div>
            <button class="btn btn-submit btn-primary" type="submit" @click.stop.prevent="updateLoan()" style="float: right">Update Loan</button>
        </form>
        <br><br>
        <div>
            <h3 class="text-center"> Payment Info</h3>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Loan Name</th>
                    <th>Payment Amount</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="payment in payments" :key="payment.id">
                    <td>{{ payment.id }}</td>
                    <td>{{ payment.loan.loan_name }}</td>
                    <td>{{ payment.pay_amount }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'edit',
    data() {
        return {
        }
    },
    created() {
        this.$store.dispatch('showLoan', this.$router.currentRoute.params.id)
        this.$store.dispatch('retrievePayments', this.$router.currentRoute.params.id)
        this.$store.dispatch('retrieveFrequencies')
        this.$store.dispatch('retrieveStatus')
        this.$store.dispatch('retrieveCurUser')
    },
    methods: {
        updateLoan() {
            this.$store.dispatch('updateLoan', {
                id: this.loan.id,
                user_id: this.curUser.id,
                loan_name: this.loan.loan_name,
                loan_amount: this.loan.loan_amount,
                loan_balance: this.loan.loan_amount,
                frequency_id: this.loan.frequency_id,
                status_id: this.loan.status_id,
                loan_term: this.loan.loan_term,
            })
                .then(response=> {
                    this.$router.push({ name: 'home' })
                })
        }
    },
    computed: {
        curUser() {
            return this.$store.getters.curUser
        },
        status() {
            return this.$store.getters.status
        },
        loan() {
            return this.$store.getters.showLoan
        },
        payments() {
            return this.$store.getters.payments
        },
        frequencies() {
            return this.$store.getters.frequencies
        },
    }
}
</script>
