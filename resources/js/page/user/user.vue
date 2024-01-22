<script setup>
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
</script>

<template>
    <div>
        <div class="flex justify-between my-2">
            <div class="relative my-2 w-[400px]">

            </div>
            <div>
                <button
                    class="text-white inline-flex items-center bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  "
                    @click="isDialogShowing = true" v-tooltip.left="'Add New User'">
                    <i class="pi pi-plus items-center flex justify-center"></i>
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
                <tbody class="bg-white divide-y divide-gray-200" v-if="result != 'No Record Fonud!'">
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
                                <Button type="button" icon="pi pi-ellipsis-v" @click="showContextMenu(user)" />
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
        <Dialog v-model:visible="isDialogShowing" @update:visible="onDialogVisibilityChange" modal header="Role And Permision" :closable="true"
            :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" :style="{ width: '50rem' }">
            <div class="grid gap-4 mb-4 grid-cols-2">
                <div class="col-span-2">
                    <!-- Item Name -->
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">UserName</label>
                    <input type="email" v-model="object.name"
                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none "
                        placeholder="Username" required="">
                </div>
                <div class="col-span-2" v-if="object.id == ''">
                    <!-- Item Name -->
                    <label  for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                    <input type="email" v-model="object.email"
                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none "
                        placeholder="Email" required="">
                </div>

                <div class="col-span-2" v-if="object.id == ''">
                    <label  for="name" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                    <input  type="text" v-model="object.password"
                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none "
                        placeholder="Password" required="">
                </div>
                <div class="col-span-2">
                    <label class="w-16" for="name">Role</label>
                    <Dropdown v-model="object.role" :options="roles" optionLabel="name" optionValue="name"
                        placeholder="Select role" class="w-full md:w-14rem" />
                </div>

            </div>

            <template #footer>
                <Button label="Ok" icon="pi pi-check" @click="save" />
            </template>
        </dialog>
    </div>
</template>

<script>
export default {
    components: {
        Button,
        Dropdown,
        InputText
    },
    data() {
        return {
            isDialogShowing: false,
            object: {
                id : '',
                role: '',
                email: '',
                name: '',
                password: ''
            },
            users: [],
            roles: [],
            items: [
                {
                    label: 'Edit',
                    icon: 'pi pi-pencil',
                    command: (products) => this.edit()

                }
            ],
        }
    },
    created() {
        this.usersLoad();

    }, mounted() {
        this.reSetform();

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
        async eventSave() {
            await this.axios.post('api/users', this.object)
                .then(({ data }) => {
                    this.$toast.add({ severity: 'success', summary: 'Add User Success', detail: 'This Add is updated successfully!', life: 3000 });

                    this.isDialogShowing = false;
                    this.reSetform();
                    this.usersLoad()
                }).catch(errors => {
                    console.error(errors)
                })
        },
        toggleMenu(event) {
            this.$refs.menu.toggle(event); // Method to toggle the PrimeVue menu
            this. reSetform();
        }, showContextMenu(product) {
            this.contextMenuProduct = product;
            console.log("Product Items : ", this.contextMenuProduct);
            this.$refs.menu.toggle(event);
        },
        edit() {
            this.showDialog();
            this.object = this.contextMenuProduct;
        }, showDialog() {

            this.isDialogShowing = true;
        },
        reSetform(){

                this.object = {
                    id : '',
                    role: '',
                    email: '',
                    name: '',
                    password: ''
                }

        },
        updateData() {
            if (this.contextMenuProduct) {
                const productId = this.contextMenuProduct.id;
                console.log("User Id :", productId);
                var editrecords = `api/users/${productId}`;
                this.axios.put(editrecords, this.object)
                    .then(
                        ({ data }) => {
                            this.reSetform();
                            this.isDialogShowing = false;
                            this.$toast.add({ severity: 'success', summary: 'Update User Success', detail: 'This User is update successly!', life: 3000 });

                        }
                    );
            }
        },save() {
            if (this.object.id == '') {

                this.eventSave();
            }
            else {

                this.updateData();
            }
            this.usersLoad();
        },
        onDialogVisibilityChange(newValue) {
            // If the dialog is being closed, reset the form
            if (!newValue) {
                this.reSetform();
            }
        },
    }}
</script>
