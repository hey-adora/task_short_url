<script setup lang="ts">
import {Head, Link, router} from '@inertiajs/vue3';
import {reactive} from "vue";

defineProps<{
    boom: string
}>();

const form = reactive({
    url: null,
});

function submit() {
    console.log(form.url);
    router.post('/add_url', form);
}

</script>

<template>
    <Head title="Welcome" />
    <main class="flex flex-col gap-2 items-center pt-[20vh] px-2 text-white">
        <section class="flex flex-col gap-4">
            <h1 class="text-pink-500 font-black text-6xl mt-4 text-center">ADD URL</h1>
            <div>{{boom}}}</div>
            <form @submit.prevent="submit" class="flex ">
                <input v-model="form.url" type="text" placeholder="https://google.com" class="border outline-none border-pink-500 bg-white/20 rounded-l  p-1 px-2 " style="max-width: 720px; width: calc(100vw - 4rem - 1rem)">
                <input type="submit" value="ADD" class="bg-pink-500 hover:bg-pink-400 cursor-pointer rounded-r w-16 font-black ">
            </form>
            <h2 class="text-cyan-400 font-black text-2xl mt-8">HISTORY</h2>
            <ul class="">
                <li class="flex">
                    <div class="border-t border-b border-l border-cyan-400 text-cyan-400 font-light px-2">FROM</div>
                    <input class="bg-transparent w-full border border-cyan-400 px-2" value="hellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohello">
                    <div class="border-t border-b border-r border-green-400 text-green-400 font-light px-2">TO</div>
                    <input class="bg-transparent w-full border border-green-400 px-2" value="sdffffffff">
                    <button class="border-t border-b border-r border-green-400 hover:bg-green-300 px-2 text-white bg-green-400 font-black">COPY</button>
                </li>
            </ul>
        </section>
    </main>
</template>
