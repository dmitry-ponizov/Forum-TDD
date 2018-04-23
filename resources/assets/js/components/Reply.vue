 <template>
    <div :id="'reply-'+ id " class="card " style="margin-top: 20px;">
        <div class="card-header" :class="isBest ? 'bg-info' :''">
            <div class="level">
                <h5 class="flex">
                    <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name"></a> said
                    <span v-text="ago"></span>
                </h5>
                <div v-if="signedIn">
                    <favorite :reply="data"></favorite>
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

        <div class="card-footer level">
            <div  v-if="canUpdate">
                <button class="btn btn-sm mr-1" @click="editing = true">Edit</button>
                <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
            </div>

            <button class="btn btn-sm btn-default mr-1" @click="markBestReply">Best Reply?</button>
        </div>
    </div>
</template>

<script>
    import Favorite from './Favorite.vue'
    import moment from 'moment';

    export default {
        components: {Favorite},
        props: ['data'],
        data() {
            return {
                editing: false,
                body: this.data.body,
                id:this.data.id,
                isBest:false
            }
        },
        computed:{
            ago(){
                return moment(this.data.created_at).fromNow().concat('...');
            },
            signedIn(){
                return window.App.signedIn;
            },
            canUpdate(){
                return this.authorize(user => this.data.user_id == user.id);
                // return this.data.user_id == window.App.user.id;
            }
        },
        methods: {
            markBestReply(){
                this.isBest = true;
            },
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                }).then(response => {

                }).catch(error=>{
                    flash(error.response.data,'danger');
                });

                this.editing = false;

                flash('Updated!');
            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted',this.data.id);

            }
        }
    }
</script>

