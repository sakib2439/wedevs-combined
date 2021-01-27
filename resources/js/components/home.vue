<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <center>
                    <h1>Welcome to <strong>Home Page</strong></h1>
                    <h2 style="margin-top: 25%">To view the products <router-link to="/products" style="color: white" class="btn bg-info">Click Here</router-link></h2>
                </center>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
