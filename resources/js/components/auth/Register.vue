<template>
    <div class="card">
        <article class="card-body">
            <h4 class="card-title mb-4 mt-1">Register</h4>
            <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="errors.length">
                <strong>Holy guacamole!</strong>
                <br><br>
                <li v-for="error in errors">{{ error }}</li>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" @submit.prevent="register">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input class="form-control" placeholder="Email" name="name" id="name"  type="name" v-model="name">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" placeholder="Email" name="email" id="email"  type="email" v-model="email">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" placeholder="******" name="password" id="password"  type="password" v-model="password">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <label for="password_confirmation">Password Confirmation</label>
                    <input class="form-control" placeholder="******" name="password_confirmation" id="password_confirmation"  type="password_confirmation" v-model="password_confirmation">
                </div> <!-- form-group// -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-block"> Create Account </button>
                </div> <!-- form-group// -->
            </form>
        </article>
    </div> <!-- card.// -->

<!--    <div class="login-form">-->
<!--        <h2 class="login-heading">Register</h2>-->
<!--        <form action="#" @submit.prevent="register">-->

<!--            <div class="form-control">-->
<!--                <label for="name">Name</label>-->
<!--                <input type="text" name="name" id="name" class="login-input" v-model="name">-->
<!--            </div>-->

<!--            <div class="form-control">-->
<!--                <label for="email">Email</label>-->
<!--                <input type="email" name="email" id="email" class="login-input" v-model="email">-->
<!--            </div>-->

<!--            <div class="form-control mb-more">-->
<!--                <label for="password">Password</label>-->
<!--                <input type="password" name="password" id="password" class="login-input" v-model="password">-->
<!--            </div>-->

<!--            <div class="form-control mb-more">-->
<!--                <label for="password_confirmation">Password Confirmation</label>-->
<!--                <input type="password" name="password_confirmation" id="password_confirmation" class="login-input" v-model="password_confirmation">-->
<!--            </div>-->

<!--            <div class="form-control">-->
<!--                <button type="submit" class="btn-submit">Create Account</button>-->
<!--            </div>-->

<!--        </form>-->
<!--    </div>-->
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            errors: [],
        }
    },
    methods: {
        checkForm: function () {

            this.errors = []

            if (this.name === "") {
                this.errors.push('Username cant be empty');
            }
            if (this.email === "") {
                this.errors.push('Mail cant be empty');
            }
            if (this.password === "") {
                this.errors.push('Need login password');
            }
            if (this.password_confirmation === "") {
                this.errors.push('Need login confirmation password');
            }
            if (!this.errors.length) {
                this.valid = true;
            }
        },
        register() {
            this.checkForm()

            if (this.valid) {
                this.$store.dispatch('register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                    .then(response => {
                        this.$router.push({name: 'login'})
                })
            }
        }
    }
}
</script>
