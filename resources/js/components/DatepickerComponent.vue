<template>
    <date-picker value-type="format" format="YYYY-MM-DD" v-model="input_val" lang="ja" :class="input_class" :input-attr="input_attr"></date-picker>
</template>

<script>
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/ja';

    export default {
        props: ['cls', 'value', 'name'],
        components: {
            DatePicker
        },
        data: function() {
            return {
                input_val: this.value,
                input_attr: {
                    name: this.name
                },
                input_class: this.cls,
            }
        },
    }
</script>

<style>
    .mx-datepicker input {
        display: block;
        width: 100%;
        height: calc(1.6em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 0.9rem;
        font-weight: 400;
        line-height: 1.6;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .mx-datepicker input:focus {
        color: #495057;
        background-color: #fff;
        border-color: #a1cbef;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(52, 144, 220, 0.25);

    }

    .mx-datepicker.is-invalid input {
        border-color: #e3342f;
        padding-right: calc(1.6em + 0.75rem);

    }
    .mx-datepicker.is-invalid input:focus {
        border-color: #e3342f !important;
        box-shadow: 0 0 0 0.2rem rgba(227, 52, 47, 0.25);
    }

</style>