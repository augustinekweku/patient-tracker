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
        successAlert(msg){
            Swal.fire(
                'Success',
                msg,
                'success'
              )
        },
        successMsg(msg){
            Toast.fire({
                icon: 'success',
                title: msg
                })          
        },
        errorMsg(msg){
            Toast.fire({
                icon: 'error',
                title: msg
                })           
        },
        infoMsg(msg){
            Toast.fire({
                icon: 'info',
                title: msg
                })          
        },
        swrMsg(){
            Toast.fire({
                icon: 'error',
                title: 'Something went wrong'
                })          
        },

    },
    computed: {

    }
}