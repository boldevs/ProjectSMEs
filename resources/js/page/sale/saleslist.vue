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
            searchKey : ''

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
    }
    // Other component logic
};
</script>
