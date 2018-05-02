<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props:['active'],
        computed:{
            classes(){
                return ['btn','btn-sm ',this.active ? 'btn-primary' : 'btn-info']
            }
        },
        methods:{
            subscribe(){

                axios[this.active ? 'delete' : 'post'](location.pathname + '/subscriptions');

                this.active = !this.active;

            }
        }
    }
</script>

