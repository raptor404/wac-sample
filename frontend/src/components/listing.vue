<template>
    <div class="base">
        <h1>Recipe API Browser</h1>
        <div>
            <ul>
                <li>
                    <router-link to="/">Listing</router-link>
                </li>
                <li>
                    <router-link to="/search">Search</router-link>
                </li>
            </ul>
        </div>

        <h3>List</h3>
        <div v-if="WholeRecipeDataSet!==null">
            <div v-for="result in WholeRecipeDataSet">
                <CustomRecipeCard
                    :RecipeObject="result"
                />
            </div>

        </div>
    </div>
</template>

<script>
import axios from "axios";
import CustomRecipeCard from "./CustomRecipeCard.vue";

export default {
    name: "ListingPage",
    data() {
        return {
            WholeRecipeDataSet: null,
            pageData:null,
        }
    },
    components: {
        CustomRecipeCard
    },
    computed: {},
    methods: {
        async fetchData() {
            let self = this
            await axios.get('http://127.0.0.1:8888/api/recipe').then(response => {
                console.log(response.data.data)
                for(const recipe of response.data.data){
                    self.$store.commit('addToRecipe', recipe)
                }

                self.WholeRecipeDataSet = response.data.data
                self.pageData = response.data.metaData
            });
        }
    },
    beforeMount() {
        this.fetchData();
    }
}


</script>
