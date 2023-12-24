<template>
    <!-- component -->
    <!-- This is an example component -->
    <div>
        <h1>Customer </h1>
        <div class="flex items-center justify-between">
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
                    class="text-white inline-flex items-center bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 my-2 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  "
                    @click="visible = true" v-tooltip.left="'Add New Product'">
                    <i class="pi pi-plus items-center flex justify-center"></i>
                </button>
                <button
                    class="text-white inline-flex items-center ml-2 bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  "
                    @click="productLoad = true" v-tooltip.left="'Refresh'">
                    <i class="pi pi-refresh items-center flex justify-center"></i>
                </button>
                <Dialog :visible="visible" @hide="visible = false" maximizable modal header="Header"
                    :style="{ width: '50rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
                    <div class="m-0 h-[600px]">

                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Create New Product
                            </h3>
                            <button type="button" @click="closeDialog"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-toggle="crud-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="p-4 md:p-5" @submit.prevent="save">
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                    <input type="text" v-model="model.product.name"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none "
                                        placeholder="Type product name" required="">
                                </div>


                                <div class="col-span-2">
                                    <label for="description"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                        Description</label>
                                    <textarea id="description" rows="4" v-model="model.product.Description"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 focus:border-sky-600  focus:outline-none"
                                        placeholder="Write product description here"></textarea>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white inline-flex items-center bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Add new Cetegory
                            </button>
                        </form>

                    </div>
                </Dialog>

            </div>
        </div>

        <div class="flex items-end justify-end fixed bottom-0 right-0 mb-4 mr-4 z-10">
            <div>
                <a title="Buy me a beer" href="https://www.buymeacoffee.com/scottwindon" target="_blank"
                    class="block w-16 h-16 rounded-full transition-all shadow hover:shadow-lg transform hover:scale-110 hover:rotate-12">
                    <img class="object-cover object-center w-full h-full rounded-full"
                        src="https://i.pinimg.com/originals/60/fd/e8/60fde811b6be57094e0abc69d9c2622a.jpg" />
                </a>
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

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">

                        </th>

                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="products in result" :key="products.id">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ products.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ products.name }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ products.Description }}</div>
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
    </div>
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return {
            visible: false,
            items: [
                {
                    label: 'Edit',
                    icon: 'pi pi-pencil',
                    command: (products) => this.edit(products)
                },
                {
                    label: 'Delete',
                    icon: 'pi pi-times',
                    command: (products) => this.confirmDelete(products)

                }
            ],
            files: [],
            totalSize: 0,
            totalSizePercent: 0,
            model: {
                product: {
                    id: '',
                    name: '',
                    description: ''

                }
            },
            result: [],
            contextMenuProduct: null,
            searchKey: ''


        };
    },
    created() {
        this.productLoad();
    },
    mounted() {

    },
    methods: {

        resetForm() {
            this.model.product = {
                id: '',
                name: '',
                description: ''
            }
        },
        productLoad() {
            var page = "http://127.0.0.1:8000/api/categories";
            axios.get(page)
                .then(
                    ({ data }) => {
                        console.log(data.Category);
                        this.result = data.Category;
                    }
                )
        },

        edit(product) {
            this.showDialog();
            this.model.product = this.contextMenuProduct;
        },
        updateData() {
            var editrecords = 'http://127.0.0.1:8000/api/categories/' + this.model.product.id;
            axios.put(editrecords, this.model.product.id)
                .then(
                    ({ data }) => {
                        this.resetForm();
                        this.productLoad();
                    }
                );

        },
        save() {
            if (this.model.product.id == '') {
                this.saveData();
            }
            else {
                this.updateData();
            }
            this.closeDialog();
        },
        saveData() {
            try {

                axios.post("http://127.0.0.1:8000/api/categories", this.model.product);

                this.resetForm();
                this.productLoad();
                this.$toast.add({ severity: 'success', summary: 'Update Product Success', detail: 'This Product is update successly!', life: 3000 });


            } catch (error) {

                if (error.response) {
                    console.error('Response data:', error.response.data);
                    console.error('Response status:', error.response.status);
                    console.error('Response headers:', error.response.headers);
                }
            }
        }, updateData() {
            if (this.contextMenuProduct) {
                const productId = this.contextMenuProduct.id;

                var editrecords = `http://127.0.0.1:8000/api/categories/${productId}`;
                axios.put(editrecords, this.model.product)
                    .then(
                        ({ data }) => {
                            this.resetForm();
                            this.$toast.add({ severity: 'success', summary: 'Update Product Success', detail: 'This Product is update successly!', life: 3000 });
                            this.productLoad();
                        }
                    );
            }
        },
        showContextMenu(product) {
            this.contextMenuProduct = product;
            console.log("Product Items : ", this.contextMenuProduct);
            this.$refs.menu.toggle(event);
        },
        confirmDelete(products) {
            this.removeProduct();
        },
        removeProduct() {
            if (this.contextMenuProduct) {
                const productId = this.contextMenuProduct.id;
                const url = `http://127.0.0.1:8000/api/categories/${productId}`;

                axios
                    .delete(url)
                    .then(() => {
                        this.$toast.add({ severity: 'success', summary: 'Success Message', detail: 'Message Content', life: 3000 });
                        this.productLoad(); // Refresh the product list after deletion

                    })
                    .catch((error) => {
                        console.error('Error deleting product:', error);
                        this.$toast.add({ severity: 'error', summary: 'Fail', detail: 'Failed to delete product', life: 3000 });
                    })
                    .finally(() => {
                        this.contextMenuProduct = null; // Reset the contextMenuProduct after deletion
                    });
            }
        },
        ressearchCategory() {
            const apiUrl = `http://127.0.0.1:8000/api/categories/search?keyword=${this.searchKey}`;

            axios.get(apiUrl)
                .then(response => {
                    // Handle the response data, for example:
                    this.result = response.data.categories;
                })
                .catch(error => {
                    console.error('Error during search:', error);
                    // Handle errors or show a message to the user
                });
        }
        ,
        toggleMenu(event) {
            this.$refs.menu.toggle(event); // Method to toggle the PrimeVue menu
        },
        getImageUrl(imageData) {
            if (imageData) {
                if (typeof imageData === 'string') {
                    // Construct the URL based on the public directory where images are stored
                    return `/images/${imageData}`;
                } else {
                    // Return a placeholder image or empty string for no image
                    return '/asset/none-icon-1.jpg';
                }
            } else {
                // Return a placeholder image or empty string for no image
                return '/asset/none-icon-1.jpg';
            }
        },
        showDialog() {
            this.visible = true;
        },
        closeDialog() {
            this.visible = false;

        },
        toggle(event) {
            this.$refs.menu.toggle(event);
        },


    }
    // Other component logic
};
</script>
