<template>
    <div>

        <nav aria-label="breadcrumb" class="flex justify-content-between">
            <div class="breadcrumb flex justify-content-between">
                <div>
                    <a class="breadcrumb-item d-inline" href="/admin/dashboard">Home</a>
                    <p class="breadcrumb-item active p-0 d-inline" aria-current="page">Teacher</p>
                </div>
                <button v-b-modal:addteachermodal class="btn btn-sm btn-primary">Add teacher</button>
                <!--         modal start-->
                <b-modal id="addteachermodal" title="Add a teacher" hide-footer>
                    <server_error :errors="validationErrors"
                                  v-if="validationErrors"></server_error>
                    <form @submit.prevent="AddTeacherNow">
                        <div class="mb-2">
                            <label class="d-none" for="name"></label>
                            <input placeholder="Name" type="text" id="name"
                                   class="form-control" v-model="teacher.name">
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="usernamename"></label>
                            <input placeholder="Username" type="text" id="usernamename"
                                   class="form-control" v-model="teacher.username">
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="password"></label>
                            <input placeholder="Password" type="password" id="password"
                                   class="form-control" v-model="teacher.password">
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="gender"></label>
                            <select name="gender" id="gender" v-model="teacher.gender" class="form-control">
                                <option value="" selected disabled>Select your gender</option>
                                <option value="man">Man</option>
                                <option value="woman">Woman</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="age"></label>
                            <input placeholder="Age" type="number" id="age"
                                   class="form-control" v-model.number="teacher.age">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add now</button>
                    </form>
                </b-modal>
                <!--                modal end-->
            </div>
        </nav>
        <div class="container-md">
            <div class="row">
                <div class="col-12" v-if="teachers.length">
                    <b-table bordered hover :items="teachers" :fields="fields">
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <template #cell(name)="data">
                            {{ data.item.name | firstcap }}
                        </template>
                        <template #cell(created_at)="data">
                            {{ data.item.created_at | moment("dddd, MMMM Do YYYY") }}
                        </template>
                        <template #cell(actions)="data">
                            <b-icon icon="trash" style="color: red" @click="deleteTeacher(data.item.id, data.index)"></b-icon>
                        </template>
                    </b-table>
                </div>
<!--                <div v-for="(teacher,index) in teachers" :key="index" class="col-lg-3 col-md-4 col-sm-6 col-12 my-2">-->
<!--                    <b-card :title="teacher.name" :sub-title="teacher.gender">-->
<!--                        <b-card-text>-->
<!--                            {{ teacher.created_at | moment("dddd, MMMM Do YYYY") }}-->
<!--                        </b-card-text>-->
<!--                        <b-card-footer>-->
<!--                            <b-icon icon="trash" style="color: red" @click.prevent="deleteTeacher(teacher.id,index)"></b-icon>-->
<!--                        </b-card-footer>-->
<!--                    </b-card>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    import server_error from "./server_error";
    import { BIcon, BIconTrash } from 'bootstrap-vue'
    export default {
        components: {
            server_error, BIcon,BIconTrash
        },
        data() {
            return {
                fields: [
                    'index',
                    {label: 'Name', key: 'name', sortable: true},
                    {label: 'Username', key: 'username', sortable: true},
                    {label: 'Gender', key: 'gender', sortable: true},
                    {label: 'Age', key: 'age', sortable: true},
                    {label: 'Created_at', key: 'created_at', sortable: true},
                    { key: 'actions', label: 'Actions' }
                ],
                teacher: {
                    name: '',
                    username: '',
                    password: '',
                    gender: '',
                    age: '',
                },
                validationErrors: '',
                teachers: []
            }
        },
        created() {
            this.allTeachers()
        },
        methods: {
            deleteTeacher(id,index){
                if (confirm('Do you want to delete this teacher')){
                    axios.delete(`/admin/teacher/init/${id}`)
                        .then(res => {
                            this.$bvToast.toast(`Successfully deleted`,{
                                title: 'Teacher',
                                solid: true
                            })
                            this.teachers.splice(index,1)
                        })
                }

            },
            allTeachers() {
                axios.get('/admin/teacher/init')
                    .then(res => {
                        this.teachers = res.data.data
                    })
            },
            AddTeacherNow() {
                axios.post('/admin/teacher/init', this.teacher)
                    .then(res => {
                        this.teacher = {
                            name: '',
                            username: '',
                            password: '',
                            gender: '',
                            age: '',
                        };
                        this.teachers.unshift(res.data.data)
                        this.$bvToast.toast(`Successfully added`,{
                            title: 'Teacher',
                            solid: true
                        })
                    }).catch(error => {
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
