<template>
        <div class="card">
            <article class="card-body">
                <a href="/api/register" class="float-right btn btn-outline-primary">
                    Register
                </a>
                <h4 class="card-title mb-4 mt-1">Sign in</h4>
                <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="errors.length">
                    <strong>Holy guacamole!</strong>
                    <br><br>
                    <li v-for="error in errors">{{ error }}</li>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" @submit.prevent="login">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input class="form-control" placeholder="Email" name="email" id="email"  type="email" v-model="email">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input class="form-control" placeholder="******" name="password" id="password"  type="password" v-model="password">
                    </div> <!-- form-group// -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Login</button>
                    </div> <!-- form-group// -->
                </form>
            </article>
        </div> <!-- card.// -->
</template>

<script>
export default {
    name: 'login',
    data() {
        return {
            email: '',
            password: '',
            errors: []
        }
    },
    methods: {
        checkForm: function () {

            this.errors = []

            if (this.email === "") {
                this.errors.push('Need login mail');
            }
            if (this.password === "") {
                this.errors.push('Need login password');
            }
            if (!this.errors.length) {
                this.valid = true;
            }
        },
        login() {
            this.checkForm()

            if (this.valid){
                this.$store.dispatch('retrieveToken', {
                    email: this.email,
                    password: this.password,
                })
                    .then(response => {
                        this.$router.push({name: 'home'})
                    })
                    .catch(error => {
                        if (error.response.status == 400) {
                            this.errors.push("We couldn't verify your account details.")
                        }
                        else if (error.response.status == 401) {
                            this.errors.push("Your credentials are incorrect. Please try again")
                        }
                    })
            }
        }
    }
}
</script>
