<template>
    <div>
        <div v-if="showConfirmation" class="fixed top-0 left-0 w-screen h-screen flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div class="bg-white w-1/3 p-6 shadow-lg rounded-lg">
                <p class="text-lg font-semibold mb-4">Are you sure you want to delete this blog?</p>
                <div class="flex justify-between">
                    <button @click="deleteBlog" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Yes</button>
                    <button @click="cancelDelete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">No</button>
                </div>
            </div>
        </div>
        <div v-if="blog" class="blog-details-container">
            <h2 class="blog-title">{{ blog.title }}</h2>
            <img :src="'/storage/'+blog.image" alt="Blog Image" class="blog-image" />
            <p class="blog-content">{{ blog.content }}</p>
            <div class="blog-info">
                <div class="blog-status">
                    <span>Status:</span>
                    <span :class="{'text-green': blog.status === '1', 'text-red': blog.status === '0'}">{{ blog.status === '1' ? 'Active' : 'Inactive' }}</span>
                </div>
                <div class="blog-publish-date">
                    <span>Publish Date:</span>
                    <span>{{ blog.publish_date }}</span>
                </div>
            </div>

            <div class="space-x-2">
                <router-link :to="'/blogs/' + blog.id + '/edit'">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">Edit</button>
                </router-link>
                    <button @click="showDeleteConfirmation" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded">Delete</button>
            </div>

        </div>
        <div v-else class="loading-message">
            <p>Loading...</p>
        </div>
    </div>
</template>



<script>
import api from '../api';

export default {
    // props: ['blogId'],
    data() {
        return {
            blog: null,
            showConfirmation: false,
        };
    },
    mounted() {
        const blogId = this.$route.params.id;
        // api.get(`/blogs/${this.blogId}`)
        api.get(`/blogs/${blogId}`)
            .then(response => {
                this.blog = response.data.data;
            })
            .catch(error => {
                console.error('API error:', error);
            });
    },

    methods: {
        showDeleteConfirmation() {
            this.showConfirmation = true;
        },
        cancelDelete() {
            this.showConfirmation = false;
        },
        deleteBlog() {

            api.delete(`/blogs/${this.$route.params.id}`)
                .then(response => {
                    this.$router.push('/blogs');
                })
                .catch(error => {
                    console.error('Delete Blog error:', error);
                });

            this.showConfirmation = false;
        },
    },
};
</script>


<style scoped>
.blog-details-container {
    text-align: center;
    padding: 20px;
    background-color: #f7f7f7;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.blog-title {
    font-size: 24px;
    font-weight: bold;
    margin: 20px 0;
    color: #333;
}

.blog-image {
    max-width: 400px;
    height: auto;
    margin: 0 auto;
    display: block;
}

.blog-content {
    font-size: 16px;
    color: #666;
    margin: 20px 0;
}

.blog-info {
    display: flex;
    justify-content: center;
    align-items: center;
}

.blog-status,
.blog-publish-date {
    margin: 0 10px;
}

.blog-status span,
.blog-publish-date span {
    font-weight: bold;
}

.text-green {
    color: green;
}

.text-red {
    color: red;
}

.blog-buttons {
    margin-top: 20px;
}

.edit-button,
.delete-button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.edit-button:hover,
.delete-button:hover {
    background-color: #0056b3;
}

.delete-confirmation {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    padding: 20px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}
</style>
