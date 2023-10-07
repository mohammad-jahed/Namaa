
<template>
    <div class="form-container">
        <h2>Create a Blog</h2>
        <form @submit.prevent="createBlog">
            <div class="mb-4">
                <label for="title" class="block text-grey-darker text-sm font-bold mb-2">Title</label>
                <input v-model="blogData.title" type="text" id="title" required>
                <p v-if="validationErrors.title" class="text-red-500 text-xs italic">{{ validationErrors.title[0] }}</p>

            </div>
            <div class="mb-4">
                <label for="content" class="block text-grey-darker text-sm font-bold mb-2">Content</label>
                <textarea v-model="blogData.content" id="content" required></textarea>
                <p v-if="validationErrors.content" class="text-red-500 text-xs italic">{{ validationErrors.content[0] }}</p>

            </div>
            <div class="mb-4">
                <label for="image" class="block text-grey-darker text-sm font-bold mb-2">Image</label>
                <div class="image-upload">
                    <input type="file" id="image" ref="imageInput" @change="handleImageUpload" accept="image/*">
                    <label for="image" class="upload-button">Choose Image</label>
                    <p v-if="validationErrors.image" class="text-red-500 text-xs italic">{{ validationErrors.image[0] }}</p>

                </div>
                <div v-if="imagePreview" class="image-preview">
                    <img :src="imagePreview" alt="Uploaded Image">
                </div>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-grey-darker text-sm font-bold mb-2">Status</label>
                <select v-model="blogData.status" id="status" class="status-dropdown" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded">Create Blog</button>
            </div>
        </form>
    </div>
</template>

<script>
import api from '../api';

export default {
    data() {
        return {
            blogData: {
                title: '',
                content: '',
                status: '1',
                image: null,
            },
            imagePreview: null,

            validationErrors: {
                title: null,
                image: null,
                publish_date: null,
                content: null,
            },
        };
    },
    methods: {
        createBlog() {
            const formData = new FormData();
            formData.append('title', this.blogData.title);
            formData.append('content', this.blogData.content);
            formData.append('image', this.blogData.image);
            formData.append('status', this.blogData.status);

            api.post('/blogs/create', formData)
                .then(response => {
                    this.$emit('blog-created');
                })
                .catch(error => {
                    // if (error.response && error.response.status === 422) {
                        if (error.response && error.response.data && error.response.data.errors) {
                            this.validationErrors = error.response.data.errors;
                    } else {
                    }
                });
        },
        handleImageUpload(event) {
            const selectedImage = event.target.files[0];
            if (selectedImage) {
                this.blogData.image = selectedImage;
                this.imagePreview = URL.createObjectURL(selectedImage);
            } else {
                this.blogData.image = null;
                this.imagePreview = null;
            }
        },
    },
};
</script>

<style scoped>
.form-container {
    max-width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f7f7f7;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.form-container h2 {
    font-size: 24px;
    margin-bottom: 20px;
    color: #333;
}

.form-container label {
    font-weight: bold;
    color: #333;
}

.form-container input[type="text"],
.form-container textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.form-container button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 20px;
    cursor: pointer;
}

.form-container button:hover {
    background-color: #0056b3;
}

.error-message {
    color: #ff0000;
    margin-top: 10px;
    font-size: 14px;
}

.image-upload {
    position: relative;
    overflow: hidden;
}

.upload-button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    display: block;
    text-align: center;
}

.upload-button:hover {
    background-color: #0056b3;
}

#image {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.image-preview {
    margin-top: 10px;
}

.image-preview img {
    max-width: 100%;
    max-height: 200px;
}
.status-dropdown {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: #fff;
    color: #333;
    font-size: 14px;
}

.status-dropdown option {
    background-color: #fff;
    color: #333;
}

.status-dropdown:hover,
.status-dropdown:focus {
    border-color: #007bff;
}

.status-dropdown option:hover {
    background-color: #007bff;
    color: #fff;
}
</style>

