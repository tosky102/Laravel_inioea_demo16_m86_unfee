<template>
  <div class="list-breadcrumb">
    <div v-for="(item, index) in breadcrumb" class="list-breadcrumb-item">
      <a :href="item.url" v-if="index != Object.keys(breadcrumb).length - 1">{{
        item.text
      }}</a>
      <span v-if="index == Object.keys(breadcrumb).length - 1">{{
        item.text
      }}</span>
    </div>
    <div class="clearfix"></div>
  </div>
</template>
<script>
export default {
  props: ["breadcrumbs"],
  data() {
    return {
      breadcrumb: JSON.parse(this.breadcrumbs),
    };
  },
};
</script>
<style>
.list-breadcrumb {
  font-size: 14px;
  margin: 20px;
}

.list-breadcrumb-item {
  float: left;
  margin-right: 15px;
}

.list-breadcrumb a {
  text-decoration: none;
}

.list-breadcrumb a:hover {
  text-decoration: underline;
}

.list-breadcrumb a,
.list-breadcrumb a:hover,
.list-breadcrumb a:visited,
.list-breadcrumb span {
  color: #969696;
}

.list-breadcrumb .list-breadcrumb-item + .list-breadcrumb-item:before {
  content: ">";
  margin-right: 15px;
  color: #969696;
}

@media (max-width: 768px) {
  .list-breadcrumb {
    display: none;
  }
}
</style>