<template>
    <div class="antialiased bg-gray-50">
        <Navbar @drawer-clicked="sidebarVisible = !sidebarVisible" />
        <Sidebar :isVisible="sidebarVisible" />
        <main class="p-4 lg:ml-48 h-auto pt-20">
            <slot />
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/Sidebar.vue';
import Navbar from '@/Components/Navbar.vue';

const sidebarVisible = ref(false);
</script>