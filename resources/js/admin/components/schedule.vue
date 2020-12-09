<template>
    <div>
        <nav aria-label="breadcrumb" class="flex justify-content-between">
            <div class="breadcrumb flex justify-content-between">
                <div>
                    <a class="breadcrumb-item d-inline" href="/admin/dashboard">Home</a>
                    <p class="breadcrumb-item active p-0 d-inline" aria-current="page">Schedule</p>
                </div>
                <button v-b-modal:addscheduleemodal class="btn btn-sm btn-primary">Add a class schedule</button>
                <!--         modal start-->
                <b-modal id="addscheduleemodal" title="Add a schedule" hide-footer>
                    <div class="bg-danger" v-if="validationErrors.length">
                        <u>
                            <li class="alert alert-danger" v-for="(error,index) in validationErrors">{{ error}}</li>
                        </u>
                    </div>
                    <form @submit.prevent="AddSchedule">
                        <div class="mb-2">
                            <label class="d-none" for="course"></label>
                            <multiselect id="course" v-model="schedule.course" track-by="name"
                                         :options="courses" :show-labels="false" :custom-label="customLabel"
                                         placeholder="Select a course"></multiselect>
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="teachers"></label>
                            <multiselect id="teachers" v-model="schedule.teacher" label="name" track-by="name"
                                         :options="teachers" :show-labels="false"
                                         placeholder="Select a teacher"></multiselect>
                        </div>

                        <div class="mb-2">
                            <label class="" for="class_day">Course Day: </label>
                            <select v-model="schedule.day" id="class_day" class="form-control form-select">
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="" for="class_time">Course time: </label>
                            <b-time v-model="schedule.time" locale="en" id="class_time"></b-time>
                        </div>
                        <div class="mb-2">
                            <label class="d-none" for="room"></label>
                            <input placeholder="Course room" type="text" id="room"
                                   class="form-control" v-model.number="schedule.room">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Add now</button>
                    </form>
                </b-modal>
                <!--                modal end-->
            </div>
        </nav>
        <div class="container-md">
            <div class="row">
                <div class="col-12" v-if="schedules.length">
                    <b-table bordered hover :items="schedules" :fields="fields">
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
    import pagination from 'laravel-vue-pagination'
    export default {
        components: {
             BIcon, BIconTrash, Multiselect, pagination
        },
        data() {
            return {
                fields: [
                    'index',
                    {label: 'Course', key: 'get_course.name', sortable: true},
                    {label: 'Code', key: 'get_course.code', sortable: true},
                    {label: 'Instructor', key: 'get_teacher.name', sortable: true},
                    {label: 'Room', key: 'room', sortable: true},
                    {label: 'Day', key: 'day', sortable: true},
                    {label: 'Time', key: 'time', sortable: true},
                    { key: 'actions', label: 'Actions' }
                    ],
                schedule: {
                    course: '',
                    teacher: '',
                    time: '',
                    room: '',
                    day: '',
                },
                validationErrors: [],
                courses: [],
                teachers: [],
                schedules: [],

            }
        },
        created() {
            this.allTeacher()
            this.allCourse()
            this.allSchedule()
        },
        methods: {
            deleteSchedule(id, index) {
                if (confirm('Do you want to delete this course')) {
                    axios.delete(`/admin/schedule/init/${id}`)
                        .then(res => {
                            this.$bvToast.toast(`Successfully deleted`, {
                                title: 'Schedule',
                                solid: true
                            })
                            this.schedules.splice(index, 1)
                        })
                }

            },
            allTeacher() {
                axios.get('/admin/teacher/init')
                    .then(res => {
                        this.teachers = res.data.data
                    })
            },
            allCourse() {
                axios.get('/admin/course/init/')
                    .then(res => {
                        this.courses = res.data.data
                    })
            },
            allSchedule() {
                axios.get('/admin/schedule/init/')
                    .then(res => {
                        this.schedules = res.data.data
                    })
            },
            AddSchedule() {
                this.validationErrors.splice(0,this.validationErrors.length)
                axios.post('/admin/schedule/init', this.schedule)
                    .then(res => {
                        this.schedule = {
                            course: '',
                            teacher: '',
                            time: '',
                            room: '',
                        };
                        this.schedules.unshift(res.data.data)
                        this.$bvToast.toast(`Successfully added`, {
                            title: 'Schedule',
                            solid: true
                        })
                    }).catch(error => {
                    this.validationErrors = error.response.data.data;
                })
            },
            customLabel({name, code}) {
                return `${name} – ${code}`
            }
        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
