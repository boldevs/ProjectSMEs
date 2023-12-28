<template>
    <!-- component -->
    <!-- This is an example component -->
    <div>
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
                    class="text-white inline-flex items-center bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  "
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
                                    <input type="text" v-model="model.product.productname"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none "
                                        placeholder="Type product name" required="">
                                </div>
                                <div class="col-span-2 sm:col-span-1">

                                    <label for="price"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                    <input type="number" name="price" id="price" v-model="model.product.productprice"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none "
                                        placeholder="$" required="">
                                </div>

                                <div class="col-span-2 sm:col-span-1">
                                    <label for="category"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                    <select id="category" v-model="model.product.category_id"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none">
                                        <option v-for="categories in Category" :key="categories.id" :value="categories.id">
                                            {{ categories.name }}</option>

                                    </select>
                                </div>
                                <div class="col-span-2 sm:col-span-1">
                                    <label for="category"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                    <select id="category" v-model="model.product.IsActive"
                                        class="bg-gray-50 border-2 border-gray-300 text-gray-900 text-sm rounded-lg focus:border-sky-600  w-full p-2.5 focus:outline-none">
                                        <option selected="">Select category</option>
                                        <option value="1">Active</option>
                                        <option value="2">Low Stock</option>
                                        <option value="3">Out of Stock</option>

                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <div class="card">
                                        <Toast />
                                        <!-- Inside your Dialog -->


                                        <FileUpload name="demo[]" @upload="onTemplatedUpload($event)"
                                            v-model="model.product.productimg" :multiple="true" accept="image/*"
                                            :maxFileSize="1000000" @select="onSelectedFiles">
                                            <template #header="{ chooseCallback, clearCallback, files }" class="">
                                                <div
                                                    class="flex flex-wrap justify-content-between align-items-center flex-1 gap-2 ">
                                                    <div class="flex gap-2">
                                                        <Button @click="chooseCallback()" icon="pi pi-images" rounded
                                                            outlined></Button>

                                                        <Button @click="clearCallback()" icon="pi pi-times" rounded outlined
                                                            severity="danger"
                                                            :disabled="!files || files.length === 0"></Button>
                                                    </div>
                                                    <ProgressBar :value="totalSizePercent" :showValue="false"
                                                        :class="['md:w-20rem h-1rem w-full md:ml-auto', { 'exceeded-progress-bar': totalSizePercent > 100 }]">
                                                        <!-- <span class="white-space-nowrap">{{ totalSize }}B </span> -->
                                                    </ProgressBar>
                                                </div>
                                            </template>
                                            <template
                                                #content="{ files, uploadedFiles, removeUploadedFileCallback, removeFileCallback }">
                                                <div v-if="files.length > 0">
                                                    <h5>Complete</h5>
                                                    <div class="flex flex-wrap p-0 sm:p-5 gap-5">
                                                        <!-- Existing file display loop -->
                                                        <div v-for="(file, index) of files"
                                                            :key="file.name + file.type + file.size"
                                                            class="card m-0 px-6 flex flex-column border-1 surface-border align-items-center gap-3">
                                                            <div>
                                                                <img role="presentation" :alt="file.name"
                                                                    :src="file.objectURL" width="200" height="100"
                                                                    class="shadow-2" />
                                                            </div>
                                                            <span class="font-semibold">{{ file.name }}</span>
                                                            <div>{{ formatSize(file.size) }}</div>
                                                            <Badge value="Pending" severity="warning" />
                                                            <Button icon="pi pi-times"
                                                                @click="onRemoveTemplatingFile(file, removeFileCallback, index)"
                                                                outlined rounded severity="danger" />
                                                        </div>
                                                    </div>
                                                </div>


                                            </template>
                                            <template #empty v-if="model.product.id == ''">
                                                <div class="flex align-items-center justify-content-center flex-column">
                                                    <i
                                                        class="pi pi-cloud-upload border-2 border-circle p-5 text-8xl text-400 border-400" />
                                                    <p class="mt-4 mb-0 flex items-center justify-center px-6">Drag and drop
                                                        files to here to upload.</p>
                                                </div>
                                            </template>
                                            <template #empty v-if="model.product.id != ''">
                                                <div class="flex align-items-center justify-content-center flex-column">
                                                    <img v-if="images" :src="images" alt="Product Image" width="200"
                                                        height="100" class="shadow-2" />
                                                </div>
                                            </template>

                                        </FileUpload>
                                    </div>
                                </div>
                                <!-- <div class="col-span-2">
                                    <label for="description"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product
                                        Description</label>
                                    <textarea id="description" rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border-2 focus:border-sky-600  focus:outline-none"
                                        placeholder="Write product description here"></textarea>
                                </div> -->
                            </div>
                            <button type="submit"
                                class="text-white inline-flex items-center bg-sky-600 hover:bg-sky-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Add new product
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                            Image
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                            Category
                        </th>

                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                            Price
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                            Status
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
                            {{ products.productname }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" :src="getImageUrl(products.productimg)" alt="">

                                </div>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">{{ products.category.name }}</div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ products.productprice }}$
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span :class="{
                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': products.IsActive === 1,
                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': products.IsActive === 2,
                                'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': products.IsActive === 3
                            }">
                                {{ products.IsActive === 1 ? 'Active' : (products.IsActive === 2 ? 'Low Stock' : 'Out of Stock') }}
                            </span>
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
            categorys: {
                name: '',
                Description: ''
            },
            model: {
                product: {
                    id: '',
                    productname: '',
                    productprice: '',
                    category_id: '',
                    productimg: '',
                    IsActive: ''
                }
            },
            result: [],
            Category: [],
            contextMenuProduct: null,
            contextMenuCategory: null,
            images: null,
            updateImage : null,
            searchKey : ''

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
                productname: '',
                productprice: '',
                productimg: '',
                IsActive: '',
                category_id: ''
            }
        },
        productLoad() {
            var page = "http://127.0.0.1:8000/api/products";
            axios.get(page)
                .then(
                    ({ data }) => {
                        console.log(data.products);
                        this.result = data.products;
                    }
                )

            var pageCategory = "http://127.0.0.1:8000/api/categories";
            axios.get(pageCategory)
                .then(
                    ({ data }) => {
                        console.log(data.Category);
                        this.Category = data.Category;
                    }
                )
        },

        edit(product) {
            this.showDialog();
            this.model.product = this.contextMenuProduct;
            this.images = this.getImageUrl(this.model.product.productimg);
        },
        updateData() {
            var editrecords = 'http://127.0.0.1:8000/api/products/' + this.model.product.id;
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
                const formData = {
                    ...this.model.product,
                    productimg: this.model.product.productimg.split(',')[1] // Extract base64 data
                };
                axios.post("http://127.0.0.1:8000/api/products", formData);
                console.log(formData);
                this.resetForm();
                this.productLoad();
                this.onTemplatedUpload();

            } catch (error) {
                console.error('Error saving data:', error);
                if (error.response) {
                    console.error('Response data:', error.response.data);
                    console.error('Response status:', error.response.status);
                    console.error('Response headers:', error.response.headers);
                }
            }
        }, updateData() {

            if (this.contextMenuProduct) {
                const productId = this.contextMenuProduct.id;
                const formData = {
                    ...this.model.product,
                    productimg: this.model.product.productimg.split(',')[1] // Extract base64 data
                    ///.split(',')[1] // Extract base64 data
                };

                var editrecords = `http://127.0.0.1:8000/api/products/${productId}/edit`;
                axios.put(editrecords, formData)
                    .then(({ data }) => {
                        console.log(data);
                        this.resetForm();
                        this.$toast.add({ severity: 'success', summary: 'Update Product Success', detail: 'This Product is updated successfully!', life: 3000 });
                        this.productLoad();
                    })
                    .catch((error) => {
                        console.error('Error updating product:', error);
                        this.$toast.add({ severity: 'error', summary: 'Failed', detail: 'Failed to update product', life: 3000 });
                    });
            }
        },
        ressearchCategory() {
            const apiUrl = `http://127.0.0.1:8000/api/products/search?searchTerm=${this.searchKey}`;

            axios.get(apiUrl)
                .then(response => {
                    // Handle the response data, for example:
                    this.result = response.data.products;
                })
                .catch(error => {
                    console.error('Error during search:', error);
                    // Handle errors or show a message to the user
                });
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
                const url = `http://127.0.0.1:8000/api/products/${productId}/delete`;

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
        toggleMenu(event) {
            this.$refs.menu.toggle(event); // Method to toggle the PrimeVue menu
        },
        getImageUrl(imagePath) {
            const baseURL = 'http://127.0.0.1:8000'; // Replace with your actual APP_URL
            return `${baseURL}/storage/${imagePath}`;
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
        onRemoveTemplatingFile(file, removeFileCallback, index) {
            removeFileCallback(index);
            this.totalSize -= parseInt(this.formatSize(file.size));
            this.totalSizePercent = this.totalSize / 10;
        },
        onClearTemplatingUpload(clear) {
            clear();
            this.totalSize = 0;
            this.totalSizePercent = 0;
        },
        onSelectedFiles(event) {
            const selectedFile = event.files[0];
            const reader = new FileReader();

            reader.onload = () => {
                // Set the base64 representation of the image in your data model
                this.model.product.productimg = reader.result;
            };

            // Read the selected image file as base64
            reader.readAsDataURL(selectedFile);
        },
        convertToBinary(arrayBuffer) {
            // Convert the array buffer to a Uint8Array
            const uintArray = new Uint8Array(arrayBuffer);

            // Convert the Uint8Array to a regular array
            const binaryArray = Array.from(uintArray);

            // Set the binary array to your data model
            this.model.product.productimg = binaryArray;
        },
        uploadEvent(callback) {
            this.totalSizePercent = this.totalSize / 10;
            callback();
        },
        onTemplatedUpload() {
            this.$toast.add({ severity: 'info', summary: 'Success', detail: 'File Uploaded', life: 3000 });
        },
        formatSize(bytes) {
            const k = 1024;
            const dm = 3;
            const sizes = this.$primevue.config.locale.fileSizeTypes;

            if (bytes === 0) {
                return `0 ${sizes[0]}`;
            }

            const i = Math.floor(Math.log(bytes) / Math.log(k));
            const formattedSize = parseFloat((bytes / Math.pow(k, i)).toFixed(dm));

            return `${formattedSize} ${sizes[i]}`;
        },

    }
    // Other component logic
};
</script>
