<template>
    <div class="page container">
    
    <v-row>
        <v-col
        cols="12"
        sm="12"
        md="6"
        lg="6"
        >
<v-list
          two-line
          subheader
        >
          <v-subheader inset>
            Folders
          </v-subheader>

          <v-list-item
            v-for="item in items"
            :key="item.title"
            link
          >
            <v-list-item-avatar>
              <v-icon :class="[item.iconClass]">
                {{ item.icon }}
              </v-icon>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>

              <v-list-item-subtitle>{{ item.subtitle }}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-action>
              <v-btn icon>
                <v-icon color="grey lighten-1">
                  mdi-information
                </v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>

          <v-divider inset></v-divider>

          <v-subheader inset>
            Files
          </v-subheader>

          <v-list-item
            v-for="item in items2"
            :key="item.title"
            link
          >
            <v-list-item-avatar>
              <v-icon :class="[item.iconClass]">
                {{ item.icon }}
              </v-icon>
            </v-list-item-avatar>

            <v-list-item-content>
              <v-list-item-title>{{ item.title }}</v-list-item-title>

              <v-list-item-subtitle>{{ item.subtitle }}</v-list-item-subtitle>
            </v-list-item-content>

            <v-list-item-action>
              <v-btn
                icon
                ripple
              >
                <v-icon color="grey lighten-1">
                  mdi-information
                </v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
        </v-list>
        </v-col>


            <v-btn
    elevation="2"
    fab
    right
    fixed
    icon
    @click="dialog=true"
    >
    <v-icon>mdi-plus</v-icon>
    </v-btn>
    </v-row>

                <!-- MODAL FOR ADDING A PATIENT -->

        <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >

      <v-card>
        <v-card-title>
          <span class="text-h5">Add Patient</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                  label="First Name*"
                  dense
                  required
                  outlined
                ></v-text-field>
              </v-col>
              <v-col
                cols="12"
                sm="6"
                md="6"
              >
                <v-text-field
                    outlined
                    dense
                  label="Last Name*"
                  hint="enter your last name"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                 outlined 
                 dense 
                  label="Address*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <vue-tel-input
                    validCharactersOnly
                    mode="international"
                    v-model="patient.contact"
                ></vue-tel-input>
              </v-col>
              <v-col
                cols="12"
                sm="6"
              >
                <v-text-field
                  outlined
                  dense
                  label="Age*"
                  required
                  type="number"
                ></v-text-field>
              </v-col>

            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

        <!-- END OF MODALFOR ADDING A PATIENT -->

    </div>
</template>

<script>
export default {
    data() {
        return{
            dialog: false,
            patient: {
                name: "",
                gender: "",
                age: null,
                address: "",
                contact: "",
            },
        items: [
          { icon: 'mdi-folder', iconClass: 'grey lighten-1 white--text', title: 'Photos', subtitle: 'Jan 9, 2014' },
          { icon: 'mdi-folder', iconClass: 'grey lighten-1 white--text', title: 'Recipes', subtitle: 'Jan 17, 2014' },
          { icon: 'mdi-folder', iconClass: 'grey lighten-1 white--text', title: 'Work', subtitle: 'Jan 28, 2014' },
        ],
        items2: [
          { icon: 'mdi-clipboard-text', iconClass: 'blue white--text', title: 'Vacation itinerary', subtitle: 'Jan 20, 2014' },
          { icon: 'mdi-gesture-tap-button', iconClass: 'amber white--text', title: 'Kitchen remodel', subtitle: 'Jan 10, 2014' },
        ],
        }
    },
    methods:{
       doSomething(){
           console.log("Something happened")
       } 
    },
    created(){

    }
}
</script>

<style scoped>
/* .page{
    height: 100vh;
} */
</style>