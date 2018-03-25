<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="glyphicon glyphicon-heart"><i class="fa fa-heart" aria-hidden="true"></i></span>
        <span class="glyphicon glyphicon-heart" v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props:{
            reply:{
                type:Object
            }
        },
        computed:{
            classes(){
                return ['btn',this.isFavorited ? 'btn-primary': 'btn-default']
            },
            endpoint(){
                return '/replies/'+ this.reply.id + '/favorites';
            }
        },
        data(){
            return {
                count:this.reply.favoritesCount,
                isFavorited:this.reply.isFavorited,
            }
        },
        methods:{
            toggle(){
                return this.isFavorited ?this.create() :this.destroy()
            },
            create(){
                axios.delete(this.endpoint);
                this.isFavorited = false;
                this.count--;
            },
            destroy(){
                axios.post(this.endpoint);
                this.isFavorited = true;
                this.count++;
            }
        }
    }
</script>

