
import { createRouter, createWebHistory } from "vue-router";


// 1. Define route components.
// These can be imported from other files
import Login from '../page/auth/login.vue'
import Unauthorized from '../page/auth/unauthorized.vue'
import Master from "../page/layout/master.vue";
import Dashboard from '../page/dashboard.vue';
import Porduct from '../page/products/products.vue';
import Category from '../page/category/category.vue'
import Sale from '../page/sale/sale.vue';
import Customer from '../page/customers/customers.vue';
import Vender from '../page/venders/vendors.vue';
import Item from '../page/Item/ItemForm.vue';
import SaleList from '../page/sale/saleslist.vue';
import User from '../page/user/user.vue'

import auth from '../middleware/auth';
import guest from '../middleware/guest';

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter: (to, from, next) => {
            guest({ next, router })
        }
    },
    {
        path: '/unauthorized',
        name: 'unauthorized',
        component: Unauthorized
    },
    {
        path: '/', redirect: '/dashboard', component: Master,
        children: [
            // UserHome will be rendered inside User's <router-view>
            // when /user/:id is matched
            {
                path: '/dashboard',
                component: Dashboard,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/products',
                component: Porduct,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/category', component: Category,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/sale', component: Sale,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/customers', component: Customer,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/vendors', component: Vender,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/ItemForm', component: Item,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/salelist', component: SaleList,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            },
            {
                path: '/user', component: User,
                beforeEnter: (to, from, next) => {
                    auth({ next, router })
                }
            }
            // ...other sub routes
        ],
    },

]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createWebHistory(import.meta.env.BASE_URL),
    routes, // short for `routes: routes`
})

export default router;

// Now the app has started!