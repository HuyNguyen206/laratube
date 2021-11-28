import numeral from 'numeral'
Vue.component('subscribe-button', {
    props:{
        channel: {
            type: Object,
            required: true
        },
        subscribers: {
            type: Array,
            default: []
        }
    },
    data() {
      return {
          subscribersData: this.subscribers
      }
    },
    // props: ['channelUserId', 'subscribers'],
 methods: {
     subscribe(){
         if(!authUser) {
             alert('Please login to subscribe the channel')
         } else {
             if(this.isOwner) {
                 alert('You are owner of this channel')
             } else {
                 axios.post(`/subscribers/channels/${this.channel.id}`)
                     .then(({data}) => {
                         if (this.isSubscribed) {
                            this.subscribersData.splice(this.subscriber.index,1)
                         } else {
                             this.subscribersData.push(data.data)
                         }
                        // this.subscribersData = data.data.subscribers
                     })
                     .catch(err => {

                     })
             }
         }

     }
 },
    computed:{
        subscriber()
        {
            for (let i = 0; i < this.subscribersData.length; i++)
            {
                if (this.subscribersData[i].id === authUser.id) {
                    return {index: i, subscriber: this.subscribersData[i]}
                }
            }
            return null
        },
        customCursor(){
            return !authUser || authUser.id === this.channel.id ? 'cursor: auto' : ''
        },
        isSubscribed(){
            if(!authUser) {
                return false
            }
            // return !!(this.subscribersData.find((subscriber, index) => (subscriber.id === authUser.id)))
            return !!this.subscriber
        },
        isOwner(){
            return authUser && this.channel.user_id === authUser.id
        },
        countSubscribers(){
            return numeral(this.subscribersData.length).format('0.0a')
        }
    }
})
