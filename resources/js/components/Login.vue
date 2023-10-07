<template>

    <div class="mx-auto w-4/12 mt-10 bg-blue-200 p-4 rounded-lg">
        <div
            class="bg-white shadow-lg rounded-lg px-8 pt-6 pb-8 mb-2 flex flex-col"
        >
            <h1 class="text-gray-600 py-5 font-bold text-3xl"> Login </h1>
            <ul class="list-disc text-red-400" v-if="errors && typeof errors === 'object'">
                <li v-for="(value, key) in errors" :key="key">{{ value[0] }}</li>
            </ul>
            <p class="list-disc text-red-400" v-if="errors && typeof errors === 'string'">{{ errors }}</p>
            <form method="post" @submit.prevent="login">
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
                        Sign In
                    </button>
                    <router-link
                        class="inline-block align-baseline font-bold text-sm text-blue hover:text-blue-darker"
                        to="/subscribe"
                    >
                        Subscribe
                    </router-link>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import api from '../api';

export default {
    setup(){

    },
    data() {
        return {
            formData: {
                username: '',
                password: '',
            },
            errors: null,
        };
    },
    methods: {
        login() {
            const { username, password } = this.formData;

            api.post('/login', { username, password })
                .then(response => {
                    if (response.data.status === 1 && response.data.message ==="User Login Successfully.") {
                        const authToken = response.data.data.token;
                        localStorage.setItem('authToken', authToken);
                        this.$router.push('/home');
                    } else {
                        this.errors = 'Wrong username or password';
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 401) {
                        this.errors = 'Wrong username or password';
                    } else {
                        console.error('Login error:', error);
                    }
                });
        },
        },
};

</script>
