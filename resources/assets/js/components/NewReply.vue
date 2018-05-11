 <template>
    <div>
        <div style="margin-top: 20px;" v-if="signIn">
            <div class="form-group">
                <wysiwyg name="body" v-model="body" placeholder="Have something to say?"></wysiwyg>
                    <!--<textarea name="body"-->
                              <!--id="body"-->
                              <!--placeholder="Have something to say?"-->
                              <!--rows="5"-->
                              <!--class="form-control"-->
                              <!--required-->
                              <!--v-model="body"></textarea>-->
            </div>
            <button type="submit"
                    class="btn btn-default"
                    @click="addReply">Post
            </button>
        </div>
        <p  v-else  style="margin-top: 20px;" class="text-center">Please <a href="/login">sign
            in </a>to
            participate in this discussion</p>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                body: ''
            }
        },
        computed:{
            signIn(){
                return window.App.signedIn;
            }
        },
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies ', {body: this.body})
                    .then(({data}) => {

                        this.body = '';

                        flash('Your reply has been posted');

                        this.$emit('created', data);
                    }).catch(error=>{
                       flash(error.response.data,'danger');
                })
            }
        }
    }
</script>

