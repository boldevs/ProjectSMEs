<template>
    <div class="w-full h-full flex">
        <sidebar :dataOpenSideBar="openSidebar" />
        <div class="w-full h-full">
            <headerTop :dataOpenSideBar="openSidebar" :clickHambuger="toggleSidebar" />
            <div class="p-[20px] h-[calc(100vh-50px)]   bg-gray-100">
                <div class="border border-gray-300 rounded-md p-[20px] h-full overflow-y-scroll no-scrollbar">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import headerTop from './../../components/header.vue'
import sidebar from './../../components/sidebar.vue'

export default {
    components: { headerTop, sidebar },
    data() {
        return {
            openSidebar: true
        }
    },
    methods: {
        toggleSidebar() {
            this.openSidebar = !this.openSidebar
        }
    }

}
</script>

<style></style>
