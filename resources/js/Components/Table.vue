<template>
    <table class="w-full text-sm text-left text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <slot name="head"></slot>

            </tr>
        </thead>
        <tbody>
            <slot name="body"></slot>
        </tbody>
    </table>
</template>
