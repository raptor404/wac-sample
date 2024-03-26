import {createApp} from 'vue'
import './style.css'
import App from './App.vue'
import Vuex from 'vuex'


import {createWebHistory, createRouter} from "vue-router";

import ListingPage from "./components/listing.vue";
import SearchPage from "./components/search.vue";
import DetailPage from './components/detail.vue';

const routes = [
    {path: '/', component: ListingPage},
    {
        path: '/search',
        name: 'search',
        component: SearchPage,
        props: true
    },
    {path: '/detail/:slug', component: DetailPage, props: true},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const store = new Vuex.Store({
    state: {
        Recipes: new Map([]),
    },
    mutations: {
        addToRecipe(state, recipe) {
            state.Recipes.set(recipe.Slug, recipe);
        }
    }
})

createApp(App)
    .use(router)
    .use(store)
    .mount('#app')
