<subscribe-button :channel="{{json_encode($channel)}}"  :subscribers = "{{json_encode($channel->subscribers)}}"  inline-template>
    <button  @click.prevent="subscribe" class="btn btn-danger" :style="customCursor">@{{isOwner ? '' : (isSubscribed ? 'Unsubscribe' : 'Subscribe')}} @{{countSubscribers}} @{{ isOwner ? 'subscribers' : '' }}</button>
</subscribe-button>
