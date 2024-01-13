<template lang="">
    <div class="container">
        <div class="card">   
            
            <div class="" v-for="error in errors">
                <p style="color : red;">{{error[0]}}</p>
            </div>

            <label for="">Email</label>
            <input type="text" v-model="user.email"/>
            <label for="border" style="color: red;" v-if="message">{{message}}</label>
            <br>
            <label for="">Password</label>
            <input type="text" v-model="user.password"/>
            <br>
            <button @click="login" type="buttom" >login</button>
        </div>
    </div>

</template>
<script>

export default {
    data() {
        return {
            message : "",
            errors : [],
            user: {
                email: "",
                password: ""
            }
        }
    },
    methods: {
        login() {
            this.axios.post('api/login', this.user).then((response) => {

                if(!response.data.status == "success"){
                    alert("login failed");
                }

                var authorisation = response.data.authorisation;
                var user = response.data.user;

                localStorage.setItem("token", JSON.stringify(authorisation.token))
                localStorage.setItem("user", JSON.stringify(user))

                this.$router.push("/")

            }).catch(errors => {
                var hasErrors = errors?.response?.data;

                if(errors.response.status == 401){
                    this.message = errors.response.data.message
                }

                if(hasErrors.errors){
                    this.errors = hasErrors.errors;
                }
            })
        }
    }
}
</script>
<style scoped>
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card {
    width: 400px;
    height: auto;
    display: flex;
    flex-direction: column;
}
</style>