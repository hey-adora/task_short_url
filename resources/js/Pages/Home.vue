<script setup lang="ts">
import {Head, Link, router} from '@inertiajs/vue3';
import {reactive} from "vue";

defineProps<{
    good?: string,
    urls: {
        org_url: string,
        new_url: string
    }[],
    errors?: {
        url?: string
    }
}>();

const form = reactive({
    url: null,
});

function submit() {
    console.log(form.url);
    router.post('/add_url', form);
}

const host = window.location.protocol + "//" + window.location.host;

// function copy(text: string) {
//     navigator.clipboard.writeText(text);
// }


function copy(text: string) {
    if (window.clipboardData && window.clipboardData.setData) {
        // Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.
        return window.clipboardData.setData("Text", text);

    }
    else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
        var textarea = document.createElement("textarea");
        textarea.textContent = text;
        textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in Microsoft Edge.
        document.body.appendChild(textarea);
        textarea.select();
        try {
            return document.execCommand("copy");  // Security exception may be thrown by some browsers.
        }
        catch (ex) {
            console.warn("Copy to clipboard failed.", ex);
            return prompt("Copy to clipboard: Ctrl+C, Enter", text);
        }
        finally {
            document.body.removeChild(textarea);
        }
    }
}

</script>

<template>
    <Head title="Welcome" />
    <main class="flex flex-col gap-2 items-center px-2 text-white" style="padding-top: clamp(2rem, 10vh, 10rem)">
        <section class="flex flex-col gap-4">
            <h1 class="text-pink-500 font-black text-6xl mt-4 text-center">ADD URL</h1>
            <div>
                <form @submit.prevent="submit" class="flex ">
                    <input v-model="form.url" type="text" placeholder="https://google.com" class="border outline-none border-pink-500 bg-white/20 rounded-l  p-1 px-2 " style="max-width: 720px; width: calc(100vw - 4rem - 1rem)">
                    <input type="submit" value="ADD" class="bg-pink-500 hover:bg-pink-400 cursor-pointer rounded-r w-16 font-black ">
                </form>
                <div v-if="!errors?.url && good" class="bg-green-400 px-2 py-1 font-black flex ">
                    <button @click="copy(`${host}/${good}`)" class="border-t-2 border-b-2 border-l-2 border-white hover:bg-green-300 px-2 text-white bg-green-400 font-black whitespace-nowrap">COPY NEW URL</button>
                    <input class="bg-transparent w-full border-2 border-white px-2" :value="`${host}/${good}`">

                </div>
                <div v-if="errors?.url" class="bg-red-600 px-2 font-black">Error: {{errors?.url}}</div>
            </div>
            <h2 class="text-cyan-400 font-black text-2xl mt-8">HISTORY</h2>
            <ul class="flex flex-col gap-2">
                <li v-for="url in urls" class="flex">
                    <div class="border-t border-b border-l border-cyan-400 text-cyan-400 font-light px-2">FROM</div>
                    <input class="bg-transparent w-full border border-cyan-400 px-2" :value="url.org_url">
                    <div class="border-t border-b border-r border-green-400 text-green-400 font-light px-2">TO</div>
                    <input class="bg-transparent w-full border border-green-400 px-2" :value="`${host}/${url.new_url}`">
                    <button @click="copy(`${host}/${url.new_url}`)" class="border-t border-b border-r border-green-400 hover:bg-green-300 px-2 text-white bg-green-400 font-black">COPY</button>
                </li>
            </ul>
        </section>
    </main>
</template>
