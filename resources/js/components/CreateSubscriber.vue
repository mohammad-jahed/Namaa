<template>
    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <div
            class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"
        >
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Sign Up </h1>
            <ul class="list-disc text-red-400" v-if="errors && typeof errors === 'object'">
                <li v-for="(value, key) in errors" :key="key">{{ value[0] }}</li>
            </ul>
            <p class="list-disc text-red-400" v-if="errors && typeof errors === 'string'">{{ errors }}</p>

            <form method="post" @submit.prevent="createSubscriber">
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="name"
                    >
                        Name
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                        id="name"
                        type="text"
                        v-model="formData.name"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="username"
                    >
                        UserName
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                        id="username"
                        type="text"
                        v-model="formData.username"
                        required
                    />
                </div>
                <div class="mb-4">
                    <label
                        class="block text-grey-darker text-sm font-bold mb-2"
                        for="password"
                    >
                        Password
                    </label>
                    <input
                        class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3"
                        id="password"
                        type="password"
                        v-model="formData.password"
                        required
                    />
                </div>
                <div class="flex items-center justify-between">
                    <button
                        class="bg-blue-500 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded"
                        type="submit"
                    >
                        Subscribe
                    </button>
                    <router-link
                        class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                        to="/login"
                    >
                        Sign in
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import api from '../api';

export default {
    data() {
        return {
            formData: {
                name: '',
                username: '',
                password: '',
            },
            errors: null,
        };
    },
    methods: {
        createSubscriber() {
            const {name, username, password} = this.formData;

            api.post('/subscribe', {name, username, password})
                .then(response => {
                    if (response.data.status === 1) {
                        const authToken = response.data.data.token;
                        localStorage.setItem('authToken', authToken);
                        console.log('Subscriber created successfully:', response.data.message);
                        this.$router.push('/home');
                    } else {
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.error('Subscriber creation error:', error);
                    }
                });
        },
    }
};
</script>
