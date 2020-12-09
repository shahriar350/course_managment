<template>
    <div>

        <nav aria-label="breadcrumb" class="flex justify-content-between">
            <div class="breadcrumb flex justify-content-between">
                <div>
                    <a class="breadcrumb-item d-inline" href="/admin/dashboard">Home</a>
                    <p class="breadcrumb-item active p-0 d-inline" aria-current="page">Course</p>
                </div>
                <button v-b-modal:addcoursemodal class="btn btn-sm btn-primary">Add Course</button>
                <!--         modal start-->
                <b-modal id="addcoursemodal" title="Add a Course" hide-footer>
                    <server_error :errors="validationErrors"
                                  v-if="validationErrors"></server_error>
                    <form @submit.prevent="AddCourse">
                        <div class="mb-2">
                            <label class="d-none" for="name"></label>
                            <input placeholder="Course name" type="text" id="name"
                                   class="form-control" v-model="course.name">
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="code"></label>
                            <input placeholder="Course code" type="text" id="code"
                                   class="form-control" v-model="course.code">
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="credit"></label>
                            <input placeholder="Course credit" type="text" id="credit"
                                   class="form-control" v-model.number="course.credit">
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="prerequisite"></label>
                            <multiselect id="prerequisite" v-model="course.prerequisite" :custom-label="customLabel" track-by="name"
                                         :options="courses" :show-labels="false" placeholder="Course prerequisite"></multiselect>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Add now</button>
                    </form>
                </b-modal>
                <!--                modal end-->
            </div>
        </nav>
        <div class="container-md">
            <div class="row">
                <div class="col-12" v-if="courses.length">
                    <b-table bordered hover :items="courses" :fields="fields">
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <template #cell(actions)="data">
                            <b-icon icon="trash" style="color: red" @click="deleteCourse(data.item.id, data.index)"></b-icon>
                        </template>

                    </b-table>
                </div>
<!--                <div v-for="(course,index) in courses" :key="index" class="col-lg-3 col-md-4 col-sm-6 col-12 my-2">-->
<!--                    <b-card :title="course.name | firstcap" :sub-title="course.code" class="shadow-sm">-->
<!--                        <b-card-text>-->
<!--                            {{ course.created_at | moment("dddd, MMMM Do YYYY") }}-->
<!--                        </b-card-text>-->
<!--                        <b-card-footer>-->
<!--                            <b-icon icon="trash" style="color: red"-->
<!--                                    @click.prevent="deleteCourse(course.id,index)"></b-icon>-->
<!--                        </b-card-footer>-->
<!--                    </b-card>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>
    import server_error from "./server_error";
    import Multiselect from 'vue-multiselect'
    import {BIcon, BIconTrash} from 'bootstrap-vue'

    export default {
        components: {
            server_error, BIcon, BIconTrash, Multiselect
        },
        data() {
            return {
                fields: [
                    'index',
                    {label: 'Name', key: 'name', sortable: true},
                    {label: 'Code', key: 'code', sortable: true},
                    {label: 'Credit', key: 'credit', sortable: true},
                    {label: 'Prerequisite', key: 'get_precourse.code', sortable: true},
                    { key: 'actions', label: 'Actions' }
                ],
                course: {
                    name: '',
                    code: '',
                    credit: '',
                    prerequisite: '',
                },
                validationErrors: '',
                courses: []
            }
        },
        created() {
            this.allCourse()
        },
        methods: {
            deleteCourse(id, index) {
                if (confirm('Do you want to delete this course')) {
                    axios.delete(`/admin/course/init/${id}`)
                        .then(res => {
                            this.$bvToast.toast(`Successfully deleted`, {
                                title: 'Course',
                                solid: true
                            })
                            this.courses.splice(index, 1)
                        })
                }

            },
            allCourse() {
                axios.get('/admin/course/init')
                    .then(res => {
                        this.courses = res.data.data
                    })
            },
            AddCourse() {
                axios.post('/admin/course/init', this.course)
                    .then(res => {
                        this.course = {
                            name: '',
                            code: '',
                            credit: '',
                            prerequisite: '',
                        };
                        this.courses.unshift(res.data.data)
                        this.$bvToast.toast(`Successfully added`, {
                            title: 'Course',
                            solid: true
                        })
                    }).catch(error => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors;
                    }
                })
            },
            customLabel ({ name, code }) {
                return `${name} – ${code}`
            }
        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
