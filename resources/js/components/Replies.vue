<template>
    <div class="mt-3">
        <div v-for="(reply, indexR) in replies" :key="indexR" class="media my-3">
            <a href="" class="mr-3">
                <avatar :size="30" :username="reply.user.name"></avatar>
            </a>
            <div class="media-body">
                <h6 class="my-0">{{ reply.user.name }}</h6>
                <small>{{ reply.body }}</small>
                <div class="my-0 w-100">
                    <div class="d-flex align-items-center justify-content-start my-0">
                        <span class="text-muted">{{ reply.created_at_human }}</span>
                    </div>
                    <vote type="comment" :default_votes="reply.voters" :entity="reply"></vote>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
import Avatar from 'vue-avatar'

export default {
    name: "Replies",
    props: ['replies'],
    components: {Avatar},
}
</script>

<style scoped>

</style>
