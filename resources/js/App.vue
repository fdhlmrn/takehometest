<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <ul class="nav">
                        <li ><router-link :to="{ name: 'home' }">Home</router-link></li>
                        <li v-if="!loggedIn"><router-link :to="{ name: 'login' }">Login</router-link></li>
                        <li v-if="!loggedIn"><router-link :to="{ name: 'register' }">Register</router-link></li>
                        <li v-if="loggedIn"><router-link :to="{ name: 'logout' }">Logout</router-link></li>
                    </ul>
                </div>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>
<style>
nav {
    background-color: #333;
}
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #333;
}

li {
    text-decoration: none;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change the link color to #111 (black) on hover */
li a:hover {
    color: white;
    background-color: #111;
    text-decoration: none;
}
</style>
<script>
export default {
    computed: {
        loggedIn() {
            return this.$store.getters.loggedIn
        }
    }
}
</script>
