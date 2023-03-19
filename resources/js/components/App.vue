<template>
    <div>
        <h1>Przykładowy nagłówek!</h1>
 
        <p>
            <router-link :to="{ name: 'hello' }" style ="margin-right:10px;">Hello World</router-link>
            <router-link :to="{ name: 'witaj' }" style ="margin-right:10px;">Witaj Świecie</router-link>
            <router-link :to="{ name: 'LoremIpsum' }" style ="margin-right:10px;">Lorem Ipsum</router-link>
            <router-link :to="{ name: 'UserCard' }">Karta Użytkownika</router-link>
        </p>
        <hr>
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default {
    }
</script>