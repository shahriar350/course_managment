<template>
    <div style="background-color: #f3f3f3" class="mt-3 pt-3">
        <div class="container-lg">
            <div class="row">
                <div class="col-12" v-if="courses.length">
                    <div v-for="(course, index) in courses" :key="index" class="rounded mb-4">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <b-card class="border-0" bg-variant="dark" text-variant="light"
                                        :title="`${course.get_course.name } - ${ course.get_course.code}`">
                                    <b-card-text class="border-0">
                                        {{ course.day }}-{{ course.time }}
                                    </b-card-text>
                                </b-card>
                            </div>
                            <div class="col-lg-8 col-12">
                                <b-table bordered hover dark :items="course.get_student_course" :fields="fields">
                                    <template #cell(index)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template #cell(total)="data">
                                        {{ data.item.final_exam + data.item.midterm + data.item.class_performance }}
                                    </template>
                                    <template #cell(actions)="data">
                                        <b-icon v-b-modal:edit_info icon="BIconPencilSquare" title="Edit"
                                                class="cursor-pointer" style="color: white"
                                                @click="completeCourse(data,index)"></b-icon>
                                    </template>
                                </b-table>
                            </div>
                        </div>

                    </div>
                    <b-modal :title="edit_data.student_id" id="edit_student_number" hide-footer>
                        <form @submit.prevent="updateStudentInfo">
                            <div class="mb-2">
                                <input type="text" v-model.number="edit_data.class_performance" class="mb-2 form-control" placeholder="Class performance">
                                <input type="text" v-model.number="edit_data.mid_term" class="mb-2 form-control" placeholder="Midterm number">
                                <input type="text" v-model.number="edit_data.final" class="mb-2 form-control" placeholder="Final number">
                            </div>
                            <button class="btn btn-primary">Update marks</button>
                        </form>
                    </b-modal>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {BIcon, BIconPencilSquare} from 'bootstrap-vue'

    export default {
        components: {
            BIcon, BIconPencilSquare
        },
        data() {
            return {
                fields: [
                    'index',
                    {label: 'Student name', key: 'get_student.name', sortable: true},
                    {label: 'Student ID', key: 'get_student.student_id', sortable: true},
                    {label: 'Class Perf', key: 'class_performance', sortable: true},
                    {label: 'Midterm', key: 'midterm', sortable: true},
                    {label: 'Final Exam', key: 'final_exam', sortable: true},
                    {key: 'total', label: 'Total'},
                    {key: 'actions', label: 'Actions'}
                ],
                edit_data: {
                    id: '',
                    mid_term: '',
                    class_performance: '',
                    final: '',
                    student_id: '',
                    name: '',
                    index: '',
                    childIndex: ''
                },
                courses: [],
            }
        },
        created() {
            this.allCourse()
        },
        methods: {
            allCourse() {
                axios.get('/teacher/schedule/init')
                    .then(res => {
                        this.courses = res.data.data
                    })
            },
            updateStudentInfo(){
                  axios.post('/teacher/schedule/init',{
                      id : this.edit_data.id,
                      mid_term : this.edit_data.mid_term,
                      final : this.edit_data.final,
                      class_performance : this.edit_data.class_performance,
                  }) .then(res => {
                    this.courses[this.edit_data.index].get_student_course[this.edit_data.childIndex].class_performance = this.edit_data.class_performance;
                    this.courses[this.edit_data.index].get_student_course[this.edit_data.childIndex].final_exam = this.edit_data.final;
                    this.courses[this.edit_data.index].get_student_course[this.edit_data.childIndex].midterm = this.edit_data.mid_term;
                    this.$bvToast.toast('Successfully update information',{
                        title: 'student marks',
                        solid: true,
                    })
                  })
            },
            completeCourse(data,index) {
                this.edit_data = {
                    id: data.item.id,
                    mid_term: data.item.midterm,
                    class_performance: data.item.class_performance,
                    final: data.item.final_exam,
                    student_id: data.item.get_student.student_id,
                    name: data.item.get_student.name,
                    index: index,
                    childIndex: data.index,
                }
                this.$bvModal.show('edit_student_number')
            },

        },
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>

</style>
