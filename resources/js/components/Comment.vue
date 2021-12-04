<template>
    <div class="card mt-2 p-5">
        <div v-for="(comment, index) in comments" :key="index" class="media">
            <a href="" class="mr-3">
                <avatar :size="30" :username="comment.user.name"></avatar>
            </a>
            <div class="media-body">
                <h6 class="mt-0">{{ comment.user.name }}</h6>
                <small>{{ comment.body }}</small>
                <div class="form-inline my-4 w-100">
                    <input type="text" class="form-control form-control-sm w-80">
                    <button class="btn btn-sm btn-primary">
                        <small>Add comment</small>
                    </button>
                </div>
                <div v-for="(reply, indexR) in comment.replies" :key="indexR" class="media mt-1">
                    <a href="" class="mr-3">
                        <avatar :size="30" :username="reply.user.name"></avatar>
                    </a>
                    <div class="media-body">
                        <h6 class="mt-0">{{ reply.user.name }}</h6>
                        <small>{{ reply.body }}</small>
                        <div class="form-inline my-4 w-100">
                            <input type="text" class="form-control form-control-sm w-80">
                            <button class="btn btn-sm btn-primary">
                                <small>Add comment</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-success">
                Load more
            </button>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'

export default {
    name: "Comment",
    components: {Avatar},
    props: [
        'videoId'
    ],
    data() {
        return {
            comments: []
        }
    },
    mounted() {
        axios.get(`/videos/${this.videoId}/comments`)
            .then(res => {
                this.comments = res.data.data.data
            })
    }
}
</script>

<style scoped>

</style>
