<template>
    <div>
        <div v-for="(reply,index) in items" :key="reply.id">
            <reply @deleted="remove(index)" :reply="reply"></reply>
        </div>
        <paginator :dataSet="dataSet" @updated="fetch"></paginator>
        <p v-if="$parent. locked">
            This is thread is locked.No more replies are allowed.
        </p>

        <new-reply v-else @created="add"></new-reply>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import NewReply from './NewReply.vue';
    import collection from '../mixins/collection';

    export default {
        components:{ Reply , NewReply  },
        mixins:[ collection ],
        data(){
            return {
                dataSet:false,
                items: [],

            }
        },
        created(){
            this.fetch();


        },
        methods:{

            fetch(page){
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            refresh({data}){
                this.dataSet = data;
                this.items = data.data;
                window.scrollTo(0,0)
            },
            url(page){
                if(!page){
                   let query = location.search.match(/page=(\d+)/);

                   page = query ? query[1] : 1;
                }
                return `${location.pathname}/replies?page=${page}`;
            },

        }
    }
</script>
