<template>
    <router-view v-slot="{ Component, route }">
    <div :key="route.name">
        <Component :is="Component"></Component>
    </div>
    </router-view>
</template>

