<template lang="">
    <div>
        <section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <img src="data:image/jpeg;base64,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" v-show="!dataOpenSideBar"
                class="p-1 w-32 h-32 rounded-full ring-2 ring-gray-100 dark:ring-gray-500 " alt="Avatar" />

      </a>

      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Sign in to your account
              </h1>
              <form class="space-y-4 md:space-y-6" action="#">
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Username</label>
                      <input v-model="user.email" type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input type="password" v-model="user.password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                  </div>
                  <div class="flex items-center justify-between">


                  </div>
                  <button @click="login" type="submit" class="w-full text-white bg-sky-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center  ">Sign in</button>
              </form>
          </div>
      </div>
  </div>
</section>
    </div>

</template>
<script>

export default {
    data() {
        return {
            message: "",
            errors: [],
            user: {
                email: "",
                password: ""
            }
        }
    },
    methods: {
        login() {
            this.axios.post('api/login', this.user).then((response) => {

                if (!response.data.status == "success") {
                    alert("login failed");
                }

                var authorisation = response.data.authorisation;
                var user = response.data.user;

                localStorage.setItem("token", JSON.stringify(authorisation.token))
                localStorage.setItem("user", JSON.stringify(user))

                this.$router.push("/")

            }).catch(errors => {
                var hasErrors = errors?.response?.data;

                if (errors.response.status == 401) {
                    this.message = errors.response.data.message
                }

                if (hasErrors.errors) {
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
