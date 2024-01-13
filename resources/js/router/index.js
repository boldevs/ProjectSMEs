
import {createRouter, createWebHistory} from "vue-router";


// 1. Define route components.
// These can be imported from other files

import Master from "../page/layout/master.vue";
import Dashboard from '../page/dashboard.vue';
import Porduct from '../page/products/products.vue';
import Category from '../page/category/category.vue'
import Sale from '../page/sale/sale.vue';
import Customer from '../page/customers/customers.vue';
import Vender from '../page/venders/vendors.vue';
import Item from '../page/Item/ItemForm.vue';
import SaleList from '../page/sale/saleslist.vue';
import Purchase from '../page/purchase/index.vue';

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
    {
        path: '/', redirect: '/sale'  ,component: Master,
        children: [
            // UserHome will be rendered inside User's <router-view>
            // when /user/:id is matched
            { path: '/dashboard', component: Dashboard },
            { path: '/products', component: Porduct },
            { path: '/category', component: Category },
            { path: '/sale', component: Sale },
            { path: '/customers', component: Customer },
            { path: '/vendors', component: Vender },
            {path:'/ItemForm',component:Item},
            { path: '/salelist', component: SaleList },
            { path: '/purchase', component: Purchase }
            // ...other sub routes
        ],
    },

]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(),
    routes, // short for `routes: routes`
})

export default router;

// Now the app has started!
