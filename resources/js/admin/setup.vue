<template>
    <div class="container mt-3">
        <server_error :errors="validationErrors"
                      v-if="validationErrors"></server_error>
        <div class="row">
            <div class="col-md-6 col-12">
                <b-card no-body class="mb-1">
                    <b-card-header header-tag="header" class="p-1" role="tab">
                        <b-button block v-b-toggle.roles variant="info">See all roles</b-button>
                    </b-card-header>
                    <b-collapse id="roles" accordion="my-accordion" role="tabpanel">
                        <b-card-body>
                            <b-card-text class="py-1" v-for="(role,index) in roles" :key="index">
                                {{ role.name | firstcap}}
                            </b-card-text>
                        </b-card-body>
                    </b-collapse>
                </b-card>

                <div class="card shadow-sm">
                    <div class="card-header">
                        <p class="lead">Role</p>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="AddRole">
                            <input type="text" placeholder="Role Display name" v-model="role.display_name"
                                   class="form-control mb-2">
                            <input required type="text" placeholder="Role name" v-model="role.name"
                                   class="form-control mb-2">
                            <input type="text" placeholder="Role Description" v-model="role.description"
                                   class="form-control mb-2">
                            <button type="submit" class="w-100 btn btn-primary">Add now</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12 mt-md-0 mt-3 shadow-sm border shadow-sm">
                <p class="h3 text-center py-2 border-bottom">Registration Start-Dateline</p>
                <form @submit.prevent="addRegDate">
                    <div class="row">
                        <div class="col-sm-6 col-12 d-flex justify-content-center mb-2">
                            <div class="mb-2">
                                <label for="start" class="lead w-100 text-center">Registration Start:</label>
                                <b-calendar id="start" class="w-100" v-model="reg.start" locale="en"></b-calendar>
                            </div>
                        </div>
                        <div class="col-sm-6 col-12 mb-2 d-flex justify-content-center">
                            <div class="mb-2">
                                <label for="end" class="lead w-100 text-center">Registration End: </label>
                                <b-calendar id="end" v-model="reg.end" class="w-100" locale="en"></b-calendar>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Registration now</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</template>

<script>
    import server_error from "./components/server_error";

    export default {
        components: {
            server_error
        },
        data() {
            return {
                reg: {
                    start: '',
                    end: ''
                },
                role: {
                    name: '',
                    description: '',
                    display_name: '',
                },
                validationErrors: '',
                roles: [],
            }
        },
        created() {
            this.all_get_roles()
            this.getRegDate()
        },
        methods: {
            getRegDate(){
                axios.get('/admin/registration/date')
                    .then(res => {
                        this.reg.start = res.data.data.registration_start
                        this.reg.end = res.data.data.registration_end
                    })
            },
            addRegDate(){
                axios.post('/admin/registration/date',{
                    start: this.reg.start,
                    end: this.reg.end,
                }) .then(res => {
                    this.$bvToast.toast('Successfully updated',{
                        title: 'Registration dateline',
                        solid: true
                    })
                })
            },
            all_get_roles(){
                axios.get('/admin/role/related')
                    .then(res => {
                        this.roles = res.data.data
                    })

            },
            AddRole() {
                axios.post('/admin/role/related', this.role)
                    .then(res => {
                        this.$bvToast.toast(`Successfully added`, {
                            title: `Role`,
                            solid: true,
                        })
                        this.role.name = '';
                        this.role.description = '';
                        this.role.display_name = '';
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.validationErrors = error.response.data.errors;
                        }
                    })
            }
        },
    }
</script>

<style scoped>

</style>
