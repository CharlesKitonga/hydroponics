import { mapGetters } from 'vuex'
export default{
    data(){
        return{

        }
    },
    methods:{
        async callApi(method, url, dataObj ){
            try {
                // Send a POST request
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });

            } catch (e) {
                console.log(e)
                return e.response
            }
        },
        i (desc, title="Hey") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s (desc, title="Great!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w (desc, title="Ooops..") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e (desc, title="Oops...") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr (desc="Something went wrong! Please try again", title="oops..") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        checkuserPermission(key){
            if(!this.userPermission) return true
            let isPermitted = false;
            for(let d of this.userPermission ){
                if(this.$route.name==d.name) {
                    if(d[key]) {
                        isPermitted = true
                        break
                    }else{
                        break
                    }
                }
                //console.log(d[key])
            }
            return isPermitted;
            //console.log(this.$route.name)
        }
    },

    computed: {
        ...mapGetters({
            'userPermission': 'getUserPermission' 
        }),
        isReadPermitted(){
            return this.checkuserPermission('read')
        },
        isWritePermitted(){
            return this.checkuserPermission('write')
        },
        isUpdatePermitted(){
            return this.checkuserPermission('update')
        },
        isDeletePermitted(){
            return this.checkuserPermission('delete')
        },
    }

}
