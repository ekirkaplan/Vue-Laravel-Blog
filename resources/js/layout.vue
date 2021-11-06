<template>
  <div>
    <headers></headers>
    <router-view></router-view>
    <footers></footers>

  </div>

</template>

<script>
import headers from "./Companents/headers";
import footers from "./Companents/footers";
export default {
  name: "layout",
  components: {
    headers,
    footers
  },
}
</script>

<style scoped>

</style>
