<template>

</template>

<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue'

    export default {

        props: ['thread'],
        components: {Replies, SubscribeButton},
        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                form: {
                    title: this.thread.title,
                    body: this.thread.body
                },
                editing: false
            }
        },
        created(){
            this.resetForm()
        },
        methods: {
            resetForm() {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                };
                this.editing = false;
            },

            toggleLock() {

                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug)

                this.locked = !this.locked;
            },
            update() {
                axios.patch('/threads/' + this.thread.channel.slug + '/' + this.thread.slug, this.form
                 ).then(() => {
                    this.editing = false;
                    flash('Your thread has been updated!')
                })
            }
        }
    }
</script>

