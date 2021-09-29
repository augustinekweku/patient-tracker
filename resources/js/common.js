import { mapGetters } from  'vuex'
export default {
    data() {
        return{

        }
    },
    methods: {
    async callApi(method, url, dataObj) {
            // Send a POST request
            try {
                return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });               
            } catch (e) {
                return e.response
            }

        },
        successMsg(msg){
            this.snackbar_msg = msg
            this.snackbarColor = "success";
            return this.snackbar = true           
        },
        errorMsg(msg){
            this.snackbar_msg = msg
            this.snackbarColor = "red darken-2";
            return this.snackbar = true           
        },
        infoMsg(msg){
            this.snackbar_msg = msg
            this.snackbarColor = "primary";
            return this.snackbar = true           
        },
        swrMsg(){
            this.snackbar_msg = "Something went wrong"
            this.snackbarColor = "error";
            return this.snackbar = true           
        },

    },
    computed: {

    }
}