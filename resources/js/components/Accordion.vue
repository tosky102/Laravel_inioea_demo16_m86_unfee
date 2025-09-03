<template>
    <dl class="accordion box" role="presentation">
        <accordion-item
                v-for="item in content"
                :multiple="multiple"
                :item="item"
                :groupId="groupId"
                :key="item.id">
        </accordion-item>
    </dl>
</template>
<script>
    export default {
        props: ['contents', 'multiple'],
        data() {
            return {
                groupId: null,
                content: JSON.parse(this.contents)
            }
        },
        mounted() {
            this.groupId = this.$el.id
        }
    }
</script>

<style>
    .accordion {
        padding: 0;
        /*background-color: #ffffff;*/
    }
    .accordion div:not(:last-child) {
        /*border-bottom: 1px solid rgba(10, 10, 10, 0.1);*/
    }
    /*.accordion div:last-child .accordion-item-details {*/
    /*    border-radius: 5px;*/
    /*}*/
    .accordion dd {
        margin-left: 0;
        /*background-color: #ffffff;*/
    }

</style>