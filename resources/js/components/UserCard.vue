<template>
    <div>
      <h2>Karta Użytkownika: </h2>
      <div>{{ name }}</div>
      <div>{{ email }}</div>
      <div>{{ created_at }}</div>
      <div>{{ role }}</div>
    </div>
</template>

<script>
    export default {
      props: [
        "name",
        "email",
        "created_at",
        "role"
      ]
    }
</script>