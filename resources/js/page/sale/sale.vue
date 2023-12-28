<template>
    <div class="">
        <div class=" bg-gray-100   ">
            <div class="flex lg:flex-row flex-col-reverse ">
                <!-- left section -->
                <div class="w-full lg:w-3/5  shadow-lg">
                    <!-- header -->
                    <div class="flex flex-row justify-between items-center px-5 mt-5 ">
                        <div class="text-gray-800">
                            <div class="font-bold text-xl">NN Coffee</div>
                            <span class="text-xs">Location SiemReap, Psa Samki</span>
                        </div>
                        <!-- <div class="flex items-center">
                            <div>
                                <span class="px-4 py-2 bg-gray-100 text-gray-800 font-semibold rounded cursor-pointer">
                                    Help </span>
                            </div>

                        </div> -->
                    </div>
                    <!-- end header -->
                    <!-- categories -->
                    <div class="mt-5 flex flex-row px-5">
                        <span class="px-5 py-1 bg-sky-500 rounded-2xl text-white text-sm mr-4 cursor-pointer">
                            All items
                        </span>
                        <span class="px-5 py-1 rounded-2xl text-sm font-semibold mr-4 cursor-pointer">
                            Food
                        </span>
                        <span class="px-5 py-1 rounded-2xl text-sm font-semibold mr-4 cursor-pointer">
                            Cold Drinks
                        </span>
                        <span class="px-5 py-1 rounded-2xl text-sm font-semibold mr-4 cursor-pointer">
                            Hot Drinks
                        </span>
                    </div>
                    <!-- end categories -->
                    <!-- products -->
                    <div class="grid grid-cols-3 gap-4 px-5 mt-5 overflow-y-auto h-3/4 cursor-pointer">
                        <div class="px-3 py-3 flex flex-col border border-gray-200 rounded-md h-32 justify-between">
                            <div>
                                <div class="font-bold text-gray-800">Griled corn</div>
                                <span class="font-light text-sm text-gray-400">150g</span>
                            </div>
                            <div class="flex flex-row justify-between items-center">
                                <span class="self-end font-bold text-lg ">$1.75</span>
                                <img src="https://source.unsplash.com/MNtag_eXMKw/600x600"
                                    class=" h-14 w-14 object-cover rounded-md" alt="">
                            </div>
                        </div>
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
                            <span class="px-4 py-2 rounded-md bg-red-100 cursor-pointer text-red-500">Clear All</span>
                        </div>
                    </div>
                    <!-- end header -->
                    <!-- order list -->
                    <div class="px-5 py-4 mt-5 overflow-y-auto h-64">
                        <div class="flex flex-row justify-between items-center mb-4">
                            <div class="flex flex-row items-center w-2/5">
                                <img src="https://source.unsplash.com/4u_nRgiLW3M/600x600"
                                    class="w-10 h-10 object-cover rounded-md" alt="">
                                <span class="ml-4 font-semibold text-sm">Stuffed flank steak</span>
                            </div>
                            <div class="w-32 flex justify-between">
                                <span class="px-3 py-1 rounded-md bg-gray-300 cursor-pointer ">-</span>
                                <span class="font-semibold mx-4">2</span>
                                <span class="px-3 py-1 rounded-md bg-gray-300 cursor-pointer ">+</span>
                            </div>
                            <div class="font-semibold text-lg w-16 text-center">
                                $13.50
                            </div>
                        </div>
                    </div>
                    <!-- end order list -->
                    <!-- totalItems -->
                    <div class="px-5 mt-5">
                        <div class="py-4 rounded-md shadow-lg">
                            <div class=" px-4 flex justify-between ">
                                <span class="font-semibold text-sm">Subtotal</span>
                                <span class="font-bold">$35.25</span>
                            </div>
                            <div class=" px-4 flex justify-between ">
                                <span class="font-semibold text-sm">Discount</span>
                                <span class="font-bold">- $5.00</span>
                            </div>
                            <div class=" px-4 flex justify-between ">
                                <span class="font-semibold text-sm">Sales Tax</span>
                                <span class="font-bold">$2.25</span>
                            </div>
                            <div class="border-t-2 mt-3 py-2 px-4 flex items-center justify-between">
                                <span class="font-semibold text-2xl">Total</span>
                                <span class="font-bold text-2xl">$37.50</span>
                            </div>
                        </div>
                    </div>
                    <!-- end total -->
                    <!-- cash -->
                    <div class="px-5 mt-5">
                        <div class="rounded-md shadow-lg px-4 py-4">
                            <div class="flex flex-row justify-between items-center">
                                <div class="flex flex-col">
                                    <span class="uppercase text-xs font-semibold">cashless credit</span>
                                    <span class="text-xl font-bold ">$32.50</span>
                                    <span class=" text-xs text-gray-400 ">Available</span>
                                </div>
                                <div class="px-4 py-3 bg-gray-300 text-gray-800 rounded-md font-bold"> Cancel</div>
                            </div>
                        </div>
                    </div>
                    <!-- end cash -->
                    <!-- button pay-->
                <div class="px-5 mt-5">
                    <div class="px-4 py-4 rounded-md shadow-lg text-center bg-sky-500 text-white font-semibold">
                        Pay With Cashless Credit
                    </div>
                </div>
                <!-- end button pay -->
            </div>
            <!-- end right section -->
        </div>
        </div>

</div></template>
