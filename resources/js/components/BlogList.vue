
<template>
    <div>

        <div class="relative mb-4">
            <input
                type="text"
                v-model="searchQuery"
                placeholder="Search blogs by title..."
                class="block w-64 p-2 pl-10 rounded-full border border-gray-300 bg-gray-100 text-gray-700 focus:outline-none focus:border-blue-400"
                style="position: absolute; left: 0; top: 0;"
            />
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 absolute left-3 top-3 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m-3 0a9 9 0 110-18 9 9 0 010 18z"
                />
            </svg>
        </div>
    <div class="blog-list">
        <h2 class="text-2xl font-semibold mb-4">All Blogs</h2>
<!--        <div v-for="blog in blogs" :key="blog.id" class="bg-white shadow-md rounded-lg p-4 mb-4">-->
        <div v-for="blog in filteredBlogs" :key="blog.id" class="bg-white shadow-md rounded-lg p-4 mb-4">
            <router-link :to="'/blogs/' + blog.id">
            <img :src="'/storage/' + blog.image" alt="Blog Image" class="max-w-full h-auto mb-2" />

            <h3 class="text-xl font-semibold mb-2">{{ blog.title }}</h3>

            <div class="text-sm text-gray-600 mb-2">
                Status: <span :class="{'text-green-500': blog.status === '1', 'text-red-500': blog.status === '0'}">{{ blog.status === '1' ? 'Active' : 'Inactive' }}</span>
            </div>

            <div class="text-sm text-gray-600 mb-2">
                Publish Date: {{ blog.publish_date }}
            </div>
            </router-link>
        </div>
    </div>
    </div>
</template>

<script>
import api from '../api';

export default {
    data() {
        return {
            blogs: [],
            searchQuery: '',
        };
    },

    computed: {
        filteredBlogs() {
            return this.blogs.filter(blog => {
                return blog.title.toLowerCase().includes(this.searchQuery.toLowerCase());
            });
        },
    },
    mounted() {
        this.fetchBlogs();
    },
    methods: {
        fetchBlogs() {
            api.get('/blogs')
                .then(response => {
                    this.blogs = response.data.data.data;
                })
                .catch(error => {
                    console.error('API error:', error);
                });
        },
    },
};
</script>


<style scoped>
.blog-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

</style>

