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
                <input type="text" class="form-control" v-model="loan.loan_amount" disabled>
            </div>

            <div class="form-group">
                <label>Loan Frequency</label>
                <input type="text" class="form-control" v-model="loan.frequency.frequencies" disabled>
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
            <button class="btn btn-submit btn-primary" type="submit" @click.stop.prevent="addLoan()" style="float: right">Update Loan</button>
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
            loan: {},
            payments: {}
        }
    },
    created() {
        let uri = `http://takehometest.test/api/loan/${this.$route.params.id}`
        console.log(this.$route.params.id)
        this.axios.get(uri)
            .then((response) => {
                this.loan = response.data[0]
                this.payments = response.data[1]
            })
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
                frequency_id: this.loan.frequency_id,
                status_id: this.loan.status_id,
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
    }
}
</script>
