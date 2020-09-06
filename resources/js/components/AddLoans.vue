<template>
    <div class="login-form">
        <h2 class="login-heading">Add Loan</h2>
        <form action="#">
            <div class="form-control">
                <label for="loan_name">Loan Name</label>
                <input type="loan_name" name="loan_name" id="loan_name" class="login-input" v-model="loan_name">
            </div>

            <div class="form-control mb-more">
                <label for="loan_amount">Loan Amount</label>
                <input type="loan_amount" name="loan_amount" id="loan_amount" class="login-input" v-model="loan_amount">
            </div>

            <div class="form-control mb-more">
                <label for="loan_term">Loan Term(in Years)</label>
                <input type="number" name="loan_term" id="loan_term" class="login-input" v-model="loan_term">
            </div>

            <div class="form-control mb-more">
                <select name="freqSelect" v-model="selectedFreq">
                    <option v-for="frequency in frequencies" v-bind:key="frequency.id" v-bind:value="frequency.id">
                        {{ frequency.frequencies }}
                    </option>
                </select>
            </div>
            <div class="form-control mb-more">
                <select name="curSelect" v-model="selectedCurrency">
                    <option v-for="currency in currencies" v-bind:key="currency.code" v-bind:value="currency.code">
                        {{ currency.code }}
                    </option>
                </select>
            </div>
            <div class="form-control">
                <button class="btn-submit" type="submit" @click.stop.prevent="addLoan()">Submit Loan</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: 'add',
    data() {
        return {
            loan_name: '',
            loan_amount: '',
            loan_term: '',
            selectedFreq: '',
            selectedCurrency: 'MYR',
        }
    },
    created() {
        this.$store.dispatch('retrieveFrequencies')
        this.$store.dispatch('retrieveCurUser')
        this.$store.dispatch('retrieveCurrency')
    },
    methods: {
        addLoan() {
            this.$store.dispatch('addLoan', {
                user_id: this.curUser.id,
                loan_name: this.loan_name,
                loan_amount: this.loan_amount,
                loan_term: this.loan_term,
                selectedFreq: this.selectedFreq,
                selectedCurrency: this.selectedCurrency,
            })
            .then(response=> {
                this.$router.push({ name: 'home' })
            })
        }
    },
    computed: {
        frequencies() {
            return this.$store.getters.frequencies
        },
        curUser() {
            return this.$store.getters.curUser
        },
        currencies() {
            return this.$store.getters.currency
        },
    }
}
</script>
