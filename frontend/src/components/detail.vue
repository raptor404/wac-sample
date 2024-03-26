<template>
    <div>
        <h1>Recipe Detail</h1>

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



        <h5 class="">{{ recipeRecord.Name }}</h5>
        <p  class="">{{ recipeRecord.Description }}</p>
        <div>
            <label class="">
                Author:
            </label>
            <p  class="">{{ recipeRecord.AuthorEmailAddress }}</p>
        </div>

        <div>
            <h6>Ingredients</h6>
            <ul>
                <li v-for="ingredient in recipeRecord.Ingredients">
                    {{ingredient.Text}}
                </li>
            </ul>
        </div>

        <div>
            <h6>Steps</h6>
            <ul>
                <li v-for="step in recipeRecord.Steps">
                    {{step.Order}}. {{step.Text}}
                </li>
            </ul>
        </div>


    </div>
</template>
<script >

import axios from "axios";
import CustomRecipeCard from "./CustomRecipeCard.vue"

export default {
    name: "DetailPage",
    props: [
        'slug',
    ],
    components: {
        CustomRecipeCard
    },
    computed: {
        recipeRecord(){
            return this.$store.state.Recipes.get(this.slug)
        }
    },

}
/*
const websiteConfig = useState('config')
const recipeRecord = useState('recipeRecord', () => null);
const route = useRoute();

await callOnce(async () => {
    let result = await $fetch(`https://localhost:8888/api/recipe/slug/${route.params.slug}`);
    console.log(result)
    recipeRecord.value = result.data
})

definePageMeta({
    validate: async (route) => {
        // Check if the id is made up of digits
        return typeof route.params.slug === 'string'
    }
})


*/

//page
//ingredient
//keyword
//author
//get api dataset

</script>



