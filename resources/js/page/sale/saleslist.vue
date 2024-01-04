<template>
    <div>


        <div class="relative my-2 float-right">
                <div class="flex items-center justify-between">
                    <div class="flex items-center mr-5 ">
                        <p class="mr-2">From Date</p>
                        <input type="date" v-model="selectedDate" @change="filterByDate" /></div>
                    <div  class="flex items-center ">
                        <p class="mr-2">To Date</p>
                        <input type="date" v-model="selectedDate" @change="filterByDate" />
                    </div>
                </div>
                </div>

                <div v-if="loading" class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-80 z-50">
                    <div class="flex items-center space-x-2">
                        <div aria-label="Loading..." role="status">
                            <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg" class="animate-spin w-12 h-12 text-gray-500">
                                <path d="M12 3v3m6.366-.366-2.12 2.12M21 12h-3m.366 6.366-2.12-2.12M12 21v-3m-6.366.366 2.12-2.12M3 12h3m-.366-6.366 2.12 2.12"></path>
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
                        {{ salelist.SDate }}
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
            updateImage : null,
            searchKey : '',
            loading : false,

        };
    },
    created() {
        this.productLoad();
    },
    mounted() {

    },
    methods: {
        productLoad() {
            var page = "http://127.0.0.1:8000/api/sales";
            axios.get(page)
                .then(
                    ({ data }) => {
                        this.result = data.sales;
                    }
                )
        },
        showContextMenu(product) {
            this.contextMenuProduct = product;
            console.log("Product Items : ", this.contextMenuProduct);
            this.$refs.menu.toggle(event);
        },

        toggleMenu(event) {
            this.$refs.menu.toggle(event); // Method to toggle the PrimeVue menu
        },
        toggle(event) {
            this.$refs.menu.toggle(event);
        },
        async generatePDF(product) {
            this.loading = true;
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/invoice', {}, {
                    responseType: 'blob'
                });
                // Create a blob URL for the PDF
                const blob = new Blob([response.data], { type: 'application/pdf' });

                // Convert the blob into a URL
                const url = URL.createObjectURL(blob);

                // Open the PDF in a hidden iframe
                const iframe = document.createElement('iframe');
                iframe.style.display = 'none';
                document.body.appendChild(iframe);
                iframe.src = url;

                // Trigger the print dialog when the iframe has loaded the PDF
                iframe.onload = () => {
                    iframe.contentWindow.print(); // Open print dialog
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
