<template>
    <div class="h-screen   decoration-green-400" id="side-bar"
        :class="dataOpenSideBar == true ? 'side-bar-visible' : 'side-bar-close'">
        <div class="bg-sky-700 h-[50px] flex justify-center items-center ">
            <div class="text-xl font-bold text-center flex items-center justify-center text-white h-full"
                v-show="dataOpenSideBar">NN Coffee</div>
            <img src="data:image/jpeg;base64,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" v-show="!dataOpenSideBar"
                class="p-1 w-8 h-8 rounded-full ring-2 ring-gray-100 dark:ring-gray-500 " alt="Avatar" />
        </div>
        <div class="flex flex-col justify-between h-[calc(100vh-3rem)] bg-sky-600">
            <div class="menu-man text-left px-2 whitespace-nowrap ">
                <div class="profile flex justify-center items-center text-center p-5 ">
                    <div class="text-center  text-white" v-show="dataOpenSideBar">
                        <img src="data:image/jpeg;base64,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"
                            class="p-1 w-24 h-24 rounded-full ring-2 ring-gray-300 dark:ring-gray-500 mb-4" alt="Avatar" />
                        <h5 class="text-xl font-medium leading-tight mb-2"> My Name</h5>
                        <p class="text-white">Admin </p>
                    </div>
                </div>

                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/sale" class="px-2 flex space-x-2"><span class="pi pi-money-bill"
                            v-tooltip.right="'Sale'"></span> <span v-show="dataOpenSideBar">Sale</span></router-link>
                </div>
                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/salelist" class="px-2 flex space-x-2"><span class=""
                            v-tooltip.right="'Invoice'"><img class="w-5 h-5 text-white" src="../../asset/invoice.png" alt=""></span> <span v-show="dataOpenSideBar">Invoice</span></router-link>
                </div>
                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/purchase" class="px-2 flex space-x-2"><span class=""
                            v-tooltip.right="'Purchase'"><img class="w-5 h-5 text-white" src="../../asset/payment-method.png" alt=""></span> <span v-show="dataOpenSideBar">Purchase</span></router-link>
                </div>

                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/ItemForm" class="px-2 flex space-x-2"><span class="pi pi-building"
                            v-tooltip.right="'Item'"></span> <span v-show="dataOpenSideBar">Item</span></router-link>
                </div>
                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/customers" class="px-2 flex space-x-2"><span class="pi pi-building"
                            v-tooltip.right="'Customer'"></span> <span v-show="dataOpenSideBar">Customer</span></router-link>
                </div>

                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/vendors" class="px-2 flex space-x-2"><span class="pi pi-credit-card"
                            v-tooltip.right="'Vendor'"></span> <span v-show="dataOpenSideBar">Vendor</span></router-link>
                </div>
                <div class="   py-3 rounded-md cursor-pointer  text-white hover:text-gray-300">
                    <router-link to="/products" class="px-2 flex space-x-2"><span class="pi pi-cart-plus "
                            v-tooltip.right="'Product'"></span> <span v-show="dataOpenSideBar">Product</span></router-link>
                </div>
                <div class="   py-3 rounded-md cursor-pointer  text-white hover:text-gray-300">
                    <router-link to="/category" class="px-2 flex space-x-2"><span class="pi pi-tags"
                            v-tooltip.right="'Category'"></span> <span v-show="dataOpenSideBar">Category</span></router-link>
                </div>

                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <div class="px-2 flex space-x-2"><span class="pi pi-slack" v-tooltip.right="'Setting'"></span> <span
                            v-show="dataOpenSideBar">Setting</span></div>
                </div>

                <div class="  py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <router-link to="/user" class="px-2 flex space-x-2"><span class="pi pi-money-bill"
                            v-tooltip.right="'User'"></span> <span v-show="dataOpenSideBar">User</span></router-link>
                </div>
            </div>
            <div class="menu-man text-left px-2 justify-self-end whitespace-nowrap">
                <div class="   py-3 rounded-md cursor-pointer text-white hover:text-gray-300">
                    <a href="https://website-nuxt-front.vercel.app/" target="_blank" class="px-2 flex space-x-2"><span
                            class="pi pi-question" v-tooltip.right="'About Me'"></span> <span v-show="dataOpenSideBar">About
                            Me</span></a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        dataOpenSideBar: Boolean
    },

}
</script>

<style>
.p-tooltip-text {
    font-size: 10px !important;
}

#side-bar {
    overflow: hidden;
    transition: 300ms;
}

.side-bar-visible {
    width: 250px !important;
}

.side-bar-close {
    width: 50px !important;
}</style>
