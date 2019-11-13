<template>
  <div class="container--small">
        {{ username }}
        <el-button type="primary" @click="logout">Logout</el-button>
  </div>
</template>

<script>
export default {
  methods: {
    async logout () {
      await this.$store.dispatch('auth/logout')
      this.$router.push('/app_index/')
    }
  },
  computed: {
    username () {
      return this.$store.getters['auth/username']
    }
  }
}
</script>