<template>
    <div class="mt-2 p-1">
        <div class="media my-2">
            <a href="" class="mr-3">
                <avatar :size="30" :username="comment.user.name"></avatar>
            </a>
            <div class="media-body">
                <h6 class="mt-0">{{ comment.user.name }}</h6>
                <small>{{ comment.body }}</small>
                    <div class="my-1 w-100">
                        <input v-if="isAddComment" type="text" class="form-control form-control-sm w-80">
                        <div class="d-flex align-items-center justify-content-start mb-2">
                            <button @click="isAddComment = true" class="btn btn-sm btn-primary mr-2">
                                <small>Add comment</small>
                            </button>
                            <span class="text-muted">{{comment.created_at_human}}</span>
                        </div>
                        <vote type="comment" :default_votes="comment.voters" :entity="comment"></vote>
                    </div>
              <replies :comment="comment"></replies>
            </div>
        </div>
    </div>
</template>

<script>
import Avatar from 'vue-avatar'
import Replies from "./Replies";
export default {
    name: "Comment",
    components: {Avatar, Replies},
    props: [
        'comment'
    ],
    data() {
        return {
            isAddComment: false
        }
    },
}
</script>

<style scoped>

</style>
