<template>
    <div class="float-left col-6 text-left">
        <router-link :to="'/detail/' + RecipeObject.Slug">
            <h5 class="">{{ RecipeObject.Name }}</h5>
            <p  class="">{{ RecipeObject.Description }}</p>
            <div>
                <label class="">
                    Author:
                </label>
                <p  class="">{{ RecipeObject.AuthorEmailAddress }}</p>
            </div>
        </router-link>
    </div>
</template>

<script>
export default {
    name: "CustomRecipeCard",
    data() {
        return {

        }
    },
    props: [
        'RecipeObject'
    ],
    computed: {
    }
}
</script>
