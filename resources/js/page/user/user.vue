<script setup>
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
</script>

<template>
    <div>
        <div class="flex justify-between">
            <div class="relative my-2 w-[400px]">
                <input type="text" id="password" v-model="searchKey"
                    class="w-full pl-3 pr-10 py-2 border-2 border-gray-200 rounded-xl hover:border-gray-300 focus:outline-none focus:border-sky-600 transition-colors"
                    placeholder="Search...">
                <button @click="ressearchCategory"
                    class="block w-7 h-7 text-center text-xl leading-0 absolute top-2 right-2 text-gray-400 focus:outline-none hover:text-gray-900 transition-colors"><i
                        class="pi pi-search"></i></button>
            </div>
            <div>
                <button
                    class="text-white inline-flex items-center bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  "
                    @click="isDialogShowing = true" v-tooltip.left="'Add New User'">
                    <i class="pi pi-plus items-center flex justify-center"></i>
                </button>
                <button
                    class="text-white inline-flex items-center ml-2 bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  "
                    @click="productLoad = true" v-tooltip.left="'Refresh'">
                    <i class="pi pi-refresh items-center flex justify-center"></i>
                </button>
                </div>
        </div>
        <div>
            <table class="min-w-full divide-y bg-sky-600 overflow-x-auto">
                <thead class="bg-sky-600">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                            Code
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Email
                        </th>
        

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                             Role
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200"  v-if="result != 'No Record Fonud!'">
                    <tr v-for="user in users" :key="user.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ user.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ user.name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ user.email }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ user.roles[0].name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap  text-sm font-medium">
                            <div class="card flex justify-content-center">
                                <Button type="button" icon="pi pi-ellipsis-v" @click="showContextMenu(products)" />
                                <Menu ref="menu" id="overlay_menu" :model="items" :popup="true" />
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>
            <div class="card justify-content-center hidden">
                <Button type="button" icon="pi pi-ellipsis-v" aria-haspopup="true" aria-controls="overlay_tmenu" />
                <Menu ref="menu" id="overlay_menu" :model="items" :popup="true" />
            </div>
            <Toast />
        </div>
        <Dialog v-model:visible="isDialogShowing" modal header="Header" :closable="true"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" :style="{ width: '50rem' }"
         >
            <div class="flex flex-col h-[600px]">

                <div class="flex space-x-3">
                    <label class="w-16" for="email">Email</label>
                    <InputText  v-model="object.email" class="border border-gray-400" ></InputText>
                </div>

                <div class="flex space-x-3">
                    <label class="w-16" for="name">Name</label>
                    <InputText v-model="object.name" autofocus class="border border-gray-400"></InputText>
                </div>
                <div class="flex space-x-3">
                    <label class="w-16" for="name">Password</label>
                    <InputText v-model="object.password" autofocus class="border border-gray-400"></InputText>
                </div>
                <div class="flex space-x-3">
                    <label class="w-16" for="name">Role</label>
                    <Dropdown v-model="object.role" :options="roles" optionLabel="name" optionValue="name" placeholder="Select role" class="w-full md:w-14rem" />
                </div>
            </div>
            <template #footer>
                <Button label="Ok" icon="pi pi-check" @click="eventSave"  />
            </template>
        </dialog>
    </div>
</template>

<script>
export default {
    components : {
        Button,
        Dropdown,
        InputText
    },
    data() {
        return {
            isDialogShowing: false,
            object:{
                role: null,
                email: null,
                name: null,
                password: null
            },
            users: [],
            roles: []
        }
    },
    created() {
        this.usersLoad();

    },
    methods: {
        usersLoad: async function () {
            await this.axios.get('api/users')
                .then(({ data }) => {
                    this.users = data.users;
                    this.roles = data.users[0].roles;
                }).catch(errors => {
                    console.error(errors)
                })
        },
        async eventSave(){
            await this.axios.post('api/users', this.object )
                .then(({ data }) => {
                  this.$toast.add({ severity: 'success', summary: 'Add User Success', detail: 'This Add is updated successfully!', life: 3000 });

                  this.isDialogShowing = false
                  this.usersLoad()
                }).catch(errors => {
                    console.error(errors)
                })
        }
    }
}
</script>