<template>
    <div>


        <div class="relative ">
            <h1
                class="text-4xl mb-2 font-extrabold leading-none tracking-tight text-gray-900 md:text-xl lg:text-xl dark:text-white float-left">
                Invoice</h1>
            <!-- <div class="flex items-center justify-between float-right  mb-2">
                <div class="flex items-center mr-5 ">
                    <p class="mr-2">From Date</p>
                    <input type="date" v-model="selectedDate" @change="filterByDate" />
                </div>
                <div class="flex items-center ">
                    <p class="mr-2">To Date</p>
                    <input type="date" v-model="selectedDate" @change="filterByDate" />
                </div>
            </div> -->
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
                        Amount
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

        <div class="card flex justify-content-center">

            <Dialog v-model:visible="visible" modal header="Preview Invoice" :style="{ width: '50rem' }"
                :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
                <div v-if="loading" class="text-center">Loading...</div>
                <div ref="invoiceContent" class="bg-white mx-auto">
                    <div class="bg-white rounded-lg shadow-lg px-8 py-10 max-w-xl mx-auto">
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center">
                                <!-- <img class="h-8 w-8 mr-2"
                                    src="https://tailwindflex.com/public/images/logos/favicon-32x32.png" alt="Logo" /> -->
                                <div class="text-gray-700 font-semibold text-lg">NN Coffe</div>
                            </div>
                            <div class="text-gray-700">
                                <div class="font-bold text-xl mb-2">INVOICE</div>
                                <div v-if="ivoice != null" class="text-sm">Date: {{ formatDate(ivoice[0].SDate) }}</div>

                            </div>
                        </div>
                        <div class="border-b-2 border-gray-300 pb-8 mb-8">
                            <h2 class="text-2xl font-bold mb-4">Bill To:</h2>
                            <div class="text-gray-700 mb-2">{{ (ivoice[0].stand_for) }}</div>
                            <div class="text-gray-700 mb-2">{{ (ivoice[0].customer_name) }}</div>
                        </div>
                        <table class="w-full text-left mb-8">
                            <thead>
                                <tr>
                                    <th class="text-gray-700 font-bold uppercase py-2">Description</th>
                                    <th class="text-gray-700 font-bold uppercase py-2">Quantity</th>
                                    <th class="text-gray-700 font-bold uppercase py-2">Price</th>
                                    <th class="text-gray-700 font-bold uppercase py-2">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="list in ivoice" :key="list.id">
                                    <td class="py-4 text-gray-700">{{ list.productname }}</td>
                                    <td class="py-4 text-gray-700 text-center">{{ list.qty }}</td>
                                    <td class="py-4 text-gray-700 text-center">{{ list.productprice }}</td>
                                    <td class="py-4 text-gray-700 text-center">{{ list.productprice * list.qty }}</td>
                                </tr>

                            </tbody>
                        </table>
                        <div class="flex justify-end mb-2">
                            <div class="text-gray-700 mr-2">Subtotal:</div>
                            <div class="text-gray-700">{{ calculateSubtotal().toFixed(2) }}</div>
                        </div>
                        <div class="flex justify-end mb-2">
                            <div class="text-gray-700 mr-2">Discount:</div>
                            <div class="text-gray-700">{{ ivoice[0].discount }}</div>

                        </div>
                        <div class="flex justify-end mb-8">
                            <div class="text-gray-700 font-bold text-xl mr-2">Total:</div>
                            <div class="text-gray-700 font-bold text-xl">$ {{ calculateTotal().toFixed(2) }}</div>
                        </div>
                        <div class="border-t-2 border-gray-300 pt-8 mb-8">
                            <p>Thank you have a good luck day! <3 </p>
                        </div>
                    </div>
                </div>
            </Dialog>
        </div>

    </div>
</template>
<script>
import axios from 'axios';
import domtoimage from 'dom-to-image';
import jsPDF from 'jspdf';
import * as XLSX from 'xlsx'; // Import the xlsx library

export default {
    data() {
        return {
            visible: false,
            items: [
                {
                    label: 'Preview',
                    icon: 'pi pi-print',
                    command: (products) => this.showDialog()

                },
                {
                    label: 'Export to Pdf',
                    icon: 'pi pi-file-export',
                    command: (products) => this.pdfinstall()
                }
            ],
            result: [],
            ivoice: [],
            contextMenuProduct: null,
            images: null,
            updateImage: null,
            searchKey: '',
            loading: false,
            id: null,
            visible: false,

        };
    },
    created() {
        this.productLoad();

    },
    mounted() {
        // this.$nextTick(() => {
        //     this.exportToPdf();
        // });
    },
    methods: {
        calculateSubtotal() {
            return this.ivoice.reduce((subtotal, item) => subtotal + item.productprice * item.qty, 0);
        }, calculateTotal() {
            // You might need to adjust this based on your actual data structure
            return this.calculateSubtotal() - this.ivoice[0].discount;
        },
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

        async showDialog() {
            await this.loadData();
            if (this.ivoice != null) {
                this.visible = true;

            }
        },
        async loadData() {
            try {
                this.loading = true;
                const response = await axios.get(`http://127.0.0.1:8000/api/invoice/${this.contextMenuProduct}`);
                this.ivoice = response.data.salesData;
                console.log("Invoices", this.ivoice);
            } catch (error) {
                console.error('Error loading data:', error);
            } finally {
                this.loading = false;
            }
        },


        // Function to convert content to data URL
        contentToDataURL(content) {
            const canvas = document.createElement('canvas');
            canvas.width = content.offsetWidth;
            canvas.height = content.offsetHeight;

            const context = canvas.getContext('2d');
            context.fillStyle = '#fff'; // Set background color
            context.fillRect(0, 0, canvas.width, canvas.height);

            return new Promise((resolve) => {
                const image = new Image();
                image.onload = () => {
                    context.drawImage(image, 0, 0);
                    resolve(canvas.toDataURL('image/png'));
                };
                image.src = 'data:image/svg+xml,' + encodeURIComponent(content.innerHTML);
            });
        },
        async exportToPdf() {
            try {
                this.visible = true;

                console.log('Exporting to PDF: Start');
                this.loading = true;

                await this.loadData();
                console.log('Data loaded successfully');
                console.log('Invoices', this.ivoice);

                await this.$nextTick(); // Wait for the next DOM update

                const content = this.$refs.invoiceContent;

                // Check if the content element is accessible and visible
                if (!content || content.offsetWidth === undefined || content.offsetHeight === undefined) {
                    throw new Error('Content element not found or is hidden.');
                }

                console.log('Content element:', content);
                console.log('Content offsetWidth:', content.offsetWidth);

                // Use dom-to-image to capture the content as an image
                let imageDataUrl;
                try {
                    imageDataUrl = await domtoimage.toPng(content);
                } catch (domToImageError) {
                    console.error('Error in dom-to-image:', domToImageError.message, domToImageError);
                    throw new Error('Failed to capture content as image.');
                }

                // Create a new jsPDF instance
                const pdf = new jsPDF({
                    unit: 'mm',
                    format: 'a4',
                });

                // Add the image to the PDF
                pdf.addImage(imageDataUrl, 'PNG', 0, 0, pdf.internal.pageSize.width, pdf.internal.pageSize.height);

                // Save the PDF directly (without showing the dialog)
                pdf.save('invoice.pdf');
                console.log('Exporting to PDF: Success');
            } catch (error) {
                console.error('Error exporting to PDF:', error.message, error);
            } finally {
                this.loading = false;
                this.visible = false;
            }
        },

        async pdfinstall() {
            await this.loadData();
            if (this.ivoice != null) {
                this.visible = true;
                this.visible = false;
                this.$nextTick(() => {
                    this.exportToPdf();
                });
            }

        },

    },

    // Other component logic
};
</script>
