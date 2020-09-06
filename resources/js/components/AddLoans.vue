<template>
    <div class="login-form">
        <h2 class="login-heading">Add Loan</h2>
        <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="errors.length">
            <strong>Holy guacamole!</strong>
            <br><br>
                <li v-for="error in errors">{{ error }}</li>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="#">
            <div class="form-group">
                <label for="loan_name">Loan Name</label>
                <input  name="loan_name" id="loan_name"  type="text" class="form-control" v-model="loan_name">
            </div>

            <div class="form-group">
                <label for="loan_amount">Loan Amount</label>
                <input type="number" min="0" name="loan_amount" id="loan_amount" class="form-control" v-model="loan_amount">
            </div>

            <div class="form-group">
                <label for="loan_term">Loan Term(in Years)</label>
                <input type="number" min="0" max="65" pattern="^.{,2}$" name="loan_term" id="loan_term" class="form-control" v-model="loan_term">
            </div>

            <div class="form-group">
                <label>Loan Frequency</label>
                <br>
                <select name="freqSelect" v-model="selectedFreq">
                    <option v-for="frequency in frequencies" v-bind:key="frequency.id" v-bind:value="frequency.id">
                        {{ frequency.frequencies }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label>Currency List</label>
                <br>
                <select name="curSelect" v-model="selectedCurrency">
                    <option v-for="currency in currencies" v-bind:key="currency.code" v-bind:value="currency.code">
                        {{ currency.code }}
                    </option>
                </select>
            </div>
            <button class="btn btn-submit btn-primary"  type="submit" @click.stop.prevent="addLoan()" style="float: right">Submit Loan</button>

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
            selectedFreq: '1',
            selectedCurrency: 'MYR',
            errors: {},
            valid : false,
        }
    },
    created() {
        this.$store.dispatch('retrieveFrequencies')
        this.$store.dispatch('retrieveCurUser')
        this.$store.dispatch('retrieveCurrency')
    },
    methods: {
        checkForm: function () {

            this.errors = []

            if (this.loan_name === "") {
                this.errors.push('Need input name');
            }
            if (this.loan_amount <= 0) {
                this.errors.push('Amount cant be 0');
            }
            if (this.loan_term >= 80 || this.loan_term <= 0) {
                this.errors.push('Loan term cant be 0 or more than 80');
            }
            if (!this.errors.length) {
                this.valid = true;
            }
        },
        addLoan() {
            this.checkForm()

            if(this.valid){
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
