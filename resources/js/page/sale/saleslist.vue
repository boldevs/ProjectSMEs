<template>
    <div>


        <div class="relative ">
            <h1
                class="text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-xl lg:text-xl dark:text-white float-left">
                Invoice</h1>
            <div class="flex items-center justify-between float-right  mb-2">
                <div class="flex items-center mr-5 ">
                    <p class="mr-2">From Date</p>
                    <input type="date" v-model="selectedDate" @change="filterByDate" />
                </div>
                <div class="flex items-center ">
                    <p class="mr-2">To Date</p>
                    <input type="date" v-model="selectedDate" @change="filterByDate" />
                </div>
            </div>
        </div>

        <div v-if="loading" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-80 z-50">
            <div class="flex items-center space-x-2">
                <div aria-label="Loading..." role="status">
                    <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"
                        class="animate-spin w-12 h-12 text-gray-500">
                        <path
                            d="M12 3v3m6.366-.366-2.12 2.12M21 12h-3m.366 6.366-2.12-2.12M12 21v-3m-6.366.366 2.12-2.12M3 12h3m-.366-6.366 2.12 2.12">
                        </path>
                    </svg>
                </div>
                <span class="text-lg font-medium text-gray-500">Loading...</span>
            </div>
        </div>



        <table class="min-w-full divide-y bg-sky-600 overflow-x-auto">
            <thead class="bg-sky-600">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                        Sid
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        customer name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                        customer Type
                    </th>

                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                        quantity
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                        Total Amount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                        Discount
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-white uppercase tracking-wider">
                        actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="salelist in result" :key="salelist.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ salelist.SId }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        {{ formatDate(salelist.SDate) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">


                        {{ salelist.customer_name }}

                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-500">
                            {{ salelist.stand_for }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ salelist.total_quantity }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ salelist.total_amount }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ salelist.discount }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="card flex justify-content-center">
                            <Button type="button" icon="pi pi-ellipsis-v" @click="showContextMenu(salelist)" />
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
</template>
<script>
import axios from 'axios'
export default {
    data() {
        return {
            visible: false,
            items: [
                {
                    label: 'Preview',
                    icon: 'pi pi-print',
                    command: (products) => this.generatePDF(products)

                },
                {
                    label: 'Export to Pdf',
                    icon: 'pi pi-file-export',


                }
            ],
            result: [],
            contextMenuProduct: null,
            images: null,
            updateImage: null,
            searchKey: '',
            loading: false,
            id: null,

        };
    },
    created() {
        this.productLoad();
    },
    mounted() {

    },
    methods: {
        formatDate(dateString) {
            const dateObject = new Date(dateString);
            // Check if the date is valid before proceeding
            if (!isNaN(dateObject.getTime())) {
                const day = dateObject.getDate().toString().padStart(2, '0');
                const month = (dateObject.getMonth() + 1).toString().padStart(2, '0');
                const year = dateObject.getFullYear();
                return `${day}/${month}/${year}`;
            } else {
                return 'Invalid Date'; // Or any other handling for invalid dates
            }
        },
        productLoad() {
            var page = "http://127.0.0.1:8000/api/sales";
            axios.get(page)
                .then(
                    ({ data }) => {
                        this.result = data.sales;
                    }
                )
        },
        showContextMenu(saleItem) {
            this.contextMenuProduct = saleItem.SId;
            console.log("Product Item SId: ", saleItem.SId);
            this.$refs.menu.toggle(event);
        },

        toggleMenu(event) {
            this.$refs.menu.toggle(event); // Method to toggle the PrimeVue menu
        },
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        async generatePDF(product) {
            console.log("id", this.contextMenuProduct)
            this.loading = true;
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/invoice/${this.contextMenuProduct}`, {}, {
                    responseType: 'blob'
                });

                const blob = new Blob([response.data], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);

                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                iframe.src = url;

                iframe.onload = () => {
                    iframe.contentWindow.print();
                    this.loading = false;
                };
            } catch (error) {
                this.loading = false;
                console.error('Error generating PDF:', error);
            }
        }
    }
    // Other component logic
};
</script>
