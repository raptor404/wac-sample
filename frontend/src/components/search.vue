<template>
    <div class="base">
        <h1>Recipe API Listing</h1>
        <div>
            <ul>
                <li>
                    <router-link to="/">Listing</router-link>
                </li>
                <li>
                    <router-link to="/search" @click="clearSearch">Search</router-link>
                </li>
            </ul>
        </div>

        <div>
            <h3>Search:</h3>
            <div>
                <label for="ingredient">Author Email</label><br>
                <input type="text" name="author" v-model="searchParamsState.author">
            </div>
            <div>
                <label for="ingredient">Ingredient</label><br>
                <input type="text" name="ingredient" v-model="searchParamsState.ingredient">
            </div>
            <div>
                <label for="ingredient">Keyword</label><br>
                <input type="text" name="keyword" v-model="searchParamsState.keyword">
            </div>

            <div style="display: none">
                <input name="password" v-model="searchParamsState.password">
            </div>
            <br>
            <button type="button" @click="doSearch(1)">Search</button>
        </div>
        <br>
        <div>
            <h3>List</h3>
            <div v-if="searchPageState!==null && searchPageState.length>0">
                <div
                    v-for="result in searchPageState"
                >
                    <CustomRecipeCard
                        :RecipeObject="result"/>
                </div>

                <div v-if="pageData!==null">
                    <div>Pages:</div>
                    <ul class="flex flex-wrap items-center justify-center text-gray-900 dark:text-white">
                        <li v-for="page in pageData.pages" @click="doSearch(page)"
                            style="float:left;display:inline; padding:5px 5px;"
                        >
                           <span
                               class="me-4 hover:underline md:me-6 "
                               :style="{'background-color': (parseInt(page)===parseInt(searchParamsState.page) ? '#718096': 'white')}"
                           >
                               {{ page }}
                           </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div v-else>
                No Results
            </div>


        </div>
    </div>
</template>
<script>
import axios from "axios";
import CustomRecipeCard from "./CustomRecipeCard.vue"

export default {
    name: "SearchPage",
    props: {},
    components: {
        CustomRecipeCard
    },
    data() {
        return {
            searchParamsState: {
                author: '',
                ingredient: '',
                keyword: '',
                password: '',
                page: 1
            },
            searchPageState: null,
            pageData: null,
        }
    },
    computed: {},
    methods: {
        clearSearch() {
            this.searchParamsState = {
                author: '',
                ingredient: '',
                keyword: '',
                password: '',
                page: 1
            }
            this.searchPageState = null
            this.pageData = null
        },
        doSearch(page) {
            this.searchParamsState.page = page
            this.$router.push({
                'name': 'search',
                query: this.searchParamsState
            })
        },
        async fetchData() {
            this.error = this.post = null
            this.loading = true
            let self = this;
            try {
                let searchParams = {
                    author: this.searchParamsState.author,
                    ingredient: this.searchParamsState.ingredient,
                    keyword: this.searchParamsState.keyword,
                    password: this.searchParamsState.password,
                    page: this.searchParamsState.page
                }

                //TODO it would be suuuuper simple to support putting these results in a store by page,
                // then doing a check in the do search to see if we have them already
                await axios.get('http://127.0.0.1:8888/api/recipe/search', {
                    params: searchParams
                }).then(response => {
                    console.log(response.data.data)
                    for (const recipe of response.data.data) {
                        self.$store.commit('addToRecipe', recipe)
                    }

                    self.searchPageState = response.data.data
                    self.page = response.data.metaData.page
                    self.pageData = response.data.metaData
                });
            } catch (err) {
                this.error = err.toString()
            } finally {
                this.loading = false
            }
        },
    },
    mounted() {
        this.searchParamsState = {
            author: this.$route.query.author,
            ingredient:  this.$route.query.ingredient,
            keyword: this.$route.query.keyword,
            password:  this.$route.query.password,
            page:  this.$route.query.page
        }
        this.fetchData()

    },
    created() {
        // watch the params of the route to fetch the data again
        this.$watch(
            () => this.$route.query,
            this.fetchData,
            // fetch the data when the view is created and the data is
            // already being observed
            {immediate: true}
        )
    },

}

</script>
