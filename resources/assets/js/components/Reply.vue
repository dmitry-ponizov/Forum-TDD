 <template>
    <div :id="'reply-'+ id " class="card " style="margin-top: 20px;">
        <div class="card-header" :class="isBest ? 'bg-info' :''">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + reply.owner.name" v-text="reply.owner.name"></a> said
                    <span v-text="ago"></span>
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="reply"></favorite>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <form action="" @submit.prevent="update">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body" required></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary" >Update</button>
                    <button class="btn btn-sm btn-link" @click="editing = false" type="button">Cancel</button>
                </form>

            </div>
            <div v-else v-html="body"></div>
        </div>

        <div class="card-footer level" v-if="authorize('owns',reply) || authorize('owns',reply.thread)">
            <div  v-if="authorize('owns',reply)">
                <button class="btn btn-sm mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-sm btn-default mr-1" @click="markBestReply" v-if="authorize('owns',reply.thread)">Best Reply?</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue'
    import moment from 'moment';

    export default {
        components: {Favorite},
        props: ['reply'],
        data() {
            return {
                editing: false,
                body: this.reply.body,
                id:this.reply.id,
                isBest:this.reply.isBest,

            }
        },
        computed:{
            ago(){
                return moment(this.reply.created_at).fromNow().concat('...');
            },


        },
        created(){
            window.events.$on('best-reply-selected',id =>{
                this.isBest = (id === this.id);
            });
        },
        methods: {
            markBestReply(){

                axios.post('/replies/'+ this.id +'/best');

                window.events.$emit('best-reply-selected',this.id);

            },
            update() {
                axios.patch('/replies/' + this.id, {
                    body: this.body
                }).then(response => {

                }).catch(error=>{
                    flash(error.response.data,'danger');
                });

                this.editing = false;

                flash('Updated!');
            },
            destroy() {
                axios.delete('/replies/' + this.id);

                this.$emit('deleted',this.id);

            }
        }
    }
</script>

