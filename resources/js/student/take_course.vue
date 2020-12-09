<template>
    <div>
        <nav aria-label="breadcrumb" class="flex justify-content-between">
            <div class="breadcrumb flex justify-content-between">
                <div>
                    <a class="breadcrumb-item d-inline" href="/student/dashboard">Home</a>
                    <p class="breadcrumb-item active p-0 d-inline" aria-current="page">Schedule</p>
                </div>
                <button v-b-modal:addscheduleemodal class="btn btn-sm btn-primary">Add a course</button>
                <!--         modal start-->
                <b-modal id="addscheduleemodal" title="Add a schedule" hide-footer>

                    <form @submit.prevent="AddCourses">
                        <div class="mb-2">
                            <label class="d-none" for="course"></label>
                            <multiselect id="course" :multiple="true" group-label="get_course"
                                         v-model="select_courses" track-by="get_course"
                                         :options="all_courses" :show-labels="false" :custom-label="customLabel"
                                         placeholder="Course name-code-day-time-teacher">
                            </multiselect>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add now</button>
                    </form>
                </b-modal>
                <!--                modal end-->
            </div>
        </nav>
        <div class="container-md">
            <div class="row">
                <div class="col-12" v-if="student_courses.length">
                    <b-table bordered hover :items="student_courses" :fields="fields">
                        <template #cell(index)="data">
                            {{ data.index + 1 }}
                        </template>
                        <template #cell(actions)="data">
                            <b-icon icon="trash" style="color: red" @click="deleteSchedule(data.item.id, data.index)"></b-icon>                        </template>
                    </b-table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import {BIcon, BIconTrash} from 'bootstrap-vue'
    export default {
        components: {
            BIcon, BIconTrash, Multiselect,
        },
        data() {
            return {
                fields: [
                    'index',
                    {label: 'Course name', key: 'get_schedule.get_course.name', sortable: true},
                    {label: 'Course code', key: 'get_schedule.get_course.code', sortable: true},
                    {label: 'Course Credit', key: 'get_schedule.get_course.credit', sortable: true},
                    {label: 'Class Day', key: 'get_schedule.day', sortable: true},
                    {label: 'Class time', key: 'get_schedule.time', sortable: true},
                    {label: 'Class room', key: 'get_schedule.room', sortable: true},
                    {label: 'Instructor', key: 'get_schedule.get_teacher.name', sortable: true},
                    { key: 'actions', label: 'Actions' }
                ],
                select_courses: [],
                all_courses: [],
                student_courses: [],

            }
        },
        created() {
            this.allCourse()
            this.studentCourseAll()
        },
        methods: {
            deleteSchedule(id, index) {
                if (confirm('Do you want to delete this course')) {
                    axios.delete(`/student/courses/init/${id}`)
                        .then(res => {
                            this.$bvToast.toast(`Successfully deleted`, {
                                title: 'Schedule',
                                solid: true
                            })
                            this.student_courses.splice(index, 1)
                        })
                }
            },

            studentCourseAll() {
                axios.get('/student/courses/init')
                    .then(res => {
                        this.student_courses = res.data.data
                    })
            },
            allCourse() {
                axios.get('/student/all/course')
                    .then(res => {
                        this.all_courses = res.data.data
                    })
            },
            AddCourses() {
                axios.post('/student/courses/init', {
                    courses: this.select_courses
                })
                    .then(res => {
                        this.schedule = {
                            course: '',
                            teacher: '',
                            time: '',
                            room: '',
                        };
                        this.student_courses = res.data.data
                        this.$bvToast.toast(`Successfully added`, {
                            title: 'Schedule',
                            solid: true
                        })
                    }).catch(error => {
                        this.$bvToast.toast(`${error.response.data.message}`,{
                            title : 'Error',
                            solid: true,
                            variant: 'danger',
                            noAutoHide: true,
                        })
                })
            },
            customLabel({get_course,get_teacher,day ,time}) {
                return `${get_course.name}-${get_course.code} - ${day} - ${time} - ${get_teacher.name}`
            }
        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
