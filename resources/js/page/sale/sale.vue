<template>
    <div class="">
        <div class=" bg-gray-100   ">
            <div class="flex lg:flex-row flex-col-reverse ">
                <!-- left section -->
                <div class="w-full lg:w-3/5  h-[calc(100vh-135px)]  shadow-lg">
                    <!-- header -->
                    <div class="flex flex-row justify-between items-center px-5 mt-5 ">
                        <div class="text-gray-800">
                            <div class="font-bold text-xl">NN Coffee</div>
                            <span class="text-xs">Location SiemReap, Psa Samki</span>
                        </div>
                        <div class="flex items-center ">
                            <div class="flex items-center justify-between">
                                <div v-if="selectedCustomer === '2'">
                                    <select v-model="selectedClientId" placeholder="Select Customer"
                                        class="w-[250px] text-centers border-2 border-sky-600 text-gray-900 text-sm rounded-lg  bor focus:ring-blue-500 focus:border-blue-500 block outline-none w-full px-6 p-2.5">

                                        <option v-for="client in clients" :key="client.id" :value="client.id">{{
                                            client.customer_name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <div class="mb-1">
                                    <input type="radio" class="mx-2" id="generalCustomer" value="1"
                                        v-model="selectedCustomer">
                                    <label for="generalCustomer">General Customer</label>
                                </div>
                                <div>
                                    <input type="radio" class="mx-2" id="particularClient" value="2"
                                        v-model="selectedCustomer">
                                    <label for="particularClient">Particular Client</label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end header -->
                    <!-- categories -->
                    <div class="mt-5 flex flex-row px-5" @click="filterCategory">
                        <span class="px-5 py-1 rounded-2xl text-sm mr-4 cursor-pointer"
                            :class="{ 'bg-sky-500 text-white': selectedItem === 'All items' }"
                            @click="selectItem('All items')">
                            All items
                        </span>
                        <span v-for="item in Category" :key="item.id"
                            class="px-5 py-1 rounded-2xl text-sm font-semibold mr-4 cursor-pointer"
                            :class="{ 'bg-sky-500 text-white': selectedItem === item.name }" @click="selectItem(item.name)">
                            {{ item.name }}
                        </span>
                    </div>
                    <!-- end categories -->
                    <!-- products -->
                    <div class="grid grid-cols-3 gap-4 px-5 mt-5 overflow-y-auto h-3/4 cursor-pointer"
                        v-if="products != 'No matching products found!'">
                        <div class="px-3 py-3 flex flex-col border border-gray-200 rounded-md h-32 justify-between"
                            v-for="item in products" :key="item.id" @click="addToOrder(item)">
                            <div>
                                <div class="font-bold text-gray-800">{{ item.productname }}</div>
                                <span class="font-light text-sm text-gray-400" :class="{
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800': item.IsActive === 1,
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800': item.IsActive === 2,
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800': item.IsActive === 3
                                }">
                                    {{ item.IsActive === 1 ? 'In Stock' : (item.IsActive === 2 ? 'Low Stock' : 'Out of Stock') }}
                                </span>
                            </div>
                            <div class="flex flex-row justify-between items-center">
                                <span class="self-end font-bold text-lg ">{{ item.productprice }}$</span>
                                <img :src="getImageUrl(item.productimg)" class=" h-14 w-14 object-cover rounded-md" alt="">
                            </div>
                        </div>

                    </div>
                    <div v-if="products == 'No matching products found!'" class="flex justify-center items-center h-64">
                        <p class="text-center">No matching products found!</p>
                    </div>
                    <!-- end products -->
                </div>
                <!-- end left section -->
                <!-- right section -->
                <div class="w-full lg:w-2/5">
                    <!-- header -->
                    <div class="flex flex-row items-center justify-between px-5 mt-5">
                        <div class="font-bold text-xl">Current Order</div>
                        <div class="font-semibold">
                            <span class="px-4 py-2 rounded-md bg-red-100 cursor-pointer text-red-500"
                                @click="clearOrder">Clear All</span>
                        </div>
                    </div>
                    <!-- end header -->
                    <!-- order list -->
                    <div class="px-5 py-4 mt-5 overflow-y-auto h-64">
                        <div class="flex flex-row justify-between items-center mb-4"
                            v-for="(orderItem, index) in currentOrder" :key="orderItem.id">
                            <div class="flex flex-row items-center w-2/5">
                                <img :src="getImageUrl(orderItem.image)" class="w-10 h-10 object-cover rounded-md" alt="">
                                <span class="ml-4 font-semibold text-sm">{{ orderItem.name }}</span>
                            </div>

                            <div class="w-32 flex justify-between">
                                <span class="px-3 py-1 rounded-md bg-gray-300 cursor-pointer "
                                    @click="decreaseQuantity(index)">-</span>
                                <span class="font-semibold mx-4">{{ orderItem.quantity }}</span>
                                <span class="px-3 py-1 rounded-md bg-gray-300 cursor-pointer "
                                    @click="increaseQuantity(index)">+</span>
                            </div>
                            <div class="font-semibold text-lg w-16 text-center">
                                ${{ orderItem.price }}
                            </div>
                        </div>
                    </div>
                    <!-- end order list -->
                    <!-- totalItems -->
                    <div class="px-5 mt-5">
                        <div class="py-4 rounded-md shadow-lg">
                            <div class=" px-4 flex justify-between ">
                                <span class="font-semibold text-sm">Subtotal</span>
                                <span class="font-bold">${{ subtotal.toFixed(2) }}</span>
                            </div>
                            <div class=" flex justify-between">
                                <label for="discountInput" class="py-2 font-semibold px-4">Set Discount:</label>
                                <input class="bg-transparent border-none outline-none text-right font-bold py-2"
                                    id="discountInput" type="number" v-model="discountValue"
                                    placeholder="Enter discount amount" />
                            </div>

                            <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                                <span class="font-semibold text-2xl">Total (with discount)</span>
                                <span class="font-bold text-2xl">${{ totalWithDiscount.toFixed(2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- button pay-->
                    <div class="px-5 mt-5" @click="saveData">
                        <div v-if="currentOrder.length > 0"
                            class="px-4 py-4 rounded-md shadow-lg text-center bg-sky-500 text-white font-semibold cursor-pointer">
                            Pay With Cash
                        </div>
                        <div v-else
                            class="px-4 py-4 rounded-md shadow-lg text-center bg-gray-300 text-white font-semibold cursor-not-allowed">
                            No Items to Purchase
                        </div>
                    </div>
                    <div class="px-5 mt-5 flex items-center justify-end">

                        <div v-if="paidWithCash"
                            class="px-4 py-4 rounded-md shadow-lg text-center bg-sky-500 text-white font-semibold cursor-pointer  mx-5">
                            Print Preview
                        </div>
                        <div
                            class="px-4 py-4 rounded-md shadow-lg text-center bg-sky-500 text-white font-semibold cursor-pointer">
                            <router-link to="/salelist">
                                Transaction
                            </router-link>

                        </div>
                    </div>

                    <!-- end button pay -->
                </div>
                <!-- end right section -->
            </div>
        </div>

    </div>
</template>
<script>
import axios from 'axios';
import { v4 as uuidv4 } from 'uuid';
export default {
    data() {
        return {

            sale: {
                SDate: '',
                SId: '',
                user_id: '',
                product_id: '',
                qty: '',
                customer_id: '',
                status: ''
            },
            paidWithCash: false,
            products: [],
            Category: [],
            selectedItem: 'All items',
            nameCategory: '',
            status: '',
            currentOrder: [],
            discountValue: 0, // Initially, the discount is set to 0
            transactionId: uuidv4(),
            selectedCustomer: '1', // To hold the selected customer type (1 or 2)
            selectedClientId: null, // To hold the selected client's ID
            clients: [],
            currentDate: ''
        };
    },
    computed: {
        subtotal() {
            return this.currentOrder.reduce((total, item) => {
                return total + item.price * item.quantity;
            }, 0);
        },
        discountAmount() {
            return parseFloat(this.discountValue) || 0; // Parse the discount value or default to 0
        },
        totalWithDiscount() {
            return this.subtotal - this.discountAmount;
        },
        salesTax() {
            // Calculate sales tax based on subtotal or any other criteria
            return 0.05 * this.subtotal; // Example: 5% sales tax
        },
        total() {
            return this.subtotal - this.discount + this.salesTax;
        }
    },
    created() {
        this.productLoad()
    },
    mounted() {
        const storedItem = localStorage.getItem('selectedItem');
        if (storedItem) {
            this.selectedItem = storedItem;
            this.filterProductsByCategory(storedItem);
        }
    },
    methods: {
        productLoad() {
            var page = "http://127.0.0.1:8000/api/products";
            axios.get(page)
                .then(
                    ({ data }) => {
                        this.products = data.products;
                    }
                )

            var pageCategory = "http://127.0.0.1:8000/api/categories";
            axios.get(pageCategory)
                .then(
                    ({ data }) => {
                        this.Category = data.Category;
                    }
                )

            var customer = "http://127.0.0.1:8000/api/customers";
            axios.get(customer)
                .then(
                    ({ data }) => {
                        this.clients = data.customers;
                    }
                )
        },
        filterProductsByCategory(category) {
            if (category === 'All items') {
                this.productLoad();
            } else {
                const apiUrl = `http://127.0.0.1:8000/api/products/search?searchTerm=${category}`;
                axios.get(apiUrl)
                    .then(response => {
                        this.products = response.data.products;
                    })
                    .catch(error => {
                        console.error('Error during search:', error);
                    });
            }
        },
        selectItem(name) {
            this.selectedItem = name;
            localStorage.setItem('selectedItem', name);
            this.filterProductsByCategory(name);
        },
        getImageUrl(imagePath) {
            const baseURL = 'http://127.0.0.1:8000'; // Replace with your actual APP_URL
            return `${baseURL}/storage/${imagePath}`;
        },
        addToOrder(product) {
            // Check if the product is already in the current order
            const uniqueId = uuidv4();

            // Check if the product is already in the current order
            const existingProduct = this.currentOrder.find(
                (orderItem) => orderItem.id === product.id
            );

            if (existingProduct) {
                // If the product is already in the order, increment the quantity
                existingProduct.quantity++;
            } else {
                // If the product is not in the order, add it with quantity 1 and unique ID
                this.currentOrder.push({
                    id: product.id,
                    name: product.productname,
                    price: product.productprice,
                    quantity: 1,
                    image: product.productimg,
                    transactionId: uniqueId // Add a unique transactionId for this product
                });
            }

        },
        clearOrder() {
            // Empty the currentOrder array
            this.currentOrder = [];
            this.discountValue = 0;
        },
        increaseQuantity(index) {
            this.currentOrder[index].quantity++;
        },

        // Method to decrease quantity
        decreaseQuantity(index) {
            if (this.currentOrder[index].quantity > 1) {
                this.currentOrder[index].quantity--;
            }
        },
        async saveData() {
            try {
                const currentDate = new Date();
      // Format the date and time as needed (for example, using toLocaleString)
                this.currentDate = currentDate.toLocaleString(); // Adjust the formatting as per your requirements
                const discountPerSale = this.discountAmount;
                const requests = this.currentOrder.map(async (item) => {
                    const formData = {
                        SId: this.transactionId,
                        product_id: item.id,
                        qty: item.quantity,
                        customer_id: this.selectedCustomer,
                        status: '',
                        SDate : this.currentDate,
                        user_id: '',
                        discount: discountPerSale,
                        particular_client: this.selectedClientId
                        // Add other necessary fields...
                    };
                    console.log("each form", formData);


                    // Return the promise from the axios.post call
                    return axios.post("http://127.0.0.1:8000/api/sales", formData);
                });
                console.log("Discound", discountPerSale);

                // Await all the requests simultaneously
                const responses = await Promise.all(requests);
                this.paidWithCash = true;
                // Clear the order after successful submission
                this.clearOrder();

            } catch (error) {
                console.error('Error saving data:', error);
                if (error.response) {
                    console.error('Response data:', error.response.data);
                    console.error('Response status:', error.response.status);
                    console.error('Response headers:', error.response.headers);
                }
            }
        },
        handleChange() {
            // Handle changes in the radio button selection
            // If it's a particular client, you might want to fetch additional client details here
            // For now, it updates the customer_id based on the radio button selected
            if (this.selectedCustomer === '1') {
                this.selectedClientId = null; // Reset selected client when general customer is selected
                // Set customer_id to 1 for general customer
                this.sale.customer_id = 1;
            } else if (this.selectedCustomer === '2') {
                // For particular client, you might want to perform additional actions here
                // Set customer_id to 2 for particular client
                this.sale.customer_id = 2;
            }
        }
    }
}
</script>

