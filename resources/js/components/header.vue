<template>
  <div class="w-full bg-gray-200 ">
    <div class="flex justify-between items-center h-[50px]">
      <div class="p-4 cursor-pointer  hover:bg-gray-50" @click="clickHambuger">
        <i class="pi pi-bars"></i>
      </div>

      <div class="flex space-x-3 items-center justify-center px-3">

        <Avatar icon="pi pi-user" class="mr-2 cursor-pointer" style="background-color:#1e63ca; color: #ffffff"
          shape="circle" @click="toggle" aria-haspopup="true" aria-controls="overlay_menu" />
        <Menu id="overlay_menu" ref="menu" :model="items" :popup="true" />

      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    dataOpenSideBar: Boolean,
    clickHambuger: Function
  },
  data() {
    return {
      items: [
        {
          label: 'Logout',
          icon: 'pi pi-refresh',
          command: () => {
            this.logout();
          }
        },
        {
          label: 'Change Password',
          icon: 'pi pi-times',
          command: () => {
            this.$toast.add({ severity: 'warn', summary: 'Delete', detail: 'Data Deleted', life: 3000 });
          }
        },
      ]
    }
  },
  methods: {
    toggle(event) {
      this.$refs.menu.toggle(event);
    },
    logout: function () {
      this.axios.post('api/logout', this.user).then((response) => {

        localStorage.removeItem("token")
        localStorage.removeItem("user")

        this.$router.push("/login")

      }).catch(errors => {
        var hasErrors = errors?.response?.data;

        if (hasErrors.errors) {
          alert(hasErrors.errors[0]);
        }
      })
    }
  }

}
</script>

<style></style>
