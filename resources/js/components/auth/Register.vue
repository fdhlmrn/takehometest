<template>
    <div class="login-form">
        <h2 class="login-heading">Register</h2>
        <form action="#" @submit.prevent="register">

            <div class="form-control">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="login-input" v-model="name">
            </div>

            <div class="form-control">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="login-input" v-model="email">
            </div>

            <div class="form-control mb-more">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="login-input" v-model="password">
            </div>

            <div class="form-control mb-more">
                <label for="password_confirmation">Password Confirmation</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="login-input" v-model="password_confirmation">
            </div>

            <div class="form-control">
                <button type="submit" class="btn-submit">Create Account</button>
            </div>

        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
        }
    },
    methods: {
        register() {
            this.$store.dispatch('register', {
                name: this.name,
                email: this.email,
                password: this.password,
                password_confirmation: this.password_confirmation,
            })
                .then(response => {
                    this.$router.push({ name: 'login' })
                })
        }
    }
}
</script>
