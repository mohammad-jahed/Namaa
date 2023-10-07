
<template>
    <div class="bg-gray-200 min-h-screen p-4">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-center mb-6">Welcome to the Home Page</h1>

            <div class="flex justify-center space-x-4 mb-6">
                <router-link to="/blogs" class="text-blue-500 hover:text-blue-700 hover:underline flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="font-semibold">All Blogs</span>
                </router-link>
            </div>

            <create-blog @blog-created="refreshBlogs" class="mb-6" />

            <div class="space-y-4">
                <blog-list :blogs="blogs" />
            </div>

        </div>
    </div>
</template>

<script>
import CreateBlog from './CreateBlog.vue';
import BlogList from './BlogList.vue';

export default {
    components: {
        CreateBlog,
        BlogList,
    },
    data() {
        return {
            blogs: [],
        };
    },
    methods: {
        refreshBlogs() {
            this.$refs.blogList.fetchBlogs();
        },
    },
};
</script>

